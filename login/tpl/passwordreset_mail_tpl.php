<?php
// ******************************************** //
//
// шаблон письма сброса пароля
//
// ******************************************** //

$subject = 'Восстановление пароля на сайте '.$config['site_name'],

$body = '
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body style="font-family: arial,helvetica,sans-serif!important;
			font-size: 16px;
			line-height: 1.7;
			color: #333;
			background-color: #f5f5f5;
			margin: 0;">
    <div style="width: 800px;
            margin: 0 auto;
			background-color: #fff;">
	<div align="center" bgcolor="#FFFFFF" valign="top" width="100%"> 	
<table align="center" border="0" cellpadding="0" cellspacing="0" style="color:#606060; border-collapse: collapse; font:12px arial,helvetica,sans-serif!important " width="800">
	<tbody> 
		<tr> 
			<td align="center" style="color: #fff; background-color: #59ABE3; padding-top: 10px; padding-bottom: 10px; font:bold 15px arial,helvetica,sans-serif!important">
				<div style="padding-top: 20px;
								padding-bottom: 20px;
								line-height: 1.4;
								background: #59ABE3;
								color: white;">
					<div style="width:700px;
								margin:0 auto;
								text-align: center;">
						<h2>Восстановление пароля на сайте '.$config['site_name'].'</h2>
					</div>
				</div>
			</td> 
		</tr> 
		<tr> 
			<td bgcolor="#F5F5F5" style="color:#2c2c2b;font:16px arial,helvetica,sans-serif!important;padding:0px 30px 25px 30px" width="540">
				<p><h3>Здравствуйте!</h3></p>
				<p>
					Вы запросили ссылку восстановления пароля на сайте <span style="color: #59ABE3;">'.$config['site_name'].'</span>
				</p>
				<p>
					Для установки нового пароля необходимо перейти по этой <a tyle="color: #59ABE3;" href="'.$config['base_site_url'].'/login/newpassword.php?email='.$user['user_email'].'&passwordreset_code='.$passwordreset_code.'">ссылке</a>
				</p>
				<p>
					Если она не работает, скопируйте этот код и вставьте в адресную строку браузера:<br /><br />
					<strong>'.$config['base_site_url'].'/login/newpassword.php?email='.$user['user_email'].'&passwordreset_code='.$passwordreset_code.'</strong></p>
				<p>
					Если Вы не знаете о чём речь и первый раз слышите о таком сайте, то, возможно, кто-то ошибочно указал Ваш адрес электронной почты.<br />
					В таком случае просто проигнорируйте это письмо.
				</p>
			</td> 
		</tr> 
		<tr> 
			<td style="color: #fff; background-color: #59ABE3; padding-top: 10px; padding-bottom: 10px;" width="560">
			    <div style="padding-top: 15px;
								padding-bottom: 0px;
								line-height: 1.4;
								background: #59ABE3;
								color: white;
								margin-bottom:25px;">
					<div style="width:700px;
								margin:0 auto;
								text-align: center;">
						<h2>'.$config['site_name'].'</h2>
					</div>
				</div>
			</td> 
		</tr>
		<tr>
			<td bgcolor="#F5F5F5" style="color:#2c2c2b;">
				<small>Данное письмо сгенерировано автоматически. Пожалуйста, не отвечайте на него.</small>
			</td>
		</tr>
	</tbody> 
</table>
</body>

</html>';

?>