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
require_once ($g_root.'/config.php');

// вызываем файл аутентификации пользователя
include_once ($config['base_include_url'].$config['url_UAC_file']);

if (!$user_login) {
	// если пользователь сейчас не залогинен

	if (empty($_POST)) {
		// если форма логина не отправлялась либо вернулась с GET ошибкой - показываем форму

		// задаём свойства формы для сборки из шаблона
		// если это повторная попытка входа, забираем ранее введённый e-mail и тип ошибки
		(!empty($_GET['login'])) ? $input_email_value 	= $_GET['login'] : '';
		(!empty($_GET['error'])) ? $error 				= $_GET['error'] : '';

		$form 			= true;						// форма активна
		$form_action 	= 'login.php';				// адрес отправки формы
		$form_method 	= 'POST';					// метод отправки формы
		$input_email 	= true;						// поле e-mail
		$input_password = true;						// поле пароль
		$btn 			= true;						// кнопка
		
		// код ответа для сборки - форма авторизации
		$result = 'login_form';
		
	} else {
		// если форма отправлялась - получаем и обрабатываем данные

		if (!empty($_POST['email']) AND !empty($_POST['password'])) {
			// если данных хватает

			if (preg_match($config['regex_email'], $_POST['email'])) {
				// если e-mail проходит проверку по маске из конфиг-файла

				// получаем из базы пользователя по e-mail
				$pattern = '
					SELECT
						users.*
					FROM
						users
					WHERE
						users.user_email = ?
					LIMIT
						1
				';
				$value = array($_POST['email']);
				$user = $db->query($pattern, $value)->row();
					
				if (!empty($user)) {
					// если такой пользователь найден в базе

					// шифруем пароль с солью
					$password_hash	= hash('sha512', hash('sha512', $_POST['password']).$config['salt'].$_POST['email']);

					if ($user['user_password'] === $password_hash) {
						// если хэши паролей совпадают

						if ((int)$user['user_state'] === 1) {
							// если пользователь не заблокирован (поле "user_state" в базе)

							if ((	$config['system_state']
								AND (int)$user['user_admin'] !== 1
								)
								OR (int)$user['user_admin'] === 1
							) {
								// если система не в сервисном режиме или это администратор

								if ((int)$user['user_activation_state'] === 1) {
									// если пользователь уже активирован

									// генерируем случайное число для хэша
									function generateCode($length = 10) {
										$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
										$code = "";
										$clen = strlen($chars) - 1;
										while (strlen($code) < $length)
										{
											$code .= $chars[mt_rand(0,$clen)];
										}
										return $code;
									}

									// шифруем его в хеш для записи в куки
									$cookiehash = md5(generateCode(10));

									// шифруем полученный хеш с солью для записи в базу
									$dbhash = hash('sha512', $cookiehash.$config['salt']);

									// записываем в базу новый хеш авторизации
									$pattern = '
										UPDATE
											users
										SET
											users.user_hash = ?
										WHERE
											users.user_id = ?i
										LIMIT
											1
									';
									$value = array($dbhash, $user['user_id']);
									$data = $db->query($pattern, $value);
									
									// ставим куки
									setcookie ('cookie_user_id', $user['user_id'], time()+60*60*24*30, '/');
									setcookie ('cookie_hash', $cookiehash, time()+60*60*24*30, '/');

									// отправляем пользователя на страницу контента
									header ('Location: /'.$config['system_page']);
									exit();

								} else {
									// если пользователь ещё не активирован

									$user_login = false; // запрещаем доступ
									$result = 'no_activation';	// код ответа для сборки - пользователь не активирован

								}

							} else {
								// если сервисный режим активен и это обычный пользователь

								$user_login = false; // запрещаем доступ
								$result = 'system_offline';	// код ответа для сборки - система отключена

							}

						} else {
							// если пользователь заблокирован

							$user_login = false; // запрещаем доступ
							$result = 'user_disabled';	// код ответа для сборки - пользователь заблокирован

						}

					} else {
						// если пароль не совпадает, отправляем снова на форму авторизации с ошибкой

						header ('Location: /login/login.php?error=password&login='.$_POST['email']);
						exit();

					}

				} else {
					// если такого пользователя нет в базе, отправляем снова на форму авторизации с ошибкой

					header ('Location: /login/login.php?error=email&login='.$_POST['email']);
					exit();

				}

			} else {
				// если данный e-mail не проходит проверку по маске

				$user_login = false; // запрещаем доступ
				$result = 'email_wrong';	// код ответа для сборки -  - некорректный e-mail

			}

		} else {
			// если данные не получены

			$user_login = false; // запрещаем доступ
			$result = 'login_form_empty';	// код ответа для сборки - пустая форма

		}

	}

	// подключаем текстовые данные для сборки ответа
	include $config['base_include_url'].'/login/tpl/login_text.php';
	
	// подключаем вёрстку для сборки ответа
	include $config['base_include_url'].'/login/tpl/login_tpl.php';

} else {
	// если пользователь уже залогинен - отправляем пользователя на страницу контента

	header ('Location: /'.$config['system_page']);
	exit();

}
?>