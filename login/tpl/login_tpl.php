<?php
// ******************************************** //
//
// общий html шаблон для всех форм и информационных страниц
//
// ******************************************** //

if (isset($page)) {
	// защита на прямой вызов файла, его нельзя вызвать если не передана переменная $page со свойствами страницы вызова.

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
	<? if (isset($form)): ?>
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
			
	<? if (isset($form)): ?>		
		<? if (isset($refregcode)): ?>
			<input type="hidden" name="refregcode" value="<?= htmlspecialchars($refregcode) ?>" />
		<? endif; ?>
		
		<? if (isset($hidden_passwordreset_code)): ?>
			<input type="hidden" name="passwordreset_code" value="<?= htmlspecialchars($hidden_passwordreset_code) ?>" />
		<? endif; ?>
		
		<? if (isset($hidden_email)): ?>
			<input type="hidden" name="email" value="<?= htmlspecialchars($hidden_email) ?>" />
		<? endif; ?>
		
		<? if (isset($input_activation_code)): ?>
			<p>
				<input name="activation_code" required="required" type="text" class="login_form_input" placeholder="<?= $input_activation_code_placeholder ?>">
			</p>
		<? endif; ?>
		
		<? if (isset($input_email)): ?>
			<p>
				<input name="email" required="required" type="text" class="login_form_input" <? if (isset($input_email_value)): ?>value="<?= htmlspecialchars($input_email_value) ?>" <? endif; ?>placeholder="<?= $input_email_placeholder ?>">
			</p>
		<? endif; ?>

		<? if (isset($input_password)): ?>
			<p>
				<input name="password" required="required" type="password" class="login_form_input" placeholder="<?= $input_password_placeholder ?>">
			</p>
		<? endif; ?>

		<? if (isset($input_invite)): ?>
			<p>
				<input name="invite" required="required" type="text" class="login_form_input" placeholder="<?= $input_invitecode_placeholder ?>"
			<? if (isset($invitecode)): ?>
				 value="<?= $invitecode ?>"
			<? endif; ?>
				>
			</p>
		<? endif; ?>
		
		<? if (isset($input_terms_checkbox)): ?>
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
			<? if (isset($footer_text)): ?>
			<p><?= $footer_text ?></p>
			<? endif; ?>
		</div>
			
	<? if (isset($form)): ?>
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