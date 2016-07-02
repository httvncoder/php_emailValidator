<?php

require_once(dirname(dirname(__FILE__)).'/helpers/varDump.php');

/**
 * 
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
	 * @param  array $valueAttributesArray ассоциативный массив, содержит соответствия имен полей форм с метками.
	 * @return false
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
	 * @param  string $label имя поля
	 * @return string        метка поля $label
	 */
	public function getAttributeLabel($label)
	{
		$allLabels = isset($_SESSION[$this->attributeLablesSessionRange]) ? $_SESSION[$this->attributeLablesSessionRange] : array();
		return array_key_exists($label, $allLabels) ? $allLabels[$label] : $label;
	}

	/**
	 * displayError отображает ошибки валидации поля
	 * @param  string $fieldName имя поля (параметр name в input)
	 * @return string            при наличии ошибки валидации поля в сессии возвращает ее текст
	 */
	public function displayError($fieldName)
	{
		$errors = isset($_SESSION[$this->requireFieldsSessionRange]) ? $_SESSION[$this->requireFieldsSessionRange] : array();
		return (isset($errors[$fieldName]) && !empty($errors[$fieldName])) ? $errors[$fieldName] : false;
	}

	/**
	 * [currentFormFieldValue]
	 * @param  string $fieldName имя поля (параметр name в input)
	 * @return string            при наличии данных в поле формы возвращает эти данные
	 */
	public function currentFormFieldValue($fieldName)
	{
		return (isset($_POST[$fieldName]) && !empty($_POST[$fieldName])) ? $_POST[$fieldName] : false;
	}

	/**
	 * [summaryError description]
	 * @param  [type] $fieldName [description]
	 * @return [type]            [description]
	 */
	public function summaryError()
	{
		$elementsArray = func_get_args();
		
		$inverseElementsArray = array_flip($elementsArray);
		$sessionRange = $_SESSION['requiredFields'];
		$compareArgsSession = array_diff_assoc($sessionRange, $inverseElementsArray);

		// echo array_key_exists($_SESSION['requiredFields'], $_SESSION) ? 'true' : 'false';
		$errorMsg = implode(' ', $compareArgsSession);

		return !empty($errorMsg) ? '<div class="alert alert-danger text-center"><b>' . $errorMsg . '</b></div>' : false;
	}

	/**
	 * Очищает заданную в параметрах область сесии
	 * область $range - вложенный массив
	 * если указана область ($range) и элементы данной области ($elements) - будет удален каджый элемент в области
	 * если область не укзана - удаление будет происходить в корне массива
	 * если не указаны элементы ($elements) - будет удалена вся область
	 * @param  string $range    область - вложенный массив массива $_SESSION
	 * @param  array $elements массив значений
	 * @return false
	 */
	public function clearSessionElements($range = NULL, $elements = NULL)
	{
		$sessionRange = (isset($range)) ? $range : false;
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
	 * [requiredFieldsValidator description]
	 * @return [type] [description]
	 */
	public function requiredFieldsValidator()
	{
		$elementsArray = func_get_args();
		// session_unset();
		$this->clearSessionElements($this->requireFieldsSessionRange, false);
		$inverseElementsArray = array_flip($elementsArray);
		
		if($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$validateFileds = array_intersect_key($_POST, $inverseElementsArray);
			foreach ($validateFileds as $k => $v) {
				if(empty(trim($v)))
				{
					// $_SESSION[$sessionRange][$k] = '<p class="text-danger text-center">' . $k . ' - обязательный аттрибут <br/></p>';
					$_SESSION[$this->requireFieldsSessionRange][$k] = '<p class="text-danger text-center">' . $this->getAttributeLabel($k) . ' - обязательный аттрибут <br/></p>';
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
}