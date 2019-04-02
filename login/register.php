<?php
// ******************************************** //
//
// форма регистрации, обработка формы регистрации, результат регистрации, ошибки регистрации
//
// ******************************************** //

// свойства файла, используются для защиты на прямой вызов служебных скриптов
$page = array(
'type' 		=> 'register'
);

// подключаем основной файл конфигурации
$g_root = $_SERVER['DOCUMENT_ROOT'];
require_once ($g_root.'/config.php');

// вызываем файл аутентификации пользователя
include_once ($config['base_include_url'].$config['url_UAC_file']);

// функция генерации индивидуального реферального кода из непохожих символов
function generateCode($length=8)
{
	$chars = 'abcdefghikmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
	$code = '';
	$clen = strlen($chars) - 1;
	while (strlen($code) < $length)
	{
		$code .= $chars[mt_rand(0,$clen)];
	}
	return $code;
}

if (!$user_login) {
	// если пользователь не залогинен

	if ($config['new_registration_open']) {
		// если регистрация открыта
	
		if (empty($_POST)) {
			// если форма не отправлялась - показываем форму

			// задаём свойства формы для сборки из шаблона
			$form					= true;				// фома активна
			$form_action			= 'register.php';	// адрес отправки формы
			$form_method			= 'POST';			// метод отправки формы
			$refregcode		=  $_GET['ref'] ?: '';		// реферальная ссылка
			$invitecode		=  $_GET['invite'] ?: '';	// код приглашения
			$input_email			= true;				// поле e-mail
			$input_password			= true;				// поле пароль
			$input_terms_checkbox	= true;				// чекбокс с соглашением
			$btn					= true;				// кнопка
		
			if (!$config['new_registration_only_invite']) {
				// если открыта регистрация без инвайтов
				
				$result = 'register_form';	// код ответа - форма регистрации без запроса кода приглашения

			} else {
				// если открыта регистрация только по инвайтам

				$input_invite = true;				// поле кода приглашения				
				$result = 'register_form_only_invite';	// код ответа - форма регистрации с запросом кода приглашения
				
			}
		} else {
			// если форма отправлялась - обрабатываем данные

			if ($_POST['email'] AND !empty($_POST['password'])) {
				// если данных достаточно

				if (preg_match($config['regex_email'], $_POST['email'])) {
					// если e-mail проходит проверку по маске

					if ($config['new_registration_only_invite']) {
						// если открыта регистрация только по инвайтам

						// проверяем наличие и активность инвайта
						$pattern = '
							SELECT
								invites.*
							FROM
								invites
							WHERE
								invites.invite_code = ?
							AND
								invites.invite_state = 1
							LIMIT
								1
						';
						$value = array($_POST['invite']);
						$invitecode = $db->query($pattern, $value)->row();
					}

					if ($config['new_registration_only_invite'] AND empty($invitecode)) {
						// если открыта регистрация только по инвайтам и мы не нашли такой код приглашения

						$result = 'register_invite_wrong'; 	// код ответа - неверный инвайт код

					} else {
						// если требования инвайтов нет либо инвайт-код валиден
					
						// проверяем e-mail на занятость
						$pattern = '
							SELECT
								users.user_id,
								users.user_activation_state
							FROM
								users
							WHERE
								users.user_email = ?
							LIMIT
								1
						';
						$value = array($_POST['email']);
						$data = $db->query($pattern, $value)->row();
							
						if (empty($data)) {
							// если нет учётки с таким e-mail

							// генерируем код активации аккаунта
							$activation_code = hash('sha256', $_POST['email'].time());
							
							// генерируем индивидуальный реферальный код
							$refcode = generateCode(8);
							
							// шифруем пароль с солью
							$password = hash('sha512', hash('sha512', $_POST['password']).$config['salt'].$_POST['email']);
							
							// добавляем запись в базу
							$set = array(
								'user_email'			=> $_POST['email'],
								'user_password'			=> $password,
								'user_activation_code'	=> $activation_code,
								'user_ref_code'			=> $refcode,
								'user_state'			=> 1,
								'user_regdate'			=> date("Y-m-d H:i:s"),
								);

							$set['user_refreg_code']	=  $_POST['refregcode'] ?: '';	// если зарегистрировались по реферальной ссылке

							(!$config['user_email_activation'])	? $set['user_activation_state'] = 1 : ''; // если активация по почте не требуется

							$pattern = '
								INSERT INTO
									users 
								SET
									?set
							';
							$value = array($set);
							$newuser_id = $db->query($pattern, $value)->id();

							if ($config['new_registration_only_invite']) {
								// если открыта регистрация только по инвайтам

								// погашаем инвайт
								$pattern = '
									UPDATE
										invites
									SET
										invites.invite_state = 0,
										invites.invite_invited_user = ?i
									WHERE
										invites.invite_code = ?
									AND
										invites.invite_state = 1
									LIMIT
										1
								';
								$value = array($newuser_id, $_POST['invite']);
								$invite = $db->query($pattern, $value);
							}
							
							if ($config['user_email_activation']) {
								// если требуется обязательная активация - генерируем письмо с кодом активации

								// кому отправляем письмо
								$to = $_POST['email'];

								// подключаем шаблон письма
								require_once 'tpl/register_mail_tpl.php';

								// подключаем функцию отправки писем
								require_once 'mailsend.php';

								// отправляем письмо с кодом активации
								Send_Mail ($to, $subject, $body);

								$result = 'register_true_code_send'; 	// код ответа - требуется активация

							} else {
								// если активация не требуется

								$result = 'register_true'; // код ответа - регистрация прошла успешно, можно начать работу

							}
						} else {
							// если данный e-mail уже есть в базе

							if ((int)$data['user_activation_state'] === 1) {
								// если уже активировн

								$result = 'register_email_busy_activation_ok'; // код ответа - e-mail уже занят, залогиньтесь или восстановите пароль если забыли

							} else {
								// если ещё не активирован
								
								$result = 'register_email_busy_not_activation'; // код ответа - e-mail уже занят, требуется активация аккаунта

							}
						}
					}
				} else {
					// если данный e-mail не проходит проверку по маске
				
					$result = 'register_email_wrong';	// код ответа - некорректный e-mail

				}
			} else {
				// если данных не поступило

				$result = 'register_form_empty';	// код ответа - пустая форма

			}
		}
	} else {
		// если регистрация закрыта

		$result = 'registration_closed';	// код ответа - регистрация временно закрыта

	}

	// подключаем текстовые данные для сборки ответа
	include $config['base_include_url'].'/login/tpl/login_text.php';
	
	// подключаем вёрстку для сборки ответа
	include $config['base_include_url'].'/login/tpl/login_tpl.php';

} else {
	// если пользователь уже залогинен - отправляем пользователя на страницу контента

	header ('Location: /'.$config['system_page']);
	exit();
}

?>