<?php
// ******************************************** //
//
// форма активации, обработка формы и ссылки активации, результат активации, ошибки активации
//
// ******************************************** //

// свойства файла, используются для защиты на прямой вызов служебных скриптов
$page = array(
'type' 		=> 'activation'
);

// подключаем основной файл конфигурации
$g_root = $_SERVER['DOCUMENT_ROOT'];
include_once ($g_root.'/config.php');

// вызываем файл аутентификации пользователя
include_once ($config['base_include_url'].$config['url_UAC_file']);

if (
	!$user_login
	OR
	(
		$user_login
	AND $userconfig['user_activation_state'] == 0
	)
)
// если пользователь не залогинен либо залогинен и не активирован - работаем дальше
{
	// проверка получения данных из формы либо из ссылки активации
	if (
			!isset($_GET['email'])
		OR !isset($_GET['activation_code'])
		OR empty($_GET['email'])
		OR empty($_GET['activation_code'])
	)
	// если нужные данные не получены - показываем форму
	{
		// задаём свойства формы для сборки из шаблона
		$form = '1';						// фома активна
		$form_action = 'activation.php';	// адрес отправки формы
		$form_method = 'GET';				// метод отправки формы
		$input_email = '1';					// поле e-mail
		$input_activation_code = '1';		// поле код активации
		$btn = '1';							// кнопка
		
		// код ответа - форма активации аккаунта
		$result = 'activation_form';
	}
	else 
	// если данные из формы либо ссылки активации получены - обрабатываем данные
	{
		// получаем e-mail и код активации
		$email = $_GET['email'];
		$user_activation_code = $_GET['activation_code'];
			
		// проверяем e-mail и код активации по маске
		$regex_code = '/^[a-fA-F0-9]{64,64}$/';
		$regex_email = $config['regex_email'];

		if(
			(preg_match($regex_code, $user_activation_code))
			AND (preg_match($config['regex_email'], $email))
		)
		// если они проходят проверку
		{
			// делаем поиск записи с такими данными в базе
			$pattern = '
				SELECT
					users.*
				FROM
					users
				WHERE
					user_activation_code = ?
				AND
					user_email = ?
				LIMIT
					1
			';
			$value = array($user_activation_code, $email);
			$data = $db->query($pattern, $value)->row();
			
			if(!empty($data))
			// если есть пользователи с такими данными
			{
				// проверяем статус активации
				if ($data['user_activation_state'] == 0)
				// если не активирован ранее, то активируем
				{
					// обновляем статус пользователя
					$pattern = '
						UPDATE
							users
						SET
							user_activation_state = 1
						WHERE
							user_activation_code = ?
						AND
							user_email = ?
						LIMIT
							1
						';
					$value = array($user_activation_code, $email);
					$data2 = $db->query($pattern, $value);
					
					// код ответа - активация успешно произведена
					$result = 'activation_true';
				}
				else
				// если уже активирован ранее
				{
					// код ответа - активация была произведена ранее
					$result = 'activation_already';
				}
			}
			else
			// если нет пользователей с таким кодом активации либо с таким e-mail
			{
				// код ответа - данные для активации неверные
				$result = 'activation_wrong';
			}
		}
		else
		// если код либо е-mail не проходят проверку по маске
		{
			// код ответа - данные для активации неверные
			$result = 'activation_wrong';
		}
	}

	// подключаем текстовые данные для сборки ответа
	include $config['base_include_url'].'/login/tpl/login_text.php';
	
	// подключаем вёрстку для сборки ответа
	include $config['base_include_url'].'/login/tpl/login_tpl.php';

}
else
// если пользователь залогинен и уже активирован - перебрасываем на основную страницу
{
	header ('Location: /'.$config['system_page']);
	exit();
}
?>
