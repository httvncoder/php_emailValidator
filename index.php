<html>
	<!DOCTYPE html>
	<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php require_once('/web/layouts/main.php'); ?>
		<?php require_once('/web/forms/modals/emailValidatorForm.php'); ?>
	</head>

<body>

<!-- <script type="text/javascript" src="/js/phoneMask.js"></script> -->
<script type="text/javascript" src="/web/js/ajaxEmailValidator.js"></script>

<div class="modal-panels">

	<div class="col-md-3" id="checkEmailPanel">
		<div class="panel panel-success panel-shadow" id="checkEmailPanelSuccess">
			<!-- <div class="panel-heading">Panel Heading</div> -->
	  		<div class="panel-body" id="checkEmailPanelBody">
				<div class="col-md-4">
					<i class="fa fa-inbox fa-inverse fa-5x"></i>
				</div>
				<div class="col-md-8">
					<h4>Проверка существования Email</h4>
				</div>
	  		</div><!-- id checkEmailPanelBody End -->
			<a data-toggle="modal" data-target="#checkEmail" style="text-align: center;">
	  			<div class="panel-footer">
					<i class="fa fa-send"></i> Запустить			
	  			</div>
	  		</a><!-- link open Modal id checkEmail -->
		</div><!-- checkEmailPanelSuccess End -->
	</div><!-- checkEmailPanel -->


	<div class="col-md-3" id="checkPtrPanel">
		<div class="panel panel-success panel-shadow" id="checkPtrPanelSuccess">
			<!-- <div class="panel-heading">Panel Heading</div> -->
	  		<div class="panel-body" id="checkPtrPanelBody">
				<div class="col-md-4">
					<i class="fa fa-inbox fa-inverse fa-5x"></i>
				</div>
				<div class="col-md-8">
					<h4>Проверка наличия PTR-записи</h4>
				</div>
	  		</div><!-- id checkEmailPanelBody End -->
			<a data-toggle="modal" data-target="#checkPtr" style="text-align: center;">
	  			<div class="panel-footer">
					<i class="fa fa-send"></i> Запустить			
	  			</div>
	  		</a><!-- link open Modal id checkEmail -->
		</div><!-- checkEmailPanelSuccess End -->
	</div><!-- checkEmailPanel -->	

</div><!-- Modal Panels End -->


			<form action="/validators/ptrValidator.php" target="my_frame" method="post" id="ptrValidation" >

				<div class="input-group input-group-lg">
					<span class="input-group-addon" id="sizing-addon2"><i class="fa fa-inbox"></i></span>
			      	<input type="text" name="email" class="form-control" placeholder="IP/FQDN:">
			      	<span class="input-group-btn">
			        	<button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> Ввод</button>
			      	</span>
			    </div>
			    <br/>

				<div id="result">
				</div><!-- Result div end -->

				<p class="button-right">
					<button type="reset" class="btn btn-default">
				    	<i class="fa fa-refresh"></i> Сброс
					</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">
						<i class="fa fa-remove"></i> Закрыть
					</button>
				</p>		

			</form><!-- getAccessForm End -->

			<iframe name="my_frame">

</body>

</html>