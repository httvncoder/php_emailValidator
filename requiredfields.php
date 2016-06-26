<?php

/**
* 
*/
class requiredFields
{
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
	public function requireFieldsValidator()
	{
		if($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			session_unset();
			$validateFileds = array_intersect_key($_POST, array_flip(func_get_args()));
			foreach ($validateFileds as $k => $v) {
				$validationErrorText[] = !empty($v) ? true : $_SESSION[$k] = $k . ' - обязательный аттрибут <br/>';
			}
		}
		else
		{
			session_unset();
			session_destroy();
		}
		
	}

	public function displayError($fieldName)
	{
		return (isset($_SESSION[$fieldName]) && !empty($_SESSION[$fieldName])) ? $_SESSION[$fieldName] : false;
	}




}


// $search_array = array('first' => 1, 'second' => 4);
// if (array_key_exists('first', $search_array)) {
//     echo "Массив содержит элемент 'first'.";
// }

