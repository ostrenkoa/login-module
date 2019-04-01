<?php
// ******************************************** //
//
// разлогин с сайта
//
// ******************************************** //

// свойства файла, используются для защиты на прямой вызов служебных скриптов
$page = array(
'type' 		=> 'logout'
);

// подключаем основной файл конфигурации
$g_root = $_SERVER['DOCUMENT_ROOT'];
include_once ($g_root.'/config.php');

// вызываем файл аутентификации пользователя
include_once ($config['base_include_url'].$config['url_UAC_file']);

if ($user_login)
// если пользователь залогинен - разлогиниваем
{
	// сбрасываем хеш в базе
	$pattern = '
		UPDATE
			users
		SET
			users.user_hash = 0
		WHERE
			users.user_id = ?i
		LIMIT
			1
		';
	$value = array($userconfig['user_id']);
	$data = $db->query($pattern, $value);
}

// обнуляем куки
setcookie ('cookie_user_id', '', time() - 3600*24*30*12, '/');
setcookie ('cookie_hash', '', time() - 3600*24*30*12, '/');

// отправляем на форму логина
header ('Location: /login/login.php');
exit();

?>