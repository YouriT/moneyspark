var slideSignin = function (direction) {
    var $this = $('.slide.active');
    var margin = parseInt($this.parents('.container').css('margin-left'),10);
    var slideLength = ($(window).width() + margin);
    if ($this.next().length > 0 && direction == 'next') {
        $this.transition({x: '-='+slideLength}).removeClass('active');
        $this.next().transition({x: '-='+slideLength}).addClass('active');
    } else {
        $this.transition({x: '+='+slideLength}).removeClass('active');
        $this.prev().transition({x: '+='+slideLength}).addClass('active');
    }
    $('#signin-step > a.active').toggleClass('active');
    $('#signin-step > a').eq($('.slide').index($('.slide.active'))).toggleClass('active');
};

var keyAt = function(obj, index) {
    var i = 0;
    for (var key in obj) {
        if ((index || 0) === i++) return key;
    }
    return null;
};