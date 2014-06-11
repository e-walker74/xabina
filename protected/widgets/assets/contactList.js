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
		$(this).parents('.scroll-cont').find('.scroll-block').scrollTo( $('.letter_'+$(this).html()), 600, {margin:true});
	}
	return false;
})

jQuery.fn.clientListSearch = function(options, callback){
	
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
		//backgroundBlack()
		$.ajax({
			url: options.url,
			success: function(response) {
				callback(response)
				if(response.success){
					$("#contactsList").html(response.html);
					alphabetEach()
				}
			},
			cache:false,
			data: {qname: el_input.val()},
			dataType: 'json',
			//complete : dellBackgroundBlack,
			type: 'GET'
		});
	}
};

var searchByName = function(elementUl, text){
	elementUl.find('.contact-name').each(function(){
		if($(this).text().toLowerCase().indexOf(text.toLowerCase())+1){
			$(this).parents('li').show().parents('.letter-block').show()
		} else {
			$(this).parents('li').hide()
			if($(this).parents('.letter-block').find('li:visible').length == 0){
				$(this).parents('.letter-block').hide()
			}
		}
	})
	alphabetEach()
}

jQuery.fn.searchContactButtonByName = function(options, callback){
	
	var pressTimeout = false,
	searchButton = $(this),
	el_input,
	_options = {
		searchLineSelector: '.account-search-input',
		parentSelector: '.search-by-name-block',
		classForResultsUl: 'ul.contact-list',
		inputSelectorForName: '.inputSelectorForName',
		inputSelectorForID: '.inputSelectorForID'
	}
	
	options = $.extend(_options, options)
	
	el_input = $(options.searchLineSelector)
	
	$(searchButton).click(function(){
		$(options.parentSelector).slideToggle()
		return false;
	})
	
	if($(options.inputSelectorForID).length != 0){
		$(options.parentSelector).on('click', '.contact-list li', function(e){
			$(options.parentSelector).slideUp()
			$(options.inputSelectorForName).val($(this).find('.contact-name').text())
			$(options.inputSelectorForID).val($(this).attr('data-id'))
			return false
		})
	}
	
	$(options.searchLineSelector).on('keyup', function(e){
		searchByName($(options.parentSelector+' '+options.classForResultsUl), $(e.currentTarget).val())
	})
}

jQuery.fn.searchContactButton = function(options, callback){
	
	var pressTimeout = false,
	searchButton = $(this),
	el_input,
	_options = {
		searchLineSelector: '.account-search-input',
		parentSelector: '.account-search-results-cont-with-searhline',
		updateElements: {
			'data-amount': '#Form_Outgoingtransf_External_amount',
			'data-cent': '#Form_Outgoingtransf_External_amount_cent',
			'data-currency': '#Form_Outgoingtransf_External_currency_id',
			'data-number': '#Form_Outgoingtransf_External_to_account_number',
			'data-holder': '#Form_Outgoingtransf_External_to_account_holder',
			'data-description': '#Form_Outgoingtransf_External_description'
		}
	}
	
	options = $.extend(_options, options)
	
	el_input = $(options.searchLineSelector)
	
	$(searchButton).click(function(){
		$(options.parentSelector).slideToggle()
		return false;
	})
	
	$(options.parentSelector).on('click', 'li.transfer-data', function(e){
		updateParams(this, options.updateElements, function(){
			$(options.parentSelector).slideToggle()
			return false;
		})
	})
	
	$(options.parentSelector).on('click', '.account-resourse-cont', function(e){
		updateParams($(this).parents('li'), options.updateElements, function(){
			$(options.parentSelector).slideToggle()
			return false;
		})
	})
	
	$(options.parentSelector).on('click', 'li.accout-pay-accordion a', function(){
		var add = true;
		
		li_selector = $(this).parents('li.accout-pay-accordion')
		
		if($(li_selector).hasClass('opened')){
			add = false
		}
		$('li.accout-pay-accordion').removeClass('opened').removeClass('open')
		if(add){
			if(!$(li_selector).hasClass('uploaded')){
				gettransfers($(li_selector))
			}
			$(li_selector).addClass('opened').addClass('open')
		} else {
			$(li_selector).removeClass('opened').removeClass('open')
		}
		return false;
	})
	
	var gettransfers = function(liObj){
		backgroundBlack()
		$.ajax({
			url: options.url,
			success: function(response) {
				liObj.addClass('uploaded')
				if(response.success){
					liObj.find('.pay-list.list-unstyled').html(response.html)
				}
			},
			cache:false,
			data: {
					qAccountNumber: liObj.attr('data-number'), 
					qAccountEType: liObj.attr('data-account-type')
				},
			dataType: 'json',
			complete : dellBackgroundBlack,
			type: 'GET'
		});
	}
	
	$(options.searchLineSelector).on('keyup', function(e){
		if (pressTimeout) clearTimeout(pressTimeout);
		var code = e.which;
		if(code == 13){
			getContactList()
		} else {
			pressTimeout = setTimeout(getContactList, 1000);
		}
	}).next('a').on('click', function(e){
		getContactList()
		return false;
	})
	
	
	var getContactList = function(){
		if(!options.url){
			return false;
		}
		//backgroundBlack()
		$.ajax({
			url: options.url,
			success: function(response) {
				if(response.success){
					$("#contactsList").html(response.html);
					$("#contactsList").slideDown();
				} else {
					$("#contactsList").slideUp().html('');
				}
				alphabetEach()
			},
			cache:false,
			data: {qname: el_input.val()},
			dataType: 'json',
			//complete : dellBackgroundBlack,
			type: 'GET'
		});
	}
}

var clientListSearchTransfers = function(options, callback){
	
	var pressTimeout = false,
	_options = {
		qholder: false,
		qnumber: false,
		updateElements: {
			'data-amount': '#Form_Outgoingtransf_External_amount',
			'data-cent': '#Form_Outgoingtransf_External_amount_cent',
			'data-number': '#Form_Outgoingtransf_External_to_account_number',
			'data-currency': '#Form_Outgoingtransf_External_currency_id',
			'data-holder': '#Form_Outgoingtransf_External_to_account_holder',
			'data-description': '#Form_Outgoingtransf_External_description'
		}
	}
	
	options = $.extend(_options, options)
    
	$(options.qholder+','+options.qnumber).on('keyup', function(e){
		if (pressTimeout) clearTimeout(pressTimeout);
		var code = e.which;
		var element = this
		if(code == 13){
			getContactList(element)
		} else {
			pressTimeout = setTimeout(getContactList, 1000);
		}
	})
	
	
	var getContactList = function(element){
	
		if(!options.url){
			return false;
		}
		
		var data = {qholder: $(options.qholder).val(), qnumber: $(options.qnumber).val()}
		
		//backgroundBlack()
		$.ajax({
			url: options.url,
			success: function(response) {
				if(response.success){
					$("#contactsList-searchTransfers").parent().show()
					$("#contactsList-searchTransfers").html(response.html)
				} else {
					$("#contactsList-searchTransfers").parent().hide()
				}
			},
			cache:false,
			data: data,
			dataType: 'json',
			//complete : dellBackgroundBlack,
			type: 'GET'
		});
	}
	
	$('#contactsList-searchTransfers').on('click', 'li', function(e){
		updateParams(this, options.updateElements, function(){
			$("#contactsList-searchTransfers").parent().hide()
		})
	})
};

var updateParams = function(element, datas, callback){
	el = $(element)
	jQuery.each(datas, function(i, val) {
		if(el.attr(i)){
			$(val).val(el.attr(i))
		}
	});
	if(callback){
		callback()
	}
	
}