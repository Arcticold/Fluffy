
<?php
require('conf/runtime.conf.php');
require('models/MySql.class.php');

Mysql::c()->connect(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);

$id = (int)$_GET['id'];
if ($id == 0) {
	echo '<button onclick="getQuestionText(1);">START</button>';
	Mysql::c()->close();
	die();
}

$choices = MySql::c()->selectKeyValueQuery('SELECT * FROM choices', 'entry', 'image');
$question = MySql::c()->selectQuery('SELECT * FROM questions WHERE entry = '.$id.' LIMIT 1');

if (count($question) != 1) {
	echo 'Page not found!';
	Mysql::c()->close();
	die();
}

$question = array_pop($question);
echo '<div id="questionText">'.$question['q_text'].'</div>';
for ($i = 1; $i <= 6; $i++) {
	if ($question['choice_'.$i]) {
		$choice = $question['choice_'.$i];
		$top = rand(40, 360);
		$left = rand(0, 760);
		echo '<img onclick="submitAnswer('.$choice.');" class="choice choice-'.$choice.'" style="z-index:'.($i + 10).'; top:'.$top.'px; left:'.$left.'px;" src="'.SITE_URL.$choices[$choice].'" alt="" />';
	}
}
echo '
	<script type=text/javascript>
		questionTextDiv = $("#questionText");
		nextQuestionId = '.($question['next_q_id'] ? $question['next_q_id'] : -1).';
		lastAnswer = -1;
		answers = new Array();
';
for ($i = 1; $i <= 6; $i++) {
	if ($question['answer_'.$i]) {
		echo 'answers['.($i - 1).'] = '.$question['answer_'.$i].';';
	}
}
echo '</script>';

Mysql::c()->close();
?>