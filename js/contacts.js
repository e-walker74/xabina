$(document).ready(function(){
	$( ".xabina-tabs , .edit-tabs" ).tabs({

    });
	
	$('#analytics-form').on('change', 'input, select', function(){
		searchAnalytics($('#analytics-form'))
	})
	
	$('.edit-contact-cont').on('click', '.button.edit, .upload.add-more', function(){
		resetPage()
		
		$(this).parents('tr').hide().next('.edit-row').show()
		return false;
	})

})

var searchAnalytics = function(form){
	$.ajax({
		url: $(form).attr('action'),
		success: function(response) {
			if(response.success){
				$('.analytics-results').html(response.html)
			}
		},
		cache:false,
		async: false,
		data: form.serialize(),
		type: 'POST',
		dataType: 'json'
	});
}

var updateContact = function(form){
	$.ajax({
		url: $(form).attr('action'),
		success: function(response) {
			if(response.success){
				resetPage()
				if(response.html){
					$(form).parents('.tab').html(response.html)
					$('.select-invisible').each(onCustomSelectChange);
					function onCustomSelectChange(){
						$(this).prev('span').text($(this).find(':selected').text());
					}
				}
			}
		},
		cache:false,
		async: false,
		data: form.serialize(),
		type: 'POST',
		dataType: 'json'
	});
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
		if($('.analytics-results').length !== 0){
			searchAnalytics(form)
		} else {
			updateContact(form)
			return false;
		}
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
		$(form).find("."+i).html(data.notify[i]).slideDown().delay(3000).slideUp();
	}
}