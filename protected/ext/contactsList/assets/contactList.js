var alphabetEach = function(){
	$('.alphabet li').removeClass('active')
	$('.alphabet li').removeClass('inactive')
	$('.alphabet li a').each(function(){
		if($('.letter_'+$(this).html()).length == 0){
			$(this).parent().addClass('inactive')
		}
	})
}

alphabetEach()

$('.alphabet li a').click(function(){
	if($('.letter_'+$(this).html()).length != 0){
		$('.alphabet li').removeClass('active')
		$(this).parent().addClass('active')
		$('.letter-block').hide()
		$('.letter_'+$(this).html()).parents('.letter-block').show();
	}
	return false;
})



jQuery.fn.clientListSearch = function(options){
	
	var el_input = $(this)
	
	var pressTimeout = false;
    
	$(this).on('keyup', function(e){
		if (pressTimeout) clearTimeout(pressTimeout);
		var code = e.which;
		if(code == 13){
			getContactList()
		} else {
			pressTimeout = setTimeout(getContactList, 1000);
		}
	})
	
	var getContactList = function(){
		if(!options.url){
			return false;
		}
		backgroundBlack()
		$.ajax({
			url: options.url,
			success: function(response) {
				if(response.success){
					$("#contactsList").html(response.html);
					alphabetEach()
				}
			},
			cache:false,
			data: {qname: el_input.val()},
			dataType: 'json',
			complete : dellBackgroundBlack,
			type: 'GET'
		});
	}
};