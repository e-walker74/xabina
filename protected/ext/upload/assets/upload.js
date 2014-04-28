	var form = document.forms.namedItem("upload");
	
	$(form).find('.file-name').hide()
	
	$(form).find('.file-input').change(function(){
		var value = $(this).val()
		$(this).parent().find('.file-name').show().html(value.split('/').pop().split('\\').pop())
		$(this).parent().find('.no-file-name').hide()
	})

	
	form.addEventListener('submit', function(ev) {
		var
		oOutput = document.getElementById("attachments-block"),
		oData = new FormData(document.forms.namedItem("upload"));

		oData.append('file', document.getElementById('uFile').files[0]);

		$(form).find('.success-popup-cont span').html('Uploading...')
		$(form).find('.success-popup-cont').fadeIn()

		var oReq = new XMLHttpRequest();
		oReq.open("POST", ev.currentTarget.action, true);
		oReq.onload = function(oEvent) {
			if (oReq.status == 200) {
				var data = jQuery.parseJSON(oEvent.currentTarget.response)
				if(data.success){
					oOutput.innerHTML = data.html
					$('html, body').animate({
						scrollTop: $("#attachments-block").offset().top-50
					}, 500);
				}
				$(form).find('.success-popup-cont').fadeIn().delay(2000).fadeOut();
				$(form).find('.success-popup span').html(data.message);
				$(form)[0].reset()
				$(form).find('.file-name').hide()
				$(form).find('.no-file-name').show()
			} else {
				$(form).find('.success-popup span').html('error');
			}
		};

		oReq.send(oData);
		ev.preventDefault();
	}, false);
	
	$('#attachments-block').on('click', '.attach-actions .delete', function(){
		var link = $(this)
		
		if(!confirm(link.attr('data-confirm-text'))){
			return false;
		}
		
		$.ajax({
			type: "POST",
			url: link.attr('href'),
			success: function(data){
				if(data.success){
					link.parents('li').remove()
				}
			},
			dataType: 'json'
		});
		return false;
	})
	
	var editRow = function(row){
		row.find('.not-edit-doc').hide()
		row.find('.edit-doc').show()
	}
	
	$('#attachments-block').on('click', '.edit-doc .ok', function(){
		var link = $(this)
		var row = link.parents('li')
		$.ajax({
			type: "POST",
			url: link.attr('href'),
			data: {comment: row.find('textarea').val()},
			success: function(data){
				row.find('.not-edit-doc').show()
				row.find('.edit-doc').hide()
				row.find('.attach-comment .not-edit-doc').html(row.find('textarea').val())
			},
			dataType: 'json'
		});
		return false;
	})
