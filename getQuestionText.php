
<?php
require('conf/runtime.conf.php');
require('models/MySql.class.php');

Mysql::c()->connect(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);

$allQuestions = MySql::c()->selectQuery('SELECT * FROM questions WHERE entry = '.(int)$_GET['id']);

if (count($allQuestions) != 0) {
	echo $allQuestions[0]['q_text'].'<button onclick="getQuestionText('.((int)$_GET['id'] + 1).');">Get something</button>
			<script type="text/javascript">var rightAnswer = "'.$allQuestions[0]['answer_1'].'";
					var currentAnswer = "KAH";</script>';
} else {
	echo 'Game over';
}

Mysql::c()->close();
?>