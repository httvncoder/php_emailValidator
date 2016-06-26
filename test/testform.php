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
			$requiredFields = new requiredFields;
			$requiredFields->requiredFieldsValidator('phone', 'email');
		?>
	</head>


<body>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="requiredfields" style="width: 60%; margin: 0 auto;">

	    <input type="text" name="fullname" class="form-control" placeholder="fullname:" value="<?php echo $requiredFields->currentFormFieldValue('fullname'); ?>">

	    	<?php echo $requiredFields->displayError('fullname'); ?>
	    
	    <br/>

	    <input type="text" name="phone" class="form-control" placeholder="phone:" value="<?php echo $requiredFields->currentFormFieldValue('phone'); ?>">
	    
	    	<?php echo $requiredFields->displayError('phone'); ?>
	    
	    <br/>
	    
	    <input type="text" name="email" class="form-control" placeholder="email:" value="<?php echo $requiredFields->currentFormFieldValue('email'); ?>">
	    
	    	<?php echo $requiredFields->displayError('email'); ?>
	    
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
			</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">
				<i class="fa fa-remove"></i> Закрыть
			</button>
		</p>		

	</form><!-- requiredfieldsForm End -->

</body>

</html>
