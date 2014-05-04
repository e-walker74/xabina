	$(".form-file-widget").each(function(){
		var form = this;
		$(form).find('.file-name').hide()
		$(form).find('.file-input').change(function(){
			var value = $(this).val()
			$(this).parent().find('.file-name').show().html(value.split('/').pop().split('\\').pop())
			$(this).parent().find('.no-file-name').hide()
		})

		form.addEventListener('submit', function(ev) {
            		
            backgroundBlack()
		
            var obj = $(ev.srcElement);
            var formId = $(obj).attr('id');
            var attachmentsBlockId = formId + "-attachments-block";
            var fileId = formId + "-file-input";
            
			var
                oOutput = document.getElementById(attachmentsBlockId),
                oData = new FormData(document.getElementById(formId));

			oData.append('file', document.getElementById(fileId).files[0]);

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
							scrollTop: $('#'+attachmentsBlockId).offset().top-50
						}, 500);
						successNotify('File Upload', 'File was successfully uploaded')
					}
					$(form).find('.success-popup-cont').fadeIn().delay(2000).fadeOut();
					$(form).find('.success-popup span').html(data.message);
					$(form)[0].reset()
					$(form).find('textarea').val('').trigger('autosize.resize')
					$(form).find('.file-name').hide()
					$(form).find('.no-file-name').show()
					$('#'+attachmentsBlockId+' .delete').confirmation({
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
	});

	$('.form-file-widget input[type=submit]').click(function(){
		var ret = false;
		var _form = $(this).parent('form');

		$.ajax({
			type: "POST",
			url: $(_form).attr('action'),
			success: function(data){
				if(data.description){
					$(_form).find('.comment .error-message').html(data.description[0]).slideDown().delay( 3000 ).slideUp()
					ret = false;
				} else {
					$(_form).find('.comment .error-message').slideUp()
					ret = true;
				}
			},
			data: $(_form).serialize()+'&ajax=1',
			dataType: 'json',
			async: false
			
		});
		
		if( $(_form).find("input[type='file']").val() == ""){
			ret = false;
			$(_form).find('.file .error-message').html('File not selected').slideDown().delay( 3000 ).slideUp()
		}
		
		return ret;
	})

	

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

	$('.attachments-block').on('click', '.edit-doc .ok', function(){
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
	});    
    
    $('.attachments-block .delete').confirmation({
		title: 'Are you sure?',
		singleton: true,
		popout: true,
		onConfirm: function(){
			link = $(this).parents('.popover').prev('a')
			deletefile(link);
			return false;
		}
	});
