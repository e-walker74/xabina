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
})