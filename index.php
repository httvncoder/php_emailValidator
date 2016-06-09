<html>
	<!DOCTYPE html>
	<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php require_once('web/layouts/main.php'); ?>
	</head>

<body>

<script type="text/javascript" src="phoneMask.js"></script>

<!-- <div class="col-md-9"> -->
<div class="col-md-6 col-md-offset-3">

	<div class="panel panel-default">
	  	<div class="panel-heading">Данные для предоставления доступа</div>
	  	<div class="panel-body">
			<form action="emailValidator.php" method="post" target="emailValidatorResult" id="getAccessForm" >	

				<div class="input-group input-small ">
				  <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-user"></i></span>
				  <input type="text" name="name" class="form-control" placeholder="Ф.И.О.:" aria-describedby="sizing-addon2">
				</div>
				<br>

				<div class="input-group input-small ">
					  <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-phone"></i></span>
					  <input type="tel" id="phone" name="phone" class="form-control" placeholder="Тел.:" aria-describedby="sizing-addon2">
					</div>
					<br>	

				<div class="input-group input-small ">
					  <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-inbox"></i></span>
					  <input type="email" name="email" class="form-control" placeholder="EMAIL:" aria-describedby="sizing-addon2">
					</div>
					<br>			
	 	 </div>

	  	<div class="panel-footer">
				<p class="button-right">
					<button type="submit" class="btn btn-success">
				    	<i class="fa fa-check"></i> Ввод
					</button>
					<button type="reset" class="btn btn-primary btn-sm">
				    	<i class="fa fa-remove"></i> Сброс
					</button>
				</p>
	  	</div>
	</div>
	
</form>

<!-- <div class="col-md-6 col-md-offset-3"> -->

<!-- <div class="panel panel-default"> -->
	<!-- <div class="panel-body"> -->
		<div class="embed-responsive embed-responsive-16by9">
		  <iframe name="emailValidatorResult" class="embed-responsive-item"></iframe>
		</div>
	<!-- </div> -->
<!-- </div> -->


<!-- </div> -->

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