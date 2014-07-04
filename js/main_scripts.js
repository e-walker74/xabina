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


    $("input").on('focus', function(){
        $(this).attr('current_value', $(this).val());
        if ($(this).hasClass('input-error')) {
            $(this).addClass('maybe-error');
            $(this).removeClass('input-error').parent().removeClass('input-error').find('.validation-icon').hide().parent().parent().find('.errorMessage').hide();
        }
    });
    $("input").on('blur', function(){

        if ($(this).val() == $(this).attr('current_value') && $(this).hasClass('maybe-error')) {
            $(this).addClass('input-error').parent().addClass('input-error').find('.validation-icon').show().parent().parent().find('.errorMessage').show();
        }
        $(this).removeClass('maybe-error');
    });

    $("input[phonefield=true]").on('focus', function(){
        if(!$(this).val()){
            $(this).val('+');
        }
    });
    $("input[phonefield=true]").on('blur', function(){
        if($(this).val()){
            $(this).val($(this).val().replace(/\s/g, ''));
        }
    });

    $("input[phonefield=true]").on('input', function(){
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

    $('.login-tabs').tabs({
        active: 1,
        activate: function( event, ui ) {
            $('#Form_Registration_role').val(ui.newTab.attr('data-item'));
        }
    });

    //$('.select-invisible').on('change', onCustomSelectChange);

    $('.checkbox-custom').on('click', 'label', function(e){
        if($(this).find('input[type=checkbox]').prop('checked')){
            $(this).addClass('checked');
            e.stopPropagation();
        }else{
            $(this).removeClass('checked');
            e.stopPropagation();
        }
    });

    $('.select-type-dropdown').on('click', '.dropdown-menu li', function(e){

        $(e.delegateTarget).find('input[type=hidden]').val($(this).data('id'));
        $(e.delegateTarget).find('.select-type').text($(this).text());
    })
});
