var redirectPageAfterLogin = "/index";
var inputObject = new Input();

var loader = function () {

    // var device_loader = $('<div id="main-loader" class="loader big"><i class="icon-refresh icon-spin"></i></div>');
    // device_loader.width($(window).width()*5);
    // // device_loader.css('left',-($(window).width()*2)+'px');
    // // $('body').prepend(device_loader);

    // // $('#page').css('-webkit-filter','blur(3px)');

    // if (eventCounts('pageLoaded') == 0) {
    //     $(window).on('pageLoaded', function () {
    //         if (navigator.userAgent.indexOf('Apple') === -1) {
    //             $('#page').css('-webkit-filter', 'blur(0px)');
    //         } else {
    //             $('#page').css('-webkit-filter', '');
    //         }
    //         $('#main-loader').remove();
    //     });
    // }
};

var linkClick = function(context) {
    $('a',context).click(function (e) {
        console.log('clicked'+$(this).prop('href'));
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
        $(document).swipe({
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

var loadedHandler = function (e, context) {
    if (firstPInstance.obj != null && firstPInstance.obj.loaded != null) {
        firstPInstance.obj.loaded.apply(firstPInstance.obj, arguments);
    }
};

var readyHandler = function (e, context) {
    console.log("Current page: "+context.attr("data-url"));

    var className = context.attr("data-url");
    className = className.charAt(0).toUpperCase() + className.slice(1);
    if (mainObject[className] != undefined) {
        firstPInstance.obj = new mainObject[className];
        if (firstPInstance.obj != null && firstPInstance.obj.ready != null) {
            firstPInstance.obj.ready.apply(firstPInstance.obj, arguments);
        }
    }

    firstPInstance.swiper();

    linkClick(context);

    // Menu click
    $('#showLeftPush').click(function () {
        var val = [0,0,0,0,0,0];
        if ($('#page').css('transform') != 'none') {
            val = matrixToArray($('#page').css('transform'));
        }

        var menuWidth = 66/16*parseInt($('#page').css('font-size'),10);

        if (val[4] == 0) {
            $('#page,nav').transition({x: menuWidth});
        } else {
            $('#page,nav').transition({x: 0});
        }
    });

    $(document).trigger("askRetrieve");
};

$(document).ready(function () {
    $(document).on('askRetrieve', retrieve);
    loader();
    firstPInstance = new Page();
    $(document).on('page-ready', readyHandler);
    $(document).trigger('page-ready', [$('#page')]);
});

$(window).load(function () {

    FastClick.attach(document.body);

    $(window).on('page-loaded', loadedHandler);
    $(window).trigger('page-loaded', [$('#page')]);

    if (TableConfiguration.findValueByKey("token") != false) {
        menuCreate(true);
    } else {
        menuCreate(false);
    }
    linkClick('nav');
});