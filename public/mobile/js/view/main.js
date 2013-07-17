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
            if (TableConfiguration.findValueByKey('token') != false) {
                $(window).changePage(th.prop('href'), dir);
            } else {
                redirectPageAfterLogin=th.prop('href');
                $(window).changePage("/connexion", dir);
            }
        }
        else if($(this).hasClass('logout')){
            if (TableConfiguration.remove("token")) {
                $(window).changePage("/connexion", dir);
            }
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
var mainObject = this;
var Page = Class.extend({
    obj: null,
    init: function () {
        var className = $('#page').attr("data-url");
        className = className.charAt(0).toUpperCase() + className.slice(1);
        if (mainObject[className] != undefined) {
            this.obj = new mainObject[className];
        } else {
            alert("The class corresponding to this page doesn't exists");
        }
        $(window).on('pageCreated', this.createdHandler);
        this.createdHandler();
        this.swiper();
    },
    swiper: function () {
        var $this = this;
        $(window).swipe({
            swipe: function (event, direction, distance, duration, fingerCount) {
                if (distance > $(window).width()*0.07) {
                    console.log($this.obj);
                    if ($this.obj['swipe'] != undefined) {
                        $this.obj.swipe(event, direction, distance, duration, fingerCount);
                    }
                }
            }
        });
    },
    createdHandler : function () {
        console.log("Current page: "+$('body').attr("data-url"));

        if (TableConfiguration.findValueByKey("token") != false) {
            //Menu when connected
            menuCreate(true);
            menuClick();
        } else {
            //Menu when not connected
            menuCreate(false);
            menuClick();
        }

        //Page deals
        if($('body').attr("data-url") === "deals"){
            
            
            // dealView.addListeners();

            // $('.pagenum').click(function () {
            //     if ($(this).index() === 2) {
            //         changeProduct('next');
            //     } else if ($(this).index() === 0) {
            //         changeProduct('prev');
            //     }
            // });
            
            

            // $('#page').removeAttr('class');

            
        }
        

        // Menu click
        $('#showLeftPush').click(function () {
            $('.menuvertical-push').toggleClass('menuvertical-push-toright');
            $('nav').toggleClass('menuvertical-left');
        });

        $(window).trigger("askRetrieve");
    }
});

$(window).ready(function () {
    loader();
});

$(window).load(function () {
    new Page();
    // $('.check').click();
});