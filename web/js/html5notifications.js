function sendNotification(title, options) {

	/**
	 * Проверка, поддержки HTML5 Notifications браузером
	 * [if description]
	 * @param  {[type]} !("Notification" in window) [description]
	 * @return {[type]}                  [description]
	 */
	if (!("Notification" in window)) {
		// alert('Ваш браузер не поддерживает HTML Notifications, его необходимо обновить.');
	}
 
	/**
	 * Проверка разрешений на отправку уведомления
	 * [if description]
	 * @param  {[type]} Notification.permission [description]
	 * @return {[type]}                         [description]
	 */
	else if (Notification.permission === "granted") {

		/**
		 * Отправка уведомления
		 * @type {Notification}
		 */
		var notification = new Notification(title, options);
		
		/**
		 * clickFunc действие при клике на уведомление
		 * @return {[type]} js alert, либо редирект при клике на уведомление
		 */
		function clickFunc() { 
			// alert('Пользователь кликнул на уведомление');
			document.location.href = document.URL;
		}
		 
		/**
		 * [onclick description]
		 * @type {[type]}
		 */
		notification.onclick = clickFunc;
	}
 
	/**
	 * Попытка получения прав, в случае их отсутствия
	 * [if description]
	 * @param  Notification.permission 	отправка уведомления если права предоставлены
	 */
	else if (Notification.permission !== 'denied') {
		Notification.requestPermission(function (permission) {

					/**
					 * Отправка уведомления, если права получены
					 */
					if (permission === "granted") {
						var notification = new Notification(title, options);				 
					}
					else {
						/**
						 * Показ уведомлений отклонен пользователем
						 */
						alert('Вы запретили показывать уведомления');
					}
				}
			);

	} 
	else {		
		/**
		 * Пользователь ранее отклонил запрос
		 */
	}
};