<?php

/**
 * Description
 * Возвращает сообщения в формате - уровень сообщения, текст сообщения
 * @param type $notificationLevel - Уровень сообщения
 * @param type $notificationText - Текст сообщения
 * @return type text
 */
function displayNotifications($notificationLevel, $notificationText)
{
	switch ($notificationLevel) {
		case 0:
			echo '<div class="alert alert-success text-center"><b>Сообщение: ';
			break;
		case 1:
			echo '<div class="alert alert-info text-center"><b>Предупреждение: ';
			break;
		case 2:
			echo '<div class="alert alert-danger"><b>Ошибка: ';
			break;
		case 3:
			echo '<b>Критическая ошибка:';
			break;
		case 4:
			echo '<b>Исключение:';
			break;
		case 5:
			echo '<div class="alert alert-info"><b>Информация: ';
			break;
		
		default:
			echo '';
			break;
	}

	echo $notificationText . "</b><br />\n</div>";
}