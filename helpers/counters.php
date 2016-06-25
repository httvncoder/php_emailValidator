<?php

class counters
{
	/**
	 * Description
	 * Выводит на экран время исполнения скрипта
	 * @return type time
	 */
	public function timeExecution()
	{
		return 'Время выполнения: ~ ' . round((microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]), 1) . ' сек';
	}	
}