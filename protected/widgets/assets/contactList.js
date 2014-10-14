var alphabetEach = function () {
    $('.alphabet li').removeClass('active')
    $('.alphabet li').removeClass('inactive')
    $('.alphabet li a').each(function () {
        if ($(this).html() != '#') {
            if ($('.letter_' + $(this).html() + ':visible').length == 0) {
                $(this).parent().addClass('inactive')
            }
        } else {
            if ($('.letter_else:visible').length == 0) {
                $(this).parent().addClass('inactive')
                if ($(this).closest('.contact-book-dropdown').length == 1) {
                    if (!$(this).closest('.contact-book-dropdown').find('.letter-block:visible').length) {
                        $(this).closest('.add-contact').removeClass('open')
                    }
                }
            }
        }
    })
}

alphabetEach()

$('.alphabet li a').click(function () {
    var selector = '.letter_' + $(this).html()
    if ($(this).html() == "#") {
        selector = '.letter_else'
    }
    if ($(selector).length != 0) {
        $('.alphabet li').removeClass('active')
        $(this).parent().addClass('active')
        var obj = $(selector)
        $(this).closest('.scroll-cont').find('.scroll-block').scrollTo(obj, 600, {margin: true});
    }
    return false;
})

jQuery.fn.clientListSearch = function (options, callback) {

//	var el_input = $(this)
//
//	var pressTimeout = false;
//
//	$(this).on('keyup', function(e){
//		if (pressTimeout) clearTimeout(pressTimeout);
//		var code = e.which;
//		if(code == 13){
//			getContactList()
//		} else {
//			pressTimeout = setTimeout(getContactList, 1000);
//		}
//	})
//
//    $('#category_id_list').change(function(){
//        var select = $(this)
//        $('.categories').hide()
//        $('.category_'+select.val()).show();
//    })
//
//	var getContactList = function(){
//		if(!options.url){
//			return false;
//		}
//		//backgroundBlack()
//		$.ajax({
//			url: options.url,
//			success: function(response) {
//				callback(response)
//				if(response.success){
//					$("#contactsList").html(response.html);
//					alphabetEach()
//				}
//			},
//			cache:false,
//			data: {qname: el_input.val()},
//			dataType: 'json',
//			//complete : dellBackgroundBlack,
//			type: 'GET'
//		});
//	}
};

var searchByName = function (elementUl, text) {
    var category = $('#category_id_list').val()
    elementUl.closest('.add-contact').addClass('open')
    elementUl.find('.contact-name').each(function () {
        if (!$(this).text()) {
            $('.categories').hide().closest('li').hide()
            $('.category_' + category).show().closest('li').show();

        } else if ($(this).text().toLowerCase().indexOf(text.toLowerCase()) + 1) {
            if (category && !$(this).closest('li').hasClass('category_' + category)) {
                $(this).closest('li').hide()
                if ($(this).closest('.letter-block').find('li:visible').length == 0) {
                    $(this).closest('.letter-block').hide()
                }
            } else {
                $(this).closest('li').show().closest('.letter-block').show()
            }
        } else {
            $(this).closest('li').hide()
            if ($(this).closest('.letter-block').find('li:visible').length == 0) {
                $(this).closest('.letter-block').hide()
            }
        }
    })
    alphabetEach()
}

