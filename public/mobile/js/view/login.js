var Login = Class.extend({
	ready: function () {
		$('form[name=login]').submit(function(){
			
			$("#page").one("meGranted", function(){
    			$(window).changePage(redirectPageAfterLogin); menuCreate(true); linkClick('nav');
    		});
			
	        var email = $(this).find('input[name=email]').val();
	        var password = $(this).find('input[name=password]').val();
	        var auth = new Auth();
	        auth.login(email, password, function(){ 
	        	
	        	//Call back on $("#page").one("meGranted")
	        		
	        }, function(){ $('.popupLogin').fadeIn('fast'); });
	        return false;
	    });
	}
});