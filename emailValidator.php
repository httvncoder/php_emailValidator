<?php

require_once('config.inc.php');

error_reporting (E_ERROR || E_WARNING || E_PARSE || E_NOTICE);

define('DEBUG',false);
define('startExecute', microtime(true));

/**
 * Description
 * @param type $notificationLevel - Уровень сообщения
 * @param type $notificationText - Текст сообщения
 * @return type text
 */
function displayNotifications($notificationLevel, $notificationText)
{
	switch ($notificationLevel) {
		case 0:
			echo '<div class="alert alert-danger">Сообщение: ';
			break;
		case 1:
			echo 'Предупреждение:';
			break;
		case 2:
			echo 'Ошибка:';
			break;
		case 3:
			echo 'Критическая ошибка:';
			break;
		case 4:
			echo 'Исключение:';
			break;
		
		default:
			echo '';
			break;
	}

	echo $notificationText . "<br />\n</div>";
}

/**
 * Description
 * Выводит на экран время исполнения скрипта
 * @return type time
 */
function timeExecution()
{
	echo '<br /> Время выполнения: ~ ' . round((microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]), 1) . ' сек';
}

/**
 * Description
 * @param type $proceedArray 
 * @return type
 */
function d($proceedArray)
{
	echo '<pre>';
	var_dump($proceedArray);
	echo '</pre>';
}

/**
 * [requiredFields description]
 * @return [type] [description]
 */
function requiredFields()
{
	return (!isset($_POST['name']) || empty($_POST['name']) || !isset($_POST['email']) || empty($_POST['email']) || !isset($_POST['phone']) || empty($_POST['phone'])) ? false : true;
}

/**
 * [emailFormat description]
 * @return [type] [description]
 */
function emailFormat()
{
	if(!requiredFields())
	{
		displayNotifications(0, 'Некорректный ввод');
		timeExecution();
		die();
	}
	else
	{
		return (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) ? false : true;		
	}	
}

/**
 * [checkEmailMX description]
 * @return [type] [description]
 */
function checkEmailMX()
{
	if(!emailFormat())
	{	
		displayNotifications(0, 'Проверьте правильность ввода EMAIL');	
		timeExecution();
		die();
	}
	else
	{
		$emailDomain = substr(strrchr($_POST['email'], "@"), 1);		
		$emailDomain = dns_get_record($emailDomain, DNS_MX);
		if(isset($emailDomain) && !empty($emailDomain)) 
		{
			foreach ($emailDomain as $mx) {
				$mxQuery[] = $mx['target'];
			}
			return $mxQuery;
		}
		else
		{
			return false;
		}
	}
}

/**
 * [mxConnect description]
 * @return [type] [description]
 */
function mxConnect()
{
	global $app_url;
	global $app_email;

	if(!checkEmailMX())
	{
		displayNotifications(0, 'Домен ящика не обнаружен в DNS');		
		timeExecution();
		die();
	}
	else
	{
		foreach (checkEmailMX() as $mxHost) {			
			$fp = @fsockopen($mxHost,25, $errno, $errstr, 5);
			if($fp)
			{
				$result[0] = trim(fgets($fp));
    			// $result[0] = substr($result[0], 0, 3);

				fwrite($fp, "HELO " . $app_url . "\r\n");
    			$result[1] = trim(fgets($fp));
    			// $result[1] = substr($result[1], 0, 3);

				fwrite($fp, "MAIL FROM: <" . $app_email . "> \r\n");
    			$result[2] = trim(fgets($fp));
    			// $result[2] = substr($result[2], 0, 3);

				fwrite($fp, "RCPT TO: <" . $_POST['email'] . "> \r\n");
    			$result[3] = trim(fgets($fp));
    			// $result[3] = substr($result[3], 0, 3);

				fwrite($fp, "QUIT" . "\r\n");
    			$result[4] = trim(fgets($fp));
    			// $result[4] = substr($result[4], 0, 3);

				fclose($fp);

				break;
			}
			else
			{
				displayNotifications(0, 'Невозможно подключиться к MX-серверу. Недоступен MX-сервер или 25-й порт');
				timeExecution();
				die();					
			}
		}
		return $fp ? $result : false;
	}
}

/**
 * [emailQuery description]
 * @return [type] [description]
 */
function emailQuery()
{
	if(!mxConnect())
	{
		displayNotifications(0, 'Невозможно установить соедининие с MX-сервером');
		timeExecution();
		die();
	}
	else
	{
		if(substr(mxConnect()[3], 0, 1) == 2)
		{
			displayNotifications(0, 'Email существует!');
			timeExecution();
		}
		elseif(substr(mxConnect()[3], 0, 1) == 4)
		{
			displayNotifications(0, 'Сервер временно отклонил попытку соединения. Повторите попытку позже!');
			displayNotifications(5, 'Причина: ');
			echo mxConnect()[3];
			timeExecution();
		}
		elseif(substr(mxConnect()[3], 0, 1) == 5)
		{
			displayNotifications(0, 'Email не существует!');
			timeExecution();
		}
	}
}

/**
 * [run description]
 * @return [type] [description]
 */
function run()
{
	emailQuery();		
}

run();