<?php

class requiredFields
{
	/**
	 * Description
	 * Если не заполнены обязательные поля возвращает false
	 * [requiredFields description]
	 * @return [type] [description]
	 */
	public function getFields()
	{
		$fieldsArray = func_get_args();
		foreach ($fieldsArray as $k=>$v) {
			return (!isset($v) || empty($v)) ? false : true;
		}
	}
}