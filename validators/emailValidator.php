<?php

require_once(dirname(dirname(__FILE__)).'/config/config.inc.php');
require_once(dirname(dirname(__FILE__)).'/helpers/displayNotifications.php');
require_once(dirname(dirname(__FILE__)).'/helpers/counters.php');
require_once(dirname(dirname(__FILE__)).'/helpers/varDump.php');
require_once(dirname(dirname(__FILE__)).'/helpers/requiredFields.php');

error_reporting (E_ERROR || E_WARNING || E_PARSE || E_NOTICE);

define('DEBUG',false);

$notrifications = new notifications;
$counters = new counters;
$requiredFields = new requiredFields;


// function requiredFields()
// {
// 	return (!isset($_POST['email']) || empty($_POST['email'])) ? false : true;
// }

/**
 * [emailFormat description]
 * Если функция requiredFields() истинна - проверяет правильность ввода, иначе - выводит сообщение об ошибке
 * @return [type] [description]
 */
function emailFormat()
{
	global $notrifications;
	global $counters;
	global $requiredFields;

	if($requiredFields->getFields($_POST['email']))
	{
		return (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) ? false : true;
	}
	else
	{
		echo $notrifications->displayNotifications(1, 'Необходимо заполнить поле EMAIL. ' . $counters->timeExecution());
		die();	
	}	
}

/**
 * [checkEmailMX description]
 * Если функция emailFormat() ложна - выводит сообщение об ошибке, если нет отделяет доменную часть переданного email-адреса, производит попытку разрешить доменное имя. Возвращает доменное имя или false
 * @return [type] [description]
 */
function checkEmailMX()
{
	global $notrifications;
	global $counters;

	if(!emailFormat())
	{	
		echo $notrifications->displayNotifications(2, 'Проверьте правильность ввода EMAIL ' . $counters->timeExecution());
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
	global $notrifications;
	global $counters;

	if(!checkEmailMX())
	{
		echo $notrifications->displayNotifications(2, 'Домен ящика не обнаружен в DNS ' . $counters->timeExecution());		
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
				echo $notrifications->displayNotifications(2, 'Невозможно подключиться к MX-серверу. Недоступен MX-сервер или 25-й порт. ' . $counters->timeExecution());
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
	global $notrifications;
	global $counters;

	if(!mxConnect())
	{
		echo $notrifications->displayNotifications(2, 'Невозможно установить соедининие с MX-сервером ' . $counters->timeExecution());
		die();
	}
	else
	{
		if(substr(mxConnect()[3], 0, 1) == 2)
		{
			echo $notrifications->displayNotifications(0, 'Email существует! '. $counters->timeExecution());
		}
		elseif(substr(mxConnect()[3], 0, 1) == 4)
		{
			echo $notrifications->displayNotifications(2, 'Сервер временно отклонил попытку соединения. Повторите попытку позже!');
			echo $notrifications->displayNotifications(5, mxConnect()[3] . '<br/>' . $counters->timeExecution());
		}
		elseif(substr(mxConnect()[3], 0, 1) == 5)
		{
			echo $notrifications->displayNotifications(2, 'Email не существует! ' . $counters->timeExecution());
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
