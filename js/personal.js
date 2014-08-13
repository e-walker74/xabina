/**
 * Created by ekazak on 12.06.14.
 * @author evgeniy.kazak@gmail.com
 */

Personal = {
    init: function (options) {

//        this._options = $.extend({}, options)

        this.bindDeleteButton()
        resetPage()
        setAllSelectedValues()
        self = this
    },
    binds: function () {
        this.bindDeleteButton()
        this.bindTooltips()
        bindDeleteConfirmationEvent()
        this.bindEditButtons()
        setAllSelectedValues()
        this.bindCheckbox()
        $('input').change(function () {
            $(window).bind('beforeunload', function () {
                return 'Are you sure you want to leave this page? All the changes will not be saved.';
            });
        })

        $('.btn-group').hover(
            function () {
                $(this).addClass('open')
            },
            function () {
                $(this).removeClass('open')
            }
        )
        input_hide_error_on_focus()
    },
    canChangeForm: function () {
        if ($._data(window, 'events').beforeunload) {
            if (confirm('Are you sure you want to close edit form? All the changes will not be saved.')) {
                $(window).unbind('beforeunload')
            } else {
                return false
            }
        }
        return true
    },
    bindCheckbox: function(){
        $('.checkbox-custom').on('click', 'label', function(e){
            if ($(this).find('input').prop('checked')) {
                $(this).addClass('checked');
                e.stopPropagation();
            } else {
                $(this).removeClass('checked');
                e.stopPropagation();
            }
            $(window).unbind('beforeunload')
        });
    },
    bindEditButtons: function () {
        $('.tab').on('click', '.button.edit, .upload.add-more', function () {
            if(!Personal.canChangeForm()){
                return false;
            }
            resetPage()
            var tr = $(this).closest('tr')
            tr.hide().next('.edit-row').show()
            if(tr.prev().hasClass('note-row')){
                tr.prev().hide();
            }
//            return false;
        })
    },
    bindTooltips: function () {
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
    },
    bindDeleteButton: function () {
        return $(".delete").confirmation({
            title: "Are you sure?",
            singleton: true,
            popout: true,
            onConfirm: function () {

                link = $(this).parents(".popover").prev("a")
                var parent = $(link).parents('.head-ajax-block')
                deleteRow(link, function (response) {
                    if (response.html) {
                        parent.html(response.html)
                    }
//                    if (response.refresh) {
                    Personal.refreshTabs()
//                    }
                    if (response.success) {
//                        successNotify("Personal account", response.message)
                    }
                });
                return false;
            }
        })
    },
    resendSms: function (link) {
        link = $(link)
        $.ajax({
            url: link.attr('href'),
            success: function (response) {
                if (response.success) {
                    successNotify('My phones', response.message, link);
                } else {
                    errorNotify('My phones', response.message, link);
                }
            },
            dataType: 'json'
        })
        return false;
    },
    activatePhone: function (url, link) {
        value = $(link).closest('tr').find('.input-text').val();
        if (!value) {
            var field = $(link).closest('tr').find('.error-message')
            this.showError(field)
            return false;
        }
        backgroundBlack()
        if (value) {
            $.ajax({
                url: url + value,
                success: function (response) {
                    if (response.success) {
                        self.successUpdateTable(response, link)
                    } else {
                        var field = $(link).closest('tr').find('.error-message')
                        Personal.showError(field)
                        dellBackgroundBlack()
                        return false;
                    }

                },
                cache: false,
                data: {},
                type: 'POST',
                dataType: 'json'
            });
        }
    },
    makePrimary: function (url, link) {
        backgroundBlack()
        $.ajax({
            url: url,
            success: function (data) {
                self.successUpdateTable(data, link)
            },
            cache: false,
            data: {},
            type: 'POST',
            dataType: 'json'
        });
    },
    sendForm: function (form) {
        backgroundBlack()
        $.ajax({
            url: $(form).attr('action'),
            success: function (response) {
                self.successUpdateTable(response, form)
            },
            cache: false,
            async: true,
            data: form.serialize(),
            type: 'POST',
            dataType: 'json'
        });
    },
    afterValidate: function (form, data, hasError) {
        form.find("input").removeClass("input-error");
        form.find("input").parent().removeClass("input-error");
        form.find(".validation-icon").fadeIn();
        for (var i in data.notify) {
            this.showError($(form).find("." + i), data.notify[i])
        }
        if (hasError) {
            for (var i in data) {
                $("#" + i).addClass("input-error");
                $("#" + i).parent().addClass("input-error");
                $("#" + i).next(".validation-icon").fadeIn();
            }
            return false;
        }
        else {
            Personal.sendForm(form)
        }
        return false;
    },
    successUpdateTable: function (response, element) {
        var headAjaxBlock = $(element).parents('.tab')
        if (response.success) {
            $(window).unbind('beforeunload')
            if (response.html) {
                headAjaxBlock.html(response.html)
                Personal.binds()
            }
            if (response.reload) {
                this.refreshTabs()
            }
            if(response.reloadWindow){
                window.location.reload()
            }
            if (element.length != 0 && response.message) {
                successNotify('Payment', response.message, element)
            }
        } else {
            if (element.length != 0 && response.message) {
                errorNotify('Payment', response.message, element)
            }
        }
        dellBackgroundBlack()
    },
    afterValidateAttribute: function (form, attribute, data, hasError) {
        if (hasError) {
            if (!$("#" + attribute.id).hasClass("input-error")) {
                $("#" + attribute.id + "_em_").hide().slideDown();
            }
            $("#" + attribute.id).removeClass("valid").parent().removeClass("valid");
            $("#" + attribute.id).addClass("input-error").parent().addClass("input-error");
            $("#" + attribute.id).next(".validation-icon").fadeIn();
        } else {
            if ($("#" + attribute.id).hasClass("input-error")) {
                $("#" + attribute.id + "_em_").show().slideUp();
            }
            $("#" + attribute.id).removeClass("input-error").parent().next("error-message").slideUp().removeClass("input-error");
            $("#" + attribute.id).next(".validation-icon").fadeIn();
            $("#" + attribute.id).addClass("valid");
        }
        for (var i in data.notify) {
            $(form).find("." + i).html(data.notify[i]).slideDown().delay(3000).slideUp();
        }
    },
    showError: function (field, message) {
        if (message) {
            $(field).html(message)
        }
        if (!$(field).is(':visible')) {
            $(field).html(message).slideDown().delay(3000).slideUp();
        }
    },
    getTab: function (url, link) {
        var link = $(link)

        $.ajax({
            url: url,
            success: function (response) {
                if (response.success) {
                    $(link.attr('href')).html(response.html)
                    Personal.binds()
                }
            },
//            async: false,
            cache: false,
            type: 'POST',
            dataType: 'json'
        });
    },
    hideCategoryTextField: function (el) {
        $(el)
            .attr('disabled', true)
            .val('')
            .closest('.form-input')
            .hide()
            .prev('.category-select')
            .show()
            .find('select')
            .attr('disabled', false)
        return false;
    },
    showAddNewCategory: function (el) {
        var select = $(el)
        if (select.val() == 'add') {
            select
                .attr('disabled', true)
                .val(select.prop('defaultSelected'))
                .closest('.form-input')
                .hide()
                .next('.add-new-category')
                .show()
                .find('input')
                .attr('disabled', false)
        }
    },
    createTabs: function () {
        $(".personal-tabs").tabs({
            select: function (event, ui) {
                window.location.hash = ui.tab.hash;
            },
            beforeActivate: function (event, ui) {
                if(!Personal.canChangeForm()){
                    return false;
                }
                var link = ui.newTab.find('a')
                if (link.attr('data-url')) {
                    Personal.getTab(link.attr('data-url'), link)
                }
            },
            create: function (event, ui) {
                var link = ui.tab.find('a')
                if (link.attr('data-url')) {
                    Personal.getTab(link.attr('data-url'), link)
                }
            }
        });
    },
    refreshTabs: function () {
        $(".personal-tabs").tabs("destroy")
        this.createTabs()
    },
    changeFontSize: function (fontSize) {
        switch (fontSize) {
            case '14':
                fontScale(1)
                break;
            case '16':
                fontScale(1.25)
                break;
            case '18':
                fontScale(1.5)
                break;
        }
    },
    bindPayments: function () {
        $('.form-payment .payment_select').change(function () {
            $(this).closest('form').find('.electronic-method-fields').css('display', 'none');
            $(this).closest('form').find('.electronic-method-fields.method-' + $(this).val()).css('display', 'block');
            if ($(this).val()) {
                $(this).closest('form').find('.category-row').css('display', 'block');
            } else {
                $(this).closest('form').find('.category-row').css('display', 'none');
            }
        })
        $('.form-payment .creditcard').each(function () {
            var creditCardField = $(this)
            creditCardField.validateCreditCard(function (result) {
                creditCardField.closest('form').find('.payments-list .logo').removeClass('active');
                creditCardField.closest('form').find('.payments-list input[type=radion]').attr('checked', false);
                if (result.card_type) {
                    creditCardField.closest('form').find('.payments-list .logo.' + result.card_type.css_class).addClass('active');
                    creditCardField.closest('form').find('.payments-list input.' + result.card_type.css_class).attr('checked', true);
                }
            }, {
                accept: ['visa', 'mastercard', 'amex', 'maestro', 'jcb', 'discover', 'union']
            });
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
    },
    bindNewsletterForm: function () {
        $('#newsletter-form input[type=checkbox]').on('change', function () {
            var checkbox = $(this)
            $.ajax({
                url: checkbox.attr('data-url'),
                success: function (response) {
                    if (response.success) {
                        successNotify('Personal', response.message, checkbox);
//                        Personal.refreshTabs()
                    } else {
                        errorNotify('Personal', error, checkbox);
                    }
                },
                data: {value: checkbox.val(), name: checkbox.attr('name')},
                dataType: 'json'
            })
            return false;

        })
    },
    resendSmsForChangeId: function (url) {
        $.ajax({
            url: url,
            success: function (response) {
                if (response.success) {
                    successNotify('Personal', response.message, $("#Users_Ids_compare_confirm_code"));
                } else {
                    errorNotify('Personal', response.message, $("#Users_Ids_compare_confirm_code"));
                }
            },
            dataType: 'json'
        })
        return false;
    },
    bindPhotoChange: function () {
        $('#Users_photo').on('change', function () {
            var name = $(this).val().split(/(\\|\/)/g).pop()
            $(this).closest('.file-label').find('.filename').html(name)
            $('input[type=hidden]').val(0)

            var input = $(this)[0];
            if (input.files && input.files[0]) {
                if (input.files[0].type.match('image.*')) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#image-mini img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                    $('#image-mini').show()
                    $('.delete-photo').show()
                } else {
                    $('#image-mini').hide()
                    $('.delete-photo').hide()
                    console.log('is not image mime type');
                }
            } else {
                console.log('not isset files data or files API not supordet');
                $('#image-mini').hide()
                $('.delete-photo').hide()
            }
        })

        $('.delete-photo').click(function () {
            $(this).find('input[type=hidden]').val(1)
            $(this).closest('.form-input').find('#Users_photo').val('')
            $('#image-mini').hide()
            $(this).hide();
            return false;
        })
    },
    uploadUserPhoto: function (form, data, hasError, callBack) {
        var error = false

        form.find('input[type="file"]').each(function () {
            var files = this.files;
            var input = this
//            if(files.length == 0){
//                $(input).closest('.form-cell').find('.error-message').html('File not selected').slideDown().delay(3000).slideUp()
//                error = true
//                return false;
//            }
            $.each(files, function (key, value) {
                if (!value.type.match('image.*')) {
                    $(input).closest('.form-cell').find('.error-message').html('file is not an image').slideDown().delay(3000).slideUp()
                    error = true
                    return false;
                }
            });
            if (files.length == 0 && $('#Users_delete').val() != 1) {
                $(input).closest('.form-cell').find('.error-message').html('file not selected').slideDown().delay(3000).slideUp()
                error = true
            }
        });

        if (error) {
            return false;
        }

        backgroundBlack()
        var options = {
            url: form.attr('action'),
            type: form.attr('method'),
            dataType: 'json',
            success: function (response) {
                dellBackgroundBlack()
                if (response.success) {
                    resetPage()
                    successNotify('Personal', response.message, form)
                    window.location.reload()
                } else {
                    errorNotify('Personal', response.message, form)
                }
            }
        };
        form.ajaxSubmit(options);
        return false;
    }
}

$(function () {
    Personal.init({});
    Personal.createTabs()
});