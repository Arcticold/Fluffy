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
require_once('userheader.php');

$user = User::getLoggedInUser();
if (!$user) {
?>
<div id="gameAreaWrapper">Please log in to see this page.</div>
<?php
} else {
	$highscores = Mysql::c()->selectQuery('SELECT accounts.username, SUM(scores.score) AS end_score FROM accounts LEFT JOIN scores ON accounts.entry = scores.account_id GROUP BY scores.game_try_id ORDER_BY end_score DESC')
?>
<div id="gameAreaWrapper">
	
</div>
<?php
}
?>
</body>
</html>