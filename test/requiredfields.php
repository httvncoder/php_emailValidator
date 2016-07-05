<?php

/**
 * formValidator	функции валидации форм, отображение ошибок
 * @version 0.1
 * @license https://opensource.org/licenses/BSD-3-Clause GPLv3 BSD-3-Clause
 * @author Maxim Ishchenko <maxim.ishchenko@gmail.com>
 * @copyright Copyright (c) Maxim Ishchenko <maxim.ishchenko@gmail.com>
 * 
 * @todo 
 * 		добавить:
 *  		проверку поля email на существование;
 * 			отправку email администратору;
 * 			возможность отправки email с авторизацией;
 * 			соединение с базой данных;
 * 			интеграция с ubiquiti-hotspot;
 * 			запись данных ubituiti-hotspot в БД;
 * 			отображение, сортировка, фильтрация, введенных ранее данных;
 * 			фиксация в БД отправленных администратору сообщений;
 * 			проверка формата полей phone;
 * 			заполнить README.md;
 * 			Changelog.
 */

/**
 * Корневая директория сайта, относительно текущего файла
 */
define('__ROOT__', dirname(dirname(__FILE__)));

/**
 *	Массив CONFIG, содержащий значения общего и персонального файлов конфигурации
 *	@uses CONFIG['paramName'] для обращения к значениям массива использовать CONFIG['вызываемый параметр']
 *	@return array возвращает массив параметров
 */
define("CONFIG", array_merge(
			require_once((__ROOT__).'/config/config.inc.php'),
			require_once((__ROOT__).'/config/config.inc.local.php')
		)
	);

require_once(dirname(dirname(__FILE__)).'/helpers/varDump.php');

/** 
 * formValidator	функции валидации форм, отображение ошибок
 * @uses  <?php session_start ?> в секции <head>;
 * включить в файл описания формы - <?php require_once(dirname(__FILE__).'/requiredfields.php'); ?>;
 * <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> ... </form> - действие при подтверждении формы, метод подтверждения;
 * $formValidator = new formValidator - объявить класс; использовать описанные ниже функции внутри формы
 */
class formValidator
{
	/**
	 * $attributeLablesSessionRange Название вложенного в $_SESSION массива для хранения названий полей форм
	 * @var string
	 */
	public $attributeLablesSessionRange = 'attributeLabels';

	/**
	 * $requireFieldsSessionRange Название вложенного в $_SESSION массива для хранения текстов сообщений об ошибках валидации
	 * @var string
	 */
	public $requireFieldsSessionRange = 'requiredFields';

	/**
	 * attributeLabels description
	 * @uses $valueAttributes = array('fieldName1' => 'fieldLabel1', ..., 'fieldNameN' => 'fieldLabelN'); $formValidator->attributeLabels($valueAttributes); задать ассоциативный массив, сопоставляющий имя поля (параметр name в input) и метку для отображения в данном поле, передать данный массив функции
	 * @param  array $valueAttributesArray ассоциативный массив, содержит соответствия имен полей форм с метками.
	 * @return none
	 */
	public function attributeLabels($valueAttributesArray)
	{
		$this->clearSessionElements($this->attributeLablesSessionRange, false);

		$_SESSION[$this->attributeLablesSessionRange] = array();
		
		foreach ($valueAttributesArray as $k => $v) {
			$_SESSION[$this->attributeLablesSessionRange][$k] = $v;
		}
	}

	/**
	 * getAttributeLabel если существует массив, содержащий метки аттрибутов возвращает метку поля по его, если нет - название поля (параметр name в input)
	 * @uses на примере placeholder: <input name="fieldname" ... placeholder="<?php echo $formValidator->getAttributeLabel('fieldname'); ?>">, где: "..." - остальные возможные параметры текстового поля input
	 * @param  string $label имя поля
	 * @return string метка поля $label
	 */
	public function getAttributeLabel($label)
	{
		$allLabels = isset($_SESSION[$this->attributeLablesSessionRange]) ? $_SESSION[$this->attributeLablesSessionRange] : array();
		return array_key_exists($label, $allLabels) ? $allLabels[$label] : $label;
	}

	/**
	 * displayError отображает ошибки валидации поля
	 * @uses на примере placeholder: <input name="fieldname" ... > <?php echo $formValidator->displayError('fieldname'); ?>, где: "..." - остальные возможные параметры текстового поля input
	 * @param  string $fieldName имя поля (параметр name в input)
	 * @return string|false при наличии ошибки валидации поля в сессии возвращает ее текст
	 */
	public function displayError($fieldName)
	{
		$errors = isset($_SESSION[$this->requireFieldsSessionRange]) ? $_SESSION[$this->requireFieldsSessionRange] : array();
		return (isset($errors[$fieldName]) && !empty($errors[$fieldName])) ? $errors[$fieldName] : false;
	}

