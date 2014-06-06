$(document).ready(function(){
	$(".xabina-tabs" ).tabs({

	});
	
	$('#analytics-form').on('change', 'input, select', function(){
		searchAnalytics($('#analytics-form'))
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
		searchAnalytics(form)
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