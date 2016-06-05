<?php

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
	return (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) ? false : true;		
}

/**
 * [checkEmailMX description]
 * @return [type] [description]
 */
function checkEmailMX()
{
	$emailDomain = substr(strrchr($_POST['email'], "@"), 1);		
	$emailDomain = dns_get_record($emailDomain, DNS_MX);
	$mxQuery = (isset($emailDomain[0]['target']) && !empty($emailDomain[0]['target'])) ? $emailDomain[0]['target'] : false;
	return $mxQuery;
}

/**
 * [mxConnect description]
 * @return [type] [description]
 */
function mxConnect()
{
	if(!checkEmailMX())
	{
		echo 'Домен ящика не обнаружен в DNS! <br />';
	}
	else
	{
		$mxConn = @fsockopen(checkEmailMX(),25, $errno, $errstr, 2);
		return $mxConn ? true : false;
	}
}

/**
 * [run description]
 * @return [type] [description]
 */
function run()
{
	if(!requiredFields())
	{
		echo 'Некорректный ввод! <br />';
	}
	elseif(!emailFormat())
	{
		echo 'Проверьте правильность ввода EMAIL! <br />';
	}
	else
	{
		if(!mxConnect())
		{
			echo 'Невозможно установить соединение с MX-сервером! <br />';
		}
		else
		{
			echo checkEmailMX();
		}
	}	
}

run();