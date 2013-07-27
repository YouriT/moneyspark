var Deal = Class.extend({
	products:null,
	index:null,
	context:null,
	init: function () {
		// console.log(this,arguments);
		this.index = -1;
		// $('#page').width($(window).width());
  //       $('#page').height($(window).height());
        // $('.ensemble-pagenum-bottom-menu').alignCenter();
	},
	ready: function (e, context) {
		this.context = context;
		this.addListeners();
		$('div[data-role=checkbox]').checkboxes();
	},
	loaded: function (e, context) {
		this.context = context;
		var pad = $('.deal', context).width() - $('.deal', context).innerWidth();
        $('.buydeal', context).css({
            marginLeft: pad/2,
            marginRight: pad/2
        });
	},
	addListeners: function () {
		$('#page').on('imin', this.investHandler);
		var obj = this;
		$('#page').on('productsGranted', function () {
			var productsDb = new TableProducts();
            obj.products = productsDb.findAll();
            obj.create();
		});
	},
	resize : function (obj) {
		var anaHeight = $(window).height() - $('.ana > .text', obj.target).offset().top - ($(window).height()*0.04+118+(0.62+0.75*16))/16*parseInt($('body').css('font-size'),10);
		$(".ana .text", obj.target).height(anaHeight);
		$(".ana .text", obj.target).niceScroll();
	},
	fee : function (obj, products) {

	    $minFeeRate = 0.05;
	    $maxFeeRate = 0.15;

	    i = parseInt(obj.parents('.deal').attr('data-product'),10);
	    prod = this.products.item(i);
	    $ratioInvested = Math.round(prod.sumInvestedAmounts/prod.requiredAmount*100)/100;
	    if($ratioInvested>1)$ratioInvested=1;
	    $diff = $maxFeeRate - $minFeeRate;
	    $feeRate = $minFeeRate+($ratioInvested*$diff);
	    $b = Math.round(parseInt(obj.val(),10)/100)*0.01;
	    $feeRate-$b < $minFeeRate ? $feeRate = $minFeeRate : $feeRate = $feeRate-$b;
	    $feeRate = Math.round($feeRate*100);
	    
	    obj.parents('.deal').find('.fees:last').html($feeRate);
	},
	investHandler : function () {
        var amountInvest = 0;
        var prod;
        var context = this.context;
        $('.validate', context).click(function () {
            var termsOk = true;
            $('.terms, .risk, .claim', context).each(function () {
                if (!$(this).hasClass('active')) {
                    termsOk = false;
                }
            });
            if (!termsOk) {
                alert('No risk, no return !');
            } else {
                new Ajax("investment", function(r) { 
                    alert(r.message);
                    $(window).changePage('/userprofile');
                }, {amount: amountInvest, idProduct: prod.id}, 'POST');
            }
        });
		$('button.letsgo', context).click(function () {
            var amountText = $(this).parents('.buydeal').find('input[name=amount]').val();
            if (amountText !== '' && !isNaN(amountText) && parseInt(amountText,10) > 0) {
                $this = $(this);
                amountInvest = parseInt(amountText);
                var obj = this;
                if (TableConfiguration.findValueByKey('token') != false) {
                    $back = $('.flip-container', context).find('.back');
                    $back.height($(window).height() - $back.offset().top - $('.bottom-menu', context).outerHeight() - parseInt($back.css('padding-top'),10)*2);

                    prod = obj.products.item($('.front > .deal', context).index($this.parents('.deal')));
                    $('.resume-amount', context).text(amountInvest);
                    $('.resume-product-name', context).text(prod.title);
                    $('.resume-hedgefund', context).text(prod.hedgefundTitle);
                    $('.resume-max-loss', context).text(prod.lossRateExpected*100);
                    $('.resume-max-loss-amount', context).text(Math.round(prod.lossRateExpected*amountInvest*100)/100);
                    $('.resume-max-gain', context).text(prod.profitsRateExpected*100);
                    $('.resume-max-gain-amount', context).text(Math.round(prod.profitsRateExpected*amountInvest*100)/100);
                    $('.resume-fee', context).text($this.parents('.buydeal').find('.fees:last').text());
                    $('.resume-user-cash', context).text();

                    $('.flip-container', context).toggleClass('hover');
                } else {
                    $(window).changePage("/connexion", "left"); 
                }
            }
		});
		$('.imin', context).click(function(){
			$('.buydeal', context).toggleClass('active');
			if (!$('.buydeal', context).hasClass('active')) {
				setTimeout(function () { $('.buydeal', context).css({marginTop: 0}); }, 300);
				// $("body").css("overflow-y", "hidden");
			}
			else {
				$('.buydeal', context).css({marginTop: -10/16+'em'});
				// $("body").css("overflow-y", "hidden");
			}
		});
	},
	parse : function(prod, i) {
	    prodObj = this.products[i];
	    prod.find('.title').html(prodObj.product.title);
	    prod.find('.hf-name').html(prodObj.hedgefund.title);
	    var funded = parseInt(prodObj.product.sumInvestedAmounts,10) / parseInt(prodObj.product.requiredAmount,10);
	    var fundedNumBar = funded > 1 ? 1 : funded;
	    var fundedBar = prod.find('.progress-bar-hover').width()*fundedNumBar;
	    prod.find('.progress-bar-hover').width('-='+fundedBar);
	    prod.find('.progress-bar-hover').css({marginLeft:fundedBar});
	    prod.find('.may-funded').before(Math.round(funded*10000)/100+'% ');
	    var endFundDate = new Date(prodObj.product.dateBeginExpected.date);
	    var today = new Date();
	    var left = (endFundDate.getTime()/1000 - today.getTime()/1000)/(24*3600);
	    var leftText = Math.round(left) > 1 ? Math.round(left)+' d' : Math.round(left) < 1 ? Math.round(left*24) > 1 ? Math.round(left*24)+' h' : Math.round(left*24)+' h' : '1 d';
	    prod.find('.lock-time').html(leftText);
	    prod.find('.ana > .text').html(prodObj.product.description);
	    var endExpect = new Date(prodObj.product.dateEndExpected.date);
	    var dealTime = (endExpect.getTime()/1000 - endFundDate.getTime()/1000)/(24*3600);
	    var dealTimeText = Math.round(dealTime) > 1 ? Math.round(dealTime)+' days' : Math.round(dealTime) < 1 ? Math.round(dealTime*24) > 1 ? Math.round(dealTime*24)+' hours' : Math.round(dealTime*24)+' hour' : '1 day';
	    prod.find('.sportwatch-time').html(dealTimeText);
	    prod.find('.renta-expected').html('+'+parseInt(prodObj.product.profitsRateExpected,10)*100+'%');
	    prod.find('.loss-expected').html('-'+parseInt(prodObj.product.lossRateExpected,10)*100+'%');
	},
	create : function () {
	    for (var i = 0; i < this.products.length; i++)
	    {
	        var newpage = $('#deal-model', this.context).html();
	        var dealWidth = $('.wrapper .container:first', this.context).width() - parseInt($('#deal-model', this.context).css('padding-top'),10)/100*$(window).width()* 2;
	        $('#deal-model', this.context).before('<div id="deal'+i+'" data-product="'+i+'" class="deal" style="width:'+dealWidth+'px;position:absolute;right:-'+$(window).width()+'px">'+newpage+'</div>');
	        this.parse($('#deal-model', this.context).prev(), i);
	        // $('#deal-model').prev().trigger('resize-product', $('#deal-model'));
	        $('input[name="amount"]', $('#deal-model', this.context).prev()).keyup(function (e) {
	            this.fee($(this), this.products);
	        });
	    }
	    $('#page').trigger('imin');
	    $('.flip-container .front', this.context).width($('#deal-container', this.context).width());
	    $('.flip-container .front', this.context).height($('#deal-container', this.context).height());
	    $('#deal-model', this.context).hide();
	    this.index = -1;
	    this.slide('next');
	    // $(window).trigger('pageLoaded');
	},
	slide : function (toPage) {
	    var toIndex = toPage === 'next' ? this.index+1 : this.index-1;
	    if ((toIndex >= this.products.length && toPage === 'next') ||
	        (toIndex < 0 && toPage === 'prev'))
	    {
	        alert('no more dude');
	        return;
	    }

	    if ($('#deal'+toPage, this.context).length == 0)
	    {
	        var mult = 1;
	        var margin = 0;
	        if (toPage === 'next') {
	            mult = -1;
	        }
	        
	        var cacheIndex = this.index;
	        var obj = this;
	        $('#deal' + toIndex, this.context).show();
	        
	        $('.pagenum', this.context).each(function () {
	            $(this).removeClass('active');
	            if (toIndex == 0 && $(this).index() == 0)
	                $(this).addClass('active');
	            else if (toIndex == obj.products.length-1 && $(this).index() == 2)
	                $(this).addClass('active');
	            else if (toIndex != 0 && toIndex != obj.products.length-1 && $(this).index() == 1)
	                $(this).addClass('active');
	        });

	        if (toIndex >= 0 && toIndex < this.products.length && $('#deal' + toIndex, this.context).length > 0)
	            $('#deal' + toIndex, this.context).transition({x: '+='+(mult*($(window).width()+margin))}, function () {
	                $('#deal' + cacheIndex, this.context).hide();
	            });
	        if (this.index >= 0 && this.index < this.products.length && $('#deal' + this.index, this.context).length > 0)
	            $('#deal' + this.index, this.context).transition({x: '+='+(mult*($(window).width()+margin))});
	        this.index = toIndex;
	    }
	},
	swipe : function (event, direction, distance, duration, fingerCount) {
        if (direction === 'right') {
            this.slide('prev');
        } else if (direction === 'left') {
            this.slide('next');
        }
	}
});