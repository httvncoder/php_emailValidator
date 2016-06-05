

<form action="emailValidator.php" method="post" target="emailValidatorResult" id="getAccessForm" >
	<p><input type="text" name="name" placeholder="Ф.И.О.:" /></p>
	<p><input type="tel" name="phone" placeholder="Тел.:" /></p>
	<p><input type="email" name="email" placeholder="EMAIL:" />
	<!-- <p><input type="submit" name="submit" value="Ввод" onClick="processForm();" /> <input type="reset" value="Сброс" /></p> -->
	<p><input type="submit" name="submit" value="Ввод" /> <input type="reset" value="Сброс" /></p>
</form>

<iframe name="emailValidatorResult">
</iframe>


<!-- <script type="text/javascript">
	function processForm()
	{
		document.getElementById('getAccessForm').reset();
	}	
</script> -->

<?php   
	// $mx = 'mail.gorodavt1o.com';
	// $fp = @fsockopen($mx,25, $errno, $errstr, 2);
	// $result = $fp ? true : false;
	// print_r($result);
?>