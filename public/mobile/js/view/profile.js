var Profile = Class.extend({
	init: function () {
		
		
		//console.log(dealresumehgt, $(window).height(), $('#profileContainer').offset().top, $('.footer').outerHeight());
		
	
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
			
			modelNotStarted = $($(".notStarted:first").outerHTML()).show();
			modelCurrent = $($(".current:first").outerHTML()).show();
			modelEnded = $($(".ended:first").outerHTML()).show();
			
			var dealresumehgt = $(window).height() - $('#profileContainer').offset().top - $('.footer').outerHeight();
			$('#profileContainer').height(dealresumehgt);
			$('#profileContainer').niceScroll();
			//Display started currents
			$(invests.current).each(function(){
				content = $(this);
				var investItem = modelCurrent.clone();
				investItem.find(".title").html(content[0].product.text.title);
				investItem.attr("data-investId", content[0].id);
				gain = parseInt(content[0].gain, 10);
				rentability = content[0].rentability*100;
				pre = "+";
				if(gain < 0){
					investItem.find('.money-result').addClass("negatif").removeClass("positif");
					pre = "";
				}
				investItem.find(".gain").html(pre+" "+numberFormat(gain, 2, ',', ' '));
				investItem.find(".rentability").html(pre+" "+numberFormat(rentability, 2, ',', ' '));
				$(".myDeals").append(investItem.outerHTML());
				investItemV = $("[data-investId="+content[0].id+"]");
				w = investItemV.find(".puce").siblings(".opportunity-bar-layout").width();
				side = Math.round(w/2);
				if(content[0].rentability < -1)
					content[0].rentability = -1;
				else if(content[0].rentability > 1)
					content[0].rentability = 1;
				position = Math.round((side+(content[0].rentability*side)));
				wp = Math.round(investItemV.find(".puce").width()/2);
				if(gain<=0)
					position -= wp;
				else if(gain > 0)
					position += wp;
				investItemV.find(".puce").animate({marginLeft:position+"px"}, 1000);
			});
			
			//Display notStarted
			$(invests.notStarted).each(function(){
				content = $(this);
				var investItem = modelNotStarted.clone();
				investItem.find(".title").html(content[0].product.text.title);
				investItem.attr("data-investId", content[0].id);
				investItem.find(".sumInvested").html(numberFormat(parseInt(content[0].product.config.sumInvestedAmounts, 10), 2, ',', ' '));
				funded = parseInt(content[0].product.config.sumInvestedAmounts,10) / parseInt(content[0].product.config.requiredAmount,10);
				ratioInvested = Math.round(funded*10000)/100;
				investItem.find(".ratioInvested").html(ratioInvested);
				$(".myDeals").append(investItem.outerHTML());
				investItemV = $("[data-investId="+content[0].id+"]");
				var fundedNumBar = funded > 1 ? 1 : funded;
				var fundedBar = investItemV.find('.progress-bar-hover').width()*fundedNumBar;
				investItemV.find('.progress-bar-hover').animate({width:"-="+fundedBar, marginLeft:fundedBar}, 1000);
			});
			
			//Display ended
			$(invests.ended).each(function(){
				content = $(this);
				var investItem = modelEnded.clone();
				investItem.find(".title").html(content[0].product.text.title);
				investItem.attr("data-investId", content[0].id);
				gain = parseInt(content[0].gain, 10);
				rentability = content[0].rentability*100;
				pre = "+";
				if(gain < 0){
					investItem.find('.closeBar').addClass("negatif-bar-close").removeClass("positif-bar-close");
					investItem.find('.money-result').addClass("negatif").removeClass("positif");
					pre = "";
				}
				investItem.find(".gain").html(pre+" "+numberFormat(gain, 2, ',', ' '));
				investItem.find(".rentability").html(pre+" "+numberFormat(rentability, 2, ',', ' '));
				$(".myDeals").append(investItem.outerHTML());
			});
			
		};
		$("#page").on("meGranted", manageProfile);
		
		
		
	}
});