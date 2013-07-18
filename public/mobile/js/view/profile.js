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
			if(c.findValueByKey("averageRentability") < 0){
				$(".result").addClass("negatif").removeClass("positif");
				pre = "-";
			}
			else{
				pre = "+";
			}
			$(".db-avgRentabilityText").html(pre+" "+numberFormat(parseInt(c.findValueByKey("averageRentability"), 10), 2, ',', ' '));
			
			var invests = i.findAll();
			//Display started currents
			modelNotStarted = $($(".notStarted:first").outerHTML()).css("display", "block");
			
			$(invests.current).each(function(){
				content = $(this);
				console.log(content);
				var investItem = modelNotStarted.clone();
				investItem.find(".title").html(content[0].product.text.title);
				investItem.find(".sumInvested").html(numberFormat(parseInt(content[0].product.config.sumInvestedAmounts, 10), 2, ',', ' '));
				investItem.find(".ratioInvested").html(parseInt(content[0].product.config.sumInvestedAmounts,10) / parseInt(content[0].product.config.requiredAmount,10));
				
				$(".myDeals").append(investItem.outerHTML());
			});
			//Display notStarted
			//Display ended
			
		};
		$(window).on("meGranted", manageProfile);
		$(window).trigger("meGranted");
		
		
		
	}
});