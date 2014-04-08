$(function(){

	next = function(button){
		$("#steps").animate({opacity: 0.5}, 500);
		var form = jQuery(button).parents('form')
		$.ajax({
			url: form.attr('action'),
			success: function(data) {
				$("#steps").animate({opacity: 1}, 500);
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
			},
			cache:false,
			data: form.serialize(),
			type: 'POST'
		});
	}
	
});