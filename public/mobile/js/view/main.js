var redirectPageAfterLogin = "/index";
var inputObject = new Input();

var loader = function () {

    var device_loader = $('<div id="main-loader" class="loader big"><i class="icon-refresh icon-spin"></i></div>');
    device_loader.width($(window).width()*5);
    device_loader.css('left',-($(window).width()*2)+'px');
    // $('body').prepend(device_loader);

    // $('#page').css('-webkit-filter','blur(3px)');

    if (eventCounts('pageLoaded') == 0) {
        $(window).on('pageLoaded', function () {
            if (navigator.userAgent.indexOf('Apple') === -1) {
                $('#page').css('-webkit-filter', 'blur(0px)');
            } else {
                $('#page').css('-webkit-filter', '');
            }
            $('#main-loader').remove();
        });
    }
};

var linkClick = function(context) {
    $('a',context).click(function (e) {
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
    swiper: function () {
        var $this = this;
        $(window).swipe({
            swipe: function (event, direction, distance, duration, fingerCount) {
                if (distance > $(window).width()*0.07) {
                    if ($this.obj['swipe'] != undefined) {
                        $this.obj.swipe(event, direction, distance, duration, fingerCount);
                    }
                }
            }
        });
    }
});
var firstPInstance;

var createdHandler = function () {
    console.log("Current page: "+$('#page').attr("data-url"));

    var className = $('#page').attr("data-url");
    className = className.charAt(0).toUpperCase() + className.slice(1);
    if (mainObject[className] != undefined) {
        firstPInstance.obj = new mainObject[className];
    } else {
        alert("The class corresponding to this page doesn't exists");
    }

    firstPInstance.swiper();

    linkClick('#page');

    // Menu click
    $('#showLeftPush').click(function () {
        $('#page').not('.menuvertical-push').addClass('menuvertical-push');
        $('.menuvertical-push').toggleClass('menuvertical-push-toright');
        $('nav').toggleClass('menuvertical-left');
    });

    $(window).trigger("askRetrieve");
}

$(window).ready(function () {
    loader();
});

$(window).load(function () {

    firstPInstance = new Page();

    $(window).on('pageCreated', createdHandler);
    $(window).trigger('pageCreated');

    if (TableConfiguration.findValueByKey("token") != false) {
        //Menu when connected
        menuCreate(true);
    } else {
        //Menu when not connected
        menuCreate(false);
    }
    linkClick('nav');
    // $('.check').click();
});