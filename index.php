<html>
	<!DOCTYPE html>
	<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php require_once('web/layouts/main.php'); ?>
		<?php require_once('web/forms/modals/emailValidatorForm.php'); ?>
	</head>

<body>

<!-- <script type="text/javascript" src="/js/phoneMask.js"></script> -->
<script type="text/javascript" src="/js/ajaxEmailValidator.js"></script>

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

</div><!-- Modal Panels End -->

</body>

</html>
