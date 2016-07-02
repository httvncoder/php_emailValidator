<html>
	<!DOCTYPE html>
	<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php session_start(); ?>
		<?php require_once(dirname(__FILE__).'/requiredfields.php'); ?>
		<?php require_once(dirname(dirname(__FILE__)).'/web/layouts/main.php'); ?>
		<?php require_once(dirname(dirname(__FILE__)).'/web/forms/modals/emailValidatorForm.php'); ?>
		<?php require_once(dirname(dirname(__FILE__)).'/helpers/displayNotifications.php'); ?>
		<?php require_once(dirname(dirname(__FILE__)).'/helpers/varDump.php'); ?>
		<?php
			// header( 'Cache-Control: no-store, no-cache, must-revalidate' ); 
			// header( 'Cache-Control: post-check=0, pre-check=0', false ); 
			// header( 'Pragma: no-cache' ); 
			// $formValidator = new formValidator;
			// $formValidator->requiredFieldsValidator('fullname', 'email');
			// echo $formValidator->summaryError();
		?>
	</head>


<body>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="requiredfields" style="width: 60%; margin: 0 auto;">
	<!-- <form action="testFormResult.php" method="post" target="_self" id="requiredfields" style="width: 60%; margin: 0 auto;"> -->
		
		<?php 
			$valueAttributes = array(
					'phone' => 'Телефон',
					'email' => 'Email',
					'fullname' => 'Ф.И.О.',
				);

			$formValidator = new formValidator;
			$formValidator->attributeLabels($valueAttributes);
			$formValidator->requiredFieldsValidator('fullname', 'email', 'phone');
			// echo $formValidator->summaryError();

		?>

	    <input type="text" name="fullname" class="form-control" placeholder="<?php echo $formValidator->getAttributeLabel('fullname') ?>" value="<?php echo $formValidator->currentFormFieldValue('fullname'); ?>">

	    	<?php echo $formValidator->displayError('fullname'); ?>
	    
	    <br/>

	    <input type="text" name="phone" class="form-control" placeholder="<?php echo $formValidator->getAttributeLabel('phone') ?>" value="<?php echo $formValidator->currentFormFieldValue('phone'); ?>">
	    
	    	<?php echo $formValidator->displayError('phone'); ?>
	    
	    <br/>
	    
	    <input type="text" name="email" class="form-control" placeholder="<?php echo $formValidator->getAttributeLabel('email') ?>" value="<?php echo $formValidator->currentFormFieldValue('email'); ?>">
	    
	    	<?php echo $formValidator->displayError('email'); ?>
	    
	    <br/>

		<div id="result">
		</div><!-- Result div end -->

		<p class="button-right">
	      	<!-- <span class="input-group-btn"> -->
	        	<button class="btn btn-primary" type="submit">
	        		<i class="fa fa-check"></i> Ввод
	        	</button>
	      	<!-- </span> -->
			<button type="reset" class="btn btn-default">
		    	<i class="fa fa-refresh"></i> Сброс
			</button><!-- 
			<button type="button" class="btn btn-default" data-dismiss="modal">
				<i class="fa fa-remove"></i> Закрыть
			</button> -->
		</p>		

	</form><!-- requiredfieldsForm End -->

</body>

</html>