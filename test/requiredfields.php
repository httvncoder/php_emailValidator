<?php

/**
 * formValidator	функции валидации форм, отображение ошибок
 * @version 0.1
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @author Maxim Ishchenko <maxim.ishchenko@gmail.com>
 * @copyright Copyright (c) Maxim Ishchenko <maxim.ishchenko@gmail.com>
 * 
 * @uses  <?php session_start ?> в секции <head>; включить в файл описания формы - <?php require_once(dirname(__FILE__).'/requiredfields.php'); ?>; <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> ... </form> - действие при подтверждении формы, метод подтверждения; $formValidator = new formValidator - объявить класс; использовать описанные ниже функции внутри формы
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

} // formValidator endClass