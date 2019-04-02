<?php
if (isset($page)) {
	// защита на прямой вызов файла, его нельзя вызвать если не передана переменная $page со свойствами страницы вызова.

	// подключаем основной файл конфигурации если вдруг не подключили его в основном файле
	$g_root = $_SERVER['DOCUMENT_ROOT'];
	require_once ($g_root.'/config.php');

	if (isset($_COOKIE['cookie_user_id'], $_COOKIE['cookie_hash'])) {
		// если наши куки у пользователя найдены

		// шифруем хэш с солью
		$dbhash = hash('sha512', $_COOKIE['cookie_hash'].$config['salt']);

		// запрашиваем пользователя с таким id и хэш из базы
		$pattern = '
			SELECT
				users.*
			FROM
				users
			WHERE
				users.user_id = ?i
			AND
				users.user_hash = ?
			LIMIT
				1
		';
		$value = array($_COOKIE['cookie_user_id'], $dbhash);
		$userconfig = $db->query($pattern, $value)->row();
		
		if (!empty($userconfig)) {
			// если пользователь найден в базе

			if ((int)$userconfig['user_state'] === 1) {
				// если пользователь не заблокирован (поле "user_state" в базе)

				if ($config['system_state']) {
					// если система не в сервисном режиме

					$user_login = true;	// разрешаем доступ

				} else {
					// если сервисный режим активен

					if ((int)$userconfig['user_admin'] !== 1) {
						// если пользователь не является админом

						// сбрасываем куки
						setcookie("cookie_user_id", "", time() - 3600*24*30*12, "/");
						setcookie("cookie_hash", "", time() - 3600*24*30*12, "/");
						
						$user_login = false; // запрещаем доступ

					} else {
						// если это админ
						
						$user_login = true;	// разрешаем доступ
					}
				}
			} else {
				// если пользователь заблокирован

				$user_login = false; // запрещаем доступ

			}
		} else {
			// если не найден такой пользователь в базе

			// сбрасываем куки		
			setcookie("cookie_user_id", "", time() - 3600*24*30*12, "/");
			setcookie("cookie_hash", "", time() - 3600*24*30*12, "/");
			
			$user_login = false; // запрещаем доступ
		}
	} else {
		// если куки не найдёны
	
		$user_login = false; // запрещаем доступ
	}
} else {
	// если была попытка прямого вызова файла

	header('Location: /404.php'); // отправляем в 404
	exit();
}
?>
