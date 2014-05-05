
function fontScale(scale){
   if(scale == 1)
	   $('body').css({'font-size': '100%'});
   if(scale == 1.25)
	   $('body').css({'font-size': '107.2%'});
   if(scale == 1.5)
	   $('body').css({'font-size': '114.3%'});
}


$(function(){
	
	/* balance index chenge currency on accounts table */
	changeCurrency = function(){
		$('.total_currencies span').hide()
		$('.total_currencies span.'+$('.currency_dropdown').text()).show()
	}
	
	if($('.currency_dropdown').length != 0)
	$('.currency_dropdown').tempDropDown({
        list: {
            EUR: 'EUR',
			USD: 'USD',
            RUB: 'RUB',
            CHF: 'CHF',
            JPY: 'JPY'
        },
        listClass: 'currencies_dropdown',
		callback: changeCurrency

    });

    $('.container').on('change', '.select-invisible', onCustomSelectChange);

    function onCustomSelectChange(){
        $(this).prev('span').text($(this).find(':selected').text());
    }
	
	$('.tooltip-icon').tooltip({
        tooltipClass: 'xabina-tooltip',
		placement: 'right',
        position:{
            my: "left+25 top-12",
            at: "right top",
            using: function( position, feedback ) {
                $( this ).css( position );
                $( "<div>" )
                    .addClass( "tooltip-arrow" )
                    .addClass( feedback.vertical )
                    .addClass( feedback.horizontal )
                    .appendTo( this );
            }
        }
    });


    //live validation plugin initialization
    /*$('.form-validable').liveValidation({
        validIco         : 'img/validation_ico.png',
        invalidIco       : 'img/validation_ico.png',
        required         : ['firstName', 'lastName', 'email', 'phone', 'address1', 'index', 'city'],
        requiredFields   : {
            'firstName': 'firstName',
            'lastName': 'lastName',
            'email':'email',
            'phone': 'phone',
            'address1': 'address1',
            'index': 'index',
            'city': 'city'
        },
        fields           :  {
            firstName:{match: /^[a-zA-Z\-]{1,}$/, message: 'error!'},
            lastName:{match:/^[a-zA-Z\-]{1,}$/, message: 'error!'},
            email:{match:/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/, message: 'error!'},
            phone:{match:/^\+\d+$/, message: 'error!'},
            address1:{match:/^.{1,}$/, message:'error!'},
            index:{match:/^\d+$/, message: 'error!'},
            city:{match:/^.{1,}$/, message:'error!'}
        },
        selects:{
            'country': 'country'
        },
        validClass:		'valid',
        invalidClass:	'input-error',
        submitButton: '.submit-button'
    });*/

	$('#steps').on('click', '.remove-file.on-success', function(){
		block = $(this).parents('.file-row')
		$.post(window.location.href, {deleteFile: $(this).parents('.file-row').find('input').val()}, function(){
			block.remove()
		})
		
	})

    $("[name=phone]").on('focus', function(){
        !$(this).val() && $(this).val('+');
    });
    $("[name=phone]").on('input', function(){
       !~($(this).val().indexOf('+')) && $(this).val( '+' + $(this).val() );
    });


    // progressbar styling

    $('.xabina-progress-bar .current').prev().addClass('previous');
	
	/**
	* Потсветка левого меню в виджете
	*/
	$('.sidebar-menu.list-unstyled li').each(function(i, e) {
		var my_href;
		my_href = $(e).find('a').attr('href');
		if(my_href == window.location.origin + window.location.pathname){
			$(e).parents('ul').show()
			if($(e).parents('ul').prev('li')){
				$(e).parents('ul').prev('li').addClass('active');
			}
			$(e).addClass('active');
			return;
		}
	});
	
	/**
	* Left menu slide down
	*/
	$('.sidebar-menu a.with-menu').click(function(){
		if($(this).attr('href') != window.location.origin + window.location.pathname){
			$('.sidebar-menu ul').slideUp('slow')
			$(this).parents('li').next('ul').slideDown('slow')
		}
		return false
	})

	/**
	* Заполнение емейлов
	*/
	save_datas = function(url, button){
		// удаляем  клонированные tr если на них есть класс remove
	    $(".line-template.remove").remove();
		var form = $(button).parents('form');
		$.ajax({
			url: url,
			success: function(data) {
				//alert(data);
				var response = $.parseJSON (data);
				if(response.success){
					$(window).unbind('beforeunload')
					$("#user_datas").html(response.html);
					reset_values(form);
				}
				else {
						//form.find("input").parent().addClass("valid")
						//form.find("input").next(".validation-icon").fadeIn();
						$.each(response, function(k, val) {
							$("#user_datas #"+k+"_em_").text(val);
							$("#user_datas #"+k+"_em_").show();                          
						});
					}
			},
			cache:false,
			data: form.serialize(),
			type: 'POST'
		});
  } 
  
  /**
  * Контроллер Personal
  * Временное заполенение таблицы данными о юзере
  */
  add_temp_user_datas = function(url, button){

		var form = jQuery(button).parents("form");
		//alert(form.attr('id')); 
		$.ajax({
			url: url,
			success: function(data) {
				
				$(window).bind('beforeunload', function(){
					return 'Are you sure you want to leave this page? All the changes will not be saved.';
				});

				var response= $.parseJSON(data);
				if(response.success){
					
					var form_values = [];
				    var select_texts = [];
					
					form.find("input:not(:hidden)").each(function(index, element) {
						var v = $(element).data("v");
                        form_values[v] = $(element).val();
						
                    });
									
					form.find("select").each(function(index, element) {
						var v = $(element).data("v");
                        form_values[v] = $(element).val();
                    });
										
					form.find("select option:selected").each(function(index, element) {
						var v = $(element).parent("select").data("v");
                        select_texts[v] = $(element).text();
                    });
					
																		
					var line_template = $(".line-template:hidden").clone(line_template);
					line_template.show().addClass("cloned");
					
					line_template.find("td.item").each(function(index, element) {
						
						var td_item_text = $.trim($(element).html());

						var arr_td_item_text = td_item_text.split(',');
						
						//console.log(arr_td_item_text);

						for(var i = 0 ; i < arr_td_item_text.length; i++){
							if( select_texts[arr_td_item_text[i]] != undefined){
								arr_td_item_text[i] = select_texts[arr_td_item_text[i]];
							}
							else{
								arr_td_item_text[i] = form_values[arr_td_item_text[i]];
							}

							if( form_values[arr_td_item_text[i]] != undefined){
								arr_td_item_text[i] = form_values[arr_td_item_text[i]];
							}						
						}
						
						td_item_text = $.trim(arr_td_item_text.join('<br>'));
						$(element).html(td_item_text)
						
					});
					
				   line_template.find("input.item:hidden").each(function(index, element) {
                       var v = $(element).data("v");
					   $(element).val(form_values[v]);
                   });
					
					$(".line-template:last").after(line_template);
					reset_values(form);
						
																	
				} else {
					form.find("input").parent().addClass("valid")
					form.find("input").next(".validation-icon").fadeIn();
					$.each(response, function(key, value) {
						$("#"+key).removeClass("valid");
						$("#"+key).parent().removeClass("valid");
						$("#"+key).addClass("input-error");
						$("#"+key).parent().addClass("input-error");
						$("#"+key).next(".validation-icon").fadeIn();
						$("#"+key+"_em_").slideDown();
						$("#"+key+"_em_").html(''+value);                            
					});
				}
			},
			cache:false,
			data: form.serialize(),
			type: 'POST'
		});
	}
  	 
	/**
	* Контроллер Personal
	* Сброс значений полей формы
	*/ 
	function reset_values(form){	
		$(form)[0].reset();
		//$(form).val('');
		//form.find("span.select-custom-label").text(form.find("select option:first").text());
        form.find("span.select-custom-label").text("Choose");
		return true;
	}
	
	$('.main-container').on('click', '.xabina-alert .close-button', function(){
 		var url = $(this).attr('data-del-alert')
 		var element = $(this).parents('.xabina-alert')
 		$.ajax({
 			url: url,
 			success: function(data) {
 				var response= jQuery.parseJSON (data);
 				if(response.success){
 					element.remove()
 				}
 			},
 			cache:false,
 			data: {success: true},
 			type: 'GET'
 		});
 	})
	
	uploadFile = function(button){
		var form = jQuery(button).parents('form')
		$.ajax({
			url: form.attr('action'),
			success: function(data) {
				var response= jQuery.parseJSON (data);
				if(response.success){
					form.addClass('success')
				} else {
					form.removeClass('success')
					form.find("input").parent().addClass("valid")
					form.find("input").next(".validation-icon").fadeIn();
					$.each(response, function(key, value) {
						$("#"+form.attr("id")+" #"+key).removeClass("valid");
						$("#"+form.attr("id")+" #"+key).parent().removeClass("valid");
						$("#"+form.attr("id")+" #"+key).addClass("input-error");
						$("#"+form.attr("id")+" #"+key).parent().addClass("input-error");
						$("#"+form.attr("id")+" #"+key).next(".validation-icon").fadeIn();
						$("#"+form.attr("id")+" #"+key+"_em_").slideDown();
						$("#"+form.attr("id")+" #"+key+"_em_").html(''+value);                            
					});
				}
			},
			cache:false,
			async: false,
			data: form.serialize(),
			type: 'POST'
		});
	}
	
	saveEditName = function(url, button){
		var forms = jQuery(document).find('form')
		$.each(forms, function(key, value) {
			if(!$(value).hasClass("success")){
				$(value).find(".violet-button-slim").click()
			}
		})
		var success = true;
		$.each(forms, function(key, value) {
			if(!$(value).hasClass("success")){
				success = false
			}
		})
		if(success){
			$.ajax({
				url: url,
				success: function(data) {
					var response= jQuery.parseJSON (data);
					if(response.success){
						$(document).find("input").parent().addClass("valid")
						$(document).find("input").next(".validation-icon").fadeIn();
						$('.xabina-alert').hide('slow');
						$('.form-validable').hide('slow');
						$('.form-submit').hide();
						$('.xabina-alert-success').slideDown();
					} else {
						
					}
				},
				cache:false,
				data: {success: true},
				type: 'POST'
			});
		}
	}
	
	$('.advanced-button').on('click', function(e){
		e.preventDefault();
		var advancedForm = $('.advanced-search-form');
		advancedForm.slideToggle();
	});
	
	searchTransactions = function(button){
		form = $(button).parents('form')
		$.ajax({
			url: form.action,
			success: function(data) {
				var response= jQuery.parseJSON (data);
				if(response.success){
					$('.transaction-table-overflow').html(response.html)
				}
			},
			cache:false,
			data: form.serialize(),
			type: 'GET'
		});
	}
	
	downloadPdf = function(e){
		form = $('#searchForm')
		url = form.attr('data-'+e.target.innerText.toLowerCase()+'-url') + "?" + form.serialize();
		window.open(url)
	}
	
	makePrimary = function(url){
		$.ajax({
			url: url,
			success: function(data) {
				var response= jQuery.parseJSON (data);
				if(response.success){
					if(response.message){
						successNotify('Primary', response.message)
					}
					if(response.reload){
						location.reload()
					}
				}
			},
			cache:false,
			data: {},
			type: 'POST'
		});
	}
	
	deleteRow = function(link){
	
		$.ajax({
			url: $(link).attr('data-url'),
			success: function(data) {
				var response= jQuery.parseJSON (data);
				if(response.success){
					if($(link).parents('tr').prev('tr').hasClass('email-comment-tr')){
						$(link).parents('tr').prev('tr').remove()
					}
					$(link).parents('tr').remove()
				}
			},
			cache:false,
			data: {},
			type: 'POST'
		});
	}
	
	activatePhone = function(url, link){
		value = $(link).parents('.field-row').find('.input-text-sms').val();
		if(value){
			$.ajax({
				url: url+value,
				success: function(data) {
					var response = jQuery.parseJSON (data);
					if(response.success){
						location.reload()
					} else {
						$(link).parents('td').find('.error-message').html(response.message).fadeIn()
					}
				},
				cache:false,
				data: {},
				type: 'POST'
			});
		}
	}
	

	/**
	* Удаление сообщений
	*/
	del_message = function(url, el, msg){
		if(!confirm(msg)){
			return;
		}
		$.ajax({
			url: url,
			success: function(data) {
				//alert(data);
				var response = $.parseJSON (data);
				if(response.success){
					$(el).parents('tr').fadeOut(100);
				}
				else {
					alert('Can not be removed');
				}
			},
			cache:false,
			type: 'GET'
		});
	}

});

