<?php
// ******************************************** //
//
// установка нового пароля после сброса по ссылке
//
// ******************************************** //

// свойства файла, используются для защиты на прямой вызов служебных скриптов
$page = array(
'type' 		=> 'newpassword'
);

// подключаем основной файл конфигурации
$g_root = $_SERVER['DOCUMENT_ROOT'];
require_once ($g_root.'/config.php');

// вызываем файл аутентификации пользователя
include_once ($config['base_include_url'].$config['url_UAC_file']);

if (!$user_login) {
	// если пользователь сейчас не залогинен

	// проверка полученных данных
	if (!empty($_GET)) {
		// если был переход по ссылке - показываем форму

		// задаём свойства формы для сборки из шаблона
		// забираем e-mail и код сброса из ссылки
		(!empty($_GET['email']))				? $hidden_email 				= $_GET['email']				: '';
		(!empty($_GET['passwordreset_code']))	? $hidden_passwordreset_code 	= $_GET['passwordreset_code']	: '';

		// задаём свойства формы
		$form								= true;					// фома активна
		$form_action						= 'newpassword.php';	// адрес отправки формы
		$form_method						= 'POST';				// метод отправки формы
		$input_hidden_passwordreset_code	= true;					// скрытое поле с кодом сброса пароля
		$input_hidden_email					= true;					// скрытое поле с адресом e-mail
		$input_password						= true;					// поле пароль
		$btn								= true;					// кнопка
		
		// код ответа - форма установки нового пароля
		$result = 'newpassword_form';

	} else if (!empty($_POST['password'])) {
		// если получили данные из отправленной формы - обрабатываем

		// проверяем e-mail и код сброса по маске
		$regex_code = '/^[a-fA-F0-9]{64,64}$/';

		if (
				(preg_match($regex_code, $_POST['passwordreset_code']))
			AND (preg_match($config['regex_email'], $_POST['email']))
		) {
			// если они проходят проверку

			// делаем поиск записи с такими данными в базе
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
				// если нашли подходящего пользователя

				// генерируем правильный код восстановления пароля по текущим данным из базы
				// id + хэш прошлого пароля + соль + email
				$goodpasswordreset_code = hash('sha256', $user['user_id'].$user['user_password'].$config['salt'].$user['user_email']);

				if ($goodpasswordreset_code === $_POST['passwordreset_code']) {
					// если код восстановления совпадает

					// шифруем новый пароль с солью и записываем в базу
					$newpassword = hash('sha512', hash('sha512', $_POST['password']).$config['salt'].$user['user_email']);
					$pattern = '
						UPDATE
							users
						SET
							users.user_password = ?
						WHERE
							users.user_email = ?
						AND
							users.user_id = ?i
						LIMIT
							1
						';
					$value = array($newpassword, $user['user_email'], $user['user_id']);
					$data = $db->query($pattern, $value);
					
					$result = 'newpassword_true';	// код ответа - пароль успешно изменён

				} else {
					// если код восстановления не совпадает

					$result = 'newpassword_code_wrong';	// код ответа - код не совпадает

				}
			} else {
				// если учётки с таким e-mail нет в базе
			
				$result = 'newpassword_email_wrong';	// код ответа - пользователь не найден

			}
		} else {
			// если данные не проходят проверку по маске
		
			$result = 'newpassword_code_wrong';	// код ответа - код не совпадает

		}
	} else {
		// если ничего не получили - даём ошибку

		header('Location: /404.php');
		exit();

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