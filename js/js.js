function deselect() {
    $(".pop").slideFadeToggle(function() { 
        $("#contact").removeClass("selected");
    });    
}

function openRegisterWindow() {
	$('#register').addClass("selected");
    $(".pop").slideFadeToggle(
    function() 
    { 
        $("#email").focus();
    });
}

$(function() 
{
    $('#register').click(function() 
    {
        if($(this).hasClass("selected")) 
        {
            deselect();               
        } 
        else 
        {
            openRegisterWindow();
        }
        return false;
    });

    $(".close").click(function() 
    {
        deselect();
        return false;
    });
});

$.fn.slideFadeToggle = function(easing, callback) {
    return this.animate({ opacity: 'toggle', height: 'toggle' }, "fast", easing, callback);
};

function getQuestionText(id)
{
	$.get("getQuestionText.php?id=" + id, 
	function(data)
	{
		$("#gameAreaWrapper").html(data);
	});
}

function googleButtonPre()
{ 
	var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	po.src = 'https://apis.google.com/js/client:plusone.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
}


function signinCallback(authResult) {
	  if (authResult['status']['google_logged_in'])
	  {
		  if (logOut == true) {
			  gapi.auth.signOut();
			  document.location = siteUrl;
		  } else {
			  $.get("https://www.googleapis.com/plus/v1/people/me?access_token=" + authResult["access_token"], function(data){
				  document.location = siteUrl + "?googleId=" + data["id"] + "&googleDisplayName=" + data["displayName"];
			  });
		  }
	  } else {
		  if (authResult['error'] == "user_signed_out")
		  {
			  document.location = siteUrl + "?logOut=1";
		  }
	  }
}

var questionTextDiv;
var nextQuestionId = -1;
var lastAnswer = -1;
var answers = new Array();

function submitAnswer(answerChoice){
	lastAnswer++;
	if (answers[lastAnswer] != answerChoice) {
		lastAnswer = -1;
		alert('FAIL! Start again!');
		questionTextDiv.show();
		return;
	}
	if (lastAnswer == 0) {
		questionTextDiv.hide();
	}
	if (answers.length == lastAnswer + 1) {
		if (nextQuestionId > -1) {
			getQuestionText(nextQuestionId);
			return;
		}
		alert('GAME OVER');
		getQuestionText(0);
		return;
	}
	$(".choice").each(function(){
		randomizeElementPosition($(this));
	});
}

function randomizeElementPosition(element){
	var topPosition = Math.floor((Math.random() * 320) + 40);
	var leftPosition = Math.floor((Math.random() * 760));
	element.animate({
		top:topPosition,
		left:leftPosition
	})
}