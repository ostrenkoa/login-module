<?php

// ####################################################
// ###			Языковой файл раздела логина		###
// ####################################################

$langpack = array(

// авторизация - login.php
// форма авторизации	-	login_form
'loginform_title'							=> 'Система',
'loginform_h1'								=> 'Авторизация',
'loginform_h2'								=> 'Укажите необходимые данные для доступа<br />Если у Вас нет аккаунта, <a href="register.php">зарегистрируйтесь</a>',
'loginform_email_placeholder'				=> 'Ваш e-mail',
'loginform_password_placeholder'			=> 'Ваш пароль',
'loginform_button'							=> 'Авторизация',
'loginform_text'							=> 'Использование системы без ввода логина и пароля невозможно. Если Вы забыли пароль, перейдите по <a href="resetpassword.php">этой ссылке</a>',
'loginform_text_no_resetpassword'			=> 'Использование системы без ввода логина и пароля невозможно.',

// ошибка авторизации	-	login_form
// неправильный пароль
'loginform_passwordincorrect_h2'			=> 'Неверный пароль, вернитесь назад и попробуйте ещё раз.',
'loginform_passwordincorrect_text'			=> 'Если Вы забыли пароль и хотите его восстановить, перейдите по <a href="resetpassword.php">этой ссылке</a>',
'loginform_passwordincorrect_noreset_text'	=> 'Если Вы забыли пароль и хотите его восстановить, <br />напишите нам на <a href="mailto:'.$config['email_support'].'">'.$config['email_support'].'</a> с адреса, который использовался при регистрации в системе.',
// неправильный логин
'loginform_loginincorrect_h2'				=> 'Аккаунт с таким e-mail не найден. Проверьте введённые данные либо <a href="register.php">зарегистрируйтесь</a>',
'loginform_loginincorrect_text'				=> 'Если уверенны в корректности действий, но ошибка не исчезает, <br />напишите нам на <a href="mailto:'.$config['email_support'].'">'.$config['email_support'].'</a> с адреса, который <br />использовался при регистрации в системе.',

// данные не заполнены	-	login_form_empty
'loginform_empty_title'						=> 'Система',
'loginform_empty_h1'						=> 'Авторизация',
'loginform_empty_h2'						=> 'Не заполнены обязательные поля',
'loginform_empty_try_again_text'			=> 'Пожалуйста, вернитесь назад и попробуйте снова.<br />Если уверенны в корректности действий, но ошибка не исчезает - напишите нам на <a href="mailto:'.$config['email_support'].'">'.$config['email_support'].'</a> с адреса, который <br />использовался при регистрации в системе.',

// email некорректен	-	login_email_wrong
'loginform_email_wrong_title'				=> 'Система',
'loginform_email_wrong_h1'					=> 'Авторизация',
'loginform_email_wrong_h2'					=> 'Некорректный e-mail',
'loginform_email_wrong_text'				=> 'Пожалуйста, вернитесь назад и попробуйте снова.<br />Если уверенны в корректности действий, но ошибка не исчезает - напишите нам на <a href="mailto:'.$config['email_support'].'">'.$config['email_support'].'</a> с адреса, который <br />использовался при регистрации в системе.',

// пользователь заблокирован - user_disable
'user_disable_title'						=> 'Система',
'user_disable_h1'							=> 'Авторизация',
'user_disable_h2'							=> 'Пользователь заблокирован',
'user_disable_text'							=> 'Вход под этими учётными данными невозможен.<br />Напишите нам на <a href="mailto:'.$config['email_support'].'">'.$config['email_support'].'</a> с адреса, который <br />использовался при регистрации в системе.',


// регистрация - register.php
// форма регистрации	-	register_form
'registerform_title'						=> 'Система',
'registerform_h1'							=> 'Регистрация',
'registerform_h2'							=> 'Укажите необходимые данные для доступа<br />Если уже регистрировались ранее - <a href="login.php">войдите</a>',
'registerform_email_placeholder'			=> 'Ваш e-mail',
'registerform_password_placeholder'			=> 'Ваш пароль',
'registerform_invitecode_placeholder'		=> 'Код приглашения',
'registerform_terms'						=> 'Согласен с <a href="'.$config['terms_page'].'">условиями использования</a>',
'registerform_terms_placeholder'			=> 'Согласен с условиями использования',
'registerform_button'						=> 'Зарегистрироваться',
'registerform_text_only_invite'				=> 'В данный момент система находится в режиме ограниченного доступа.<br />Для получения кода приглашения напишите нам на <a href="mailto:'.$config['email_support'].'">'.$config['email_support'].'</a>.',
'registerform_text'							=> 'Использование системы без предварительной регистрации невозможно.<br />Придумайте максимально сложный пароль используя буквы a-z A-Z, цифры 0-9, cимволы .,-_!?@ и не сообщайте его никому.',

// регистрация закрыта	-	registration_closed
'register_closed_title'						=> 'Система',
'register_closed_h1'						=> 'Регистрация',
'register_closed_h2'						=> 'Регистрация закрыта',
'register_closed_text'						=> 'В данный момент возможность самостоятельной регистрации новых пользователей отключена администратором системы.<br />Для регистрации напишите нам на <a href="mailto:'.$config['email_support'].'">'.$config['email_support'].'</a>',

// отправлена недозаполненная форма	-	register_form_empty
'register_form_empty_title'					=> 'Система',
'register_form_empty_h1'					=> 'Регистрация',
'register_form_empty_h2'					=> 'Не заполнены обязательные поля',
'register_form_empty_text'					=> 'Пожалуйста, вернитесь назад и попробуйте снова.<br />Если уверенны в корректности действий, но ошибка не исчезает - напишите нам на <a href="mailto:'.$config['email_support'].'">'.$config['email_support'].'</a>',

// код приглашения некорректен	-	register_invite_wrong
'register_invite_wrong_title'				=> 'Система',
'register_invite_wrong_h1'					=> 'Регистрация',
'register_invite_wrong_h2'					=> 'Некорректный код приглашения',
'register_invite_wrong_text'				=> 'Пожалуйста, вернитесь назад и попробуйте снова.<br />Если уверенны в корректности действий, но ошибка не исчезает - напишите нам на <a href="mailto:'.$config['email_support'].'">'.$config['email_support'].'</a>',

// email некорректен	-	register_email_wrong
'register_email_wrong_title'				=> 'Система',
'register_email_wrong_h1'					=> 'Регистрация',
'register_email_wrong_h2'					=> 'Некорректный e-mail',
'register_email_wrong_text'					=> 'Пожалуйста, вернитесь назад и попробуйте снова.<br />Если уверенны в корректности действий, но ошибка не исчезает - напишите нам на <a href="mailto:'.$config['email_support'].'">'.$config['email_support'].'</a>',

// email занят, аккаунт активирован	-	register_email_busy_activation_ok
'register_email_busy_activation_ok_title'	=> 'Система',
'register_email_busy_activation_ok_h1'		=> 'Регистрация',
'register_email_busy_activation_ok_h2'		=> 'Данный e-mail уже зарегистрирован в системе',
'register_email_busy_activation_ok_text'	=> 'Если вы регистрировались ранее, то <a href="login.php">войдите в систему</a> используя логин и пароль.',

// email занят, аккаунт не активирован	-	register_email_busy_not_activation
'register_email_busy_not_activation_title'	=> 'Система',
'register_email_busy_not_activation_h1'		=> 'Регистрация',
'register_email_busy_not_activation_h2'		=> 'Данный e-mail уже зарегистрирован в системе',
'register_email_busy_not_activation_text'	=> 'Активация аккаунта не была проведена ранее. Для активации аккаунта найдите в электронной почте письмо, содержащее код активации, и перейдите по ссылке.',

// успешная регистрация, код активации отправлен	-	register_true_code_send
'register_true_code_send_title'				=> 'Система',
'register_true_code_send_h1'				=> 'Регистрация',
'register_true_code_send_h2'				=> 'Регистрация прошла успешно',
'register_true_code_send_text'				=> 'На указанный адрес электронной почты была отправлена ссылка активации (письмо может идти до 5 минут).<br />Для доступа к сайту необходимо произвести активацию перейдя по ссылке.',

// успешная регистрация, активация не требуется	-	register_true
'register_true_title'						=> 'Система',
'register_true_h1'							=> 'Регистрация',
'register_true_h2'							=> 'Регистрация прошла успешно',
'register_true_text'						=> 'Вы можете <a href="login.php">авторизоваться</a> на сайте.',


// активация - activation.php
// форма активации	-	activation_form
'activation_form_title'						=> 'Система',
'activation_form_h1'						=> 'Активация аккаунта',
'activation_form_h2'						=> 'Введите код активации',
'activation_form_code_placeholder'			=> 'Код активации',
'activation_form_button'					=> 'Активировать',
'activation_form_text'						=> 'Для начала работы с системой необходимо подтвердить e-mail, указанный при регистрации, активировав аккаунт.',

// ещё не активирован	-	no_activation
'no_activation_title'						=> 'Система',
'no_activation_h1'							=> 'Активация аккаунта',
'no_activation_h2'							=> 'Ваш аккаунт ещё не активирован',
'no_activation_text'						=> 'Следуйте указаниям из отправленного на электронную почту письма. <br />Если письмо долго не приходит, напишите нам на <a href="mailto:'.$config['email_support'].'">'.$config['email_support'].'</a> <br />с адреса, который использовался при регистрации в системе.',

// успешная активация	-	activation_true
'activation_true_title'						=> 'Система',
'activation_true_h1'						=> 'Активация аккаунта',
'activation_true_h2'						=> 'Ваш аккаунт успешно активирован',
'activation_true_text'						=> 'Теперь можно <a href="login.php">авторизоваться</a> на сайте.',

// уже активирован ранее	-	activation_already
'activation_already_title'					=> 'Система',
'activation_already_h1'						=> 'Активация аккаунта',
'activation_already_h2'						=> 'Ваш аккаунт уже был активирован ранее',
'activation_already_text'					=> 'Вы можете <a href="login.php">авторизоваться</a> на сайте.',

// неверные данные для активации	-	activation_wrong
'activation_wrong_title'					=> 'Система',
'activation_wrong_h1'						=> 'Активация аккаунта',
'activation_wrong_h2'						=> 'Неверные данные для активации',
'activation_wrong_text'						=> 'Пожалуйста, вернитесь назад и попробуйте снова.<br />Если уверенны в корректности действий, но ошибка не исчезает - напишите нам на <a href="mailto:'.$config['email_support'].'">'.$config['email_support'].'</a><br />с адреса, который использовался при регистрации в системе.',


// сброс пароля - resetpassword.php
// форма сброса пароля	-	passwordreset_form
'passwordreset_form_title'					=> 'Система',
'passwordreset_form_h1'						=> 'Сброс пароля',
'passwordreset_form_h2'						=> 'Укажите e-mail своей учётной записи',
'passwordreset_form_email_placeholder'		=> 'Ваш e-mail',
'passwordreset_form_button'					=> 'Сбросить',
'passwordreset_form_text'					=> 'На указанный e-mail будет отправлено письмо с инструкцией для сброса пароля.',

// письмо с инструкциями отправлено	-	passwordreset_true_code_send
'passwordreset_true_code_send_title'		=> 'Система',
'passwordreset_true_code_send_h1'			=> 'Сброс пароля',
'passwordreset_true_code_send_h2'			=> 'На указанный адрес электронной почты была отправлена инструкция по установке нового пароля.',
'passwordreset_true_code_send_text'			=> '',

// восстановление пароля отключено	-	passwordreset_disable
'passwordreset_disable_title'				=> 'Система',
'passwordreset_disable_h1'					=> 'Сброс пароля',
'passwordreset_disable_h2'					=> 'В настоящий момент самостоятельный сброс пароля для учётной записи невозможен',
'passwordreset_disable_text'				=> 'Попробуйте ещё раз через некоторое время, <br />либо напишите нам на <a href="mailto:'.$config['email_support'].'">'.$config['email_support'].'</a> с адреса, <br />который использовался при регистрации в системе.',

// email не найден	-	passwordreset_email_not_found
'passwordreset_email_not_found_title'		=> 'Система',
'passwordreset_email_not_found_h1'			=> 'Сброс пароля',
'passwordreset_email_not_found_h2'			=> 'Учётная запись с указанным e-mail не найдена',
'passwordreset_email_not_found_text'		=> 'Пожалуйста, вернитесь назад и попробуйте снова.<br />Если уверенны в корректности действий, но ошибка не исчезает - напишите нам на <a href="mailto:'.$config['email_support'].'">'.$config['email_support'].'</a><br />Если у Вас нет аккаунта, <a href="register.php">зарегистрируйтесь</a>',

// email некорректен - passwordreset_email_wrong
'passwordreset_email_wrong_title'			=> 'Система',
'passwordreset_email_wrong_h1'				=> 'Сброс пароля',
'passwordreset_email_wrong_h2'				=> 'Некорректный e-mail',
'passwordreset_email_wrong_text'			=> 'Пожалуйста, вернитесь назад и попробуйте снова.<br />Если уверенны в корректности действий, но ошибка не исчезает - напишите нам на <a href="mailto:'.$config['email_support'].'">'.$config['email_support'].'</a>',

// установка нового пароля после сброса - newpassword.php
// форма установки нового пароля	-	newpassword
'newpassword_form_title'				=> 'Система',
'newpassword_form_h1'					=> 'Установка нового пароля',
'newpassword_form_h2'					=> 'Укажите новый пароль',
'newpassword_form_password_placeholder'	=> 'Пароль',
'newpassword_form_button'				=> 'Установить',
'newpassword_form_text'					=> 'Придумайте максимально сложный пароль используя буквы a-z A-Z, цифры 0-9, cимволы .,-_!?@ и не сообщайте его никому.',

// пароль успешно установлен	-	newpassword_true
'newpassword_true_title'				=> 'Система',
'newpassword_true_h1'					=> 'Установка нового пароля',
'newpassword_true_h2'					=> 'Установка пароля прошла успешно. Теперь можно <a href="login.php">войти в систему</a> используя новый пароль.',
'newpassword_true_text'					=> '',

// код восстановления не совпадает	-	newpassword_code_wrong
'newpassword_code_wrong_title'			=> 'Система',
'newpassword_code_wrong_h1'				=> 'Установка нового пароля',
'newpassword_code_wrong_h2'				=> 'Код установки нового пароля не совпадает',
'newpassword_code_wrong_text'			=> 'Пожалуйста, попробуйте снова.<br />Если уверенны в корректности действий, но ошибка не исчезает - напишите нам на <a href="mailto:'.$config['email_support'].'">'.$config['email_support'].'</a>',

// учётки с таким e-mail нет в базе	-	newpassword_email_wrong
'newpassword_email_wrong_title'			=> 'Система',
'newpassword_email_wrong_h1'			=> 'Сброс пароля',
'newpassword_email_wrong_h2'			=> 'Учётная запись с указанным e-mail не найдена',
'newpassword_email_wrong_text'			=> 'Пожалуйста, вернитесь назад и попробуйте снова.<br />Если уверенны в корректности действий, но ошибка не исчезает - напишите нам на <a href="mailto:'.$config['email_support'].'">'.$config['email_support'].'</a>',


// сервисные сообщения - message.php
// система недоступна, т.к. активен сервисный режим	-	service_mode
'service_mode_form_title'					=> 'Система',
'service_mode_form_h1'						=> 'Система недоступна',
'service_mode_form_h2'						=> 'Система отключена на обслуживание. Попробуйте вернуться через несколько минут.',
'service_mode_form_text'					=> '',

);

?>