	/**
	 * currentFormFieldValue подставляет в поле формы значение отправленное методом $_POST при ошибках валидации
	 * @uses <input name="fieldname" ... value="<?php echo $formValidator->currentFormFieldValue('fieldname'); ?>">, где: "..." - остальные возможные параметры текстового поля input
	 * @param  string $fieldName имя поля (параметр name в input)
	 * @return string|false при наличии данных в поле формы возвращает эти данные
	 */
	public function currentFormFieldValue($fieldName)
	{
		return (isset($_POST[$fieldName]) && !empty($_POST[$fieldName])) ? $_POST[$fieldName] : false;
	}

	/**
	 * summaryError отображает суммарную информацию об ошибках валидации формы
	 * @uses echo $formValidator->summaryError()  отображает суммарную информацию об ошибках валидации в месте вызова
	 * @param $sessionRange array возвращает массив сообщений об ошибках, в случае отсутствия - пустой массив
	 * @return string|false возвращает тексты ошибок из области массива $_SESSION, указанной в переменной requireFieldsSessionRange 
	 */
	public function summaryError()
	{
		$sessionRange = isset($_SESSION[$this->requireFieldsSessionRange]) ? $_SESSION[$this->requireFieldsSessionRange] : array();
		$errorMsg = implode(' ', $sessionRange);
		return !empty($errorMsg) ? '<div class="alert alert-danger text-center"><b>' . $errorMsg . '</b></div>' : false;
	}

	/**
	 * addSessionMessages добавляет сообщения к текущей сессии
	 * @uses  $formValidator->addSessionMessages($range, $attribute, $value); если нет необходимости указывать область $range - $formValidator->addSessionMessages($range=false, $attribute, $value); для добавления нескольких сообщений - создать массив текстов сообщений и вызывать данный метод через foreach:
	 * $values = array('message1', ..., 'messageN')
	 * foreach($values as $value)
	 * {
	 * 	$formValidator->addSessionMessages($range, $attribute, $value);
	 * }
	 * @param array $range      область массива $_SESSION для хранения сообщений
	 * @param string $attributes название аттрибута массива $_SESSION для хранения сообщений
	 * @param string $values     текст сообщения
	 * @return  none
	 */
	public function addSessionMessages($range=NULL, $attributes, $values)
	{
		if(isset($range) && !empty($range))
		{
			$_SESSION[$range][$attributes] = $values;
		}
		elseif(!isset($range))
		{
			$_SESSION[$attributes] = $values;
		}
		else
		{
			die('Заданные аттрибуты не корректны');
		}
	}

	/**
	 * Очищает заданную в параметрах область сесии
	 * область $range - вложенный массив
	 * если указана область ($range) и элементы данной области ($elements) - будет удален каджый элемент в области
	 * если область не укзана - удаление будет происходить в корне массива
	 * если не указаны элементы ($elements) - будет удалена вся область
	 * @uses $formValidator->clearSessionElements($rangeName) - удаление области сообщений из сессии; $formValidator->clearSessionElements($rangeName, $fieldsName) - удаление полей сообщений, перечисленных в массиве $fieldsName из области заданной в $rangeName сессии;
	 * @param  string $range область - вложенный массив массива $_SESSION
	 * @param  array $elements массив значений
	 * @return none
	 */
	public function clearSessionElements($range = NULL, $elements = NULL)
	{
		if(isset($elements) && !empty($elements))
		{
			foreach ($elements as $k => $v) {
				unset($_SESSION[$range][$v]);
			}			
		}
		else
		{
			unset($_SESSION[$range]);
		}
	}

	/**
	 * requiredVieldsValidator валидация обязательных полей формы
	 * получает на входе список полей формы подлежащих заполнению
	 * Очищает текущую сессию от возможных предыдущих ошибок валидации
	 * В случае отправки данных формы методом $_POST, проверяет заполнены ли полученные на входе поля формы
	 * Если указанное в качестве аргумента поле(-я) не заполнено(-ы) создает в массиве $_SESSION вложенный массив, в который записывает ошибки валидации формы
	 * @uses  $formValidator->requiredFieldsValidator('fieldName1', 'fieldName2', ...,'fieldNameN')
	 * @param  string $fieldName1, ..., fieldNameN имена полей (параметр name в input)
	 * @return true|false
	 */
	public function requiredFieldsValidator()
	{
		$elementsArray = func_get_args();
		$this->clearSessionElements($this->requireFieldsSessionRange, false);
		$inverseElementsArray = array_flip($elementsArray);
		
		if($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$validateFileds = array_intersect_key($_POST, $inverseElementsArray);
			foreach ($validateFileds as $k => $v) {
				if(empty(trim($v)))
				{
					// $_SESSION[$this->requireFieldsSessionRange][$k] = '<p class="text-danger text-center">' . $this->getAttributeLabel($k) . ' - обязательный аттрибут <br/></p>';
					$this->addSessionMessages($this->requireFieldsSessionRange, $k,'<p class="text-danger text-center">' . $this->getAttributeLabel($k) . ' - обязательный аттрибут <br/></p>');
				}				
			}

			$compareArgsSession = array();

			if(isset($_SESSION[$this->requireFieldsSessionRange]))
			{
				$compareArgsSession = array_diff_assoc($_SESSION[$this->requireFieldsSessionRange], $inverseElementsArray);
			}

		}

		return !empty($compareArgsSession) ? false : true;		
	}

