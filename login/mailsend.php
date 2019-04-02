<?php
function Send_Mail($to, $subject, $body)
{
	// получаем данные для подключения к серверу
	global $mailconfig;

	// вызываем библиотеку
	require_once ($_SERVER['DOCUMENT_ROOT'].'/assets/libs/phpmailer/PHPMailerAutoload.php');

	$results_messages = array();
	 
	$mail = new PHPMailer(true);
	$mail->CharSet = 'utf-8';
	ini_set('default_charset', 'UTF-8');
	 
	class phpmailerAppException extends phpmailerException {}
	 
	try
	{
		if (!PHPMailer::validateAddress($to))
		{
			throw new phpmailerAppException("Email address " . $to . " is invalid -- aborting!");
		}

		// определяем параметры отправки
		$mail->isSMTP();
		$mail->SMTPDebug  = 0;
		$mail->Host       = $mailconfig['smtphost'];
		$mail->Port       = $mailconfig['smtpport'];
		$mail->SMTPSecure = $mailconfig['smtpsecure'];
		$mail->SMTPAuth   = $mailconfig['smtpauth'];
		$mail->Username   = $mailconfig['smtpusername'];
		$mail->Password   = $mailconfig['smtppassword'];
		$mail->addReplyTo($mailconfig['smtpmail'], $mailconfig['smtpfrom']);
		$mail->setFrom($mailconfig['smtpmail'], $mailconfig['smtpfrom']);
		$mail->AddAddress($to, $to);
		$mail->Subject  = $subject;
		$mail->MsgHTML($body);
		$mail->WordWrap = 78;

		try
		{
			// отправляем письмо
			$mail->send();
		}
		catch (phpmailerException $e)
		{
			throw new phpmailerAppException('Unable to send to: ' . $to. ': '.$e->getMessage());
		}

	}
	catch (phpmailerAppException $e)
	{
		$results_messages[] = $e->errorMessage();
	}
	 
	if (count($results_messages) > 0)
	{
		echo "<h2>Run results</h2>\n";
		echo "<ul>\n";
		foreach ($results_messages as $result)
		{
			echo "<li>$result</li>\n";
		}
		echo "</ul>\n";
	}
}

?>
