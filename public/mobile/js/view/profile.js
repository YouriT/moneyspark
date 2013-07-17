var Profile = Class.extend({
	init: function () {
		var dealresumehgt = $(window).height() - $('#profileContainer').offset().top - $('.bottom-menu').outerHeight();
        $('#profileContainer').height(dealresumehgt);
        var profile;
        new Ajax('profile/me', function (r) {
            console.log(r);
            profile = r;
        });
	}
});