<?php
session_start();
require_once('conf/runtime.conf.php');
require_once('models/MySql.class.php');
require_once('models/User.class.php');

Mysql::c()->connect(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Fluffy</title>

<link rel="stylesheet" type="text/css" href="css/css.css">

<script type="text/javascript">
   var logOut = <?php if ($_REQUEST['logOut']) { echo 'true'; } else { echo 'false'; } ?>;
</script>
<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/js.js"></script>

<script type="text/javascript">
  var siteUrl = "<?php echo SITE_URL; ?>";
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/client:plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
   })();
</script>

<body>
<?php
$loginErrorMessage = User::handleLogin();
$registrationErrorMessages = User::handleRegistration();

User::handleGoogleLogin();

$user = User::getLoggedInUser();
if ($user && isset($_GET['logOut']) && !isset($_REQUEST['login'])) {
	$user->logout();
}

require_once('userheader.php');
?>
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
