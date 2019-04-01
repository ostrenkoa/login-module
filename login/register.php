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
include_once ($g_root.'/config.php');

// вызываем файл аутентификации пользователя
include_once ($config['base_include_url'].$config['url_UAC_file']);

if (!$user_login)
// если пользователь не залогинен - работаем дальше
{
	// проверка возможности новых регистраций
	if ($config['new_registration_open'])
	// если регистрация открыта
	{
		// проверка отправки формы
		if (!isset($_POST['submit']))
		// если форма не отправлялась - показываем форму
		{
			// задаём свойства формы для сборки из шаблона
			$form = '1';							// фома активна
			$form_action = 'register.php';			// адрес отправки формы
			$form_method = 'POST';					// метод отправки формы
			$input_email = '1';						// поле e-mail
			$input_password = '1';					// поле пароль
			$input_terms_checkbox = '1';			// чекбокс с соглашением

			if (isset($_GET['ref']))
			{$refregcode = $_GET['ref'];}			// реферальная ссылка, если была получена в ссылке

			if (isset($_GET['invite']))
			{$invitecode = $_GET['invite'];}		// код приглашения, если был получен в ссылке

			$btn = '1';								// кнопка
		
			if ($config['new_registration_only_invite'] == true)
			// если открыта регистрация только по инвайтам
			{
				$input_invite = '1';				// поле кода приглашения

				// код ответа - форма регистрации с запросом кода приглашения
				$result = 'register_form_only_invite';
			}
			else
			{
				// код ответа - форма регистрации без запроса кода приглашения
				$result = 'register_form';
			}
		}
		else if(isset($_POST['submit']))
		// если форма отправлялась - обрабатываем данные
		{
			// проверка достаточности полученных данных
			if (
					!empty($_POST['email'])
				AND !empty($_POST['password'])
				AND isset($_POST['email'])
				AND isset($_POST['password'])
			)
			// если данные получены
			{
				// получаем e-mail и пароль
				$email = $_POST['email'];
				$pass = $_POST['password'];
				
				// проверяем наличие реферального кода
				if(isset($_POST['refcode']))
				{
					$refcode = $_POST['refcode'];
				}
				else
				{
					$refcode = 0;
				}

				// проверяем e-mail на валидность по маске
				if (preg_match($config['regex_email'], $email))
				// если e-mail проходит проверку
				{
					// проверяем статус требования инвайтов
					if ($config['new_registration_only_invite'] == true)
					// если открыта регистрация только по инвайтам
					{
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

					if ($config['new_registration_only_invite'] == true AND empty($invitecode))
					// если открыта регистрация только по инвайтам и мы не нашли такой код приглашения - даём ошибку
					{
						$result = 'register_invite_wrong'; 	// код ответа
					}
					else
					// если требования инвайтов нет либо инвайт-код валиден, то работаем дальше
					{
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
						$value = array($email);
						$data = $db->query($pattern, $value)->row();
							
						if (empty($data))
						// если нет учётки с таким e-mail
						{
							// генерируем код активации аккаунта
							$activation_code = hash('sha256', $email.time()); // email + timestamp
							
							// генерируем индивидуальный реферальный код
							function generateCode($length=8)
							{
								$chars = "abcdefghikmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789";
								$code = "";
								$clen = strlen($chars) - 1;
								while (strlen($code) < $length)
								{
									$code .= $chars[mt_rand(0,$clen)];
								}
								return $code;
							}
							$refcode = generateCode();
							
							// шифруем пароль с солью
							$password = hash('sha512', hash('sha512', $pass).$config['salt'].$email);
							
							// добавляем запись в базу
							$set = array(
								'user_email'			=> $email,
								'user_password'			=> $password,
								'user_activation_code'	=> $activation_code,
								'user_ref_code'			=> $refcode,
								'user_state'			=> 1,
								'user_regdate'			=> date("Y-m-d H:i:s"),
								);
							if (isset($refregcode))
							{
								$set['user_refreg_code']	= $refregcode;
							}
							
							$pattern = '
								INSERT INTO
									users 
								SET
									?set
							';
							$value = array($set);
							$newuser_id = $db->query($pattern, $value)->id();

							// проверяем возможность регистрации без инвайта
							if ($config['new_registration_only_invite'] == true)
							// если открыта регистрация только по инвайтам
							{
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
							
							// проверка обязательности активации аккаунта
							if ($config['user_email_activation'] == true)
							// если требуется активация - генерируем письмо с кодом активации
							{
								// кому отправляем письмо
								$to = $email;

								// подключаем шаблон письма
								include 'tpl/register_mail_tpl.php';

								// подключаем функцию отправки писем
								include 'mailsend.php';

								// отправляем письмо с кодом активации
								Send_Mail ($to, $subject, $body);

								// код ответа - регистрация прошла успешно, отправлено письмо со ссылкой активации
								$result = 'register_true_code_send'; 	
							}
							else
							// если активация не требуется - активируем аккаунт сразу
							{
								// обновляем запись пользователя в базе
								$pattern = '
									UPDATE
										users 
									SET
										users.user_activation_state = 1
									WHERE
										users.user_id = ?i
									LIMIT
										1
								';
								$value = array($newuser_id);
								$useractivation = $db->query($pattern, $value);

								// код ответа - регистрация прошла успешно, можно начать работу
								$result = 'register_true';
							}
						}
						else
						// если данный e-mail уже есть в базе
						{
							// проверяем статус активации аккаунта
							if ($data['user_activation_state'] == 1)
							// если уже активировн
							{
								// код ответа - e-mail уже занят, залогиньтесь или восстановите пароль если забыли
								$result = 'register_email_busy_activation_ok';
							}
							else if ($data['user_activation_state'] == 0)
							// если ещё не активирован
							{
								// код ответа - e-mail уже занят, требуется активация аккаунта
								$result = 'register_email_busy_not_activation';
							}
						}
					}
				}
				else
				// если данный e-mail не проходит проверку по маске
				{
					// код ответа - некорректный e-mail
					$result = 'register_email_wrong';
				}
			}
			else
			// если данных не поступило
			{
				// код ответа - пустая форма
				$result = 'register_form_empty';
			}
		}
	}
	else
	// если регистрация закрыта
	{
		// код ответа - регистрация временно закрыта
		$result = 'registration_closed';
	}

	// подключаем текстовые данные для сборки ответа
	include $config['base_include_url'].'/login/tpl/login_text.php';
	
	// подключаем вёрстку для сборки ответа
	include $config['base_include_url'].'/login/tpl/login_tpl.php';
}
else
// если пользователь уже залогинен - перебрасываем на основную страницу
{
	header ('Location: /'.$config['system_page']);
	exit();
}

?>