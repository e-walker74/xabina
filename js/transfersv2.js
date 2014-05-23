$(document).ready(function(){
	if($('textarea.len1').length != 0)
	$('textarea.len1').limiter('140',$('.len1-num'));
	if($('textarea.len2').length != 0)
	$('textarea.len2').limiter('140',$('.len2-num'));
	if($('textarea.len3').length != 0)
	$('textarea.len3').limiter('140',$('.len3-num'));

	/*$('.main-container').on('click', '.overview-check', function(){
		verifyTransfer(this)
	})*/

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

    $('.details-accordion').accordion({
        heightStyle: "content",
        active: 0,
        collapsible: false
    });

    $( ".xabina-tabs.main" ).tabs({ active: false, collapsible: true });
	
	$(".frequency-tab .xabina-tabs").tabs()

    $('.favorite-check').on('click', function(){
        $(this).parent().toggleClass('active')
    })

    $('.disabled').hide();
    $('.disabled input').attr('disabled','disabled');

    $('#Form_Outgoingtransf_Ewallet_ewallet_type').change(function(){
        changeEWalletType(this)
    })

    $('#Form_Outgoingtransf_External_bic').change(function(){
        $.ajax({
            url: $('#Form_Outgoingtransf_External_bic').attr('data-url'),
            success: function(response) {
                if(response.success){
                    $('#Form_Outgoingtransf_External_bank_name').val(response.name)
                } else {
                    $('#Form_Outgoingtransf_External_bank_name').val('')
                }
            },
            cache:false,
            async: false,
            data: {bic: $('#Form_Outgoingtransf_External_bic').val()},
            type: 'POST',
            dataType: 'json'
        });
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
                if(!form.find('.clicked-button').hasClass('button-right')){
                    if($('.clicked-button').length != 0){
                        successNotify('Payment', response.message, $('.clicked-button'))
                    } else {
                        successNotify('Payment', response.message)
                    }
                }
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

var change_click_button = function(input){
    $('.clicked-button').removeClass('clicked-button')
    $(input).addClass('clicked-button');
}

$(document).ready(function(){
    $('.table-overview .table-header .overview-check').change(function(){
        if($('.table-overview .table-header .overview-check:checked').length != 0){
            checkAll(this)
        } else {
            $('input[type=checkbox]').attr('checked', false)
            verifyTransfer(this)
        }
    })

    $('.overview-tr input[type=checkbox]').change(function(){
        if($('.overview-tr input[type=checkbox]').length != $('.overview-tr input[type=checkbox]:checked').length){
            $('.table-overview .table-header .overview-check').attr('checked', false)
        } else {
            $('.table-overview .table-header .overview-check').attr('checked', true)
        }
        verifyTransfer(this)
    })
})

checkAll = function(el){
    $('input[type=checkbox]').attr('checked', 'checked')
    return verifyTransfer(el)
}

verifyTransfer = function(el){
    var form = $('#overview-form')
    var result = false
    $.ajax({
        url: form.attr('action'),
        success: function(data) {
            var response= jQuery.parseJSON (data);
            if(response.success){
                if(response.html)
                    $('.overview-payment-sum').html(response.html)
                if(response.error){
                    errorNotify('error', response.message, el)
                }
                else{
                    result = true
                }
            } else {
                location.reload()
            }
        },
        cache:false,
        async: false,
        data: form.serialize(),
        type: 'POST'
    });
    return result;
}

edit_quick_transfer = function(el){
    resetPage()
	var text = $(el).parents('.quick-row').find('.comm-txt').html()
	var amount = $(el).parents('.quick-row').find('.amount').html()
	
	$(el).parents('.quick-row').next('.quick-row-edit').find('#Transfers_Outgoing_Favorite_amount').val(amount)
    $(el).parents('.quick-row').next('.quick-row-edit').find('#Transfers_Outgoing_Favorite_description').val(text)
	$(el).parents('.quick-row').hide().next('.quick-row-edit').show()
}

afterValidate = function(form, data, hasError) {
	form.find("input").removeClass("input-error");
	form.find("input").parent().removeClass("input-error");
	form.find(".validation-icon").fadeIn();
	for(var i in data.notify) {
		$(form).find("."+i).html(data.notify[i]).slideDown().delay(3000).slideUp();
	}
	if(hasError) {
		for(var i in data) {
			$("#"+i).addClass("input-error");
			$("#"+i).parent().addClass("input-error");
			$("#"+i).next(".validation-icon").fadeIn();
		}
		return false;
	}
	else {
		submitTransaction(form)
	}
	return false;
}

afterValidateAttribute = function(form, attribute, data, hasError) {
	if(hasError){
		if(!$("#"+attribute.id).hasClass("input-error")){
			$("#"+attribute.id+"_em_").hide().slideDown();
		}
		$("#"+attribute.id).removeClass("valid").parent().removeClass("valid");
		$("#"+attribute.id).addClass("input-error").parent().addClass("input-error");
		$("#"+attribute.id).next(".validation-icon").fadeIn();
	} else {
		if($("#"+attribute.id).hasClass("input-error")){
			$("#"+attribute.id+"_em_").show().slideUp();
		}
		$("#"+attribute.id).removeClass("input-error").parent().next("error-message").slideUp().removeClass("input-error");
		$("#"+attribute.id).next(".validation-icon").fadeIn();
		$("#"+attribute.id).addClass("valid");
	}
	for(var i in data.notify) {
		$(form).find("."+i).html(data.notify[i]).slideDown().delay(1500).slideUp();
	}
}