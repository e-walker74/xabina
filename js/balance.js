$(function(){

	updateTransactionsTable = function(select){
		var accNumber = $(select).val()
		$("#Form_Search_account_number").val(accNumber);
        $('#searchForm_account_number').val(accNumber);
		backgroundBlack();
		$('#search_accordion').accordion({ collapsible: true , active: false})
		$.ajax({
			url: window.location.pathname,
			success: function(data) {
				var response= jQuery.parseJSON (data);
				if(response.success){
					$('.transaction-table-overflow').html(response.html);
				}
			},
            complete : dellBackgroundBlack,
			cache:false,
			data: $('#searchForm').serialize(),
			type: 'GET'
		});

	}
	
	$(document).on('click', '.transaction-table-overflow tr', function(){
		var url = $(this).attr('data-transaction-info-url')
		if(url){
			window.location.href = url
		}
	})
	
});

$(document).ready(function(){
	$('.refresh-button').fadeOut()
	$('.account-selection .account-select select').change(function(){
		updateTransactionsTable(this)
	})
	
	$('#search_accordion').accordion({
        heightStyle: "content",
        active: false,
        collapsible: true
    });
})