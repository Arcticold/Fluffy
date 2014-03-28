<?php
session_start();
require('conf/runtime.conf.php');
require('models/MySql.class.php');
require('models/User.class.php');

Mysql::c()->connect(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);

$registrationErrorMessages = array();

if (isset($_POST['login'])) {
	$result = User::logInByUsername($_POST['username'], $_POST['password']);
	if ($result !== true) {
		$loginErrorMessage = $result;
	}
	
} elseif (isset($_POST['register'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];
	
	$existingUsers = Mysql::c()->selectQuery('SELECT entry FROM accounts WHERE username = "'.addslashes($username).'"');
	if (count($existingUsers) != 0) {
		$registrationErrorMessages[] = 'An account with this username already esists.';
	}
	
	if (strlen($password) < 4) {
		$registrationErrorMessages[] = 'Password too short.';
	}
	
	$existingUsers = Mysql::c()->selectQuery('SELECT entry FROM accounts WHERE email = "'.addslashes($email).'"');
	if (count($existingUsers) != 0) {
		$registrationErrorMessages[] = 'An account with this e-mail already exists.';
	}
	
	if (count($registrationErrorMessages) == 0) {
		$userId = Mysql::c()->query('INSERT INTO accounts (username, password, email, registered) VALUES ("'.addslashes($username).'", MD5("'.addslashes($password).'"), "'.addslashes($email).'", NOW())');
		if (!$userId) {
			$registrationErrorMessages[] = 'For some unexplainable reason the creation of a brand new account for you was unsuccessful.';
		}
	}
}

$user = User::getLoggedInUser();
if ($user && isset($_GET['logOut'])) {
	$user->logout();
	$user = NULL;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Fluffy</title>

<link rel="stylesheet" type="text/css" href="css/css.css">

<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/js.js"></script>

<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/client:plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
   })();
</script>

<body>


	<div id="headerwrap">
		<?php 
			if ($user) {
		?>
		<div style="float:right; margin-right:10px"><a href="?logOut=1">Log out</a></div>
		<?php 
				echo '<div style="float:right; margin-right:10px">'.$user->username.'</div>';
			} else {
		?>
		<div style="float:right; padding:2px 0 2px 2px;">
			<span id="signinButton">
			  <span
			    class="g-signin"
			    data-callback="signinCallback"
			    data-clientid="1080323710175-qnl5druq6lep6jjom5um4b1m4riktd2i.apps.googleusercontent.com"
			    data-cookiepolicy="single_host_origin"
			    data-requestvisibleactions="http://schemas.google.com/AddActivity"
			    data-scope="https://www.googleapis.com/auth/plus.login">
			  </span>
			</span>
		</div>
		<button id="register" style="float:right; margin-right:10px">
			Register
		</button>
		<button class="link" style="float:right; margin-right:10px" onclick="$('#loginForm').submit();">
			Login
		</button>
		<form method="post" action="" id="loginForm">
			<div style="float:right; margin-right:10px">
		    	Password: <input type="password" name="password" value="" size="10px" />
			</div>
			<div style="float:right; margin-right:10px">
				Username: <input type="text" name="username" value="" size="10px" />
			</div>
			<input type="hidden" name="login" value="1" />
		</form>
		
		<div class="messagepop pop">
		    <form method="post" action="">
		    	<?php
			    	if (count($registrationErrorMessages) > 0) {
			    		echo '<p style="color:red;">'.implode('<br />', $registrationErrorMessages).'</p>';
			    	}
		    	?>
		        <p><label for="username">Username</label><input type="text" size="30" name="username" id="username" /></p>
		        <p><label for="password">Password</label><input name="password" id="password" type="password"/></p>
		        <p><label for="email">E-mail</label><input name="email" id="email" /></p>
		        <p><input type="submit" value="Register" name="register" /> or <a class="close" href="/">Cancel</a></p>
		    </form>
		</div>
		<?php
			}
		?>
	</div>
	
	
<div id="gameAreaWrapper"></div>
	
	<script type="text/javascript">
			<?php
	    	if (count($registrationErrorMessages) > 0) {
	    		echo 'openRegisterWindow();';
	    	}
	    	?>
		getQuestionText(1);
	</script>
	
</body>
</html>