jQuery.fn.searchContactButtonByName = function (options, callback) {

    var pressTimeout = false,
        searchButton = $(this),
        el_input,
        key_codes = {
            ENTER: 13,
            UP: 38,
            DOWN: 40,
            ESC: 27

        },
        _options = {
            searchLineSelector: '.account-search-input',
            parentSelector: '.search-by-name-block',
            classForResultsUl: 'ul.contact-list',
            inputSelectorForName: '.inputSelectorForName',
            inputSelectorForID: '.inputSelectorForID'
        }


    options = $.extend(_options, options)

    el_input = $(options.searchLineSelector)

    if ($(options.inputSelectorForID).length != 0) {
        $(options.parentSelector).on('click', '.contact-list li', function (e) {
            $(options.parentSelector).slideUp()
            $(options.inputSelectorForName).val($(this).find('.contact-name').text())
            $(options.inputSelectorForID).val($(this).attr('data-id'))
            return false
        })
    }

    el_input.on('keyup', function (e) {
        searchByNameIndex($(options.parentSelector + ' ' + options.classForResultsUl), $(e.currentTarget).val())
    })

    $('#category_id_list').on('change', function (e) {
        searchByNameIndex($(options.parentSelector + ' ' + options.classForResultsUl), $(el_input).val())
    })

    $('#types_list').on('change', function (e) {
        searchByNameIndex($(options.parentSelector + ' ' + options.classForResultsUl), $(el_input).val())
    })

    $('.clear-input-but').on('click', function (e) {
        $(this).parents('.clear-input-cont').find('input').val('');
        $('.clear-input-but').hide()
        searchByNameIndex($(options.parentSelector + ' ' + options.classForResultsUl), $(e.currentTarget).val())
    });

    var searchByNameIndex = function (elementUl, text) {

        var contacts = $(options.parentSelector + ' .one-contact')
        var letterBlocks = $(options.parentSelector + ' .letter-block')
        var category = $('#category_id_list').val()
        var type = $('#types_list').val()

        contacts.show()
        letterBlocks.show()
        $(options.parentSelector + ' .letter-block').show()

        contacts.each(function () {
            if (type) {
                if (!$(this).hasClass('type_' + type)) {
                    $(this).hide()
                }
            }
            if (category) {
                if (!$(this).hasClass('category_' + category)) {
                    $(this).hide()
                }
            }

            if ($(this).text().toLowerCase().indexOf(text.toLowerCase()) + 1 == 0) {
                $(this).hide()
            }
        })

        letterBlocks.each(function(){
            if($(this).find('.one-contact:visible').length == 0)
                $(this).hide()
        })

        alphabetEach()

        if (elementUl.find('.one-contact:visible').length == 0) {
            elementUl.closest('#contactsList').find('.empty-list').removeClass('hidden').show()
        } else {
            elementUl.closest('#contactsList').find('.empty-list').addClass('hidden').hide()
        }
    }

    var focusNextItem = function () {
        var element_for_focus = false;
        if ($(options.parentSelector).find('.list-focus').length != 0) {
            var flag_next = false;
            $(options.parentSelector + " .one-contact:visible").each(function () {
                if (flag_next == true) {
                    element_for_focus = $(this)
                    return false;
                }
                if ($(this).hasClass('list-focus')) {
                    flag_next = true
                }
            })
        } else {
            element_for_focus = $(options.parentSelector).find('.one-contact:visible:first')
        }
        if (element_for_focus.length == 1) {
            $(options.parentSelector).find('.list-focus').removeClass('list-focus')
            element_for_focus.addClass('list-focus')
            $(element_for_focus).parents('.scroll-block').scrollTo(element_for_focus, 200, {margin: true});
        } else {
            $(options.parentSelector).find('.list-focus').removeClass('list-focus')
            focusNextItem()
        }
    }

    var focusPrevItem = function () {
        var element_for_focus = false;
        if ($(options.parentSelector).find('.list-focus').length != 0) {
            var flag_prev = false;
            $(options.parentSelector + " .one-contact:visible").each(function () {
                if ($(this).hasClass('list-focus')) {
                    flag_prev = true
                    return false;
                }
                element_for_focus = $(this)
            })
            if (!flag_prev) {
                element_for_focus = false
            }
        } else {
            element_for_focus = $(options.parentSelector).find('.one-contact:visible:last')
        }
        if (element_for_focus.length == 1) {
            $(options.parentSelector).find('.list-focus').removeClass('list-focus')
            element_for_focus.addClass('list-focus')
            $(element_for_focus).parents('.scroll-block').scrollTo(element_for_focus, 200, {margin: true});
        } else {
            $(options.parentSelector).find('.list-focus').removeClass('list-focus')
            focusPrevItem()
        }
    }

    var selectChange = function () {
        if ($(options.inputSelectorForID).length != 0) {
            if ($(options.parentSelector).find('.list-focus').length == 1) {
                $(options.parentSelector).find('.list-focus').click()
            }
        } else {
            if ($(options.parentSelector).find('.list-focus').length == 1) {
                $(options.parentSelector).find('.list-focus a')[0].click()
            }
        }
    }

    el_input.on('keypress', function (e) {
        if (e.which == '13') {
            e.preventDefault();
        }
    })

    el_input.on('keyup', function (e) {
        if (e.keyCode == key_codes.DOWN) {
            focusNextItem()
            $(this)[0].selectionStart = $(this)[0].selectionEnd = $(this).val().length;
            return false;
        } else if (e.keyCode == key_codes.UP) {
            focusPrevItem()
            $(this)[0].selectionStart = $(this)[0].selectionEnd = $(this).val().length;
            return false;
        } else if (e.keyCode == key_codes.ENTER) {
            selectChange()
            return false;
        }
        return false;
    })

    alphabetEach()

    $('.alphabet li a').click(function () {
        var selector = '.letter_' + $(this).html()
        if ($(this).html() == "#") {
            selector = '.letter_else'
        }
        if ($(selector).length != 0) {
            $('.alphabet li').removeClass('active')
            $(this).parent().addClass('active')
            var obj = $(selector)
            $(this).closest('.scroll-cont').find('.scroll-block').scrollTo(obj, 600, {margin: true});
        }
        return false;
    })
}

