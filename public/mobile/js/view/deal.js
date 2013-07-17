var Deal = Class.extend({
	products:null,
	index:null,
	init: function () {
		this.index = -1;
		$('div[data-role=checkbox]').checkboxes();
		$('#page').width($(window).width());
        $('#page').height($(window).height());
        var pad = $('.deal').width() - $('.deal').innerWidth();
        $('.buydeal').css({
            marginLeft: pad/2,
            marginRight: pad/2
        });
        var middle = $('.container:last').width()/2 - $('.ensemble-pagenum-bottom-menu').width()/2 - $('.button-menuvertical').width();
        $('.ensemble-pagenum-bottom-menu').css({
            marginLeft: middle+'px'
        });
        this.addListeners();
	},
	addListeners: function () {
		$(window).on('imin', this.investHandler);
		var obj = this;
		if (eventCounts('productsGranted') == 0) {
			$(window).on('productsGranted', function () {
				var productsDb = new TableProducts();
                obj.products = productsDb.findAll();
			});
		}
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
        $('.check-little-grey:not(.no-change)').click(function () {
            $(this).toggleClass('active');
        });
        $('.validate').click(function () {
            var termsOk = true;
            $('.terms, .risk, .claim').each(function () {
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
		$('button.letsgo').click(function () {
            var amountText = $(this).parents('.buydeal').find('input[name=amount]').val();
            if (amountText !== '' && !isNaN(amountText) && parseInt(amountText,10) > 0) {
                $this = $(this);
                amountInvest = parseInt(amountText);
                var obj = this;
                if (TableConfiguration.findValueByKey('token') != false) {
                    $back = $('.flip-container').find('.back');
                    $back.height($(window).height() - $back.offset().top - $('.bottom-menu').outerHeight() - parseInt($back.css('padding-top'),10)*2);

                    prod = obj.products.item($('.front > .deal').index($this.parents('.deal')));
                    $('.resume-amount').text(amountInvest);
                    $('.resume-product-name').text(prod.title);
                    $('.resume-hedgefund').text(prod.hedgefundTitle);
                    $('.resume-max-loss').text(prod.lossRateExpected*100);
                    $('.resume-max-loss-amount').text(Math.round(prod.lossRateExpected*amountInvest*100)/100);
                    $('.resume-max-gain').text(prod.profitsRateExpected*100);
                    $('.resume-max-gain-amount').text(Math.round(prod.profitsRateExpected*amountInvest*100)/100);
                    $('.resume-fee').text($this.parents('.buydeal').find('.fees:last').text());
                    $('.resume-user-cash').text();

                    $('.flip-container').toggleClass('hover');
                } else {
                    $(window).changePage("/connexion", "left"); 
                }
            }
		});
		$('.imin').click(function(){
			$('.buydeal').toggleClass('active');
			if (!$('.buydeal').hasClass('active')) {
				setTimeout(function () { $('.buydeal').css({marginTop: 0}); }, 300);
				$("body").css("overflow-y", "hidden");
			}
			else {
				$('.buydeal').css({marginTop: -10/16+'em'});
				$("body").css("overflow-y", "hidden");
			}
		});
	},
	parse : function(prod, i) {
	    prodObj = this.products.item(i);
	    prod.find('.title').html(prodObj.title);
	    prod.find('.hf-name').html(prodObj.hedgefundTitle);
	    var funded = prodObj.sumInvestedAmounts / prodObj.requiredAmount;
	    var fundedNumBar = funded > 1 ? 1 : funded;
	    var fundedBar = prod.find('.progress-bar-hover').width()*fundedNumBar;
	    prod.find('.progress-bar-hover').width('-='+fundedBar);
	    prod.find('.progress-bar-hover').css({marginLeft:fundedBar});
	    prod.find('.may-funded').before(Math.round(funded*10000)/100+'% ');
	    var endFundDate = new Date(prodObj.dateBeginExpected.date);
	    var today = new Date();
	    var left = (endFundDate.getTime()/1000 - today.getTime()/1000)/(24*3600);
	    var leftText = Math.round(left) > 1 ? Math.round(left)+' d' : Math.round(left) < 1 ? Math.round(left*24) > 1 ? Math.round(left*24)+' h' : Math.round(left*24)+' h' : '1 d';
	    prod.find('.lock-time').html(leftText);
	    prod.find('.ana > .text').html(prodObj.description);
	    var endExpect = new Date(prodObj.dateEndExpected.date);
	    var dealTime = (endExpect.getTime()/1000 - endFundDate.getTime()/1000)/(24*3600);
	    var dealTimeText = Math.round(dealTime) > 1 ? Math.round(dealTime)+' days' : Math.round(dealTime) < 1 ? Math.round(dealTime*24) > 1 ? Math.round(dealTime*24)+' hours' : Math.round(dealTime*24)+' hour' : '1 day';
	    prod.find('.sportwatch-time').html(dealTimeText);
	    prod.find('.renta-expected').html('+'+prodObj.profitsRateExpected*100+'%');
	    prod.find('.loss-expected').html('-'+prodObj.lossRateExpected*100+'%');
	},
	create : function () {
	    for (var i = 0; i < this.products.length; i++)
	    {
	        var newpage = $('#deal-model').html();
	        $('#deal-model').before('<div id="deal'+i+'" data-product="'+i+'" class="deal" style="width:'+$('#deal-model').width()+'px;position:absolute;right:-'+$(window).width()+'px">'+newpage+'</div>');
	        this.parse($('#deal-model').prev(), i);
	        $('#deal-model').prev().trigger('resize-product', $('#deal-model'));
	        $('input[name="amount"]', $('#deal-model').prev()).keyup(function (e) {
	            this.fee($(this), this.products);
	        });
	    }
	    $(window).trigger('imin');
	    $('.flip-container .front').width($('#deal-container').width());
	    $('.flip-container .front').height($('#deal-container').height());
	    $('#deal-model').hide();
	    this.index = -1;
	    this.slide('next');
	    $(window).trigger('pageLoaded');
	},
	slide : function (toPage) {
	    var toIndex = toPage === 'next' ? this.index+1 : this.index-1;
	    if ((toIndex >= this.products.length && toPage === 'next') ||
	        (toIndex < 0 && toPage === 'prev'))
	    {
	        alert('no more dude');
	        return;
	    }

	    if ($('body').find('#deal'+toPage).length == 0)
	    {
	        var mult = 1;
	        var margin = 0;
	        if (toPage === 'next') {
	            mult = -1;
	        }
	        
	        var cacheIndex = this.index;
	        var obj = this;
	        $('#deal' + toIndex).show();
	        
	        $('.pagenum').each(function () {
	            $(this).removeClass('active');
	            if (toIndex == 0 && $(this).index() == 0)
	                $(this).addClass('active');
	            else if (toIndex == obj.products.length-1 && $(this).index() == 2)
	                $(this).addClass('active');
	            else if (toIndex != 0 && toIndex != obj.products.length-1 && $(this).index() == 1)
	                $(this).addClass('active');
	        });

	        if (toIndex >= 0 && toIndex < this.products.length && $('#deal' + toIndex).length > 0)
	            $('#deal' + toIndex).transition({x: '+='+(mult*($(window).width()+margin))}, function () {
	                $('#deal' + cacheIndex).hide();
	            });
	        if (this.index >= 0 && this.index < this.products.length && $('#deal' + this.index).length > 0)
	            $('#deal' + this.index).transition({x: '+='+(mult*($(window).width()+margin))});
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