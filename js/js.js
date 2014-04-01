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