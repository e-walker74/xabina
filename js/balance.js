$(function(){

	updateTransactionsTable = function(refresh_button){
		var accNumber = $('.refresh-button').parent().find('select').val()
		$.ajax({
			url: window.location.pathname,
			success: function(data) {
				var response= jQuery.parseJSON (data);
				if(response.success){
					$('.transaction-table-overflow').html(response.html);
				}
			},
			cache:false,
			data: {account: accNumber},
			type: 'GET'
		});
	}
	
	$(document).on('click', '.transaction-table-overflow tr', function(){
		var url = $(this).attr('data-transaction-info-url')
		window.location.href = url
	})
	
});