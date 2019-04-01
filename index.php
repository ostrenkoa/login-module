<?php
// ******************************************** //
//
// Данный файл может являться основой для любого файла системы, 
// доступ к которому должен быть только у зарегистрированных пользователей.
//
// ******************************************** //

// свойства файла, используются для защиты на прямой вызов служебных скриптов
$page = array(
'type' => 'index'
);

// подключаем основной файл конфигурации
$g_root = $_SERVER['DOCUMENT_ROOT'];
include_once ($g_root.'/config.php');

// вызываем файл аутентификации пользователя
include_once ($config['base_include_url'].$config['url_UAC_file']);

if ($user_login)
// если пользователь залогинен - показываем содержимое
{
	// сюда вставляем основное наполнение каждой страницы закрытого раздела сайта в каком угодно виде
?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title><?= $config['site_name'] ?></title>
		<link href="/assets/css/login.css" rel="stylesheet" />
	</head>
	<body>
		<div class="login_ext">
			<div class="login_int container">
				<div class="login_form">
					<div class="title">
						<h1>Login module</h1>
						<div class="colorline"></div>
						<h2>This is a test page for login module. Welcome, <?= $userconfig['user_email'] ?>!</h2>
					</div>
					<div class="footer">
						<p>logout link is <a href="login/logout.php">here</a></p>
					</div>
				</div>
			</div>
		</div>
	</body>
	</html>
<?php
}
else
// если не залогинен - отправляем на страницу логина
{
	//header('Location: /login/login.php');
	//exit();
	// следующий код можно убрать
?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title><?= $config['site_name'] ?></title>
		<link href="/assets/css/login.css" rel="stylesheet" />
	</head>
	<body>
		<div class="login_ext">
			<div class="login_int container">
				<div class="login_form">
					<div class="title">
						<h1>Login module</h1>
						<div class="colorline"></div>
						<h2>Please, login <a href="login/login.php">here</a></h2>
					</div>
					<div class="footer">
						<p> </p>
					</div>
				</div>
			</div>
		</div>
	</body>
	</html>
<?php
}

?>