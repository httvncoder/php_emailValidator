<?php

/**
 * Description
 * Выводит на экран время исполнения скрипта
 * @return type time
 */
function timeExecution()
{
	return 'Время выполнения: ~ ' . round((microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]), 1) . ' сек';
}