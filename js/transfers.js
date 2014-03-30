$(function(){

	saveTransactions = function(form){
		url = form.attr('action')
		if(form.find('.clicked-button').hasClass('button-next')){
			url = url + '&next=1'
		}
		$.ajax({
			url: url,
			success: function(data) {
				var response= jQuery.parseJSON (data);
				if(response.success){
					if(response.clean){
						$(form)[0].reset()
						$('#transfer_accordion').accordion({ collapsible: true , active: false})
					} else {
						window.location.href = response.url
					}
				} else {

				}
			},
			cache:false,
			async: false,
			data: form.serialize(),
			type: 'POST'
		});
	}
	
	deleteTransaction = function(link, message){
		if (confirm(message)) {
			url = $(link).attr('href')
			$.ajax({
				url: url,
				success: function(data) {
					var response= jQuery.parseJSON (data);
					if(response.success){
						$(link).parents('tr').slideUp().remove()
					} else {

					}
				},
				cache:false,
				async: true,
				data: {},
				type: 'POST'
			});
		}
		return false;
	}
	
	verifyTransfer = function(link){
		var lname = $(link).attr('name')
		$.ajax({
			url: window.location.href,
			success: function(data) {
				var response= jQuery.parseJSON (data);
				if(response.success){
					if(response.html)
					$('.table-xabina-overview-re').html(response.html)
				} else {
					location.reload()
				}
			},
			cache:false,
			async: true,
			data: {transfer: lname},
			type: 'POST'
		});
	}
	
	checkAll = function(link){
		url = $(link).attr('href')
		$.ajax({
			url: url+'/all',
			success: function(data) {
				var response= jQuery.parseJSON (data);
				if(response.success){
					return true;
				} else {
					location.reload()
				}
			},
			cache:false,
			async: false,
			data: {},
			type: 'POST'
		});
	}
	
	confirmSms = function(form){
		$.ajax({
			url: form.action,
			success: function(data) {
				var response= jQuery.parseJSON (data);
				if(response.success){
					window.location.href=response.url
				} else {
					$('.error-message').html(response.message).slideDown()
				}
			},
			cache:false,
			async: false,
			data: form.serialize(),
			type: 'POST'
		});
	}
	
});

$(document).ready(function(){
	$('.main-container').on('click', '.overview-check', function(){
		verifyTransfer(this)
	})
	
	$('#transfer_accordion').accordion({
		heightStyle: "content",
		active: false,
		collapsible: true,
		activate: function(event, ui){
			$(event.target).find('input').attr('disabled','disabled')
			$(event.target).find('textarea').attr('disabled','disabled')
			$(event.target).find('select').attr('disabled','disabled')
			$(event.target).find('.ui-accordion-content-active input').removeAttr('disabled')
			$(event.target).find('.ui-accordion-content-active textarea').removeAttr('disabled')
			$(event.target).find('.ui-accordion-content-active select').removeAttr('disabled')
			$(event.target).find('.recurrence-form input').attr('disabled','disabled')
			$(event.target).find('.recurrence-form select').attr('disabled','disabled')
			if($(event.target).find('.ui-accordion-content-active .recurrence-form .active').hasClass('one-time')){
				$(event.target).find('.ui-accordion-content-active .one_time_form input').removeAttr('disabled')
				$(event.target).find('.ui-accordion-content-active .one_time_form select').removeAttr('disabled')
			} else {
				$(event.target).find('.ui-accordion-content-active .standing-form input').removeAttr('disabled')
				$(event.target).find('.ui-accordion-content-active .standing-form select').removeAttr('disabled')
			}
			
		}
	});
	
})