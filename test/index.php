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


				$formName = 'Форма предоставления доступа к публичному сегменту сети WiFi';

				$agreementCheckboxText = '<em>*</em> <span id="checkboxText" class="text-danger">Подтверждаю свое согласие на обработку персональных данных</span>';

			?>

	</head>

<script type="text/javascript" src="/web/js/html5notifications.js">
/**
 * Ссылка на файл, содержащий функцию отображения HTML5 уведомлений
 */
</script>

<script type="text/javascript" src="/web/js/submitStatusByAgreement.js">
/**
 * Ссылка на файл, содержащий функцию отключения кнопки подтверждения формы без проставленного согласия
 */
</script>

<body>

	<div class="panel panel-primary" style="width: 60%; margin: 0 auto;">
		<div class="panel-heading">
			
			<?php echo '<h4>' . $formName . '</h4>'; ?>

		</div>
		<div class="panel-body">

	<form action="<?php /** вызвать действие на текущей странице */ echo $_SERVER['PHP_SELF']; ?>" method="post" id="requiredfields">
		
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
				/**
				 * Проверить поле EMAIL на существование, если валидация успешна
				 * @see  $formValidator->emailQuery($emailField);
				 */
				$formValidator->emailQuery('email');				
			}

			/**
			* Суммарное отображение ошибок валидации
			* @see $formValidator->summaryError()
			*/
			echo $formValidator->summaryError();

		?>

		<div class="col-md-2 button-right">
			<label for="fullname"><?php /** возвращает метку поля */ echo $formValidator->getAttributeLabel('fullname') ?></label>
		</div>
		<div class="col-md-10">
	    	<input type="text" id="fullname" name="fullname" class="form-control" placeholder="Иванов Иван Иванович" value="<?php /** возвращает введенные в поле данные в случае ошибок валидации */ echo $formValidator->currentFormFieldValue('fullname'); ?>">
	    </div>

		<div class="col-md-12">
	    	<?php
	    		/**
	    		 * Возвращает текст ошибки поля при ее наличии
	    		 * @see $formValidator->displayError()
	    		 */
	    		echo $formValidator->displayError('fullname'); 
	    	?>
	    </div>
	    
	    <br/><br/><br/>

		<div class="col-md-2 button-right">
			<label for="phone"><?php /** возвращает метку поля */ echo $formValidator->getAttributeLabel('phone') ?></label>
		</div>
		<div class="col-md-10">
	    	<input type="text" name="phone" id="phone" class="form-control" placeholder="+7 (XXX) XXX-XX-XX" value="<?php /** возвращает введенные в поле данные в случае ошибок валидации */ echo $formValidator->currentFormFieldValue('phone'); ?>">
	    </div>

		<div class="col-md-12">
	    	<?php
	    		/**
	    		 * Возвращает текст ошибки поля при ее наличии
	    		 * @see $formValidator->displayError()
	    		 */
	    		echo $formValidator->displayError('phone'); 
	    	?>
	    </div>
	    
	    <br/><br/><br/>
	    
		<div class="col-md-2 button-right">
			<label for="email"><?php /** возвращает метку поля */ echo $formValidator->getAttributeLabel('email') ?></label>
		</div>
		<div class="col-md-10">
	    	<input type="text" id="email" name="email" class="form-control" placeholder="info@ivanov.org" value="<?php /** возвращает введенные в поле данные в случае ошибок валидации */ echo $formValidator->currentFormFieldValue('email'); ?>">
	    </div>	    

		<div class="col-md-12">
	    	<?php
	    		/**
	    		 * Возвращает текст ошибки поля при ее наличии
	    		 * @see $formValidator->displayError()
	    		 */
	    		echo $formValidator->displayError('email'); 
	    	?>
	    </div>	    
	    
	    <br/><br/><br/>

		<div id="result">
		</div><!-- Result div end -->		

		<p class="button-right">
			<input type = 'checkbox' name = "isAccepted" onchange = 'blockSubmitBtn("agreementSubmit", "emailFormSubmit", "checkboxText");' id = 'agreementSubmit';'/> <?php echo $agreementCheckboxText; ?>	
		</p>
	    	<?php
	    		/**
	    		 * Возвращает текст ошибки поля при ее наличии
	    		 * @see $formValidator->displayError()
	    		 */
	    		echo $formValidator->displayError('isAccepted'); 
	    	?>

		<p class="button-right">
	        <button class="btn btn-primary btn-lg" id="emailFormSubmit" type="submit" disabled>
	        	<i class="fa fa-check"></i> Ввод
	        </button>
			<button name="resetBtn" type="reset" onclick="window.location='<?php /** Обновить страницу */ echo $_SERVER['PHP_SELF']; ?>'" class="btn btn-link">
		    	<i class="fa fa-refresh"></i> Сброс
			</button>
		</p>	

	</form><!-- requiredfieldsForm End -->


		</div>
	</div>

</body>

</html>

<script type="text/javascript" src="/web/js/phoneMask.js">
	/**
	 * 
	 */
	jQuery(function($){
	   $("#phone").mask("+7 (999) 999-99-99");
	});
</script>

<script type="text/javascript">
	/**
	 * Вызов, передача аргументов функции показа уведомлений
	 * @type {String|Array}
	 */
	sendNotification('Группа компаний "Альянс"', 
		{
			body: '<?php echo $formName; ?>',
			icon: '/web/img/icons/alliance_logo.png',
			dir: 'auto'
		}
	);
</script>