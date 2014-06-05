$(document).ready(function() {
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

    $( ".xabina-tabs.main" ).tabs({ active: false, collapsible: true });
	
	$(".frequency-tab .xabina-tabs").tabs()

    $('.details-accordion').accordion({
        heightStyle: "content",
        active: 0,
        collapsible: false
    });
	
	$('.selectpicker').selectpicker();
	
	$('.favorite-check').on('click', function() {
        $(this).parent().toggleClass('active')
    })
})

var quick_edit = function(button) {
	resetPage()
	
	var amount = nospaces($(button).parents('.quick-row').find('.amount').html())
	var cent = amount.split('.')[1]
	
	$(button).parents('.quick-row').next('.row-edit').find('#Form_Incoming_Quick_amount').val(Math.floor(amount))
	$(button).parents('.quick-row').next('.row-edit').find('#Form_Incoming_Quick_amount_cent').val(cent)
	$(button).parents('.quick-row').hide().next('.row-edit').show()
	$(button).parents('li').hide().next('.row-edit').show()
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