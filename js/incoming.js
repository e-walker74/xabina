$(document).ready(function(){
    $('.xabina-accordion').accordion({
        heightStyle: "content",
        active: false,
        collapsible: true,
        activate: function( event, ui ) {
            var offset = $('.ui-accordion-header-active').offset();
            if(offset) {
                $('html,body').animate({
                    scrollTop: $('.ui-accordion-header-active a').offset().top -40
                }, 250);
            }
        }
    });

    $( ".xabina-tabs" ).tabs();

    $('.details-accordion').accordion({
        heightStyle: "content",
        active: 0,
        collapsible: false
    });
	
	$('.selectpicker').selectpicker();
	
	$('#Form_Incoming_Electronic_electronic_method').change(function(){
		$('.electronic-method-fields').hide();
		$('.electronic-method-fields.method-'+$(this).val()).slideDown();
	})
	
	$('#Form_Incoming_Electronic_creditcard_number').validateCreditCard(function(result)
	{
		$('.payments-list .logo').removeClass('active')
		$('.payments-list input[type=radion]').attr('checked', false)
		if(result.card_type){
			$('.payments-list .logo.'+result.card_type.css_class).addClass('active')
			$('.payments-list input.'+result.card_type.css_class).attr('checked', true)
		}
	}, {
		accept: ['visa', 'mastercard', 'amex', 'maestro', 'jcb', 'discover', 'union']
	});
	
	$('.favorite-check').on('click', function(){
        $(this).parent().toggleClass('active')
    })
})

var submitTransaction = function(form){
    url = form.attr('action')
    if(form.find('.clicked-button').hasClass('button-right')){
        url = url + '&next=1'
    }

    $.ajax({
        url: url,
        success: function(response) {
            if(response.success){
                if(response.url) {
                    window.location.href = response.url
                }
            } else {

            }
        },
        cache:false,
        async: false,
        data: form.serialize(),
        type: 'POST',
        dataType: 'json'
    });

}

var send_quick_transfer = function(quick_id){
    $.ajax({
        success: function(response) {
            if(response.success){
                if(response.url)
                    window.location.href = response.url
            } else {

            }
        },
        cache:false,
        async: false,
        data: {quick: quick_id},
        type: 'POST',
        dataType: 'json'
    });
}