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
	  if (authResult['status']['signed_in']) {
	    // Update the app to reflect a signed in user
	    // Hide the sign-in button now that the user is authorized, for example:
	    document.getElementById('signinButton').setAttribute('style', 'display: none');
	  } else {
	    // Update the app to reflect a signed out user
	    // Possible error values:
	    //   "user_signed_out" - User is signed-out
	    //   "access_denied" - User denied access to your app
	    //   "immediate_failed" - Could not automatically log in the user
	    console.log('Sign-in state: ' + authResult['error']);
	  }
	}