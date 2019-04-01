<?php
// ******************************************** //
//
// установка нового пароля после сброса по ссылке
//
// ******************************************** //

// свойства файла, используются для защиты на прямой вызов служебных скриптов
$page = array(
'type' 		=> 'newpassword'
);

// подключаем основной файл конфигурации
$g_root = $_SERVER['DOCUMENT_ROOT'];
include_once ($g_root.'/config.php');

// вызываем файл аутентификации пользователя
include_once ($config['base_include_url'].$config['url_UAC_file']);

if (!$user_login)
// если пользователь не залогинен - работаем дальше
{
	// проверка полученных данных
	if (
			isset($_GET['email'])
		AND isset($_GET['passwordreset_code'])
		AND !empty($_GET['email'])
		AND !empty($_GET['passwordreset_code'])
	)
	// если был переход по ссылке - показываем форму
	{

		// задаём свойства формы
		$form = '1';								// фома активна
		$form_action = 'newpassword.php';			// адрес отправки формы
		$form_method = 'POST';						// метод отправки формы
		$input_hidden_passwordreset_code = '1';		// скрытое поле с кодом сброса пароля
		$hidden_passwordreset_code = $_GET['passwordreset_code'];
		$input_hidden_email = '1';					// скрытое поле с адресом e-mail
		$hidden_email = $_GET['email'];
		$input_password = '1';						// поле пароль
		$btn = '1';									// кнопка
		
		// код ответа - форма установки нового пароля
		$result = 'newpassword_form';

	}
	else if (
		isset($_POST['email'])
		AND isset($_POST['password'])
		AND isset($_POST['passwordreset_code'])
		AND !empty($_POST['email'])
		AND !empty($_POST['password'])
		AND !empty($_POST['passwordreset_code'])
	)
	// если получили данные из отправленной формы - обрабатываем
	{
		// проверяем e-mail и код сброса по маске
		$regex_code = '/^[a-fA-F0-9]{64,64}$/';
		$regex_email = $config['regex_email'];

		if (
			(preg_match($regex_code, $_POST['passwordreset_code']))
			AND (preg_match($config['regex_email'], $_POST['email']))
		)
		// если они проходят проверку
		{
			// делаем поиск записи с такими данными в базе
			$pattern = '
				SELECT
					users.user_id,
					users.user_email,
					users.user_password
				FROM
					users
				WHERE
					user_email = ?
				LIMIT
					1
			';
			$value = array($_POST['email']);
			$user = $db->query($pattern, $value)->row();

			// если есть пользователи с такими данными
			if(!empty($user))
			// если нашли подходящего пользователя
			{
				// генерируем правильный код восстановления пароля по текущим данным из базы
				// id + хэш прошлого пароля + соль + email
				$goodpasswordreset_code = hash('sha512', $user['user_id'].$user['user_password'].$config['salt'].$user['user_email']);
				// сравниваем полученный код восстановления с правильным
				if ($goodpasswordreset_code === $_POST['passwordreset_code'])
				// если код восстановления совпадает, записываем в базу новый пароль
				{	
					// шифруем пароль с солью
					$newpassword = hash('sha512', hash('sha512', $_POST['password']).$config['salt'].$user['user_email']);
					$pattern = '
						UPDATE
							users
						SET
							user_password = ?
						WHERE
							user_email = ?
						AND
							user_id = ?i
						LIMIT
							1
						';
					$value = array($newpassword, $user['user_email'], $user['user_id']);
					$data = $db->query($pattern, $value);
					
					// код ответа - пароль успешно изменён
					$result = 'newpassword_true';
				}
				else
				// если код восстановления не совпадает
				{
					// код ответа - код не совпадает
					$result = 'newpassword_code_wrong';
				}
			else
			// если учётки с таким e-mail нет в базе
			{
				// код ответа - пользователь не найден
				$result = 'newpassword_email_wrong';
			}
		}
		else
		// если данные не проходят проверку по маске
		{
			// код ответа - код не совпадает
			$result = 'newpassword_code_wrong';
		}
	}
	else
	// если ничего не получили - даём ошибку
	{
		header('Location: /404.php');
		exit();
	}

	// подключаем текстовые данные для сборки ответа
	include $config['base_include_url'].'/login/tpl/login_text.php';
	
	// подключаем вёрстку для сборки ответа
	include $config['base_include_url'].'/login/tpl/login_tpl.php';
}
?>