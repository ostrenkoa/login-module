<?php
if (isset($page))
// защита на прямой вызов файла, его нельзя вызвать если не передана переменная $page со свойствами страницы вызова.
{
	// проверяем наличие наших куков у пользователя
	if (
			isset($_COOKIE['cookie_user_id'])
		AND isset($_COOKIE['cookie_hash'])
	)
	// если наши куки найдены
	{
		// получаем из куков id пользователя и хэш доступа
		$user_id = $_COOKIE['cookie_user_id'];
		$user_hash = $_COOKIE['cookie_hash'];

		// шифруем хэш
		$user_hash = hash('sha512', $user_hash);

		// запрашиваем пользователя с таким id и хэш из базы
		$pattern = '
			SELECT
				users.*
			FROM
				users
			WHERE
				users.user_id = ?i
			AND
				users.user_hash = ?
			LIMIT
				1
		';
		$value = array($user_id, $user_hash);
		$userconfig = $db->query($pattern, $value)->row();
		
		if (
				isset($userconfig)
			AND !empty($userconfig)
		)
		// если пользователь найден в базе - проверяем на отсутствие сервисного режима системы
		{
			if ($config['system_state'])
			// если система не в сервисном режиме
			{
				// проверяем статус пользователя, поле "user_state" в базе. можем им оперировать если хотим заблокировать пользователя
				if ($userconfig['user_state'] == 1)
				// если он активен, разрешаем доступ
				{
					$user_login = true;
				}
				else
				// если пользователь заблокирован - запрещаем доступ и показываем ошибку
				{
					$user_login = false;
				}
			}
			else
			// если сервисный режим активен - проверяем на права админа
			{
				if ($userconfig['user_admin'] != 1)
				// если пользователь не является админом - сбрасываем куки и запрещаем доступ
				{
					setcookie("cookie_user_id", "", time() - 3600*24*30*12, "/");
					setcookie("cookie_hash", "", time() - 3600*24*30*12, "/");
					
					$user_login = false;
				}
				else
				// если это админ
				{
					// проверяем статус пользователя, поле "user_state" в базе. можем им оперировать если хотим заблокировать пользователя
					if ($userconfig['user_state'] == 1)
					// если он активен, разрешаем доступ
					{
						$user_login = true;
					}
					else
					// если пользователь заблокирован - запрещаем доступ и показываем ошибку
					{
						$user_login = false;
					}
				}
			}
		}
		else
		// если не найден такой пользователь в базе - обнуляем ему куки на всякий случай и запрещаем доступ
		{
			setcookie("cookie_user_id", "", time() - 3600*24*30*12, "/");
			setcookie("cookie_hash", "", time() - 3600*24*30*12, "/");
			
			$user_login = false;
		}
	}
	else
	// если куки не найдёны - запрещаем доступ
	{
		$user_login = false;
	}

}
else
// если была попытка прямого вызова файла - отправляем в 404
{
	header('Location: /404.php');
	exit();
}
?>
