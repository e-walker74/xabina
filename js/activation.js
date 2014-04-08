$(function(){

	back = function(url){
		$.ajax({
			url: url,
			success: function(data) {
					var response= jQuery.parseJSON (data);
					if(response.success){
						$("#steps").html(response.html)
					} else {
						
					}
				},
			type: 'GET'
		})
	}
	
	next = function(url, button){
		$("#steps").animate({opacity: 0.5}, 500);
		var form = jQuery(button).parents('form')
		$.ajax({
			url: url,
			success: function(data) {
				var response= jQuery.parseJSON (data);
				if(response.success){
					form.find("input").parent().addClass("valid")
					form.find("input").next(".validation-icon").fadeIn();
					$("#steps").html(response.html)
				} else {
					form.find("input").parent().addClass("valid")
					form.find("input").next(".validation-icon").fadeIn();
					$.each(response, function(key, value) {
						$("#"+key).removeClass("valid");
						$("#"+key).parent().removeClass("valid");
						$("#"+key).addClass("input-error");
						$("#"+key).parent().addClass("input-error");
						$("#"+key).next(".validation-icon").fadeIn();
						$("#"+key+"_em_").slideDown();
						$("#"+key+"_em_").html(''+value);                            
					});
				}
				$("#steps").animate({opacity: 1}, 500);
			},
			cache:false,
			data: form.serialize(),
			type: 'POST'
		});
	}
	
	last = function(url, button){
		var forms = jQuery(document).find('form')
		$.each(forms, function(key, value) {
			if(!$(value).hasClass("success")){
				$(value).find(".violet-button-slim").click()
			}
		})
		var success = true;
		$.each(forms, function(key, value) {
			if(!$(value).hasClass("success")){
				success = false
			}
		})
		if(success){
			$.ajax({
				url: url,
				success: function(data) {
					var response= jQuery.parseJSON (data);
					if(response.success){
						$(document).find("input").parent().addClass("valid")
						$(document).find("input").next(".validation-icon").fadeIn();
						$("#steps").html(response.html)
					} else {
						
					}
				},
				cache:false,
				data: {success: true},
				type: 'POST'
			});
		}
	}
});