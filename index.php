<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Fluffy</title>

<link rel="stylesheet" type="text/css" href="css/css.css">

<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/js.js"></script>

<body>

	<div id="headerwrap">
	<button style="float:right;">
		Register
	</button>
	<button class="link" style="float:right; margin-right:10px">
		Login
	</button>
	<div class="TEdit" id="PW" style="float:right; margin-right:10px">
    	<input type="password" name="PW" value="Password" size="10px">
	</div>
	<div class="TEdit" id="ID" style="float:right; margin-right:10px">
		<input type="text" name="ID" value="ID" size="10px">
	</div>
	</div>


	
	
<div id="gameAreaWrapper"></div>
	
	<script type="text/javascript">
		getQuestionText(1);
	</script>
</body>
</html>

