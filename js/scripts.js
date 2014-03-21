
function fontScale(scale){
   if(scale == 1)
	   $('body').css({'font-size': '100%'});
   if(scale == 1.25)
	   $('body').css({'font-size': '107.2%'});
   if(scale == 1.5)
	   $('body').css({'font-size': '114.3%'});
}


$(function(){

	$('.currency_dropdown').currencyDropDown({
        currencies: {
            EUR: 'EUR',
			USD: 'USD',
            RUB: 'RUB',
            CHF: 'CHF',
            JPY: 'JPY'
        }
    });

    $('.select-invisible').on('change', onCustomSelectChange);
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
					reset_values();
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
	  
		var form = jQuery(button).parents('form')
		$.ajax({
			url: url,
			success: function(data) {
				
				var response= jQuery.parseJSON (data);
				if(response.success){
					
					var form_values = [];
				    var select_texts = [];
					
					$('#user_datas input:not(:hidden)').each(function(index, element) {
						var v = $(element).data('v');						
                        form_values[v] = $(element).val();
						
                    });
					
				
					$('#user_datas select').each(function(index, element) {
						var v = $(element).data('v');
                        form_values[v] = $(element).val();
                    });
										
					$('#user_datas select option:selected').each(function(index, element) {
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
								//alert('select');
							}
							else{
								arr_td_item_text[i] = form_values[arr_td_item_text[i]];
								//alert('val');
							}

							if( form_values[arr_td_item_text[i]] != undefined){
								arr_td_item_text[i] = form_values[arr_td_item_text[i]];
							}						
						}
						
						td_item_text = $.trim(arr_td_item_text.join('<br>'));
						$(element).html(td_item_text)
						
					});
					
					
					//console.log(form_values);
					
					
					//$('#user_datas input.item:hidden').each(function(index, element) {
                       // var v = $(element).data('v');
					    //$(element).val(form_values[v]);
					    //alert(v);
                   // });
				   line_template.find('input.item:hidden').each(function(index, element) {
                       var v = $(element).data('v');
					   $(element).val(form_values[v]);
                   });
					
					
					
					$(".line-template:last").after(line_template);					
					reset_values();	
																	
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
	function reset_values(){
		
		$('#user_datas input.input-text:not(:hidden)').each(function(index, element) {
			$(element).val('');
		});
		
		$('#user_datas select').each(function(index, element) {
			$(element).val('');
		});
		$("span.select-custom-label").text($("#user_datas select option:first").text());					
		
					
		
		//$("input.input-text.item0").val('');
		//$("select.item1 :first").attr("selected", "selected");
		//$("span.select-custom-label").text($("select.item1 option:first").text());
		return true;
	}
	
	
	 add_temp_user_address = function(url, button){
	  
		var form = jQuery(button).parents('form')
		$.ajax({
			url: url,
			success: function(data) {
				var response= jQuery.parseJSON (data);
				if(response.success){
					var input_text_val = $("input.input-text.item0").val();									
					var select_option_val = $("select.item1").val();
					var select_option_txt = $("select.item1 option:selected").text();
							
																		
					var line_template = $(".line-template:hidden").clone(line_template);
					line_template.show();
					
					line_template.find("td.item0").html(input_text_val);
					line_template.find("td.item1").html(select_option_txt);
										
					line_template.find("input.hidden.item0").val(input_text_val);
					line_template.find("input.hidden.item1").val(select_option_val);
					
					$(".line-template:last").after(line_template);					
					reset_values();	
																	
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
});