jQuery.fn.popUpSearchContact = function (options, callback) {
    var pressTimeout = false,
        searchButton = $(this),
        el_input,
        key_codes = {
            ENTER: 13,
            UP: 38,
            DOWN: 40,
            ESC: 27

        },
        _options = {
            searchLineSelector: '.account-search-input',
            parentSelector: '.search-by-name-block',
            classForResultsUl: 'ul.contact-list',
            inputSelectorForName: '.inputSelectorForName',
            inputSelectorForID: '.inputSelectorForID'
        }


    options = $.extend(_options, options)

    el_input = $(options.searchLineSelector)

    $(options.inputSelectorForName)
        .on('beforeCreateToken', function (e) {
            var li = $(options.parentSelector + ' li.list-focus')
            var id = $(options.parentSelector + ' li.one-contact[data-id="' + e.token.value + '"]')
            var name = $(options.parentSelector + ' li.one-contact[data-name="' + e.token.value.toLowerCase() + '"]')
            var xabina = $(options.parentSelector + ' li.one-contact[data-xabina="' + e.token.value + '"]')
            if (li.length == 1) {
                e.token.value = $(li).attr('data-id')
                e.token.label = $(li).find('.contact-name').html()
                li.removeClass('list-focus')
            } else if (id.length == 1) {
                e.token.value = id.attr('data-id')
                e.token.label = id.find('.contact-name').html()
            } else if (name.length == 1) {
                e.token.value = name.attr('data-id')
                e.token.label = name.find('.contact-name').html()
            } else if (xabina.length == 1) {
                e.token.value = xabina.attr('data-id')
                e.token.label = xabina.find('.contact-name').html()
            }
        })
        .on('afterCreateToken', function (e) {
            // Гњber-simplistic e-mail validation

            var re = $(options.parentSelector + ' li.one-contact[data-id=' + e.token.value + ']')
            var valid = re.length
            if (!valid) {
                $(e.relatedTarget).addClass('invalid')
                e.token.value = ''
            }
        })
        .on('preventDuplicateToken', function (e) {
            $(options.parentSelector).parent().find('.error-message').slideDown().delay(3000).slideUp()
        })
        .tokenfield({showAutocompleteOnFocus: false});

    $(searchButton).click(function () {
        $(this).closest('.form-input').toggleClass('open')
        $(document).bind('click.close-the-popup', function () {
            if (!$(this.activeElement).hasClass('open') && $(this.activeElement).closest('.open').length === 0) {
                $('.open').removeClass('open')
                $(document).unbind('click.close-the-popup')
            }
        })
        return false;
    })

    $('.tokenfield').click(function (e) {
        $(this).closest('.form-input').addClass('open')
        searchPopUp($(options.parentSelector + ' ' + options.classForResultsUl), $(e.currentTarget).val())
        $(document).bind('click.close-the-popup', function () {
            if (!$(this.activeElement).hasClass('open') && $(this.activeElement).closest('.open').length === 0) {
                $('.open').removeClass('open')
                $(document).unbind('click.close-the-popup')
            }
        })
    })


//    if($(options.inputSelectorForID).length != 0){
//        $(options.searchLineSelector).on('click', '.contact-list li', function(e){
//            $('.open').removeClass('open')
//            $(document).unbind('click.close-the-popup')
//            $(options.inputSelectorForName).val($(this).find('.contact-name').text())
//            $(options.inputSelectorForID).val($(this).attr('data-id'))
//            return false
//        })
//    }

    $('.one-contact').on('click', function () {
//        $('#linkName-tokenfield').val($(this).find('.contact-name').html())
        addToken(this)
    })

    $('.token-input').on('keyup', function (e) {
        searchPopUp($(options.parentSelector + ' ' + options.classForResultsUl), $(e.currentTarget).val())
    })

    $(options.parentSelector + ' .clear-input-but').on('click', function (e) {
        $(this).parents('.clear-input-cont').find('input').val('');
        searchPopUp($(options.parentSelector + ' ' + options.classForResultsUl), $(e.currentTarget).val())
    });

    var focusNextItem = function () {
        var element_for_focus = false;
        if ($(options.parentSelector).find('.list-focus').length != 0) {
            var flag_next = false;
            $(options.parentSelector + " .one-contact:visible").each(function () {
                if (flag_next == true) {
                    element_for_focus = $(this)
                    return false;
                }
                if ($(this).hasClass('list-focus')) {
                    flag_next = true
                }
            })
        } else {
            element_for_focus = $(options.parentSelector).find('.one-contact:visible:first')
        }
        if (element_for_focus.length == 1) {
            $(options.parentSelector).find('.list-focus').removeClass('list-focus')
            element_for_focus.addClass('list-focus')
            $(element_for_focus).parents('.scroll-block').scrollTo(element_for_focus, 200, {margin: true});
        } else {
            $(options.parentSelector).find('.list-focus').removeClass('list-focus')
            focusNextItem()
        }
    }

    var focusPrevItem = function () {
        var element_for_focus = false;
        if ($(options.parentSelector).find('.list-focus').length != 0) {
            var flag_prev = false;
            $(options.parentSelector + " .one-contact:visible").each(function () {
                if ($(this).hasClass('list-focus')) {
                    flag_prev = true
                    return false;
                }
                element_for_focus = $(this)
            })
            if (!flag_prev) {
                element_for_focus = false
            }
        } else {
            element_for_focus = $(options.parentSelector).find('.one-contact:visible:last')
        }
        if (element_for_focus.length == 1) {
            $(options.parentSelector).find('.list-focus').removeClass('list-focus')
            element_for_focus.addClass('list-focus')
            $(element_for_focus).parents('.scroll-block').scrollTo(element_for_focus, 200, {margin: true});
        } else {
            $(options.parentSelector).find('.list-focus').removeClass('list-focus')
            focusPrevItem()
        }
    }

    var selectChange = function () {
        if ($(options.inputSelectorForID).length != 0) {
            if ($(options.parentSelector).find('.list-focus').length == 1) {
                $(options.parentSelector).find('.list-focus').click()
            }
        } else {
            if ($(options.parentSelector).find('.list-focus').length == 1) {
                $(options.parentSelector).find('.list-focus a')[0].click()
            }
        }
    }

    $('.token-input').on('keyup', function (e) {
        if (e.keyCode == key_codes.DOWN) {
            focusNextItem()
            $(this)[0].selectionStart = $(this)[0].selectionEnd = $(this).val().length;
            return false;
        } else if (e.keyCode == key_codes.UP) {
            focusPrevItem()
            $(this)[0].selectionStart = $(this)[0].selectionEnd = $(this).val().length;
            return false;
        } else if (e.keyCode == key_codes.ENTER) {
            selectChange()
            return false;
        }
        return false;
    })

    var addToken = function (li) {
        $('.token-input').val('')
        $(options.inputSelectorForName).tokenfield(
            'createToken',
            {
                value: $(li).attr('data-id'),
                label: $(li).find('.contact-name').html()
            }
        );
        $('.open').removeClass('open')
    }

    var searchPopUp = function (elementUl, text) {
        searchByName(elementUl, text)

        var tokens = $(options.inputSelectorForName).tokenfield('getTokens')

        elementUl.find('.one-contact').each(function () {
            var li = $(this)
            var sel = 'tr[data-select-id="' + $(this).attr('data-id') + '"]'
            var table = $(elementUl).closest('table')
            if (table.find(sel).length !== 0) {
                li.hide()
                if (li.closest('.letter-block').find('li:visible').length == 0) {
                    li.closest('.letter-block').hide()
                }
            }

            $(tokens).each(function () {
                if (li.attr('data-id') == this.value) {
                    li.closest('li').hide()
                    if (li.closest('.letter-block').find('li:visible').length == 0) {
                        li.closest('.letter-block').hide()
                    }
                }
            })
        })
    }
}


