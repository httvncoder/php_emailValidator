<?php

require_once('config.inc.php');
$startExecute = microtime(true); 
// error_reporting(E_ERROR);
error_reporting (E_ERROR || E_WARNING || E_PARSE || E_NOTICE);
define('DEBUG',false);

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
		throw new Exception("Некорректный ввод", 1);
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
		throw new Exception("Проверьте правильность ввода EMAILt", 1);		
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
		throw new Exception("Домен ящика не обнаружен в DNS", 1);		
	}
	else
	{
		foreach (checkEmailMX() as $mxHost) {			
			$fp = @fsockopen($mxHost,25, $errno, $errstr, 5);
			if($fp)
			{
				$result[0] = trim(fgets($fp));
    			$result[0] = substr($result[0], 0, 3);

				fwrite($fp, "HELO " . $app_url . "\r\n");
    			$result[1] = trim(fgets($fp));
    			$result[1] = substr($result[1], 0, 3);

				fwrite($fp, "MAIL FROM: <" . $app_email . "> \r\n");
    			$result[2] = trim(fgets($fp));
    			$result[2] = substr($result[2], 0, 3);

				fwrite($fp, "RCPT TO: <" . $_POST['email'] . "> \r\n");
    			$result[3] = trim(fgets($fp));
    			$result[3] = substr($result[3], 0, 3);

				fwrite($fp, "QUIT" . "\r\n");
    			$result[4] = trim(fgets($fp));
    			$result[4] = substr($result[4], 0, 3);

				fclose($fp);
				// echo substr ($result[3],0,1);
				// echo '<pre>';
				// print_r($result);
				// echo '</pre>';

				break;
			}
			else
			{
				throw new Exception("Невозможно подключиться к MX-серверу. Недоступен MX-сервер или 25-й порт", 1);				
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
		throw new Exception("Невозможно установить соединение с MX-сервером", 0);		
	}
	else
	{
		if(substr(mxConnect()[3], 0, 1) == 2)
		{
			echo 'Email существует!';
		}
		elseif(substr(mxConnect()[3], 0, 1) == 4)
		{
			echo 'Сервер временно отклонил попытку соединения. Повторите попытку позже!';
		}
		elseif(substr(mxConnect()[3], 0, 1) == 5)
		{
			echo 'Email не существует!';
		}
		// print_r(mxConnect()[3]);
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
printf('<br /> Время выполнения: %.1F сек.', (microtime(true) - $startExecute));