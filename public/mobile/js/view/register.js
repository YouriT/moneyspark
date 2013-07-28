var keyAt = function(obj, index) {
    var i = 0;
    for (var key in obj) {
        if ((index || 0) === i++) return key;
    }
    return null;
};

var globalLocale = "fr_BE";
var Register = Class.extend({
    ready: function () {
        var $this = this;
        $('#signin-slider > div').width($('#signin-slider').parents('.container').width());
        $('#signin-slider > div:not(.active)').each(function () {
            $(this).css('right',-$(window).width());
        });

        $('.check,.check-text').click(function () {
            $(this).parent().find('.check').toggleClass('active');
            $(this).parent().find('input').val($(this).parent().find('.check').hasClass('active') ? '1' : '0');
        });
        
        $('input[name=birthDate]').keypress(function(e){
            var t = $(this);
            if (t.val().length >= 10 && e.which != 8)
                return false;
            if(e.which != 13 && e.which != 8){
                if(t.val().length == 2 || t.val().length == 5){
                    t.val(t.val()+"/");
                }
            }
        });
        n=0;
        $('input[name=iban]').keypress(function(e){
            t = $(this);
            if(e.which != 13 && e.which != 8){
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
                            $this.slide('next');
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
                                            $this.slide('prev');
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
    },
    swipe : function (event, direction, distance, duration, fingerCount) {
        if (direction === 'right') {
            this.slide('prev');
        } else if (direction === 'left') {
            this.slide('next');
        }
    },
    slide : function (direction) {
        var $this = $('.slide.active');
        var margin = parseInt($this.parents('.container').css('margin-left'),10);
        var slideLength = ($(window).width() + margin);
        if ($this.next().length > 0 && direction == 'next') {
            $this.transition({x: '-='+slideLength}).removeClass('active');
            $this.next().transition({x: '-='+slideLength}).addClass('active');
        } else {
            $this.transition({x: '+='+slideLength}).removeClass('active');
            $this.prev().transition({x: '+='+slideLength}).addClass('active');
        }
        $('#signin-step > a.active').toggleClass('active');
        $('#signin-step > a').eq($('.slide').index($('.slide.active'))).toggleClass('active');
    }
});