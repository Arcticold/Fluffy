<div id="headerwrap">
	<?php
		$user = User::getLoggedInUser();
		if ($user) {
	?>
	<div style="float:right; margin-right:10px"><a href="index.php?logOut=1">Log out</a></div>
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
	<form method="post" action="index.php" id="loginForm">
		<div style="float:right; margin-right:10px">
	    	Password: <input type="password" name="password" value="" size="10" />
		</div>
		<div style="float:right; margin-right:10px">
			Username: <input type="text" name="username" value="" size="10" />
		</div>
		<input type="hidden" name="login" value="1" />
	</form>
	<button id="highscores" onclick="document.location=siteUrl+'highscores.php'" style="cursor:pointer; float:left;">
		Highscores
	</button>
	
	<div class="messagepop pop">
	    <form method="post" action="<?php echo SITE_URL; ?>">
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