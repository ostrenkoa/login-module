<?php
// ******************************************** //
//
// форма логина, обработка формы логина, результат логина, ошибки логина
//
// ******************************************** //

// свойства файла, используются для защиты на прямой вызов служебных скриптов
$page = array(
'type' 		=> 'login'
);

// подключаем основной файл конфигурации
$g_root = $_SERVER['DOCUMENT_ROOT'];
include_once ($g_root.'/config.php');

// вызываем файл аутентификации пользователя
include_once ($config['base_include_url'].$config['url_UAC_file']);

if (!$user_login)
// если пользователь не залогинен - работаем дальше
{
	// ПРОВЕРКА ОТПРАВКИ ФОРМЫ
	if (!isset($_POST['submit']))
	// если форма логина не отправлялась - показываем форму
	{
		// ПРОВЕРКА НАЛИЧИЯ ПРЕДЫДУЩЕЙ ПОПЫТКИ ВХОДА
		if (
				isset($_GET['login'])
			AND isset($_GET['error'])
		)
		//если была неуспешная попытка входа, получаем код ошибки и e-mail
		{
			$email = $_GET['login'];
			$error = $_GET['error'];
		}

		// задаём свойства формы для сборки из шаблона
		$form = '1';								// форма активна
		$form_action = 'login.php';					// адрес отправки формы
		$form_method = 'POST';						// метод отправки формы
		$input_email = '1';							// поле e-mail
		$input_password = '1';						// поле пароль
		$btn = '1';									// кнопка

		if (isset($email))
		{$input_email_value = $email;}				// заполняем поле e-mail если это повторная попытка входа
		
		// код ответа - форма авторизации
		$result = 'login_form';
		
	}
	else if (isset($_POST['submit']))
	// если форма отправлялась - получаем и обрабатываем данные
	{
		// проверка достаточности полученных данных
		if (
				!empty($_POST['email'])
			AND !empty($_POST['password'])
			AND isset($_POST['email'])
			AND isset($_POST['password'])
		)
		// если данные получены
		{
			// получаем e-mail и пароль
			$email = $_POST['email'];
			$password = $_POST['password'];

			// шифруем пароль с солью
			$password_hash	= hash('sha512', hash('sha512', $password).$config['salt'].$email);

			// проверяем e-mail на валидность по маске
			if (preg_match($config['regex_email'], $email))
			// если e-mail проходит проверку
			{
				// получаем из базы запись по e-mail
				$pattern = '
					SELECT
						users.*
					FROM
						users
					WHERE
						user_email = ?
					LIMIT
						1
				';
				$value = array($email);
				$user = $db->query($pattern, $value)->row();
					
				if (
						isset($user)
					AND !empty($user)
				)
				// если такой пользователь найден в базе
				{
					// сравниваем пароль
					if ($user['user_password'] === $password_hash)
					// если пароль совпадает
					{
						// проверяем на отсутствие сервисного режима системы
						if (
							(	$config['system_state']
							AND $user['user_admin'] != 1
							)
							OR $user['user_admin'] == 1
						)
						// если система не в сервисном режиме или это администратор
						{
							// проверяем статус пользователя, поле "user_state" в базе. можем им оперировать если хотим заблокировать пользователя
							if ($user['user_state'] == 1)
							// если пользователь не заблокирован
							{
								// проверяем статус активации
								if ($user['user_activation_state'] == 1)
								// если пользователь уже активирован
								{
									// Генерируем случайное число для хэша
									function generateCode($length = 10)
									{
										$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
										$code = "";
										$clen = strlen($chars) - 1;
										while (strlen($code) < $length)
										{
											$code .= $chars[mt_rand(0,$clen)];
										}
										return $code;
									}

									// Шифруем его в хеш для записи в куки
									$hash = md5(generateCode(10));

									// Шифруем полученный хеш для записи в базу
									$dbhash = hash('sha512', $hash);

									// Записываем в базу новый хеш авторизации
									$pattern = '
										UPDATE
											users
										SET
											user_hash = ?
										WHERE
											user_id = ?i
										LIMIT
											1
									';
									$value = array($dbhash, $user['user_id']);
									$data = $db->query($pattern, $value);
									
									// Ставим куки
									setcookie ('cookie_user_id', $user['user_id'], time()+60*60*24*30, '/');
									setcookie ('cookie_hash', $hash, time()+60*60*24*30, '/');

									// отправляем пользователя на страницу контента
									header ('Location: /'.$config['system_page']);
									exit();
								}
								else
								// если пользователь ещё не активирован - запрещаем доступ и показываем ошибку
								{
									$user_login = false;
									// код ответа - пользователь не активирован
									$result = 'no_activation';
								}
							}
							else
							// если пользователь заблокирован - запрещаем доступ и показываем ошибку
							{
								$user_login = false;
								// код ответа - пользователь заблокирован
								$result = 'user_disabled';
							}
						}
						else
						// если сервисный режим активен и это обычный пользователь
						{
							$user_login = false;
							// код ответа - система отключена
							$result = 'system_offline';
						}
					}
					else
					// если пароль не совпадает, отправляем снова на форму авторизации с ошибкой
					{
						header ('Location: /login/login.php?error=password&login='.$email);
						exit();
					}
				}
				else
				// если такого пользователя нет в базе, отправляем снова на форму авторизации с ошибкой
				{
					header ('Location: /login/login.php?error=email&login='.$email);
					exit();
				}
			}
			else
			// если данный e-mail не проходит проверку по маске - запрещаем доступ и показываем ошибку
			{
				$user_login = false;
				// код ответа -  - некорректный e-mail
				$result = 'email_wrong';
			}
		}
		else
		// если данные не получены - пустая форма
		{
			$user_login = false;
			// код ответа - пустая форма
			$result = 'login_form_empty';
		}
	}

	// подключаем текстовые данные для сборки ответа
	include $config['base_include_url'].'/login/tpl/login_text.php';
	
	// подключаем вёрстку для сборки ответа
	include $config['base_include_url'].'/login/tpl/login_tpl.php';
}
else
// если пользователь уже залогинен - перебрасываем на основную страницу
{
	header ('Location: /'.$config['system_page']);
	exit();
}

?>