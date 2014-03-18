function getQuestionText(id){
	$.get("getQuestionText.php?id=" + id, function(data){
		$("#gameAreaWrapper").html(data);
	});
}