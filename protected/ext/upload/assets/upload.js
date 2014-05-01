	var form = document.forms.namedItem("upload");

	$(form).find('.file-name').hide()

	$(form).find('.file-input').change(function(){
		var value = $(this).val()
		$(this).parent().find('.file-name').show().html(value.split('/').pop().split('\\').pop())
		$(this).parent().find('.no-file-name').hide()
	})
	
	$('#file-form input[type=submit]').click(function(){
		var ret = false;
		
		$.ajax({
			type: "POST",
			url: $('#file-form').attr('action'),
			success: function(data){
				if(data.description){
					$('#file-form').find('.comment .error-message').html(data.description[0]).slideDown().delay( 3000 ).slideUp()
					ret = false;
				} else {
					$('#file-form').find('.comment .error-message').slideUp()
					ret = true;
				}
			},
			data: $('#file-form').serialize()+'&ajax=1',
			dataType: 'json',
			async: false
			
		});
		
		if(!document.getElementById('uFile').files[0]){
			ret = false;
			$('#file-form').find('.file .error-message').html('File not selected').slideDown().delay( 3000 ).slideUp()
		}
		
		return ret;
	})

	form.addEventListener('submit', function(ev) {
	
		backgroundBlack()
	
		var
		oOutput = document.getElementById("attachments-block"),
		oData = new FormData(document.forms.namedItem("upload"));

		oData.append('file', document.getElementById('uFile').files[0]);

		$(form).find('.success-popup-cont span').html('Uploading...')
		$(form).find('.success-popup-cont').fadeIn()

		var oReq = new XMLHttpRequest();
		oReq.open("POST", ev.currentTarget.action, true);
		oReq.onload = function(oEvent) {
			dellBackgroundBlack()
			if (oReq.status == 200) {
				var data = jQuery.parseJSON(oEvent.currentTarget.response)
				if(data.success){
					oOutput.innerHTML = data.html
					$('html, body').animate({
						scrollTop: $("#attachments-block").offset().top-50
					}, 500);
					successNotify('File Upload', 'File was successfully uploaded')
				}
				$(form).find('.success-popup-cont').fadeIn().delay(2000).fadeOut();
				$(form).find('.success-popup span').html(data.message);
				$(form)[0].reset()
				$(form).find('textarea').val('').trigger('autosize.resize')
				$(form).find('.file-name').hide()
				$(form).find('.no-file-name').show()
				$('#attachments-block .delete').confirmation({
					title: 'Are you sure?',
					singleton: true,
					popout: true,
					onConfirm: function(){
						link = $(this).parents('.popover').prev('a')
						deletefile(link);
						return false;
					}
				})
			} else {
				$(form).find('.success-popup span').html('error');
			}
		};

		oReq.send(oData);
		ev.preventDefault();
	}, false);

	var deletefile = function(link){
		
		$.ajax({
			type: "POST",
			url: $(link).attr('data-url'),
			success: function(data){
				if(data.success){
					$(link).parents('li').remove()
					successNotify('Delete File', 'File was successfully deleted')
				}
			},
			dataType: 'json'
		});
		return false;
	}

	
	
	var editRow = function(row){
		resetPage()
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
				if(data.success){
					row.find('.not-edit-doc').show()
					row.find('.attach-comment .not-edit-doc').html(data.comment).show()
					row.find('.edit-doc').hide()
					row.find('.attach-comment textarea').next('.error-message').html('').slideUp()
					successNotify('Comment File', 'Comment to file was successfully updated')
				} else {
					row.find('.attach-comment textarea').next('.error-message').html(data.message).slideDown('slow')
				}
			},
			dataType: 'json'
		});
		return false;
	})