	/**
	 * getFields проверка пустых полей
	 * @uses $formValidator->getFields('fieldName1', ..., 'fieldNameN')
	 * @return true|false возвращает true/false если переданный(-е) аргумент(-ы) существует/не существует
	 */
	public function getFields()
	{
		$fieldsArray = func_get_args();
		foreach ($fieldsArray as $k=>$v) {
			return (!isset($v) || empty($v)) ? false : true;
		}
	}

	/**
	 * emailFormat проверяет корректность заполнения поля email
	 * @param  string $emailField поле ввода email для валидации
	 * @return true|false возвращает true/false если переданный аргумент - адрес электронной почты
	 */
	public function emailFormat($emailField)
	{
		if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST[$emailField]))
		{
			if($this->getFields($emailField)){
				if(!filter_var($_POST[$emailField], FILTER_VALIDATE_EMAIL))
				{
					$this->addSessionMessages($this->requireFieldsSessionRange, 'emailFormat', '<p class="text-danger text-center"> В поле "Email" введено значение некорректного формата <br/></p>');
					return false;
				}
				else
				{
					return true;
				}
			}
			else
			{
				$this->addSessionMessages($this->requireFieldsSessionRange, 'emailFormat', '<p class="text-danger text-center"> В поле "Email" введено значение некорректного формата <br/></p>');
			}
		}
	}

	/**
	 * checkEmailMX определяет доменную часть переданного аргумента (email), производит попытку разрешить доменное имя, в случае успеха возвращает массив SMTP-серверов, обслуживающих данный email
	 * @param  string $emailField поле email для валидации
	 * @return array|false возвращает массив SMTP-серверов при наличии обнаружения в DNS-окружении, false - при отсутствии
	 */
	public function checkEmailMX($emailField)
	{
		if($this->emailFormat($emailField))
		{
			$emailDomain = substr(strrchr($_POST[$emailField], "@"), 1);		
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
				$this->addSessionMessages($this->requireFieldsSessionRange, 'emailFormat', '<p class="text-danger text-center"> Домен указанного email не обнаружен в DNS. Возможно он не существует. Проверьте правильность ввода Email <br/></p>');
				return false;
			}
		}
	}

	/**
	 * [mxConnect description]
	 * @param  [type] $emailField [description]
	 * @return [type]             [description]
	 */
	public function mxConnect($emailField)
	{
		if($this->checkEmailMX($emailField))
		{
			foreach ($this->checkEmailMX($emailField) as $mxHost) {			
				$fp = @fsockopen($mxHost,25, $errno, $errstr, 5);
				if($fp)
				{
					$result[0] = trim(fgets($fp)); // $result[0] = substr($result[0], 0, 3);

					fwrite($fp, "HELO " . CONFIG['app_url'] . "\r\n");
	    			$result[1] = trim(fgets($fp)); // $result[1] = substr($result[1], 0, 3);

					fwrite($fp, "MAIL FROM: <" . CONFIG['app_email'] . "> \r\n");
	    			$result[2] = trim(fgets($fp)); // $result[2] = substr($result[2], 0, 3);

					fwrite($fp, "RCPT TO: <" . $_POST['email'] . "> \r\n");
	    			$result[3] = trim(fgets($fp)); // $result[3] = substr($result[3], 0, 3);

					fwrite($fp, "QUIT" . "\r\n");
	    			$result[4] = trim(fgets($fp)); // $result[4] = substr($result[4], 0, 3);

					fclose($fp);

					break;
				}
				else
				{
					$this->addSessionMessages($this->requireFieldsSessionRange, 'emailFormat', '<p class="text-danger text-center"> Невозможно подключиться к MX-серверу. Недоступен MX-сервер или 25-й порт указанного сервера. <br/></p>');
					die();					
				}
			}
			return $fp ? $result : false;
		}
	}

	public function emailQuery($emailField)
	{
		if($this->mxConnect($emailField))
		{

			if(substr($this->mxConnect($emailField)[3], 0, 1) == 2)
			{
				$this->addSessionMessages($this->requireFieldsSessionRange, 'emailFormat', '<p class="text-danger text-center"> Email существует! <br/></p>');
			}
			elseif(substr($this->mxConnect($emailField)[3], 0, 1) == 4)
			{
				$this->addSessionMessages($this->requireFieldsSessionRange, 'emailFormat', '<p class="text-danger text-center"> Сервер временно отклонил попытку соединения. Повторите попытку позже! <br/></p>');				
				// echo $notrifications->displayNotifications(5, mxConnect()[3] . '<br/>' . $counters->timeExecution());
			}
			elseif(substr($this->mxConnect($emailField)[3], 0, 1) == 5)
			{
				$this->addSessionMessages($this->requireFieldsSessionRange, 'emailFormat', '<p class="text-danger text-center"> Email не существует! <br/></p>');
			}


		}
		else
		{
			$this->addSessionMessages($this->requireFieldsSessionRange, 'emailFormat', '<p class="text-danger text-center"> Невозможно установить соедининие с MX-сервером <br/></p>');
			// die();
		}
	}

} // formValidator endClass

