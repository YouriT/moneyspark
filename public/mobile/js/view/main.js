var redirectPageAfterLogin = "/index";
var inputObject = new Input();

var loader = function () {

    var device_loader = $('<div id="main-loader" class="loader big"><i class="icon-refresh icon-spin"></i></div>');
    device_loader.width($(window).width()*5);
    device_loader.css('left',-($(window).width()*2)+'px');
    $('body').prepend(device_loader);

    $('#page').css('-webkit-filter','blur(3px)');

    $(window).one('pageLoaded', function () {
        if (navigator.userAgent.indexOf('Apple') === -1) {
            $('#page').css('-webkit-filter', 'blur(0px)');
        } else {
            $('#page').css('-webkit-filter', '');
        }
        $('#main-loader').remove();
    });
};

var menuClick = function() {
    $('a').click(function (e) {
        e.preventDefault();
        if ($(this).prop('href').indexOf('#') !== -1) {
            return false;
        }

        var dir = 'left';
        if ($(this).attr('data-direction') === 'right') {
            dir = 'right';
        }

        if($(this).hasClass('needConnected')){
            //Check out if user is connected
            var th = $(this);
            TableConfiguration.findValueByKey('token', function(){ $(window).changePage(th.prop('href'), dir); },
                                                       function(){
                                                            redirectPageAfterLogin=th.prop('href');
                                                            $(window).changePage("/connexion", dir);
                                                       });
        }
        else if($(this).hasClass('logout')){
            TableConfiguration.delete("token", function(){
                $(window).changePage("/connexion", dir);
            });
        } else {
            $(window).changePage($(this).prop('href'), dir);
        }
    });
};

var menuCreate = function(connected){
    $('.ensemble-menu').append('<a href="/userprofile" class="needConnected"><i class="icon-user iconmenu"></i></a><div class="inter-menu"></div>');
    $('.ensemble-menu').append('<a href="/cash1" class="needConnected"><i class="icon-lock iconmenu"></i></a><div class="inter-menu"></div>');
    $('.ensemble-menu').append('<a href="/about"><i class="icon-bolt iconmenu"></i></a>');
    $('.ensemble-menu').append('<div class="inter-menu"></div><a href="/index"><i class="icon-home iconmenu"></i></a>');
    if(connected){
        $('.ensemble-menu').append('<div class="inter-menu"></div><a href="/index" class="logout"><i class="icon-power-off iconmenu"></i></a>');
    }
};

