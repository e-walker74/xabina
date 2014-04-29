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

	var deletefile = function(link){
		
		$.ajax({
			type: "POST",
			url: link.attr('href'),
			success: function(data){
				if(data.success){
					$('.to-remove').parents('li').remove()
				}
			},
			dataType: 'json'
		});
		return false;
	}

	var editRow = function(row){
		$(document).find('.edit-doc').hide()
		$(document).find('.not-edit-doc').show()
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
				} else {
					row.find('.attach-comment textarea').next('.error-message').html(data.message).slideDown('slow')
				}
			},
			dataType: 'json'
		});
		return false;
	})

    $( "#attachments-block" ).on('click', ".dialog-file-delete", function() {
        var $dialog = $( ".dialog-file-delete-dialog" );
		$dialog.dialog( "option", "appendTo", $(this));
        $dialog.dialog( "option", "width", $(this).parents('table').width());
        $dialog.dialog( "option", "position", {
            my: 'right+11 top+15',
            at: 'right bottom',
            of: $(this)
        } );
		$( ".dialog-file-delete-dialog" ).find('.yes').attr('href', $(this).attr('href'))
		$(this).addClass('to-remove')
        $dialog.dialog( "open" );
        return false;
    });

	$('.dialog-file-delete-dialog .no').click(function(){
        $(this).parents('.dialog-file-delete-dialog').dialog('close');
        $('.attach-actions .to-remove').removeClass('to-remove')
		return false;
    });

    $('.dialog-file-delete-dialog .yes').click(function(){
		$(this).parents('.dialog-file-delete-dialog').dialog('close');
		return deletefile($(this))
    });
