<?php
// ******************************************** //
//
// текстовые наполнения для всех форм и информационных страниц раздела логина
//
// ******************************************** //

if (isset($page)) {
	// защита на прямой вызов файла, его нельзя вызвать если не передана переменная $page со свойствами страницы вызова.

	// подключаем языковой файл. при необходимости можем реализовать мультиязычность через данную точку
	// для этого лишь надо принимать переменную с названием языка и на её основе подключать нужный файл
	require_once $config['base_include_url'].'/login/tpl/ru.php';

	// если не приняли дополнительные переменные
	($result) ? '' : $result = false;

	// ####################################################
	// ###			авторизация - login.php				###
	// ####################################################
	
	if ($result === 'login_form') {
		// форма авторизации, две ошибки авторизации - неправильны логин и неправильный пароль

		$title = $langpack['loginform_title'];
		$keywords = '';
		$description = '';
		$h1 = $langpack['loginform_h1'];

		if (!isset($error)) {
			// форма логина без ошибок
		
			$h2 = $langpack['loginform_h2'];

			($config['user_email_passwordreset']) ? $footer_text = $langpack['loginform_text'] : $footer_text = $langpack['loginform_text_no_resetpassword'];

		} else if ($error AND $error === 'password') {
			// неправильный пароль
		
			$h2 = $langpack['loginform_passwordincorrect_h2'];

			($config['user_email_passwordreset']) ? $footer_text = $langpack['loginform_passwordincorrect_text'] : $footer_text = $langpack['loginform_passwordincorrect_noreset_text'];

		} else if ($error AND $error === 'email') {
			// неправильный логин
		
			$h2 = $langpack['loginform_loginincorrect_h2'];
			$footer_text = $langpack['loginform_loginincorrect_text'];
		}

		$input_email_placeholder = $langpack['loginform_email_placeholder'];
		$input_password_placeholder = $langpack['loginform_password_placeholder'];
		$btn_name = $langpack['loginform_button'];

	} else if ($result === 'login_form_empty') {
		// данные не заполнены

		$title = $langpack['loginform_empty_title'];
		$h1 = $langpack['loginform_empty_h1'];
		$h2 = $langpack['loginform_empty_h2'];
		$footer_text = $langpack['loginform_empty_try_again_text'];

	} else if ($result === 'login_email_wrong') {
		// указанный e-mail некорректен

		$title = $langpack['loginform_email_wrong_title'];
		$h1 = $langpack['loginform_email_wrong_h1'];
		$h2 = $langpack['loginform_email_wrong_h2'];
		$footer_text = $langpack['loginform_email_wrong_text'];

	} else if ($result === 'user_disable') {
		// пользователь заблокирован

		$title = $langpack['user_disable_title'];
		$h1 = $langpack['user_disable_h1'];
		$h2 = $langpack['user_disable_h2'];
		$footer_text = $langpack['user_disable_text'];
	}

	// ####################################################
	// ###			регистрация - register.php			###
	// ####################################################

	else if ($result === 'register_form' OR $result === 'register_form_only_invite') {
		// форма регистрации

		$title = $langpack['registerform_title'];
		$keywords = '';
		$description = '';
		$h1 = $langpack['registerform_h1'];
		$h2 = $langpack['registerform_h2'];
		$terms_checkbox_text = $langpack['registerform_terms'];
		$terms_checkbox_placeholder = $langpack['registerform_terms_placeholder'];
		$input_email_placeholder = $langpack['registerform_email_placeholder'];
		$input_password_placeholder = $langpack['registerform_password_placeholder'];
		
		$input_invitecode_placeholder = $langpack['registerform_invitecode_placeholder'];
		
		$btn_name = $langpack['registerform_button'];
		
		if ($result === 'register_form') {
			$footer_text = $langpack['registerform_text'];
		} else if ($result === 'register_form_only_invite') {
			$footer_text = $langpack['registerform_text_only_invite'];
		}

	} else if ($result === 'registration_closed') {

		// регистрация закрыта
		$title = $langpack['register_closed_title'];
		$h1 = $langpack['register_closed_h1'];
		$h2 = $langpack['register_closed_h2'];
		$footer_text = $langpack['register_closed_text'];

	} else if ($result === 'register_form_empty') {
		// отправлена недозаполненная форма

		$title = $langpack['register_form_empty_title'];
		$h1 = $langpack['register_form_empty_h1'];
		$h2 = $langpack['register_form_empty_h2'];
		$footer_text = $langpack['register_form_empty_text'];

	} else if ($result === 'register_invite_wrong') {
		// указанный код приглашения некорректен

		$title = $langpack['register_invite_wrong_title'];
		$h1 = $langpack['register_invite_wrong_h1'];
		$h2 = $langpack['register_invite_wrong_h2'];
		$footer_text = $langpack['register_invite_wrong_text'];

	} else if ($result === 'register_email_wrong') {
		// указанный e-mail некорректен

		$title = $langpack['register_email_wrong_title'];
		$h1 = $langpack['register_email_wrong_h1'];
		$h2 = $langpack['register_email_wrong_h2'];
		$footer_text = $langpack['register_email_wrong_text'];

	} else if ($result === 'register_email_busy_activation_ok') {
		// указанный e-mail уже занят и аккаунт активирован

		$title = $langpack['register_email_busy_activation_ok_title'];
		$h1 = $langpack['register_email_busy_activation_ok_h1'];
		$h2 = $langpack['register_email_busy_activation_ok_h2'];
		$footer_text = $langpack['register_email_busy_activation_ok_text'];

	} else if ($result === 'register_email_busy_not_activation') {
		// указанный e-mail уже занят, но аккаунт не активирован

		$title = $langpack['register_email_busy_not_activation_title'];
		$h1 = $langpack['register_email_busy_not_activation_h1'];
		$h2 = $langpack['register_email_busy_not_activation_h2'];
		$footer_text = $langpack['register_email_busy_not_activation_text'];

	} else if ($result === 'register_true_code_send') {
		// успешная регистрация, код активации отправлен

		$title = $langpack['register_true_code_send_title'];
		$h1 = $langpack['register_true_code_send_h1'];
		$h2 = $langpack['register_true_code_send_h2'];
		$footer_text = $langpack['register_true_code_send_text'];

	} else if ($result === 'register_true') {
		// успешная регистрация, активация не требуется

		$title = $langpack['register_true_title'];
		$h1 = $langpack['register_true_h1'];
		$h2 = $langpack['register_true_h2'];
		$footer_text = $langpack['register_true_text'];
	}

	// ####################################################
	// ###			активация - activation.php			###
	// ####################################################

	else if ($result === 'activation_form') {
		// форма активации

		$title = $langpack['activation_form_title'];
		$keywords = '';
		$description = '';
		$h1 = $langpack['activation_form_h1'];
		$h2 = $langpack['activation_form_h2'];
		$input_activation_code_placeholder = $langpack['activation_form_code_placeholder'];
		$btn_name = $langpack['activation_form_button'];
		$footer_text = $langpack['activation_form_text'];

	} else if ($result === 'no_activation') {
		// ещё не ативирован

		$title = $langpack['no_activation_title'];
		$h1 = $langpack['no_activation_h1'];
		$h2 = $langpack['no_activation_h2'];
		$footer_text = $langpack['no_activation_text'];

	} else if ($result === 'activation_true') {
		// успешная активация

		$title = $langpack['activation_true_title'];
		$h1 = $langpack['activation_true_h1'];
		$h2 = $langpack['activation_true_h2'];
		$footer_text = $langpack['activation_true_text'];

	} else if ($result === 'activation_already') {
		// уже активирован

		$title = $langpack['activation_already_title'];
		$h1 = $langpack['activation_already_h1'];
		$h2 = $langpack['activation_already_h2'];
		$footer_text = $langpack['activation_already_text'];

	} else if ($result === 'activation_wrong') {
		// неверные данные для активации

		$title = $langpack['activation_wrong_title'];
		$h1 = $langpack['activation_wrong_h1'];
		$h2 = $langpack['activation_wrong_h2'];
		$footer_text = $langpack['activation_wrong_text'];
	}

	// ####################################################
	// ###		сброс пароля - resetpassword.php		###
	// ####################################################

	else if ($result === 'passwordreset_form') {
		// форма сброса пароля

		$title = $langpack['passwordreset_form_title'];
		$keywords = '';
		$description = '';
		$h1 = $langpack['passwordreset_form_h1'];
		$h2 = $langpack['passwordreset_form_h2'];
		$input_email_placeholder = $langpack['passwordreset_form_email_placeholder'];
		$btn_name = $langpack['passwordreset_form_button'];
		$footer_text = $langpack['passwordreset_form_text'];

	} else if ($result === 'passwordreset_true_code_send') {
		// успешно - письмо с инструкциями отправлено

		$title = $langpack['passwordreset_true_code_send_title'];
		$h1 = $langpack['passwordreset_true_code_send_h1'];
		$h2 = $langpack['passwordreset_true_code_send_h2'];
		$footer_text = $langpack['passwordreset_true_code_send_text'];

	} else if ($result === 'passwordreset_disable') {
		// ошибка - возможность отправки писем отключена

		$title = $langpack['passwordreset_disable_title'];
		$h1 = $langpack['passwordreset_disable_h1'];
		$h2 = $langpack['passwordreset_disable_h2'];
		$footer_text = $langpack['passwordreset_disable_text'];

	} else if ($result === 'passwordreset_email_not_found') {
		// ошибка - подходящего пользователя не нашли

		$title = $langpack['passwordreset_email_not_found_title'];
		$h1 = $langpack['passwordreset_email_not_found_h1'];
		$h2 = $langpack['passwordreset_email_not_found_h2'];
		$footer_text = $langpack['passwordreset_email_not_found_text'];

	} else if ($result === 'passwordreset_email_wrong') {
		// ошибка - указанный email некорректен

		$title = $langpack['passwordreset_email_wrong_title'];
		$h1 = $langpack['passwordreset_email_wrong_h1'];
		$h2 = $langpack['passwordreset_email_wrong_h2'];
		$footer_text = $langpack['passwordreset_email_wrong_text'];

	} else if ($result === 'newpassword_form') {
		// форма установки нового пароля

		$title = $langpack['newpassword_form_title'];
		$keywords = "";
		$description = "";
		$h1 = $langpack['newpassword_form_h1'];
		$h2 = $langpack['newpassword_form_h2'];
		$input_password_placeholder = $langpack['newpassword_form_password_placeholder'];
		$btn_name = $langpack['newpassword_form_button'];
		$footer_text = $langpack['newpassword_form_text'];

	} else if ($result === 'newpassword_true') {
		// пароль успешно установлен

		$title = $langpack['newpassword_true_title'];
		$h1 = $langpack['newpassword_true_h1'];
		$h2 = $langpack['newpassword_true_h2'];
		$footer_text = $langpack['newpassword_true_text'];

	} else if ($result === 'newpassword_code_wrong') {
		// код восстановления не совпадает

		$title = $langpack['newpassword_code_wrong_title'];
		$h1 = $langpack['newpassword_code_wrong_h1'];
		$h2 = $langpack['newpassword_code_wrong_h2'];
		$footer_text = $langpack['newpassword_code_wrong_text'];

	} else if ($result === 'newpassword_email_wrong') {
		// учётки с таким e-mail нет в базе

		$title = $langpack['newpassword_email_wrong_title'];
		$h1 = $langpack['newpassword_email_wrong_h1'];
		$h2 = $langpack['newpassword_email_wrong_h2'];
		$footer_text = $langpack['newpassword_email_wrong_text'];
	}

	// ####################################################
	// ###		сервисные сообщения						###
	// ####################################################

	else if ($result === 'system_offline') {
		// сервисный режим системы

		$title = $langpack['service_mode_form_title'];
		$keywords = '';
		$description = '';
		$h1 = $langpack['service_mode_form_h1'];
		$h2 = $langpack['service_mode_form_h2'];
		$footer_text = $langpack['service_mode_form_text'];
	}

} else {

	header('Location: /404.php'); exit();
}
?>