jQuery.fn.searchContactButton = function (options, callback) {

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

    $(searchButton).click(function () {
        $(options.parentSelector).slideToggle()
        return false;
    })

    $(options.parentSelector).on('click', 'li.transfer-data', function (e) {
        updateParams(this, options.updateElements, function () {
            $(options.parentSelector).slideToggle()
            return false;
        })
    })

    $(options.parentSelector).on('click', '.account-resourse-cont', function (e) {
        updateParams($(this).parents('li'), options.updateElements, function () {
            $(options.parentSelector).slideToggle()
            return false;
        })
    })

    $(options.parentSelector).on('click', 'li.accout-pay-accordion a', function () {
        var add = true;

        li_selector = $(this).parents('li.accout-pay-accordion')

        if ($(li_selector).hasClass('opened')) {
            add = false
        }
        $('li.accout-pay-accordion').removeClass('opened').removeClass('open')
        if (add) {
            if (!$(li_selector).hasClass('uploaded')) {
                gettransfers($(li_selector))
            }
            $(li_selector).addClass('opened').addClass('open')
        } else {
            $(li_selector).removeClass('opened').removeClass('open')
        }
        return false;
    })

    var gettransfers = function (liObj) {
        backgroundBlack()
        $.ajax({
            url: options.url,
            success: function (response) {
                liObj.addClass('uploaded')
                if (response.success) {
                    liObj.find('.pay-list.list-unstyled').html(response.html)
                }
            },
            cache: false,
            data: {
                qAccountNumber: liObj.attr('data-number'),
                qAccountEType: liObj.attr('data-account-type')
            },
            dataType: 'json',
            complete: dellBackgroundBlack,
            type: 'GET'
        });
    }

    $(options.searchLineSelector).on('keyup',function (e) {
        if (pressTimeout) clearTimeout(pressTimeout);
        var code = e.which;
        if (code == 13) {
            getContactList()
        } else {
            pressTimeout = setTimeout(getContactList, 1000);
        }
    }).next('a').on('click', function (e) {
        getContactList()
        return false;
    })


    var getContactList = function () {
        if (!options.url) {
            return false;
        }
        //backgroundBlack()
        $.ajax({
            url: options.url,
            success: function (response) {
                if (response.success) {
                    $("#contactsList").html(response.html);
                    $("#contactsList").slideDown();
                } else {
                    $("#contactsList").slideUp().html('');
                }
                alphabetEach()
            },
            cache: false,
            data: {qname: el_input.val()},
            dataType: 'json',
            //complete : dellBackgroundBlack,
            type: 'GET'
        });
    }
}

