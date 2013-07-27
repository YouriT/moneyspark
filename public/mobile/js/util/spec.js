var eventCounts = function (name) {
	var arr = $._data($(window)[0], 'events');
	if (arr[name] == undefined)
		return 0;
	else
		return arr[name].length;
};

var matrixToArray = function(matrix) {
    return matrix.substr(7, matrix.length - 8).split(', ');
};

var numberFormat = function (number, decimals, dec_point, thousands_sep) {
	var n = number, prec = decimals;

	var toFixedFix = function (n,prec) {
	    var k = Math.pow(10,prec);
	    return (Math.round(n*k)/k).toString();
	};

	n = !isFinite(+n) ? 0 : +n;
	prec = !isFinite(+prec) ? 0 : Math.abs(prec);
	var sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep;
	var dec = (typeof dec_point === 'undefined') ? '.' : dec_point;

	var s = (prec > 0) ? toFixedFix(n, prec) : toFixedFix(Math.round(n), prec); //fix for IE parseFloat(0.55).toFixed(0) = 0;

	var abs = toFixedFix(Math.abs(n), prec);
	var _, i;

	if (abs >= 1000) {
	    _ = abs.split(/\D/);
	    i = _[0].length % 3 || 3;

	    _[0] = s.slice(0,i + (n < 0)) +
	          _[0].slice(i).replace(/(\d{3})/g, sep+'$1');
	    s = _.join(dec);
	} else {
	    s = s.replace('.', dec);
	}

	var decPos = s.indexOf(dec);
	if (prec >= 1 && decPos !== -1 && (s.length-decPos-1) < prec) {
	    s += new Array(prec-(s.length-decPos-1)).join(0)+'0';
	}
	else if (prec >= 1 && decPos === -1) {
	    s += dec+new Array(prec).join(0)+'0';
	}
	return s; 
};

(function ($) {
    $.fn.changePage = function (page, direction) {
        console.log('wanna change', page);
        var counter = 0;
        $('#page').unbind();
        $.ajaxSetup ({
            cache: true
        });


        // Change-page function
        loader();
        
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
                $page.css({left:$(window).width()+'px'});
            } else {
                $page.css({left:-$(window).width()+'px'});
            }

            // $page.width($(window).width());
            // $page.height($(window).height());
            // $page.parent().find('script').remove();
            // $page.css('-webkit-filter','blur(3px)');
            $('#page').before($page[0].outerHTML).ready(function () {
                $(document).trigger('page-ready', [$('#page2')]);
            });
            $('#page').css('overflow','hidden');
            var add = 0;
            var menuWidth = 66/16*parseInt($('#page').css('font-size'),10);
            
            function transitions() {
                $('#page').transition({x:mult*($(window).width())});
                $('#page2').transition({x:mult*($(window).width())}, function () {
                    var $p2 = $('#page2');
                    $('#page').remove();
                    $p2.prop('id','page');
                    $p2.css({
                        transform: '',
                        left: ''
                    });
                    $(window).trigger('page-loaded', [$('#page')]);
                });
            }

            var val = [0,0,0,0,0,0];
            if ($('#page').css('transform') != 'none') {
                val = matrixToArray($('#page').css('transform'));
            }

            if (val[4] != 0) {
                $('#page').transition({x:0});
                $('nav').transition({x:0}, transitions);
            } else {
                transitions();
            }
        }, 'html');
    };
    $.fn.checkboxes = function () {
	    $(this).find('div:first-child').toggleClass('active');
	    $this = $(this);
	    $('.check-text-little-grey, .check-little-grey', this).click(function () {
			$this.find('div:first-child').toggleClass('active');
	    });
	    // $('.check-input').eq($('.slide .check').index($(this))).val($(this).hasClass('active') ? 1 : 0);
	};
    $.fn.alignCenter = function () {
        console.log('aligning',$(this));
        var middle = $(this).width()/2;
        $(this).width($(this).width());
        $(this).css({
            position: 'absolute',
            left: '50%',
            marginLeft: '-'+middle+'px'
        });
    };
    $.fn.outerHTML = function(s) {
        return s
            ? this.before(s).remove()
            : jQuery("<p>").append(this.eq(0).clone()).html();
    };
}(jQuery));