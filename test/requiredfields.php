<?php

// require_once(dirname(dirname(__FILE__)).'/helpers/varDump.php');
// require_once(dirname(__FILE__).'/counters.php');
// require_once(dirname(__FILE__).'/displayNotifications.php');

/**
* 
*/
class requiredFields
{
	/**
	 * Description
	 * @return type
	 */
	public function clearSessionElements()
	{
		$elementsArray = func_get_args();
		foreach ($elementsArray as $k => $v) {
			unset($_SESSION[$v]);
		}
	}

	/**
	 * [requireFieldsValidator description]
	 * если отправлен $_POST запрос - очищает сессию от возможно присвоенных ранее значений
	 * получает массив переданных функции аргументов, в котором меняет местами ключи со значениями
	 * вычисляет пересечение полученного массива с переданным массивом $_POST по ключам записывает в новый массив $_POST
	 * проверяет значения элементов, полученного массива $_POST
	 * если найдены пустые значения - записывает в сессию переменную вида $_SESSION[$k], где $k - ключ массива $_POST, равный имени передаваемого поля формы
	 * если пустые значения не найдены - возвращает true
	 * если $_POST запрос не был отправлен - очищает и уничтожает сессию
	 * @return [type] [description]
	 */
	public function requiredFieldsValidator()
	{
		$elementsArray = func_get_args();
		call_user_func_array(array($this, 'clearSessionElements'), $elementsArray);
		
		if($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$validateFileds = array_intersect_key($_POST, array_flip($elementsArray));
			foreach ($validateFileds as $k => $v) {
				// $validationErrorText[] = !empty($v) ? true : $_SESSION[$k] = $k . ' - обязательный аттрибут <br/>';
				if(empty($v))
				{
					$_SESSION[$k] = $k . ' - обязательный аттрибут <br/>';
				}				
			}
		}
		
		return !empty($_SESSION) ? false : true;		
	}

	/**
	 * Description
	 * @param type $fieldName 
	 * @return type boolean
	 */
	public function displayError($fieldName)
	{
		return (isset($_SESSION[$fieldName]) && !empty($_SESSION[$fieldName])) ? $_SESSION[$fieldName] : false;
	}

	/**
	 * Description
	 * @param type $fieldName 
	 * @return type
	 */
	public function currentFormFieldValue($fieldName)
	{
		return (isset($_POST[$fieldName]) && !empty($_POST[$fieldName])) ? $_POST[$fieldName] : false;
	}
}