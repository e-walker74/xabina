$(function(){

    $(window).on('resize', onResizeWindow);
    $(window).resize();
    $(window).scroll();

    function onResizeWindow(){
        
        if($(window).width() > 480){
            $('body').removeClass('mobile-view').addClass('desktop-view');
            initSlideshow();
        }
        if($(window).width() <= 480) {
            $('body').removeClass('desktop-view').addClass('mobile-view');
            $.vegas('destroy', 'slideshow');
        }
    }

    $(window).scroll(function(){
        if( $(window).scrollTop() > $('.logo').height() ){
            $('.logo').addClass('logo-fixed');
        }else{
            $('.logo').removeClass('logo-fixed');
        }
        if( $('.content').lenght && $(window).scrollTop() > $('.content').offset().top ){
            $('.menu-left').addClass('menu-fixed');
        }else{
            $('.menu-left').removeClass('menu-fixed');
        }
    });


    $("#Form_Registration_phone").on('focus', function(){
        if(!$(this).val()){
            $(this).val('+');
        }
    });
    $("#Form_Registration_phone").on('input', function(){
        if( !~($(this).val().indexOf('+')) ){
            $(this).val( '+' + $(this).val() );
        }
    });
	
	$("#Form_Smslogin_phone").on('focus', function(){
        if(!$(this).val()){
            $(this).val('+'); 
        }
    });
    $("#Form_Smslogin_phone").on('input', function(){
        if( !~($(this).val().indexOf('+')) ){
            $(this).val( '+' + $(this).val() );
        }
    });
	
	resendLoginEmail = function(message, url){
		$.ajax({
 			url: url,
 			success: function(response) {
 				if(response.success){
 					alert(message)
 				}
 			},
 			cache:false,
			dataType: 'json',
 			data: {success: true},
 			type: 'GET'
 		});
	}

    //live validation plugin initialization
    /*$('#popup-register-form').liveValidation({
       validIco   : 'img/form_check.png',
       invalidIco : 'img/form_check.png',
       required   : ['firstName', 'lastName', 'email', 'phone'],
       fields     :  {
           firstName:{match: /^[a-zA-Z\-]{1,}$/, message: 'error!'},
           lastName:{match:/^[a-zA-Z\-]{1,}$/, message: 'error!'},
           email:{match:/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/, message: 'error!'},
           phone:{match:/^\+\d+$/, message: 'error!'}
       },
       validClass:		'valid',
       invalidClass:	'input-error'
    });
	
	$('#popup-auth-form').liveValidation({
       validIco   : 'img/form_check.png',
       invalidIco : 'img/form_check.png',
       required   : ['Form_Login[login]', 'Form_Login[password]'],
       fields     :  {
           'Form_Login[login]':{match: /^[a-zA-Z\-]{1,}$/, message: 'error!'},
           'Form_Login[password]':{match:/^[a-zA-Z\-]{1,}$/, message: 'error!'},
       },
       validClass:		'valid',
       invalidClass:	'input-error'
    });*/

    //jquery ui tooltip initialization
    $('.tooltip-icon').tooltip({
        tooltipClass: 'xabina-tooltip',
        position:{
            my: "left+25 top-12",
            at: "right top",
            using: function( position, feedback ) {
                $( this ).css( position );
                $( "<div>" )
                    .addClass( "tooltip-arrow" )
                    .addClass( feedback.vertical )
                    .addClass( feedback.horizontal )
                    .appendTo( this );
            }
        }
    });




    $('#popup-register-form ').on('focus', 'input[type=text]', onRegisterFieldFocus);
    $('#popup-register-form ').on('blur', 'input[type=text]', onRegisterFieldBlur);

    function onRegisterFieldFocus(){
        var tooltipText = $(this).parents('.form-block').find('.tooltip-icon').attr('title');
        if(tooltipText){
            var mobileTooltip = $('<div class=" mobile-tooltip" style="display: none"></div>').html(tooltipText);
            $(this).parents('.form-input').before(mobileTooltip);
            $(this).parents('.form-block').find('.mobile-tooltip').slideDown();
        }

    }
    function onRegisterFieldBlur(){
       $(this).parents('.form-block').find('.mobile-tooltip').slideUp(function(){
           $(this).remove();
       })
    }



    //background slideshow initialization
    function initSlideshow(){

        var vegasBackgrounds = shuffle([
            { src: '/images/slides/slide1.jpg', fade: 2000 },
            { src: '/images/slides/slide2.jpg', fade: 2000 },
            { src: '/images/slides/slide3.jpg', fade: 2000 },
            { src: '/images/slides/slide4.jpg', fade: 2000 },
            { src: '/images/slides/slide5.jpg', fade: 2000 }
        ]);

        $.vegas('slideshow', {
            loading: false,
            backgrounds: vegasBackgrounds
        });
    }


    //custom select for mobile

    $('.language-select').on('change', onCustomSelectChange);

    function onCustomSelectChange(){
        $(this).prev('span').text($(this).find(':selected').text());
    }

    $('.section-select').on('change', function(){
        $(this).prev('span').text($(this).find(':selected').text());
        $('html,body').animate({scrollTop: $($(this).find(':selected').val()).offset().top}, 500);
    });

    //scroll into view
    $('.menu-left').on('click', 'a', function(e){
        e.preventDefault();
        $('html,body').animate({scrollTop: $($(this).attr('href')).offset().top}, 500);
    });
	
	/*delay = (function(){
	  var timer = 0;
	  return function(callback, ms){
		clearTimeout (timer);
		timer = setTimeout(callback, ms);
	  };
	})();
	
	$('input').keyup(function() {
		delay(function(){
		  validateFormFields()
		}, 2000 );
	});
	
	validateFormFields = function(){
		var form = jQuery('form')
		$.ajax({
			url: form.attr('action'),
			success: function(data) {
				var response= jQuery.parseJSON (data);
				if(response.length==0){
					form.find("input").parent().addClass("valid")
					form.find("input").next(".validation-icon").fadeIn();
					form.find("input").removeClass('input-error')
					form.find(".errorMessage").hide()
				}
				$.each(response, function(key, value) {
					if($("#"+form.attr("id")+" #"+key).val()){
						$("#"+form.attr("id")+" #"+key).removeClass("valid");
						$("#"+form.attr("id")+" #"+key).parent().removeClass("valid");
						$("#"+form.attr("id")+" #"+key).addClass("input-error");
						$("#"+form.attr("id")+" #"+key).parent().addClass("input-error");
						$("#"+form.attr("id")+" #"+key).next(".validation-icon").fadeIn();
						$("#"+form.attr("id")+" #"+key+"_em_").slideDown();
						$("#"+form.attr("id")+" #"+key+"_em_").html(''+value);                            
					}
				});
			},
			cache:false,
			async: false,
			data: form.serialize() + '&ajax' + '=' + form.attr('id'),
			type: 'POST'
		});
	}*/

});
