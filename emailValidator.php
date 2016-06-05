<?php

	// if(isset($_POST['name']) && isset($_POST['email']))
	// {
	// 	echo 'Имя: ' , $_POST['name'] , ', email: ' , $_POST['email'];
	// }
	// else
	// {
	// 	echo 'некорректный ввод';
	// }

	function requiredFields()
	{
		return (!isset($_POST['name']) || empty($_POST['name']) || !isset($_POST['email']) || empty($_POST['email']) || !isset($_POST['phone']) || empty($_POST['phone'])) ? false : true;
	}
	
	function emailFormat()
	{
		return (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) ? false : true;		
	}

	function checkEmailMX()
	{
		echo 'checkEmailMX';
	}
	
	if(!requiredFields())
	{
		echo 'Некорректный ввод!';
	}
	elseif(!emailFormat())
	{
		echo 'Проверьте правильность ввода EMAIL!';
	}
	else
	{
		// echo 'Поля заполнены верно!';
		checkEmailMX();
	}

// private function doUnset()
// {
//     unset($_POST['alpha'];
//     unset($_POST['gamma'];
//     unset($_GET['eta'];
//     unset($_GET['zeta'];
// }

	// if (!isset($_POST['name']) || empty($_POST['name']) || !isset($_POST['email']) || empty($_POST['email']) || !isset($_POST['phone']) || empty($_POST['phone']))
	// {
	// 	echo 'Заполнены не все обязательные поля';
	// }
	// else
	// {
	// 	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	// 	    echo 'E-mail ', $_POST['email'] ,' указан верно. <br/>';
	// 	}else
	// 	{
	// 		echo 'неверно! <br/>';
	// 	}

	// 	echo $_POST['name'] , '<br/>';
	// 	echo $_POST['email'] , '<br/>';
	// 	echo $_POST['phone'] , '<br/>';
	// }