function printDiv(divName) {
	$('.attachments').hide();
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();
	
    document.body.innerHTML = originalContents;
	$('.attachments').show();
}

$(document).ready(function(){

	$('.main-container').on('click', '.clickable-row', function(){
		url = $(this).attr('data-url')
		window.location.href=url
	})

	if($('.calendar-input').length != 0)
	$(".calendar-input").datepicker({
		showOn:"button",
		buttonImage: '/images/calendar_ico.png',
		buttonImageOnly:true
	});
	
	$('select.language-select').on('change', function(){
		window.location.href=$(this).val()
	})

	$('.recurrence-select').on('click', 'a', changeRecurrenceForm);
	
	$('.recurrence-form').find('input').attr('disabled','disabled')
	$('.recurrence-form').find('select').attr('disabled','disabled')

	function changeRecurrenceForm(e){
		e.preventDefault();
		$(this).parents('.recurrence-form').find('input').attr('disabled','disabled')
		$(this).parents('.recurrence-form').find('select').attr('disabled','disabled')
		if($(this).hasClass('one-time')){
			$(this).parents('.recurrence-select').find('.active').removeClass('active');
			$(this).addClass('active');
			$(this).parents('.recurrence-form').find('.one_time_form').find('input').removeAttr('disabled')
			$(this).parents('.recurrence-form').find('.one_time_form').find('select').removeAttr('disabled')
			$(this).parents('.recurrence-form').find('.one_time_form').show();
			$(this).parents('.recurrence-form').find('.standing-form').hide();
		}else if($(this).hasClass('standing')){
			$(this).find('input').removeAttr('disabled')
			$(this).find('select').removeAttr('disabled')
			$(this).parents('.recurrence-select').find('.active').removeClass('active');
			$(this).addClass('active');
			$(this).parents('.recurrence-form').find('.standing-form').find('input').removeAttr('disabled')
			$(this).parents('.recurrence-form').find('.standing-form').find('select').removeAttr('disabled')
			$(this).parents('.recurrence-form').find('.standing-form').show();
			$(this).parents('.recurrence-form').find('.one_time_form').hide();
		}
	}
	
	if($('.with_datepicker').length != 0)
	$(".with_datepicker").datepicker({
        showOn:"button",
        buttonImage: '/images/calendar_ico.png',
        buttonImageOnly:true
    });
	
	if($('#bg-404-gold').length){
		$('#bg-404-gold').plaxify({"xRange":30,"yRange":30});
		$.plax.enable();
	}
	
	 $('.mask-toggle').on('mouseenter', function(e){
        var $maskedEl = $(this).parents('td').find('.masked-value');
        var $originalEl = $(this).parents('td').find('.original-value');
        $maskedEl.html($originalEl.val());
    })
    $('.mask-toggle').on('mouseleave', function(e){
        var $maskedEl = $(this).parents('td').find('.masked-value');
        var $originalEl = $(this).parents('td').find('.original-value');
        $maskedEl.html('**********');
    })
	
	
	
	if($('.calendar-input, .with_datepicker').length)
    $(".calendar-input, .with_datepicker").datepicker({
        showOn:"button",
        buttonImage: '/images/calendar_ico.png',
        buttonImageOnly:true
    });
    if($('.calendar-input-2').length)
    $(".calendar-input-2").datepicker({
        showOn:"button",
        buttonImage: '/images/calendar_ico_2.png',
        buttonImageOnly:true
    });
	
	/*if($('input.button-find').length)
	$(document).keyup(function(event){
		if(event.keyCode == 13){
			$("input.button-find").click();
		}
	});*/
	
	if($('.download-button').length != 0)
	$('.download-button').tempDropDown({
		list: {
		   PDF: {
               id : 'pdf',
               name : 'PDF',
               class : 'PDF'
           },
           DOC : {
               id : 'doc',
               name : 'DOC',
               class : 'DOC'
           },
           CSV : {
               id : 'csv',
               name : 'CSV',
               class : 'XLS'
           }
		   /*,Other: 'Other'
		   PDF : 'PDF' ,
           XLS : 'XLS' ,
           DOC : 'DOC' ,
           JPG : 'JPG'*/
		},
		listClass: 'formats_dropdown',
		toChange: false,
		callback: downloadPdf
	});
	
	if($('#addNotes').length != 0){
		$('#addNotes').on('submit', function(ev) {
			var data = $('#addNotes').serialize();
			$.post($('#addNotes').attr('action'), data, function(data){
				if(data.success){
					$('#notes-list').html(data.html)
					$('html, body').animate({
						scrollTop: $("#notes-list").offset().top-50
					}, 500);
				}
				$('#addNotes')[0].reset()
			}, 'json')
			
			return false;
		});
	}
	
	if($("#notes-list"))
	$("#notes-list").on('click', '.delete', function(){
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
	
	if($("#transaction-category-select"))
	$("#transaction-category-select").change(function(){
		
		$.ajax({
			type: "POST",
			url: $("#transaction-category-select").attr('data-url'),
			data: {category: $("#transaction-category-select").val()}
		});
		return false;
	})
	
	$( ".escape-dialog" ).dialog({
        autoOpen: false,
        appendTo: '#top_container .clearfix',
        dialogClass: 'xabina-popup-alerts',
        height: 'auto',
        minHeight: 0,
        position:{
            my: 'right top',
            at: 'right bottom',
            of: ".user-logout"
        },
        show: 'fadeIn',
        resizable: false
    });

    $( ".user-logout" ).click(function() {
        var $dialog = $( ".escape-dialog" );
        $dialog.dialog( "option", "width", $(this).parents('.clearfix').width());
        $dialog.dialog( "open" );
        return false;
    });
    $('.xabina-dialog .no').click(function(){
        $(this).parents('.xabina-dialog').dialog('close');
        return false;
    });
    $('.xabina-dialog .yes').click(function(){
        var link = $(this).parents('a')
		return deleteTransaction(link)
    });

    $( ".remove-dialog" ).dialog({
        autoOpen: false,
        dialogClass: 'xabina-popup-alerts',
        height: 'auto',
        minHeight: 0,
        show: 'fadeIn'
    });
	
	if($('.remove-with-dialog').length != 0)
	$('.remove-with-dialog').click(function() {
        var $dialog =  $( ".remove-dialog" );
        $dialog.dialog( "option", "appendTo", $(this));
        $dialog.dialog( "option", "width", $(this).parents('.xabina-form-container').width());
        $dialog.dialog( "option", "position", {
            my: 'right+11 top+15',
            at: 'right bottom',
            of: $(this)
        } );
        $dialog.dialog( "open" );
        return false;
    })
	
	$('textarea').autosize();
})

var resetPage = function(){
	$(document).find('.edit-doc').hide()
	$(document).find('.not-edit-doc').show()
	$(document).find('.prof-form').hide()
	$(document).find('.add-new-td').parents('tr').show()
}

$(document).on('click', '.button.cancel', function(){
	resetPage()
})

var successNotify = function(title, message){
	$.pnotify({ title: title, text: message, type: 'success', width: '500px', delay: 3000});
}



