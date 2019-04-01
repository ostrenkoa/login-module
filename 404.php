<?php
header("HTTP/1.0 404 Not Found");

echo'
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>Login Module</title>
	<link href="/assets/css/login.css" rel="stylesheet" />
</head>
<body>
	<div class="login_ext">
		<div class="login_int container">
			<div class="login_form">
				<div class="title">
					<h1>Такой страницы не существует</h1>
					<div class="colorline"></div>
					<h2>Вернитесь назад и попробуйте что-то ещё</h2>
				</div>
				<div class="footer">
					<p>Возможно, Вам помогут эти ссылки:</p>
					<p>  
						<a href="login/register.php">Регистрация</a>  -  
						<a href="login/login.php">Авторизация</a>  -  
						<a href="/">Главная страница</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
';
?>