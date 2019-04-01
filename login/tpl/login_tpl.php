<?php
// ******************************************** //
//
// общий html шаблон для всех форм и информационных страниц
//
// ******************************************** //

if (isset($page))
// защита на прямой вызов файла, его нельзя вызвать если не передана переменная $page со свойствами страницы вызова.
{
?>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?= $config['site_name'] ?> - <?= $title ?></title>
		<link href="<?= $config['base_site_url'] ?>/assets/css/login.css" rel="stylesheet">
	</head>
	<body>
		<div class="login_ext">
			<div class="login_int container">
	<? if (isset($form) AND $form == '1'): ?>
		<form class="login_form" action="<?= $form_action ?>" method="<?= $form_method ?>">
	<? else: ?>
		<div class="login_form">
	<? endif; ?>
			<div class="title">
				<? if (isset($h1)): ?>
				<h1><?= $h1 ?></h1>
				<? endif; ?>
				<div class="colorline"></div>
				<? if (isset($h2)): ?>
				<h2><?= $h2 ?></h2>
				<? endif; ?>
			</div>
			
	<? if (isset($form) AND $form == '1'): ?>
		<? if (isset($input_hidden_activation_code) AND $input_hidden_activation_code == '1'): ?>
			<input type="hidden" name="activation_code" value="<?= htmlspecialchars($user_activation_code) ?>" />
		<? endif; ?>
		
		<? if (isset($_GET['ref'])): ?>
			<input type="hidden" name="refreg_code" value="<?= htmlspecialchars($_GET['ref']) ?>" />
		<? endif; ?>
		
		<? if (isset($input_hidden_passwordreset_code) AND $input_hidden_passwordreset_code == '1'): ?>
			<input type="hidden" name="passwordreset_code" value="<?= htmlspecialchars($hidden_passwordreset_code) ?>" />
		<? endif; ?>
		
		<? if (isset($input_hidden_email) AND $input_hidden_email == '1'): ?>
			<input type="hidden" name="email" value="<?= htmlspecialchars($hidden_email) ?>" />
		<? endif; ?>
		
		<? if (isset($input_activation_code) AND $input_activation_code == '1'): ?>
			<p>
				<input name="activation_code" required="required" type="text" class="login_form_input" placeholder="<?= $input_activation_code_placeholder ?>">
			</p>
		<? endif; ?>
		
		<? if (isset($input_email) AND $input_email == '1'): ?>
			<p>
				<input name="email" required="required" type="text" class="login_form_input" <? if (isset($input_email_value)): ?>value="<?= htmlspecialchars($input_email_value) ?>" <? endif; ?>placeholder="<?= $input_email_placeholder ?>">
			</p>
		<? endif; ?>

		<? if (isset($input_password) AND $input_password == '1'): ?>
			<p>
				<input name="password" required="required" type="password" class="login_form_input" placeholder="<?= $input_password_placeholder ?>">
			</p>
		<? endif; ?>

		<? if (isset($input_invite) AND $input_invite == '1'): ?>
			<p>
				<input name="invite" required="required" type="text" class="login_form_input" placeholder="<?= $input_invitecode_placeholder ?>"
			<? if (isset($_GET['invite'])): ?>
				 value="<?= $_GET['invite'] ?>"
			<? endif; ?>
				>
			</p>
		<? endif; ?>
		
		<? if (isset($input_terms_checkbox) AND $input_terms_checkbox == '1'): ?>
			<p>
				<label class="login_form_checkbox"><input type="checkbox" class="login_form_checkbox" name="terms" value="terms" required="required" placeholder="<?= $terms_checkbox_placeholder ?>" /> <?= $terms_checkbox_text ?></label>
			</p>
		<? endif; ?>

		<? if (isset($btn)): ?>
			<p>
				<input type="submit" name="submit" value="<?= $btn_name ?>" class="login_form_btn">
			</p>
		<? endif; ?>
	<? endif; ?>

		<div class="footer">
			<? if(isset($footer_text)): ?>
			<p><?= $footer_text ?></p>
			<? endif; ?>
		</div>
			
	<? if (isset($form) AND $form == '1'): ?>
	</form>
	<? else: ?>
	</div>
	<? endif; ?>

		</div>
	</div>
	</body>
	</html>
<?php
}
else
{
	header('Location: /404.php'); exit();
}
?>