var pageCreated = function (){
	console.log("Current page: "+$('body').attr("data-url"));

	//All pages
	//Create menu
	TableConfiguration.findValueByKey("token", function(){
		//Menu when connected
		menuCreate(true);
        menuClick();
	}, function(){
		//Menu when not connected
			menuCreate(false);
            menuClick();
	});

	//Page login
	if($('body').attr("data-url") === "login"){
		$('form[name=login]').submit(function(){
			var email = $(this).find('input[name=email]').val();
			var password = $(this).find('input[name=password]').val();
			var auth = new Auth();
            auth.login(email, password, function(){ $(window).changePage(redirectPageAfterLogin); }, function(){ $('.popupLogin').fadeIn('fast'); });
            return false;
		});
	}

	//Page profile
	if($('body').attr("data-url") === "profile"){
		var dealresumehgt = $(window).height() - $('#profileContainer').offset().top - $('.bottom-menu').outerHeight();
        $('#profileContainer').height(dealresumehgt);
        var profile;
        new Ajax('profile/me', function (r) {
            console.log(r);
            profile = r;
        });
    }


	//Page deals
	if($('body').attr("data-url") === "deals"){
        
        $('.pagenum').click(function () {
            if ($(this).index() === 2) {
                changeProduct('next');
            } else if ($(this).index() === 0) {
                changeProduct('prev');
            }
        });
		if (eventCounts('productsGranted') === 0) {
			$(window).on('productsGranted', function () {
				var productsDb = new TableProducts();
                productsDb.findAll(function (r) {
					createProducts(r);
                    $(window).trigger('pageLoaded');
                });
			});
		}
		$('#page').width($(window).width());
        $('#page').height($(window).height());
        var pad = $('.deal').width() - $('.deal').innerWidth();
        $('.buydeal').css({
            marginLeft: pad/2,
            marginRight: pad/2
        });

        $('#page').removeAttr('class');

        var middle = $('.container:last').width()/2 - $('.ensemble-pagenum-bottom-menu').width()/2 - $('.button-menuvertical').width();
        $('.ensemble-pagenum-bottom-menu').css({
            marginLeft: middle+'px'
        });
	}

    //Page register
    if($('body').attr("data-url") === "register") {
        $('#signin-slider > div').width($('#signin-slider').parents('.container').width());
        $('#signin-slider > div:not(.active)').each(function () {
            $(this).css('right',-$(window).width());
        });
        
        $('input[name=birthDate]').keypress(function(e){
            var t = $(this);
        	if(e.which != 13){
        		if(t.val().length == 2 || t.val().length == 5){
        			t.val(t.val()+"/");
        		}
        	}
        });
        n=0;
        $('input[name=iban]').keypress(function(e){
        	t = $(this);
        	if(e.which != 13){
        		if(t.val().length == 4 || ( t.val().length > 4 && ( t.val().length-n )%4 ==0 ) ) {
        			n++;
        			t.val(t.val()+" ");
        		}
        	}
        	else
        	{
        		if(t.val().length%5==0)
        			n--;
        	}
        });

        $('button.signin').click(function () {
        	nb = $('.active').find('input').length;
        	current = 0;
        	$('.active').find('input').each(function(){
        		obj = $(this);
        		inputObject.set(obj);      	
        		if(inputObject.validate() != "good"){
        			alert("Error"+" "+obj.attr("name")+" : "+inputObject.validate());
        			return;
        		}
        		else
        		{
        			current++;
        			if(nb==current){
        				current=0;
        				//Next if not last step
        				if($('.active').index() <= 1 ){
        					slideSignin('next');
        				}
        				else //Last step !
        				{
        					//Send if last step
        					birthD = $('input[name=birthDate]').val();
        					birthDArray = birthD.split("/");
        					if(birthDArray[2] != undefined && birthDArray[1] != undefined && birthDArray[0] != undefined){
        						newBirthD = birthDArray[2]+"-"+birthDArray[1]+"-"+birthDArray[0];
        					}
        					else
        					{
        						newBirthD = "";
        					}
        					new Ajax("Register", function(r){
        						if(r.error != undefined){

        							
        							if(r.error.code != 1000){
        								for(i=0; i<2;i++){
	        								slideSignin('prev');
	        							}
	        							alert(r.error.message);
        							}
        							else
        							{
        								errorInputName = keyAt(r.error.message, 0);
	        							errorType = keyAt(r.error.message[errorInputName], 0);
	        							errorValue = r.error.message[errorInputName][errorType];
	        							//Wich slide has this input ?
	        							nIndexSlide = $('input[name='+errorInputName+']').parents(".slide").index();
	        							nSlideEffect = 2-nIndexSlide;
	        							for(i=0; i<nSlideEffect;i++){
	        								slideSignin('prev');
	        							}
	        							alert(errorInputName+" "+errorValue);
	        						}
        						}
        						else
        						{
        							$(window).changePage("/index", "right");
        							alert("All right, you are registered !");
        						}
        						
        					}, $('input:not([name$="birthDate"])').serialize()+"&locale="+globalLocale+"&birthDate="+newBirthD, "POST");
        					
        				}
        				return;
        			}
        		}
        	});
        });
    }
    
    // Swipe function /!\ must be at the end
    $(window).swipe({
        swipe: function (event, direction, distance, duration, fingerCount) {
            if (distance > $(window).width()*0.07) {
                // Products swipe
                if($('body').attr("data-url") == "deals") {
                    if (direction === 'right') {
                        changeProduct('prev');
                    } else if (direction === 'left') {
                        changeProduct('next');
                    }
                }
                // Signin swipe
                if($('body').attr("data-url") == "register") {
                    if (direction === 'right') {
                        slideSignin('prev');
                    } else if (direction === 'left') {
                        slideSignin('next');
                    }
                }
            }
        }
    });

    // Menu click
    $('#showLeftPush').click(function () {
        $('.menuvertical-push').toggleClass('menuvertical-push-toright');
        $('nav').toggleClass('menuvertical-left');
    });

	$(window).trigger("askRetrieve");
};

$(window).ready(function () {
    loader();
});

$(window).load(function () {
    $(window).on('resize-product', resizeProduct);
    $(window).on('imin', iminClick);
    $(window).on('pageCreated', pageCreated);
    $(window).trigger("pageCreated");
    $('.check').click();
});