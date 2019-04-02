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
require_once ($g_root.'/config.php');

// вызываем файл аутентификации пользователя
include_once ($config['base_include_url'].$config['url_UAC_file']);

if (!$user_login) {
	// если пользователь не залогинен

	if ($config['user_email_passwordreset']) {
		// если возможность сброса пароля через почту активна
	
		if (!isset($_POST['submit'])) {
			// если форма не отправлялась - показываем форму

			// задаём свойства формы
			$form			= true;						// фома активна
			$form_action	= 'resetpassword.php';		// адрес отправки формы
			$form_method	= 'POST';					// метод отправки формы
			$input_email	= true;						// поле e-mail
			$btn			= true;						// кнопка
			
			$result = 'passwordreset_form';	// код ответа - форма сброса пароля

		} else {
			// если форма отправлялась
		
			if (!empty($_POST['email'])) {
				// если данных достаточно

				if (preg_match($config['regex_email'], $_POST['email'])) {
					// если e-mail проходит проверку по маске

					// получаем из базы запись по e-mail
					$pattern = '
						SELECT
							users.user_id,
							users.user_email,
							users.user_password
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
						// если есть учётка с таким e-mail

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

						$result = 'passwordreset_true_code_send'; // код ответа - отправлено письмо со ссылкой на установку нового пароля

					} else {
						// если учётки с таким e-mail нет в базе

						$result = 'passwordreset_email_not_found';	// код ответа - пользователь не найден

					}
				} else {
					// если данный e-mail не проходит проверку
				
					$result = 'passwordreset_email_wrong';	// код ответа -  - некорректный e-mail

				}
			} else {
				// если нужные переменные не получены - даём ошибку
			
				$result = 'login_form_empty';	// код ответа - пустая форма

			}
		}
	} else {
		// если письма отправлять нельзя
	
		$result = 'passwordreset_disable';	// код ответа - восстановить пароль самостоятельно невозможно
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