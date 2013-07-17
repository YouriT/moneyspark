var eventCounts = function (name) {
	var arr = $._data($(window)[0], 'events');
	if (arr[name] == undefined)
		return 0;
	else
		return arr[name].length;
};



var numberFormat = function (number, decimals, dec_point, thousands_sep) {
	// Formats a number with grouped thousands
	//
	// version: 906.1806
	// discuss at: http://phpjs.org/functions/number_format
	// +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
	// +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	// +     bugfix by: Michael White (http://getsprink.com)
	// +     bugfix by: Benjamin Lupton
	// +     bugfix by: Allan Jensen (http://www.winternet.no)
	// +    revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
	// +     bugfix by: Howard Yeend
	// +    revised by: Luke Smith (http://lucassmith.name)
	// +     bugfix by: Diogo Resende
	// +     bugfix by: Rival
	// +     input by: Kheang Hok Chin (http://www.distantia.ca/)
	// +     improved by: davook
	// +     improved by: Brett Zamir (http://brett-zamir.me)
	// +     input by: Jay Klehr
	// +     improved by: Brett Zamir (http://brett-zamir.me)
	// +     input by: Amir Habibi (http://www.residence-mixte.com/)
	// +     bugfix by: Brett Zamir (http://brett-zamir.me)
	// *     example 1: number_format(1234.56);
	// *     returns 1: '1,235'
	// *     example 2: number_format(1234.56, 2, ',', ' ');
	// *     returns 2: '1 234,56'
	// *     example 3: number_format(1234.5678, 2, '.', '');
	// *     returns 3: '1234.57'
	// *     example 4: number_format(67, 2, ',', '.');
	// *     returns 4: '67,00'
	// *     example 5: number_format(1000);
	// *     returns 5: '1,000'
	// *     example 6: number_format(67.311, 2);
	// *     returns 6: '67.31'
	// *     example 7: number_format(1000.55, 1);
	// *     returns 7: '1,000.6'
	// *     example 8: number_format(67000, 5, ',', '.');
	// *     returns 8: '67.000,00000'
	// *     example 9: number_format(0.9, 0);
	// *     returns 9: '1'
	// *     example 10: number_format('1.20', 2);
	// *     returns 10: '1.20'
	// *     example 11: number_format('1.20', 4);
	// *     returns 11: '1.2000'
	// *     example 12: number_format('1.2000', 3);
	// *     returns 12: '1.200'
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
        $.ajaxSetup ({
            cache: false
        });
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
                console.log($page);
                // throw "stop execution";
            } else {
                $page.css({left:-$(window).width()+'px'});
            }

            // $page.width($(window).width());
            // $page.height($(window).height());
            // $page.parent().find('script').remove();
            // $page.css('-webkit-filter','blur(3px)');
            $('#page').before($page[0].outerHTML);
            $('#page').css('overflow','hidden');
            var add = 0;
            function transitions() {
                $('#page').transition({x:mult*($(window).width())});
                $('#page2').transition({x:mult*($(window).width())},function () {
                    var $p2 = $('#page2');
                    $('#page').remove();
                    $p2.css({
                        left: '',
                        transform: '',
                    });
                    $p2.prop('id','page');
                    $(window).trigger('pageCreated');
                    // $(window).trigger('pageLoader');
                });
            }
            if (!$('nav').hasClass('menuvertical-left'))
                $('nav').addClass('menuvertical-left');
            // if ($('body').hasClass('menuvertical-push-toright')) {
            //     $('body').removeClass('menuvertical-push-toright');
            //     transitions();
            // }
            // else
                transitions();
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