<html>
	<!DOCTYPE html>
	<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

			<?php

				/**
				 * Начало сессии
				 * @see $formValidator
				 */
				session_start();

				/**
				 * Шаблон оформления сайта
				 */
				require_once(dirname(dirname(__FILE__)).'/web/layouts/main.php');

				/**
				 * Подключение файла, содержащего функции валидации полей формы
				 * @see  $formValidator
				 */
				require_once(dirname(__FILE__).'/requiredfields.php'); 

			?>

	</head>


<body>

	<form action="<?php /** вызвать действие на текущей странице */ echo $_SERVER['PHP_SELF']; ?>" method="post" id="requiredfields" style="width: 60%; margin: 0 auto;">
		
		<?php 

			/**
			 * $valueAttributes метки имен полей
			 * @see $formValidator
			 * @var $valueAttributes = array('fieldname1' => 'fieldLabel1', ...);	Ассоциативный массив формата <имя поля> => <значение метки для отображения>
			 */
			$valueAttributes = array(
					'phone' => 'Телефон',
					'email' => 'Email',
					'fullname' => 'Ф.И.О.',
				);

			/**
			 * $formValidator объявление класса, содержащего функции валидации формы
			 * @see $formValidator
			 * @var formValidator
			 */
			$formValidator = new formValidator;

			/**
			 * Передать массив для присвоения меток полям формы
			 * 
			 * @see  $formValidator->attributeLabels()
			 */
			$formValidator->attributeLabels($valueAttributes);

			/**
			 * Передать перечень полей, обязательных для заполнения
			 * @see $formValidator->requiredFieldsValidator()
			 */
			if($formValidator->requiredFieldsValidator('fullname', 'email', 'phone'))
			{
				$formValidator->emailQuery('email');				
			}

			

			/**
			 * Суммарное отображение ошибок валидации
			 * @see $formValidator->summaryError()
			 */
			echo $formValidator->summaryError();

		?>

	    <input type="text" name="fullname" class="form-control" placeholder="<?php /** возвращает метку поля */ echo $formValidator->getAttributeLabel('fullname') ?>" value="<?php /** возвращает введенные в поле данные в случае ошибок валидации */ echo $formValidator->currentFormFieldValue('fullname'); ?>">

	    	<?php
	    		/**
	    		 * Возвращает текст ошибки поля при ее наличии
	    		 * @see $formValidator->displayError()
	    		 */
	    		echo $formValidator->displayError('fullname'); 
	    	?>
	    
	    <br/>

	    <input type="text" name="phone" class="form-control" placeholder="<?php /** возвращает метку поля */ echo $formValidator->getAttributeLabel('phone') ?>" value="<?php /** возвращает введенные в поле данные в случае ошибок валидации */ echo $formValidator->currentFormFieldValue('phone'); ?>">
	    
	    	<?php
	    		/**
	    		 * Возвращает текст ошибки поля при ее наличии
	    		 * @see $formValidator->displayError()
	    		 */
	    		echo $formValidator->displayError('phone'); 
	    	?>
	    
	    <br/>
	    
	    <input type="text" name="email" class="form-control" placeholder="<?php /** возвращает метку поля */ echo $formValidator->getAttributeLabel('email') ?>" value="<?php /** возвращает введенные в поле данные в случае ошибок валидации */ echo $formValidator->currentFormFieldValue('email'); ?>">
	    
	    	<?php
	    		/**
	    		 * Возвращает текст ошибки поля при ее наличии
	    		 * @see $formValidator->displayError()
	    		 */
	    		echo $formValidator->displayError('email'); 
	    	?>
	    
	    <br/>

		<div id="result">
		</div><!-- Result div end -->

		<p class="button-right">
	        	<button class="btn btn-primary" type="submit">
	        		<i class="fa fa-check"></i> Ввод
	        	</button>
			<button type="reset" class="btn btn-default">
		    	<i class="fa fa-refresh"></i> Сброс
			</button>
		</p>		

	</form><!-- requiredfieldsForm End -->

</body>

</html>

<script type="text/javascript">

function sendNotification(title, options) {

	// Проверка, поддержки HTML5 Notifications браузером
	if (!("Notification" in window)) {
		alert('Ваш браузер не поддерживает HTML Notifications, его необходимо обновить.');
	}
 
	// Проверка разрешений на отправку уведомления
	else if (Notification.permission === "granted") {

		// Отправка уведомления
		var notification = new Notification(title, options);
		 
		function clickFunc() { 
			alert('Пользователь кликнул на уведомление'); 
		}
		 
		notification.onclick = clickFunc;
	}
 
	// Попытка получения прав, в случае их отсутствия
	else if (Notification.permission !== 'denied') {
		Notification.requestPermission(function (permission) {
					// Отправка уведомления, если права получены
					if (permission === "granted") {
						var notification = new Notification(title, options);				 
					}
					else {
						alert('Вы запретили показывать уведомления'); // Показ уведомлений отклонен пользователем
					}
				}
			);

	} 
	else {
		// Пользователь ранее отклонил запрос
	}
};

sendNotification('Заголовок', 
	{
		body: 'Описание',
		icon: 'icon.jpg',
		dir: 'auto'
	}
);

</script>