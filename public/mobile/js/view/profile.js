var Profile = Class.extend({
	init: function () {
//		var dealresumehgt = $(window).height() - $('#profileContainer').offset().top - $('.bottom-menu').outerHeight();
//        $('#profileContainer').height(dealresumehgt);
//        var profile;
//        new Ajax('profile/me', function (r) {
//            console.log(r);
//            profile = r;
//        });
		var manageProfile = function(){
			$(".db-fullName").html(c.findValueByKey("firstName")+" "+c.findValueByKey("lastName"));
			$(".db-lockboxAmountText").html(numberFormat(parseInt(c.findValueByKey("lockboxAmount"), 10), 2, ',', ' '));
			pre = "+";
			if(c.findValueByKey("averageRentability") < 0){
				$(".result").addClass("negatif").removeClass("positif");
				pre = "";
			}
			$(".db-avgRentabilityText").html(pre+" "+numberFormat(parseInt(c.findValueByKey("averageRentability"), 10), 2, ',', ' '));
			
			var invests = i.findAll();
			
			modelNotStarted = $($(".notStarted:first").outerHTML()).css("display", "block");
			modelCurrent = $($(".current:first").outerHTML()).css("display", "block");
			modelEnded = $($(".ended:first").outerHTML()).css("display", "block");
			
			
			//Display started currents
			$(invests.current).each(function(){
				content = $(this);
				var investItem = modelCurrent.clone();
				investItem.find(".title").html(content[0].product.text.title);
				gain = parseInt(content[0].gain, 10);
				rentability = content[0].rentability;
				pre = "+";
				if(gain < 0){
					investItem.find('.money-result').addClass("negatif").removeClass("positif");
					pre = "";
				}
				investItem.find(".gain").html(pre+" "+numberFormat(gain, 2, ',', ' '));
				investItem.find(".rentability").html(pre+" "+numberFormat(rentability, 2, ',', ' '));
				$(".myDeals").append(investItem.outerHTML());
			});
			
//			//Display notStarted
//			$(invests.notStarted).each(function(){
//				content = $(this);
//				console.log(content);
//				var investItem = modelNotStarted.clone();
//				investItem.find(".title").html(content[0].product.text.title);
//				investItem.find(".sumInvested").html(numberFormat(parseInt(content[0].product.config.sumInvestedAmounts, 10), 2, ',', ' '));
//				funded = parseInt(content[0].product.config.sumInvestedAmounts,10) / parseInt(content[0].product.config.requiredAmount,10);
//				var fundedNumBar = funded > 1 ? 1 : funded;
//				var fundedBar = investItem.find('.progress-bar-hover').width()*fundedNumBar;
//				investItem.find('.progress-bar-hover').width('-='+fundedBar);
//				investItem.find('.progress-bar-hover').css({marginLeft:fundedBar});
//				ratioInvested = Math.round(funded*10000)/100;
//				investItem.find(".ratioInvested").html(ratioInvested);
//				$(".myDeals").append(investItem.outerHTML());
//			});
			
			//Display ended
			
		};
		$(window).on("meGranted", manageProfile);
		
		
		
	}
});