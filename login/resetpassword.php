<?php
// ******************************************** //
//
// сброс пароля через отправку ссылки на почту
//
// ******************************************** //

// свойства файла, используются для защиты на прямой вызов служебных скриптов
$page = array(
'type' 		=> 'passwordreset'
);

// подключаем основной файл конфигурации
$g_root = $_SERVER['DOCUMENT_ROOT'];
include_once ($g_root.'/config.php');

// вызываем файл аутентификации пользователя
include_once ($config['base_include_url'].$config['url_UAC_file']);

if (!$user_login)
// если пользователь не залогинен - работаем дальше
{
	// проверка возможности сброса пароля через почту
	if ($config['user_email_passwordreset'] == true)
	// если можно - работаем дальше
	{
		// ПРОВЕРКА ОТПРАВКИ ФОРМЫ
		if (!isset($_POST['submit']))
		// если форма не отправлялась - показываем форму
		{
			// задаём свойства формы
			$form = '1';								// фома активна
			$form_action = 'resetpassword.php';			// адрес отправки формы
			$form_method = 'POST';						// метод отправки формы
			$input_email = '1';							// поле e-mail
			$btn = '1';									// кнопка
			
			// код ответа - форма сброса пароля
			$result = 'passwordreset_form';
		}
		else
		// если форма отправлялась - получаем данные
		{
			// проверка достаточности полученных данных
			if (
					isset($_POST['email'])
				AND !empty($_POST['email'])
			)
			// если данные получены - обрабатываем
			{
				// проверяем e-mail на валидность по маске
				if(preg_match($config['regex_email'], $_POST['email']))
				// если e-mail проходит проверку
				{
					// получаем из базы запись по e-mail
					$pattern = '
						SELECT
							users.user_id,
							users.user_email,
							users.user_password
						FROM
							users
						WHERE
							user_email = ?
						LIMIT
							1
					';
					$value = array($_POST['email']);
					$user = $db->query($pattern, $value)->row();
						
					if(!empty($user))
					// если есть учётка с таким e-mail
					{
						// генерируем код восстановления пароля
						// id + хэш прошлого пароля + соль + email
						// из-за использования хэша прошлого пароля, ссылка будет действительна только на одну смену пароля
						$passwordreset_code = hash('sha256', $user['user_id'].$user['user_password'].$config['salt'].$user['user_email']);
						
						// генерируем письмо с кодом сброса
						// кому отправляем письмо
						$to = $user['user_email'];

						// подключаем шаблон письма
						include 'tpl/passwordreset_mail_tpl.php';

						// подключаем функцию отправки писем
						include 'mailsend.php';

						// отправляем письмо с кодом сброса
						Send_Mail ($to, $subject, $body);

						// код ответа - отправлено письмо со ссылкой на установку нового пароля
						$result = 'passwordreset_true_code_send'; 
					}
					else
					// если учётки с таким e-mail нет в базе
					{
						// код ответа - пользователь не найден
						$result = 'passwordreset_email_not_found';
					}
				}
				else
				// если данный e-mail не проходит проверку
				{
					// код ответа -  - некорректный e-mail
					$result = 'passwordreset_email_wrong';
				}
			}
			else
			// если нужные переменные не получены - даём ошибку
			{
				// код ответа - пустая форма
				$result = 'login_form_empty';
			}
		}
	}
	else
	// если письма отправлять нельзя
	{
		// код ответа - восстановить пароль самостоятельно невозможно
		$result = 'passwordreset_disable';
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