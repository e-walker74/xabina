$(document).ready(function(){
	if($('textarea.len1').length != 0)
	$('textarea.len1').limiter('140',$('.len1-num'));
	if($('textarea.len2').length != 0)
	$('textarea.len2').limiter('140',$('.len2-num'));
	if($('textarea.len3').length != 0)
	$('textarea.len3').limiter('140',$('.len3-num'));

	$('.main-container').on('click', '.overview-check', function(){
		verifyTransfer(this)
	})

    $('.xabina-accordion').accordion({
        heightStyle: "content",
        active: false,
        collapsible: true
    });

    $('.details-accordion').accordion({
        heightStyle: "content",
        active: false,
        collapsible: true
    });

    $( ".xabina-tabs" ).tabs({

    });

    $('.favorite-check').on('click', function(){
        $(this).parent().toggleClass('active')
    })

    $('.disabled').hide();
    $('.disabled input').attr('disabled','disabled');

    $('#Form_Outgoingtransf_Ewallet_ewallet_type').change(function(){
        changeEWalletType(this)
    })

})

var changeEWalletType = function(select){
    $('.disabled').hide();
    $('.disabled input').attr('disabled',true);

    var activeBlock = $(select).parents('.from-form').find('.e-wallet-type-'+$(select).val())
    activeBlock.find('input').attr('disabled',false)
    activeBlock.show();
}

var submitTransaction = function(form){
    url = form.attr('action')
    if(form.find('.clicked-button').hasClass('button-right')){
        url = url + '&next=1'
    }

    $.ajax({
        url: url,
        success: function(response) {
            if(response.success){
                successNotify('Payment', response.message, $('.clicked-button'))
                resetPage()
                if(response.clean){
                    //$('#transfer_accordion').accordion({ collapsible: true , active: false})
                } else if(response.url) {
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

var change_click_button = function(input){
    $('.clicked-button').removeClass('clicked-button')
    $(input).addClass('clicked-button');
}

