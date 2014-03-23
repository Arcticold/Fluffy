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


<div class="wrapper">
  <div class="fixed-wrapper">
    <div class="fixed">
      	<div class="TEdit" id="ID" style="position: relative; left: 0%; top: 0px;">
    		<input type="text" name="ID" value="ID" size="10px">
		</div>
    </div>
  </div>
</div>


	
	
<div id="gameAreaWrapper"></div>
	
	<script type="text/javascript">
		getQuestionText(1);
	</script>
</body>
</html>

<!-- 

	
	<div class="TEdit" id="PW" style="position: relative; left: 665px; top: 220px;">
    	<input type="password" name="PW" value="Password" size="10px">
	</div>
	
	<button class="link" style="position: absolute; left: 1000px; top: 220px;">
		Register
	</button>
	
	<button class="link" style="position: absolute; left: 760px; top: 220px;">
		Login
	</button>
	
-->