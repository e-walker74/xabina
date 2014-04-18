$(document).ready(function(){
	$('.xabina-messages-table tr').click(function(e){
		if(e.srcElement.className != 'remove-button'){
			window.location.href= $(this).find('.message-header a').attr('href')
		}
	})
})