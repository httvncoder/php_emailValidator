<html>
	<!DOCTYPE html>
	<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

	    <link rel="stylesheet" type="text/css" href="/css/bootstrap/3.3.5/bootstrap.min.css">
	    
	    <link rel="stylesheet" href="/css/bootstrap/3.3.5/bootstrap-theme.min.css">

		<script src="/js/jQuery/1.12.0/jquery.min.js"></script>
	    <script src="/js/bootstrap/3.3.5/bootstrap.min.js"></script>
	</head>

<body>

<form action="emailValidator.php" method="post" target="emailValidatorResult" id="getAccessForm" >
	<p><input type="text" name="name" placeholder="Ф.И.О.:" /></p>
	<p><input type="tel" name="phone" placeholder="Тел.:" /></p>
	<p><input type="email" name="email" placeholder="EMAIL:" /></p>
	<!-- <p><input type="submit" name="submit" value="Ввод" onClick="processForm();" /> <input type="reset" value="Сброс" /></p> -->
	<p><input type="submit" name="submit" value="Ввод" class="btn btn-success btn-sm" /> <input type="reset" value="Сброс" /></p>
</form>
<iframe name="emailValidatorResult"></iframe>

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