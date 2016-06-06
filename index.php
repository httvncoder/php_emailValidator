<html>
	<!DOCTYPE html>
	<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php require_once('/web/layouts/main.php'); ?>
	</head>

<body>

<form action="emailValidator.php" method="post" target="emailValidatorResult" id="getAccessForm" class="emailValidateForm">
	<p><input type="text" name="name" placeholder="Ф.И.О.:" /></p>
	<p><input type="tel" name="phone" placeholder="Тел.:" /></p>
	<p><input type="email" name="email" placeholder="EMAIL:" /></p>
	<!-- <p><input type="submit" name="submit" value="Ввод" onClick="processForm();" /> <input type="reset" value="Сброс" /></p> -->
	<p>
		<button type="submit" class="btn btn-success">
	    	<i class="fa fa-plus"></i> Ввод
		</button>
		<!-- <input type="submit" name="submit" value="<i class='fa fa-plus'></i>Ввод" class="btn btn-success" />  -->
		<input type="reset" value="Сброс" class="btn btn-primary btn-sm" />
	</p>
</form>

<div class="embed-responsive embed-responsive-4by3">
  <iframe name="emailValidatorResult" class="embed-responsive-item"></iframe>
</div>

</body>

</html>

<!-- <script type="text/javascript">
	function processForm()
	{
		document.getElementById('getAccessForm').reset();
	}	
</script> -->

<?php 

?>