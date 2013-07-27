var Login = Class.extend({
	init: function () {
		$('form[name=login]').submit(function(){
	        var email = $(this).find('input[name=email]').val();
	        var password = $(this).find('input[name=password]').val();
	        var auth = new Auth();
	        auth.login(email, password, function(){ $(window).changePage(redirectPageAfterLogin); menuCreate(true); linkClick('nav'); }, function(){ $('.popupLogin').fadeIn('fast'); });
	        return false;
	    });
	}
});