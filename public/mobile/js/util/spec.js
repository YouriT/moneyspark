var eventCounts = function (name) {
	var arr = $._data($(window)[0], 'events');
	if (arr[name] == undefined)
		return 0;
	else
		return arr[name].length;
};

(function ($) {
    $.fn.changePage = function (page, direction) {
        $.ajaxSetup ({
            cache: false
        });
        loader();
        var page = page.replace(".html", "").replace(SERVER_HTTP_HOST(), "");
        
        $.get(page, function (r) {
            var mult = -1;
            if (direction == undefined) {
                direction = 'left';
            }
            if (direction == 'right') {
                mult = 1;
            }

            var pattern = /<body[^>]*>((.|[\n\r])*)<\/body>/im
            var body = pattern.exec(r);
            if (body != null) {
                r = body[0].replace('<body','<div').replace('</body>','</div>');
            }
            var $page = $(r).find('#page');

            $page.prop('id','page2');
            if (direction === 'left') {
                $page.css({position:'absolute',left:$(window).width()+'px'});
            } else {
                $page.css({position:'absolute',left:-$(window).width()+'px'});
            }

            $page.width($(window).width());
            $page.height($(window).height());
            $page.parent().find('script').remove();
            $page.css('-webkit-filter','blur(3px)');
            $('#page').before($page.parent().html());
            $('#page').css('overflow','hidden');
            var add = 0;
            function transitions() {
                $('#page').transition({x:mult*($(window).width())});
                $('#page2').transition({x:mult*($(window).width())},function () {
                    var $p2 = $('#page2');
                    var copyClasses = $p2.prop('class');
                    $p2.removeAttr('class');
                    $('body').prop('class', copyClasses);
                    $('body').attr('data-url', $p2.attr('data-url'));
                    $('#page').remove();
                    $p2.css({
                        position: '',
                        left: '',
                        transform: '',
                    });
                    $p2.prop('id','page');
                    $(window).trigger('pageCreated');
                    $(window).trigger('pageLoader');
                });
            }
            if ($('body').hasClass('menuvertical-push-toright')) {
                $('body').removeClass('menuvertical-push-toright');
                transitions();
            }
            else
                transitions();
        }, 'html');
    };
}(jQuery));

var beautyCheckboxes = function () {
    $(this).toggleClass('active');
    $('.check-input').eq($('.slide .check').index($(this))).val($(this).hasClass('active') ? 1 : 0);
};