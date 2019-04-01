<?php
// ******************************************** //
//
// текстовые наполнения для всех форм и информационных страниц раздела логина
//
// ******************************************** //

if (isset($page))
// защита на прямой вызов файла, его нельзя вызвать если не передана переменная $page со свойствами страницы вызова.
{
	// подключаем языковой файл. при необходимости можем реализовать мультиязычность через данную точку
	// для этого лишь надо принимать переменную с названием языка и на её основе подключать нужный файл
	include $config['base_include_url'].'/login/tpl/ru.php';

	if (!isset($result)) {$result = false;}

	// ####################################################
	// ###			авторизация - login.php				###
	// ####################################################

	// форма авторизации, две ошибки авторизации - неправильны логин и неправильный пароль
	if ($result == 'login_form')
	{
		$title = $langpack['loginform_title'];
		$keywords = '';
		$description = '';
		$h1 = $langpack['loginform_h1'];

		if (!isset($error))
		// форма логина без ошибок
		{
			$h2 = $langpack['loginform_h2'];

			if ($config['user_email_passwordreset'] == true)
			// если можно - даём ссылку на восстановление пароля
			{
				$footer_text = $langpack['loginform_text'];
			}
			else
			// если нет - текст без ссылки
			{
				$footer_text = $langpack['loginform_text_no_resetpassword'];
			}
		}
		else if (isset($error) AND $error == 'password')
		// неправильный пароль
		{
			$h2 = $langpack['loginform_passwordincorrect_h2'];

			if ($config['user_email_passwordreset'] == true)
			// если можно - даём ссылку на восстановление пароля
			{
				$footer_text = $langpack['loginform_passwordincorrect_text'];
			}
			else
			// если нет - отправляем в поддержку
			{
				$footer_text = $langpack['loginform_passwordincorrect_noreset_text'];
			}
		}
		else if (isset($error) AND $error == 'email')
		// неправильный логин
		{
			$h2 = $langpack['loginform_loginincorrect_h2'];
			$footer_text = $langpack['loginform_loginincorrect_text'];
		}

		$input_email_placeholder = $langpack['loginform_email_placeholder'];
		$input_password_placeholder = $langpack['loginform_password_placeholder'];
		$btn_name = $langpack['loginform_button'];
	}

	// данные не заполнены
	else if ($result == 'login_form_empty')
	{
		$title = $langpack['loginform_empty_title'];
		$h1 = $langpack['loginform_empty_h1'];
		$h2 = $langpack['loginform_empty_h2'];
		$footer_text = $langpack['loginform_empty_try_again_text'];
	}

	// указанный e-mail некорректен
	else if ($result == 'login_email_wrong')
	{
		$title = $langpack['loginform_email_wrong_title'];
		$h1 = $langpack['loginform_email_wrong_h1'];
		$h2 = $langpack['loginform_email_wrong_h2'];
		$footer_text = $langpack['loginform_email_wrong_text'];
	}

	// пользователь заблокирован
	else if ($result == 'user_disable')
	{
		$title = $langpack['user_disable_title'];
		$h1 = $langpack['user_disable_h1'];
		$h2 = $langpack['user_disable_h2'];
		$footer_text = $langpack['user_disable_text'];
	}

	// ####################################################
	// ###			регистрация - register.php			###
	// ####################################################

	// форма регистрации
	else if ($result == 'register_form' OR $result == 'register_form_only_invite')
	{
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
		
		if ($result == 'register_form')
		{
			$footer_text = $langpack['registerform_text'];
		}
		else if ($result == 'register_form_only_invite')
		{
			$footer_text = $langpack['registerform_text_only_invite'];
		}
	}

	// регистрация закрыта
	else if ($result == 'registration_closed')
	{
		$title = $langpack['register_closed_title'];
		$h1 = $langpack['register_closed_h1'];
		$h2 = $langpack['register_closed_h2'];
		$footer_text = $langpack['register_closed_text'];
	}

	// отправлена недозаполненная форма
	else if ($result == 'register_form_empty')
	{
		$title = $langpack['register_form_empty_title'];
		$h1 = $langpack['register_form_empty_h1'];
		$h2 = $langpack['register_form_empty_h2'];
		$footer_text = $langpack['register_form_empty_text'];
	}

	// указанный код приглашения некорректен
	else if ($result == 'register_invite_wrong')
	{
		$title = $langpack['register_invite_wrong_title'];
		$h1 = $langpack['register_invite_wrong_h1'];
		$h2 = $langpack['register_invite_wrong_h2'];
		$footer_text = $langpack['register_invite_wrong_text'];
	}

	// указанный e-mail некорректен
	else if ($result == 'register_email_wrong')
	{
		$title = $langpack['register_email_wrong_title'];
		$h1 = $langpack['register_email_wrong_h1'];
		$h2 = $langpack['register_email_wrong_h2'];
		$footer_text = $langpack['register_email_wrong_text'];
	}
	// указанный e-mail уже занят и аккаунт активирован
	else if ($result == 'register_email_busy_activation_ok')
	{
		$title = $langpack['register_email_busy_activation_ok_title'];
		$h1 = $langpack['register_email_busy_activation_ok_h1'];
		$h2 = $langpack['register_email_busy_activation_ok_h2'];
		$footer_text = $langpack['register_email_busy_activation_ok_text'];
	}
	// указанный e-mail уже занят, но аккаунт не активирован
	else if ($result == 'register_email_busy_not_activation')
	{
		$title = $langpack['register_email_busy_not_activation_title'];
		$h1 = $langpack['register_email_busy_not_activation_h1'];
		$h2 = $langpack['register_email_busy_not_activation_h2'];
		$footer_text = $langpack['register_email_busy_not_activation_text'];
	}
	// успешная регистрация, код активации отправлен
	else if ($result == 'register_true_code_send')
	{
		$title = $langpack['register_true_code_send_title'];
		$h1 = $langpack['register_true_code_send_h1'];
		$h2 = $langpack['register_true_code_send_h2'];
		$footer_text = $langpack['register_true_code_send_text'];
	}
	// успешная регистрация, активация не требуется
	else if ($result == 'register_true')
	{
		$title = $langpack['register_true_title'];
		$h1 = $langpack['register_true_h1'];
		$h2 = $langpack['register_true_h2'];
		$footer_text = $langpack['register_true_text'];
	}

	// ####################################################
	// ###			активация - activation.php			###
	// ####################################################

	// форма активации
	else if ($result == 'activation_form')
	{
		$title = $langpack['activation_form_title'];
		$keywords = '';
		$description = '';
		$h1 = $langpack['activation_form_h1'];
		$h2 = $langpack['activation_form_h2'];
		$input_activation_code_placeholder = $langpack['activation_form_code_placeholder'];
		$btn_name = $langpack['activation_form_button'];
		$footer_text = $langpack['activation_form_text'];
	}
	// ещё не ативирован
	else if ($result == 'no_activation')
	{
		$title = $langpack['no_activation_title'];
		$h1 = $langpack['no_activation_h1'];
		$h2 = $langpack['no_activation_h2'];
		$footer_text = $langpack['no_activation_text'];
	}
	// успешная активация
	else if ($result == 'activation_true')
	{
		$title = $langpack['activation_true_title'];
		$h1 = $langpack['activation_true_h1'];
		$h2 = $langpack['activation_true_h2'];
		$footer_text = $langpack['activation_true_text'];
	}
	// уже активирован
	else if ($result == 'activation_already')
	{
		$title = $langpack['activation_already_title'];
		$h1 = $langpack['activation_already_h1'];
		$h2 = $langpack['activation_already_h2'];
		$footer_text = $langpack['activation_already_text'];;
	}
	// неверные данные для активации
	else if ($result == 'activation_wrong')
	{
		$title = $langpack['activation_wrong_title'];
		$h1 = $langpack['activation_wrong_h1'];
		$h2 = $langpack['activation_wrong_h2'];
		$footer_text = $langpack['activation_wrong_text'];
	}

	// ####################################################
	// ###		сброс пароля - resetpassword.php		###
	// ####################################################

	// форма сброса пароля
	else if ($result == 'passwordreset_form')
	{
		$title = $langpack['passwordreset_form_title'];
		$keywords = '';
		$description = '';
		$h1 = $langpack['passwordreset_form_h1'];
		$h2 = $langpack['passwordreset_form_h2'];
		$input_email_placeholder = $langpack['passwordreset_form_email_placeholder'];
		$btn_name = $langpack['passwordreset_form_button'];
		$footer_text = $langpack['passwordreset_form_text'];
	}
	// успешно - письмо с инструкциями отправлено
	else if ($result == 'passwordreset_true_code_send')
	{
		$title = $langpack['passwordreset_true_code_send_title'];
		$h1 = $langpack['passwordreset_true_code_send_h1'];
		$h2 = $langpack['passwordreset_true_code_send_h2'];
		$footer_text = $langpack['passwordreset_true_code_send_text'];
	}
	// ошибка - возможность отправки писем отключена
	else if ($result == 'passwordreset_disable')
	{
		$title = $langpack['passwordreset_disable_title'];
		$h1 = $langpack['passwordreset_disable_h1'];
		$h2 = $langpack['passwordreset_disable_h2'];
		$footer_text = $langpack['passwordreset_disable_text'];
	}
	// ошибка - подходящего пользователя не нашли
	else if ($result == 'passwordreset_email_not_found')
	{
		$title = $langpack['passwordreset_email_not_found_title'];
		$h1 = $langpack['passwordreset_email_not_found_h1'];
		$h2 = $langpack['passwordreset_email_not_found_h2'];
		$footer_text = $langpack['passwordreset_email_not_found_text'];
	}
	// ошибка - указанный email некорректен
	else if ($result == 'passwordreset_email_wrong')
	{
		$title = $langpack['passwordreset_email_wrong_title'];
		$h1 = $langpack['passwordreset_email_wrong_h1'];
		$h2 = $langpack['passwordreset_email_wrong_h2'];
		$footer_text = $langpack['passwordreset_email_wrong_text'];
	}

	// форма установки нового пароля
	else if ($result == 'newpassword_form')
	{
		$title = $langpack['newpassword_form_title'];
		$keywords = "";
		$description = "";
		$h1 = $langpack['newpassword_form_h1'];
		$h2 = $langpack['newpassword_form_h2'];
		$input_password_placeholder = $langpack['newpassword_form_password_placeholder'];
		$btn_name = $langpack['newpassword_form_button'];
		$footer_text = $langpack['newpassword_form_text'];
	}
	// пароль успешно установлен
	else if ($result == 'newpassword_true')
	{
		$title = $langpack['newpassword_true_title'];
		$h1 = $langpack['newpassword_true_h1'];
		$h2 = $langpack['newpassword_true_h2'];
		$footer_text = $langpack['newpassword_true_text'];
	}
	// код восстановления не совпадает
	else if ($result == 'newpassword_code_wrong')
	{
		$title = $langpack['newpassword_code_wrong_title'];
		$h1 = $langpack['newpassword_code_wrong_h1'];
		$h2 = $langpack['newpassword_code_wrong_h2'];
		$footer_text = $langpack['newpassword_code_wrong_text'];
	}
	// учётки с таким e-mail нет в базе
	else if ($result == 'newpassword_email_wrong')
	{
		$title = $langpack['newpassword_email_wrong_title'];
		$h1 = $langpack['newpassword_email_wrong_h1'];
		$h2 = $langpack['newpassword_email_wrong_h2'];
		$footer_text = $langpack['newpassword_email_wrong_text'];
	}

	// ####################################################
	// ###		сервисные сообщения - message.php		###
	// ####################################################

	// сервисный режим системы
	else if ($result == "system_offline")
	{
		$title = $langpack['service_mode_form_title'];
		$keywords = "";
		$description = "";
		$h1 = $langpack['service_mode_form_h1'];
		$h2 = $langpack['service_mode_form_h2'];
		$footer_text = $langpack['service_mode_form_text'];
	}
}
else
{
	header('Location: /404.php'); exit();
}
?>