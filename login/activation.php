<?php
// ******************************************** //
//
// форма активации, обработка формы и ссылки активации, результат активации, ошибки активации
//
// ******************************************** //

// свойства файла, используются для защиты на прямой вызов служебных скриптов
$page = array(
'type' 		=> 'activation'
);

// подключаем основной файл конфигурации
$g_root = $_SERVER['DOCUMENT_ROOT'];
require_once ($g_root.'/config.php');

// вызываем файл аутентификации пользователя
include_once ($config['base_include_url'].$config['url_UAC_file']);

if (!$user_login OR !$userconfig['user_activation_state']) {
	// если пользователь не залогинен либо залогинен и не активирован

	if (empty($_GET)) {
		// если нужные данные формы либо из ссылки активации не получены - показываем форму
	
		// задаём свойства формы для сборки из шаблона
		$form					= true;					// фома активна
		$form_action			= 'activation.php';		// адрес отправки формы
		$form_method			= 'GET';				// метод отправки формы
		$input_email			= true;					// поле e-mail
		$input_activation_code	= true;					// поле код активации
		$btn					= true;					// кнопка
		
		// код ответа - форма активации аккаунта
		$result = 'activation_form';

	} else {
		// если данные из формы либо ссылки активации получены - обрабатываем данные
	
		// получаем e-mail и код активации
		(!empty($_GET['email']))			? $email 					= $_GET['email']			: '';
		(!empty($_GET['activation_code']))	? $user_activation_code 	= $_GET['activation_code']	: '';
			
		// проверяем e-mail и код активации по маске
		$regex_code = '/^[a-fA-F0-9]{64,64}$/';

		if(
				(preg_match($regex_code, $user_activation_code))
			AND (preg_match($config['regex_email'], $email))
		) {
			// если они проходят проверку
		
			// делаем поиск записи с такими данными в базе
			$pattern = '
				SELECT
					users.*
				FROM
					users
				WHERE
					users.user_activation_code = ?
				AND
					users.user_email = ?
				LIMIT
					1
			';
			$value = array($user_activation_code, $email);
			$user = $db->query($pattern, $value)->row();
			
			if (!empty($user)) {
				// если есть пользователь с такими данными

				if (!$user['user_activation_state']) {
					// если не активирован ранее, то активируем

					// обновляем статус пользователя
					$pattern = '
						UPDATE
							users
						SET
							users.user_activation_state = 1
						WHERE
							users.user_activation_code = ?
						AND
							users.user_email = ?
						LIMIT
							1
						';
					$value = array($user_activation_code, $email);
					$activation = $db->query($pattern, $value);
					
					$result = 'activation_true';	// код ответа - активация успешно произведена

				} else {
					// если уже активирован ранее

					$result = 'activation_already';	// код ответа - активация была произведена ранее

				}
			} else {
				// если нет пользователей с таким кодом активации либо с таким e-mail

				$result = 'activation_wrong';	// код ответа - данные для активации неверные

			}
		} else {
			// если код либо е-mail не проходят проверку по маске

			$result = 'activation_wrong';	// код ответа - данные для активации неверные

		}
	}

	// подключаем текстовые данные для сборки ответа
	include $config['base_include_url'].'/login/tpl/login_text.php';
	
	// подключаем вёрстку для сборки ответа
	include $config['base_include_url'].'/login/tpl/login_tpl.php';

} else {
	// если пользователь залогинен и уже активирован - отправляем пользователя на страницу контента

	header ('Location: /'.$config['system_page']);
	exit();
}
?>