var clientListSearchTransfers = function (options, callback) {

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

    $(options.qholder + ',' + options.qnumber).on('keyup', function (e) {
        if (pressTimeout) clearTimeout(pressTimeout);
        var code = e.which;
        var element = this
        if (code == 13) {
            getContactList(element)
        } else {
            pressTimeout = setTimeout(getContactList, 1000);
        }
    })


    var getContactList = function (element) {

        if (!options.url) {
            return false;
        }

        var data = {qholder: $(options.qholder).val(), qnumber: $(options.qnumber).val()}

        //backgroundBlack()
        $.ajax({
            url: options.url,
            success: function (response) {
                if (response.success) {
                    $("#contactsList-searchTransfers").parent().show()
                    $("#contactsList-searchTransfers").html(response.html)
                } else {
                    $("#contactsList-searchTransfers").parent().hide()
                }
            },
            cache: false,
            data: data,
            dataType: 'json',
            //complete : dellBackgroundBlack,
            type: 'GET'
        });
    }

    $('#contactsList-searchTransfers').on('click', 'li', function (e) {
        updateParams(this, options.updateElements, function () {
            $("#contactsList-searchTransfers").parent().hide()
        })
    })
};

var updateParams = function (element, datas, callback) {
    el = $(element)
    jQuery.each(datas, function (i, val) {
        if (el.attr(i)) {
            $(val).val(el.attr(i))
        }
    });
    if (callback) {
        callback()
    }
}

var clickCheckboxContacts = function (row){
    var row = $(row).closest('li')
    if(row.find('.modal-galka-checkbox').hasClass('active')){
        row.find('.modal-galka-checkbox').removeClass('active');
        row.find('.modal-galka-checkbox input').attr('checked', false);
    } else{
        row.find('.modal-galka-checkbox').addClass('active');
        row.find('.modal-galka-checkbox input').attr('checked', true);
    }
}