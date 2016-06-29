<?php

require_once(dirname(dirname(__FILE__)).'/helpers/varDump.php');
// require_once(dirname(__FILE__).'/counters.php');
// require_once(dirname(__FILE__).'/displayNotifications.php');

/**
 * 
 */
class formValidator
{
	/**
	 * [attributeLabels description]
	 * @return [type] [description]
	 */
	public function attributeLabels($attributes)
	{
		return $attributes;
		d($attributes);
	}

	/**
	 * [clearSessionElements description]
	 * @return [type] [description]
	 */
	public function clearSessionElements()
	{
		$elementsArray = func_get_args();
		foreach ($elementsArray as $k => $v) {
			unset($_SESSION[$v]);
		}
	}

	/**
	 * [requiredFieldsValidator description]
	 * @return [type] [description]
	 */
	public function requiredFieldsValidator()
	{
		$elementsArray = func_get_args();
		call_user_func_array(array($this, 'clearSessionElements'), $elementsArray);
		$inverseElementsArray = array_flip($elementsArray);
		
		if($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$validateFileds = array_intersect_key($_POST, $inverseElementsArray);
			foreach ($validateFileds as $k => $v) {
				if(empty(trim($v)))
				{
					$_SESSION[$k] = '<p class="text-danger text-center">' . $k . ' - обязательный аттрибут <br/></p>';
					// $_SESSION[$k] = '<p class="text-danger text-center">' . $this->getAttributeLabel($valueAttributes, $k) . ' - обязательный аттрибут <br/></p>';
				}				
			}
		}		

		$compareArgsSession = array_diff_assoc($_SESSION, $inverseElementsArray);

		!empty($compareArgsSession) ? call_user_func_array(array($this, 'summaryError'), $elementsArray) : false;
		// d($compareArgsSession);

		return !empty($compareArgsSession) ? false : true;		
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
		$compareArgsSession = array_diff_assoc($_SESSION, $inverseElementsArray);

		$errorMsg = implode(' ', $compareArgsSession);

		return !empty($errorMsg) ? '<div class="alert alert-danger text-center"><b>' . $errorMsg . '</b></div>' : false;
	}

	/**
	 * [displayError description]
	 * @param  [type] $fieldName [description]
	 * @return [type]            [description]
	 */
	public function displayError($fieldName)
	{
		return (isset($_SESSION[$fieldName]) && !empty($_SESSION[$fieldName])) ? $_SESSION[$fieldName] : false;
	}

	/**
	 * [currentFormFieldValue description]
	 * @param  [type] $fieldName [description]
	 * @return [type]            [description]
	 */
	public function currentFormFieldValue($fieldName)
	{
		return (isset($_POST[$fieldName]) && !empty($_POST[$fieldName])) ? $_POST[$fieldName] : false;
	}

	/**
	 * [getAttributeLabel description]
	 * @param  [type] $attributes [description]
	 * @param  [type] $label      [description]
	 * @return [type]             [description]
	 */
	public function getAttributeLabel($attributes, $label)
	{
		return array_key_exists($label, $attributes) ? $attributes[$label] : $label;
	}
}