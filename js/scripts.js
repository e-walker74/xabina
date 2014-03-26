
function fontScale(scale){
   if(scale == 1)
	   $('body').css({'font-size': '100%'});
   if(scale == 1.25)
	   $('body').css({'font-size': '107.2%'});
   if(scale == 1.5)
	   $('body').css({'font-size': '114.3%'});
}


$(function(){
	
	$('.currency_dropdown').tempDropDown({
        list: {
            EUR: 'EUR',
			USD: 'USD',
            RUB: 'RUB',
            CHF: 'CHF',
            JPY: 'JPY'
        },
        listClass: 'currencies_dropdown'

    });

    $('.container').on('change', '.select-invisible', onCustomSelectChange);

    function onCustomSelectChange(){
        $(this).prev('span').text($(this).find(':selected').text());
    }
	
	$('.tooltip-icon').tooltip({
        tooltipClass: 'xabina-tooltip',
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
		if(my_href == window.location.href){
			$(e).addClass('active');
			return;
		}
	});
	
	
	/**
	* Заполнение емейлов
	*/
	save_datas = function(url, button){
		// удаляем  клонированные tr если на них есть класс remove
	    $('.line-template.remove').remove();
		var form = $(button).parents('form');
		$.ajax({
			url: url,
			success: function(data) {
				//alert(data);
				var response = $.parseJSON (data);
				if(response.success){
					//alert(response.html);
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
	  	
		var form = jQuery(button).parents('form');
		//alert(form.attr('id')); 
		$.ajax({
			url: url,
			success: function(data) {
				
				var response= jQuery.parseJSON(data);
				if(response.success){
					
					var form_values = [];
				    var select_texts = [];
					
					form.find('input:not(:hidden)').each(function(index, element) {
						var v = $(element).data('v');						
                        form_values[v] = $(element).val();
						
                    });
									
					form.find('select').each(function(index, element) {
						var v = $(element).data('v');
                        form_values[v] = $(element).val();
                    });
										
					form.find('select option:selected').each(function(index, element) {
						var v = $(element).parent('select').data('v');
                        select_texts[v] = $(element).text();
                    });
					
																		
					var line_template = $(".line-template:hidden").clone(line_template);
					line_template.show().addClass('cloned');
					
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
					
				   line_template.find('input.item:hidden').each(function(index, element) {
                       var v = $(element).data('v');
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
		$(form).val('');
		form.find("span.select-custom-label").text(form.find("select option:first").text());					
		return true;
	}
	
	/**
	* Контроллер Personal
	* Помечаем как удаленные данные во временной таблицы
	*/
	$('td.remove-td').live('click', function(){
		if($(this).parents('tr').find('input.delete').val() == '0'){
			$(this).parents('tr').find('input.delete').val('1');
			$(this).parent('tr').css('background-color', '#FFCACA');
			$(this).parent('tr').addClass('remove');
		}
		else{
			$(this).parents('tr').find('input.delete').val('0');
			$(this).parent('tr').css('background-color', '#FFF');
			$(this).parent('tr').removeClass('remove');
		}
		
	});
	
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
	
	$(document).ready(function(){
		$(".calendar-input").datepicker({
			showOn:"button",
			buttonImage: '/images/calendar_ico.png',
			buttonImageOnly:true
		});
		
		$('.trans-download').tempDropDown({
			list: {
			   PDF: 'PDF'
			   /*,Other: 'Other'*/
			},
			listClass: 'formats_dropdown',
			toChange: false,
			callback: downloadPdf
		});
		
		$('select.language-select').on('change', function(){
			window.location.href=$(this).val()
		})
	})

	
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
	
	downloadPdf = function(){
		form = $('#searchForm')
		url = form.attr('data-pdf-url') + "?" + form.serialize();
		window.location.href=url
	}
	
	makePrimary = function(url){
		$.ajax({
			url: url,
			success: function(data) {
				var response= jQuery.parseJSON (data);
				if(response.success){
					if(response.message){
						alert(response.message);
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
	
	activatePhone = function(url, link){
		value = $(link).next().val();
		if(value){
			$.ajax({
				url: url+value,
				success: function(data) {
					var response = jQuery.parseJSON (data);
					if(response.success){
						location.reload()
					}
				},
				cache:false,
				data: {},
				type: 'POST'
			});
		}
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


