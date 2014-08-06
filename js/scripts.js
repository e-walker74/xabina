function fontScale(scale) {
    if (scale == 1)
        $('body').css({'font-size': '100%'});
    if (scale == 1.25)
        $('body').css({'font-size': '107.2%'});
    if (scale == 1.5)
        $('body').css({'font-size': '114.3%'});
}

$.fn.extend({
    limiter: function (limit, elem) {
        $(this).on("keyup focus", function () {
            setCount(this, elem);
        });
        function setCount(src, elem) {
            var chars = src.value.length;
            if (chars > limit) {
                src.value = src.value.substr(0, limit);
                chars = limit;
            }
            elem.html(chars);
        }

        setCount($(this)[0], elem);
    }
});

var onCustomSelectChange = function () {
    $(this).prev('span').text($(this).find(':selected').text());
}

var setAllSelectedValues = function () {
    $('.select-invisible').each(onCustomSelectChange);
}

$(function () {

    /* balance index chenge currency on accounts table */
    changeCurrency = function () {
        $('.total_currencies span').hide()
        $('.total_currencies span.' + $('.currency_dropdown').text()).show()
    }

    if ($('.currency_dropdown').length != 0)
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

    setAllSelectedValues()

    $('.tooltip-icon').tooltip({
        tooltipClass: 'xabina-tooltip',
        placement: 'right',
        position: {
            my: "left+25 top-12",
            at: "right top",
            using: function (position, feedback) {
                $(this).css(position);
                $("<div>")
                    .addClass("tooltip-arrow")
                    .addClass(feedback.vertical)
                    .addClass(feedback.horizontal)
                    .appendTo(this);
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

    $('#steps').on('click', '.remove-file.on-success', function () {
        block = $(this).parents('.file-row')
        backgroundBlack()
        $.post(window.location.href, {deleteFile: $(this).parents('.file-row').find('input').val()}, function () {
            block.remove()
            dellBackgroundBlack()
        })

    })

    $("[name=phone]").on('focus', function () {
        !$(this).val() && $(this).val('+');
    });
    $("[name=phone]").on('input', function () {
        !~($(this).val().indexOf('+')) && $(this).val('+' + $(this).val());
    });
    $(document).on('focus', 'input', function () {
        $(this)
            .removeClass('input-error')
            .closest('.form-input')
            .removeClass('input-error')
            .find('.error-message').slideUp()
    })


    // progressbar styling

    $('.xabina-progress-bar .current').prev().addClass('previous');

    /**
     * Потсветка левого меню в виджете
     */
    $('.sidebar-menu.list-unstyled li').each(function (i, e) {
        var my_href;
        my_href = $(e).find('a').attr('href');
        if (my_href == window.location.origin + window.location.pathname) {
            $(e).parents('ul').show()
            if ($(e).parents('ul').prev('li')) {
                $(e).parents('ul').prev('li').addClass('active');
            }
            $(e).addClass('active');
            return;
        }
    });

    /**
     * Left menu slide down
     */
    $('.sidebar-menu a.with-menu').click(function () {
        if ($(this).attr('href') != window.location.origin + window.location.pathname) {
            $('.sidebar-menu ul').slideUp('slow')
            $(this).parents('li').next('ul').slideDown('slow')
        }
        return false
    })

    /**
     * Заполнение емейлов
     */
    save_datas = function (url, button) {
        // удаляем  клонированные tr если на них есть класс remove
        $(".line-template.remove").remove();
        backgroundBlack()
        var form = $(button).parents('form');
        $.ajax({
            url: url,
            success: function (data) {
                dellBackgroundBlack()
                var response = $.parseJSON(data);
                if (response.success) {
                    $(window).unbind('beforeunload')
                    $("#user_datas").html(response.html);
                    reset_values(form);
                }
                else {
                    //form.find("input").parent().addClass("valid")
                    //form.find("input").next(".validation-icon").fadeIn();
                    $.each(response, function (k, val) {
                        $("#user_datas #" + k + "_em_").text(val);
                        $("#user_datas #" + k + "_em_").show();
                    });
                }
            },
            cache: false,
            data: form.serialize(),
            type: 'POST'
        });
    }

    /**
     * Контроллер Personal
     * Временное заполенение таблицы данными о юзере
     */
    add_temp_user_datas = function (url, button) {
        backgroundBlack()
        var form = jQuery(button).parents("form");
        //alert(form.attr('id'));
        $.ajax({
            url: url,
            success: function (data) {
                dellBackgroundBlack()
                $(window).bind('beforeunload', function () {
                    return 'Are you sure you want to leave this page? All the changes will not be saved.';
                });

                var response = $.parseJSON(data);
                if (response.success) {

                    var form_values = [];
                    var select_texts = [];

                    form.find("input:not(:hidden)").each(function (index, element) {
                        var v = $(element).data("v");
                        form_values[v] = $(element).val();

                    });

                    form.find("select").each(function (index, element) {
                        var v = $(element).data("v");
                        form_values[v] = $(element).val();
                    });

                    form.find("select option:selected").each(function (index, element) {
                        var v = $(element).parent("select").data("v");
                        select_texts[v] = $(element).text();
                    });


                    var line_template = $(".line-template:hidden").clone(line_template);
                    line_template.show().addClass("cloned");

                    line_template.find("td.item").each(function (index, element) {

                        var td_item_text = $.trim($(element).html());

                        var arr_td_item_text = td_item_text.split(',');

                        //console.log(arr_td_item_text);

                        for (var i = 0; i < arr_td_item_text.length; i++) {
                            if (select_texts[arr_td_item_text[i]] != undefined) {
                                arr_td_item_text[i] = select_texts[arr_td_item_text[i]];
                            }
                            else {
                                arr_td_item_text[i] = form_values[arr_td_item_text[i]];
                            }

                            if (form_values[arr_td_item_text[i]] != undefined) {
                                arr_td_item_text[i] = form_values[arr_td_item_text[i]];
                            }
                        }

                        td_item_text = $.trim(arr_td_item_text.join('<br>'));
                        $(element).html(td_item_text)

                    });

                    line_template.find("input.item:hidden").each(function (index, element) {
                        var v = $(element).data("v");
                        $(element).val(form_values[v]);
                    });

                    $(".line-template:last").after(line_template);
                    reset_values(form);


                } else {
                    form.find("input").parent().addClass("valid")
                    form.find("input").next(".validation-icon").fadeIn();
                    $.each(response, function (key, value) {
                        $("#" + key).removeClass("valid");
                        $("#" + key).parent().removeClass("valid");
                        $("#" + key).addClass("input-error");
                        $("#" + key).parent().addClass("input-error");
                        $("#" + key).next(".validation-icon").fadeIn();
                        $("#" + key + "_em_").slideDown();
                        $("#" + key + "_em_").html('' + value);
                    });
                }
            },
            cache: false,
            data: form.serialize(),
            type: 'POST'
        });
    }

    /**
     * Контроллер Personal
     * Сброс значений полей формы
     */
    function reset_values(form) {
        $(form)[0].reset();
        //$(form).val('');
        //form.find("span.select-custom-label").text(form.find("select option:first").text());
        form.find("span.select-custom-label").text("Choose");
        return true;
    }

    $('.main-container').on('click', '.xabina-alert .close-button', function () {
        var url = $(this).attr('data-del-alert')
        var element = $(this).parents('.xabina-alert')
        $.ajax({
            url: url,
            success: function (data) {
                var response = jQuery.parseJSON(data);
                if (response.success) {
                    element.remove()
                }
            },
            cache: false,
            data: {success: true},
            type: 'GET'
        });
    })

    uploadFile = function (button) {
        backgroundBlack()
        var form = jQuery(button).parents('form')
        $.ajax({
            url: form.attr('action'),
            success: function (data) {
                dellBackgroundBlack()
                var response = jQuery.parseJSON(data);
                if (response.success) {
                    form.addClass('success')
                } else {
                    form.removeClass('success')
                    form.find("input").parent().addClass("valid")
                    form.find("input").next(".validation-icon").fadeIn();
                    $.each(response, function (key, value) {
                        $("#" + form.attr("id") + " #" + key).removeClass("valid");
                        $("#" + form.attr("id") + " #" + key).parent().removeClass("valid");
                        $("#" + form.attr("id") + " #" + key).addClass("input-error");
                        $("#" + form.attr("id") + " #" + key).parent().addClass("input-error");
                        $("#" + form.attr("id") + " #" + key).next(".validation-icon").fadeIn();
                        $("#" + form.attr("id") + " #" + key + "_em_").slideDown();
                        $("#" + form.attr("id") + " #" + key + "_em_").html('' + value);
                    });
                }
            },
            cache: false,
            async: false,
            data: form.serialize(),
            type: 'POST'
        });
    }

    saveEditName = function (url, button) {
        var forms = jQuery(document).find('form')
        $.each(forms, function (key, value) {
            if (!$(value).hasClass("success")) {
                $(value).find(".violet-button-slim").click()
            }
        })
        var success = true;
        $.each(forms, function (key, value) {
            if (!$(value).hasClass("success")) {
                success = false
            }
        })
        if (success) {
            backgroundBlack()
            $.ajax({
                url: url,
                success: function (data) {
                    dellBackgroundBlack()
                    var response = jQuery.parseJSON(data);
                    if (response.success) {
                        $(document).find("input").parent().addClass("valid")
                        $(document).find("input").next(".validation-icon").fadeIn();
                        $('.xabina-alert').hide('slow');
                        $('.form-validable').hide('slow');
                        $('.form-submit').hide();
                        $('.xabina-alert-success').slideDown();
                    } else {

                    }
                },
                cache: false,
                data: {success: true},
                type: 'POST'
            });
        }
    }

    $('.advanced-button').on('click', function (e) {
        e.preventDefault();
        var advancedForm = $('.advanced-search-form');
        advancedForm.slideToggle();
    });

    searchTransactions = function (button) {
        var form = $(button).parents('form');
        backgroundBlack();
        $.ajax({
            url: form.action,
            success: function (data) {
                var response = jQuery.parseJSON(data);
                if (response.success) {
                    $('.transaction-table-overflow').html(response.html)
                }
                form.find('.refresh-button').fadeOut();
            },
            complete: dellBackgroundBlack,
            cache: false,
            data: form.serialize(),
            type: 'GET'
        });
    }

    downloadPdf = function (e) {
        form = $('#searchForm')
        url = form.attr('data-' + e.target.innerText.toLowerCase() + '-url') + "?" + form.serialize();
        window.open(url)
    }


    resendActivationEmail = function (url, link) {
        $.ajax({
            url: url,
            success: function (response) {
                if (response.success) {
                    successNotify(response.titleMess, response.message, link)
                }
            },
            dataType: 'json',
            cache: false,
            data: {},
            type: 'POST'
        });
    }

    deleteRow = function (link, callback, parentTag) {
        if (!parentTag) {
            var parentTag = 'tr';
        }
        backgroundBlack();
        $.ajax({
            url: $(link).attr('data-url'),
            success: function (data) {
                dellBackgroundBlack();
                var response = jQuery.parseJSON(data);
                if (response.success) {

                    if (response.message) {
                        successNotify(response.mesTitle, response.message, link, 'success', 80);
                    }

                    if ($(link).parents(parentTag).prev(parentTag).hasClass('email-comment-tr')) {
                        $(link).parents(parentTag).prev(parentTag).remove();
                    }
                    $(link).parents(parentTag).remove();

                    if (response.reload) {
                        location.reload();
                    }
                }
                if (callback) {
                    callback(response);
                }

            },
            cache: false,
            data: {},
            type: 'POST'
        });
    }


    /**
     * Удаление сообщений
     */
    del_message = function (url, el, msg) {
        if (!confirm(msg)) {
            return;
        }
        $.ajax({
            url: url,
            success: function (data) {
                //alert(data);
                var response = $.parseJSON(data);
                if (response.success) {
                    $(el).parents('tr').fadeOut(100);
                }
                else {
                    alert('Can not be removed');
                }
            },
            cache: false,
            type: 'GET'
        });
    }

    $(document).on('click', '.checkbox-custom label', function (e) {
        if ($(this).find('input[type="checkbox"]').prop('checked')) {
            $(this).addClass('checked');
            e.stopPropagation();
        } else {
            $(this).removeClass('checked');
            e.stopPropagation();
        }
    });

});

var bindDeleteConfirmationEvent = function(){
    $('.btn-group.with-delete-confirm').on({
        "hide.bs.dropdown": function (e) {
            var opened = $(this).find('.delete.opened')
            if (opened.length !== 0) {
                opened.removeClass('opened')
                return false;
            }
        }
    });
}

function printDiv(divName) {
    window.print();
}

$(document).ready(function () {

    $(".xabina-tabs , .edit-tabs").tabs({
        select: function (event, ui) {
            window.location.hash = ui.tab.hash;
        }
    });

    $('.main-container').on('click', '.clickable-row', function () {
        url = $(this).attr('data-url')
        window.location.href = url
    })

//	if($('.calendar-input').length != 0)
//	$(".calendar-input").datepicker({
//		showOn:"button",
//		buttonImage: '/images/calendar_ico.png',
//		buttonImageOnly:true
//	});

    $('select.language-select').on('change', function () {
        window.location.href = $(this).val()
    })

    $('.recurrence-select').on('click', 'a', changeRecurrenceForm);

    $('.recurrence-form').find('input').attr('disabled', 'disabled')
    $('.recurrence-form').find('select').attr('disabled', 'disabled')

    function changeRecurrenceForm(e) {
        e.preventDefault();
        $(this).parents('.recurrence-form').find('input').attr('disabled', 'disabled')
        $(this).parents('.recurrence-form').find('select').attr('disabled', 'disabled')
        if ($(this).hasClass('one-time')) {
            $(this).parents('.recurrence-select').find('.active').removeClass('active');
            $(this).addClass('active');
            $(this).parents('.recurrence-form').find('.one_time_form').find('input').removeAttr('disabled')
            $(this).parents('.recurrence-form').find('.one_time_form').find('select').removeAttr('disabled')
            $(this).parents('.recurrence-form').find('.one_time_form').show();
            $(this).parents('.recurrence-form').find('.standing-form').hide();
        } else if ($(this).hasClass('standing')) {
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

    if ($('form .with_datepicker, .calendar-input').length != 0)
        $("form .with_datepicker, .calendar-input").datepicker({
            showOn: "both",
            buttonImage: '/images/calendar_ico.png',
            buttonImageOnly: true,
            dateFormat: 'dd.mm.yy'
        }).inputmask("d.m.y")

    if ($('#bg-404-gold').length) {
        $('#bg-404-gold').plaxify({"xRange": 30, "yRange": 30});
        $.plax.enable();
    }

//	if($('.calendar-input, .with_datepicker').length)
//    $(".calendar-input, .with_datepicker").datepicker({
//        showOn:"button",
//        buttonImage: '/images/calendar_ico.png',
//        buttonImageOnly:true
//    });
//    if($('.calendar-input-2').length)
//    $(".calendar-input-2").datepicker({
//        showOn:"button",
//        buttonImage: '/images/calendar_ico_2.png',
//        buttonImageOnly:true
//    });

    /*if($('input.button-find').length)
     $(document).keyup(function(event){
     if(event.keyCode == 13){
     $("input.button-find").click();
     }
     });*/

    if ($('.download-button').length != 0)
        $('.download-button').tempDropDown({
            list: {
                PDF: {
                    id: 'pdf',
                    name: 'PDF',
                    class: 'PDF'
                },
                DOC: {
                    id: 'doc',
                    name: 'DOC',
                    class: 'DOC'
                },
                CSV: {
                    id: 'csv',
                    name: 'CSV',
                    class: 'XLS'
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

    if ($('#addNotes').length != 0) {
        $('#addNotes').on('submit', function (ev) {
            var data = $('#addNotes').serialize();
            backgroundBlack()
            $.post($('#addNotes').attr('action'), data, function (data) {
                dellBackgroundBlack()
                if (data.success) {
                    $('#notes-list').html(data.html)
                    $('html, body').animate({
                        scrollTop: $("#notes-list").offset().top - 50
                    }, 500);
                }
                $('#addNotes')[0].reset()
            }, 'json')

            return false;
        });
    }

    if ($("#notes-list"))
        $("#notes-list").on('click', '.delete', function () {
            var link = $(this)

            if (!confirm(link.attr('data-confirm-text'))) {
                return false;
            }

            $.ajax({
                type: "POST",
                url: link.attr('href'),
                success: function (data) {
                    if (data.success) {
                        link.parents('li').remove()
                    }
                },
                dataType: 'json'
            });
            return false;
        })

    if ($("#transaction-category-select"))
        $("#transaction-category-select").change(function () {
            var value = $(this).val();
            var $el = $(this);
            $.ajax({
                type: "POST",
                url: $el.attr('data-url'),
                data: {category: value},
                dataType: 'json',
                success: function (res) {
                    if (res.success) {
                        $el.siblings('.select-custom-label').html($el.find('option[selected]').html());
                    }
                }
            });
            //		return false;
        })

    $(".escape-dialog").dialog({
        autoOpen: false,
        appendTo: '#top_container .clearfix',
        dialogClass: 'xabina-popup-alerts',
        height: 'auto',
        minHeight: 0,
        position: {
            my: 'right top',
            at: 'right bottom',
            of: ".user-logout"
        },
        show: 'fadeIn',
        resizable: false
    });

    $(".user-logout").click(function () {
        var $dialog = $(".escape-dialog");
        $dialog.dialog("option", "width", $(this).parents('.clearfix').width());
        $dialog.dialog("open");
        return false;
    });
    $('.xabina-dialog .no').click(function () {
        $(this).parents('.xabina-dialog').dialog('close');
        return false;
    });
    $('.xabina-dialog .yes').click(function () {
        var link = $(this).parents('a')
        return deleteTransaction(link)
    });

    $(".remove-dialog").dialog({
        autoOpen: false,
        dialogClass: 'xabina-popup-alerts',
        height: 'auto',
        minHeight: 0,
        show: 'fadeIn'
    });

    if ($('.remove-with-dialog').length != 0)
        $('.remove-with-dialog').click(function () {
            var $dialog = $(".remove-dialog");
            $dialog.dialog("option", "appendTo", $(this));
            $dialog.dialog("option", "width", $(this).parents('.xabina-form-container').width());
            $dialog.dialog("option", "position", {
                my: 'right+11 top+15',
                at: 'right bottom',
                of: $(this)
            });
            $dialog.dialog("open");
            return false;
        })

    $('textarea.autosize').autosize();

    var edit = false;

    $('.xabina-table-personal input[type=text], .xabina-table-personal input[type=password], .xabina-table-personal textarea, .xabina-table-personal select').change(function () {
        if (edit == false) {
            edit = true
            $(window).bind('beforeunload', function () {
                return 'Are you sure you want to leave this page? All the changes will not be saved.';
            });
        }
    })

    $('form').on('submit', function () {
        $(window).unbind('beforeunload')
    })

    $('.bank-swift').change(function () {
        var swift_input = $(this)
        var bank_name_input = $(this).parents('form').find('.bankinfo-name')
        $.ajax({
            url: swift_input.attr('data-url'),
            success: function (response) {
                if (response.success) {
                    bank_name_input.val(response.name)
                } else {
                    bank_name_input.val('')
                }
            },
            cache: false,
            async: false,
            data: {bic: swift_input.val()},
            type: 'POST',
            dataType: 'json'
        });
    })

    $(document).on('keypress', '.numeric', function (e) {
        if (
            e.keyCode < 48 || e.keyCode > 57
            ) {
            return false;
        }
    })

    $(document).on('keyup', '.phone',function () {
        if (!$(this).val()) {
            $(this).val('+');
        }
    }).on('input', '.phone', function () {
        if (!~($(this).val().indexOf('+') )) {
            $(this).val('+' + $(this).val());
        }
    }).on('focus', '.phone', function(){
        if (!$(this).val()) {
            $(this).val('+');
        }
    });

    bindDeleteConfirmationEvent()

    $('.tab').on('click', '.dropdown-toggle', function () {
        $(this).toggleClass('closed');

        $(this).hasClass('closed') ?
            $(this).html('<span>' + $(this).data('closed-text') + '</span>') :
            $(this).html('<span>' + $(this).data('opened-text') + '</span>');
        $(this).parents('.dropdown-list-cont').find('.list-dropdown-toggle').slideToggle();
        return false;
    })

//    $('#withDeleteConfirm').on('hide.bs.dropdown', function (event) {
//        pop = $(event.target).find('.popover:visible')
//        if($(event.target).find('.popover').length !== 0){
//            return false;
//        }
//    })

})

var cancelPage = function () {
    $(window).unbind('beforeunload')

    /* name page */
    $(document).find('.edit-doc').hide()
    $(document).find('.not-edit-doc').show()

    /* phones page */
    $(document).find('.prof-form').hide()
    $(document).find('.add-new-td').parents('tr').show()

    /* addresses page */
    $('.address-tr').show();
    $('.edit-address-tr').hide();
    $('.add-new-td').parent().show()
    $('.prof-form').hide()

    /* pins page */
    $('.transaction-buttons-cont .edit').show()
    $('.edit-form').hide()

    /* settings page */
    $('.edit-block').hide();
    $('.user-settings-data').show();

    $('form').trigger('reset')

    /*$('form select').each(function( index ) {
     $(this).parents('.select-custom').find('.select-custom-label').html($(this).find('option:selected').text())
     })*/

//    $('.checkbox-custom label').removeClass('checked')

    /* new transfer page */
    $('.quick-row-edit').hide()
    $('.quick-row').show()
}

var resetPage = function () {

    $(window).unbind('beforeunload')

    /* name page */
    $(document).find('.edit-doc').hide()
    $(document).find('.not-edit-doc').show()

    /* phones page */
    $(document).find('.prof-form').hide()
    $(document).find('.add-new-td').parents('tr').show()

    /* addresses page */
    $('.address-tr').show();
    $('.edit-address-tr').hide();
    $('.add-new-td').parent().show()
    $('.prof-form').hide()

    /* pins page */
    $('.transaction-buttons-cont .edit').show()
    $('.edit-form').hide()

    /* settings page */
    $('.edit-block, tr.edit-row').hide();
    $('.user-settings-data, tr.data-row').show();

    $('form').trigger('reset')

    /*$('form select').each(function( index ) {
     $(this).parents('.select-custom').find('.select-custom-label').html($(this).find('option:selected').text())
     })*/

//    $('.checkbox-custom label').removeClass('checked')

    /* new transfer page */
    $('.quick-row-edit').hide()
    $('.quick-row').show()

    /* quic upload */
    $('.row-edit').hide().prev('li').show()

    if ($('.ui-pnotify').is(":visible")) {
        $('.ui-pnotify').fadeOut()
    }
}

$(document).on('click', '.button.cancel', function () {
    resetPage()
})

var successNotify = function (title, message, element, type, top) {

    if (!top) {
        top = 40
    }

    if (element && element.length != 0) {
        var stack_context = {
            "dir1": "down",
            "dir2": "left",
            "firstpos2": 15,
            "firstpos1": $(element).offset().top - $('.col-lg-9.col-md-9.col-sm-9:first').offset().top - top,
            context: $('.col-lg-9.col-md-9.col-sm-9:first')
        };
    } else if ($('.h1-header').length != 0) {
        var stack_context = {"dir1": "down", "dir2": "left", "firstpos1": 0, "firstpos2": 15, "firstpos1": $('.h1-header:first').position().top - 40, context: $('.h1-header:first')};
    } else {
        var stack_context = {"dir1": "down", "dir2": "left", "firstpos1": 0, "firstpos2": 0, context: $('.top-bar .container .clearfix')};
    }
    if (!type) {
        type = 'success'
    }
    $.pnotify(
        {
            /*title: title,*/
            text: message,
            type: type,
            delay: 3000,
            width: $('.col-lg-9').width() + 'px',
            stack: stack_context,
            history: false,
            mouse_reset: false
        });

    $('html').one('click', function () {
        if (!$(event.target).closest('.ui-pnotify').length) {
            if ($('.ui-pnotify').is(":visible")) {
                $('.ui-pnotify').fadeOut()
            }
        }
    })

}

var errorNotify = function (title, message, element) {

    if (element) {
        var stack_context = {
            "dir1": "down",
            "dir2": "left",
            "firstpos2": 15,
            "firstpos1": $(element).offset().top - $('.col-lg-9.col-md-9.col-sm-9').offset().top - 40,
            context: $('.col-lg-9.col-md-9.col-sm-9')
        };
    } else if ($('.h1-header').length != 0) {
        var stack_context = {"dir1": "down", "dir2": "left", "firstpos1": 0, "firstpos2": 15, "firstpos1": $('.h1-header:first').position().top - 40, context: $('.h1-header:first')};
    } else {
        var stack_context = {"dir1": "down", "dir2": "left", "firstpos1": 0, "firstpos2": 0, context: $('.top-bar .container .clearfix')};
    }
    $.pnotify({ /*title: title,*/ text: message, type: 'error', delay: 3000, width: $('.col-lg-9').width() + 'px', stack: stack_context, history: false});

}

/*
 $(document).bind("ajaxSend", function(){
 backgroundBlack()
 }).bind("ajaxComplete", function(){
 dellBackgroundBlack()
 });
 */

var backgroundBlack = function () {

    if (!jQuery("body").find("#TB_overlay").is("div")) /* если фон уже добавлен не добавляем повторно */
    {
        if (!jQuery.browser.msie) /* если браузер не ИЕ фоном будет div */
            jQuery("body").append("<div id='TB_overlay' style='z-index: 99999999'><div class='wait-ico'></div></div>");
        else /* иначе добавляем iframe */
            jQuery("body").append("<div id='TB_overlay'><iframe scrolling='no' frameborder='0' style='position: absolute; top: 0; left: 0; width: 100%; height: 100%; filter:alpha(opacity=0)'></iframe></div>");
    }
    var centerWidth = ($(window).width()) / 2,
        centerHeight = ($(window).height()) / 2;
    $('body').css({overflow: 'hidden'})
    $('body').addClass('withoutScroll');

    $("#TB_overlay").fadeIn("fast");

}

var dellBackgroundBlack = function () {
    $("#TB_overlay").remove();
    $('body').css({overflow: 'auto'})
    $('body').removeClass('withoutScroll');
}

var chechSequrityValuesData = function () {
    $('#Users_Securityquestions_question_id option').show().prop('disabled', false);
    $('.question-row').each(function () {
        $('#Users_Securityquestions_question_id option[value=' + $(this).attr('data-value') + ']').hide().prop('disabled', true);
    })
    $('#Users_Securityquestions_question_id option:not(:disabled)').first().attr('selected', true)
    $('form .select-custom-label').html($('#Users_Securityquestions_question_id option:selected').html())

};


/* add new category */
$(function () {
    var block = $('#category-block'),
        cancelEdit = function () {
            block.find('div.non-edit-doc').show();
            block.find('div.edit-doc').hide();
            $('#category-title').val('')
                .next('.error-message').html('').hide();
        };

    block.on('click', '.button.edit', function (e) {
        e.preventDefault();
        block.find('div.non-edit-doc').hide();
        block.find('div.edit-doc').show();
    });

    block.on('click', '.button.ok', function (e) {
        e.preventDefault();
        backgroundBlack();
        var $title = $('#category-title'),
            $errorBox = $title.next('.error-message');
        $errorBox.html('').hide();
        $.ajax({
            url: $title.data('url'),
            data: {title: $title.val()},
            type: 'post',
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    successNotify('Transaction category', res.message);
                    block.find('#transaction-category-select')
                        .append('<option value="' + res.data.id + '">' + res.data.title + '</option>')
                        .val(res.data.id).trigger('change');
                    cancelEdit();
                } else {
                    $errorBox.html(res.message.title.join('<br>')).slideDown('slow');
                }
            },
            complete: dellBackgroundBlack
        });
    });

    block.on('click', '.button.cancel', function (e) {
        e.preventDefault();
        cancelEdit();
    });


    cancelEdit();
});

var change_click_button = function (input) {
    $('.clicked-button').removeClass('clicked-button')
    $(input).addClass('clicked-button');
}

function nospaces(str) {
    var VRegExp = new RegExp(/(\s|\u00A0)+/g);
    var VResult = str.replace(VRegExp, '');
    return VResult
}

// Rbac accounts switcher
$(document).ready(function () {
    $("#rbac-accounts-switcher-form a").on('click', function () {
        $("#rbac-accounts-switcher-form input[name='account']").val($(this).data('uid'));
        $("#rbac-accounts-switcher-form").submit();
        return false;
    });
});


$(function () {

    $('.details-accordion').accordion({
        heightStyle: "content",
        active: 0,
        collapsible: true
    });

    $('.show-users').accordion({
        heightStyle: "content",
        active: 1,
        collapsible: true
    });

    $('.xabina-accordion').accordion({
        heightStyle: "content",
        active: false,
        collapsible: true
    });

    $('.select-img').on('click', '.img-dropdown a', function(e){
        var $context = $(e.delegateTarget);
        var status = $(this).data('id');
        var imgSrc = $(this).find('img').attr('src')
        $context.find('.selected-img img').attr('src', imgSrc);
        e.preventDefault();

        $.ajax({
            url: '/ajax/SetUserActivityStatus/',
            data: {status: status},
            type: 'Post',
            cache: false,
            success: function(){
                $('.self-activity-status').attr('src', imgSrc)
            }
        })
    });
    $('.select-img .selected-img img').attr('src', $('.img-dropdown img[data-selected="selected"]').attr('src'));

    $('.sidebar-menu').on('click', '> li', function(){
        if($(this).next('.sidebar-submenu').length){
            if($(this).next('.sidebar-submenu:visible').length){
                $(this).next('.sidebar-submenu').toggleClass('inv').slideUp(400, function(){
                    $(this).prev().toggleClass('active');
                });
            } else{
                $(this).next('.sidebar-submenu').toggleClass('inv').slideDown();
                $(this).toggleClass('active');
            }

            return false;
        }

    })
});
