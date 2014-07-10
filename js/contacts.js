$(document).ready(function () {
    $(".xabina-tabs , .edit-tabs").tabs({

    });

    $('#analytics-form').on('change', 'input, select', function () {
        searchAnalytics($('#analytics-form'))
    })

    $('.edit-tabs.inner-tabs, .xabina-table-contacts, .xabina-form-container').on('click', '.button.edit, .upload.add-more', function () {
        resetPage()

        $(this).parents('tr').hide().next('.edit-row').show()
        return false;
    })

    $('#Users_Contacts_photo').on('change', function () {
        var name = $(this).val().split(/(\\|\/)/g).pop()
        $(this).parents('.file-label').find('.filename').html(name)
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
        } else console.log('not isset files data or files API not supordet');
    })

    $('.delete-photo').click(function () {
        $(this).find('input[type=hidden]').val(1)
        $('#image-mini').hide()
        $(this).hide();
        return false;
    })

    $('.account_type_fields').hide()
    $('.account_type_fields.selected').show()

    $('.accout_type_select').on('change', function () {
        var form = $(this).parents('form')
        form.find('.account_type_fields').hide()
        form.find('.account_type_fields.data_' + $(this).val()).show()
    })

    $('.select-img').on('click', '.img-dropdown a', function (e) {
        var $context = $(e.delegateTarget);
        $context.find('input[type=hidden]').val($(this).data('id'));
        updateInputSocNet($context.find('input[type=hidden]'))
        $context.find('.selected-img img').attr('src', $(this).find('img').attr('src'));
        e.preventDefault();
    })

    var getSelectSocialNetforInput = function (input) {
        var select = input.parents('form').find('.socnet-select')
        switch (select.val()) {
            case 'fb':
                return 'https://www.facebook.com/';
            case 'linkedin':
                return 'https://www.linkedin.com/';
            case 'twitter':
                return 'https://twitter.com/';
        }
    }
    var updateInputSocNet = function (select) {
        var input = $(select).parents('form').find('.social-url-input')
        input.val(getSelectSocialNetforInput(input))
    }

    $(".social-url-input").on('focus', function () {
        if (!$(this).val()) {
            $(this).val(getSelectSocialNetforInput($(this)));
        }
    });
    $(".social-url-input").on('input', function () {
        if (!~($(this).val().indexOf(getSelectSocialNetforInput($(this))))) {
            $(this).val(getSelectSocialNetforInput($(this)) + $(this).val());
        }
    });

    $('.btn-group.with-delete-confirm').on({
        "hide.bs.dropdown": function (e) {
            var opened = $(this).find('.opened')
            if (opened.length !== 0) {
                opened.removeClass('opened')
                return false;
            }
        }
    });


})

var searchAnalytics = function (form) {
    backgroundBlack()
    $.ajax({
        url: $(form).attr('action'),
        success: function (response) {
            if (response.success) {
                $('.analytics-results').html(response.html)
            }
            dellBackgroundBlack()
        },
        cache: false,
        async: true,
        data: form.serialize(),
        type: 'POST',
        dataType: 'json'
    });
}

var updateContact = function (form) {
    backgroundBlack()
    $.ajax({
        url: $(form).attr('action'),
        success: function (response) {
            if (response.success) {
                dellBackgroundBlack()
                resetPage()
                if (response.html) {
                    var tab = $(form).closest('.tab')
                    tab.html(response.html)
                    setAllSelectedValues()
                    successNotify('Contact', 'Entity was successfully updated', tab.find('tr:visible:last'))
                }
            }
        },
        data: $(form).serialize(),
        type: 'POST',
        dataType: 'json',
        cache: false,
        async: true
    });
}

var makePrimary = function (link) {
    backgroundBlack()
    $.ajax({
        url: $(link).attr('data-url'),
        success: function (response) {
            if (response.success) {
                dellBackgroundBlack()
                resetPage()
                if (response.html) {
                    var tab = $(link).parents('.tab')
                    tab.html(response.html)
                    setAllSelectedValues()
                    successNotify('Contact', 'Entity was successfully updated', tab.find('tr.data-row:visible:first'))
                }
            }
        },
        cache: false,
        async: true,
        data: {},
        type: 'POST',
        dataType: 'json'
    });
}

afterValidate = function (form, data, hasError, callBack) {
    form.find("input").removeClass("input-error");
    form.find("input").parent().removeClass("input-error");
    form.find(".validation-icon").fadeIn();
    for (var i in data.notify) {
        $(form).find("." + i).html(data.notify[i]).slideDown().delay(3000).slideUp();
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
//		if($('.analytics-results').length !== 0){
//			searchAnalytics(form)
//		} else {
//			updateContact(form)
//			return false;
//		}
        if (form.find('input[type="file"]').length === 0) {
            updateContact(form)
        } else {
            uploadContactPhoto(form)
        }
        return false;
    }
    return false;
}

afterValidateAttribute = function (form, attribute, data, hasError) {
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
}

var hideAllSelectedCategories = function () {
    $('.contact-categories-table #Users_Contacts_Categories_Links_category_id option').show()
    $('.contact-categories-table tr').each(function () {
        var cat_id = $(this).attr('data-cat-id')
        $('.contact-categories-table #Users_Contacts_Categories_Links_category_id option[value=' + cat_id + ']').hide()
    })
}

var uploadContactPhoto = function (form) {
    var data = new FormData();
    var formData = form.serializeArray();
    for (var key in formData) {
        obj = formData[key];
        data.append(obj.name, obj.value);
    }
    form.find('input[type="file"]').each(function () {
        var files = this.files;
        var input = this
        $.each(files, function (key, value) {
            if (!value.type.match('image.*')) {
                $(input).closest('.form-cell').find('.error-message').html('file is not an image').slideDown().delay(3000).slideUp()
                return false;
            }
            data.append($(input).attr('name'), value);
        });
    });

    data.append('file-upload', $(form).attr('id'))

    backgroundBlack()

    var oReq = new XMLHttpRequest();
    oReq.open("POST", form.attr('action'), true);

    oReq.onload = function (oEvent) {
        dellBackgroundBlack()
        if (oReq.status == 200) {
            var response = jQuery.parseJSON(oEvent.currentTarget.response)
            if (response.success) {
                dellBackgroundBlack()
                resetPage()
                if (response.html) {
                    var tab = $(form).closest('.tab')
                    tab.html(response.html)
                    setAllSelectedValues()
                    successNotify('Contact', 'Entity was successfully updated', tab.find('tr:visible:last'))
                }
            }
        } else {
            errorNotify('Contact', 'Server error')
        }
    };

    oReq.send(data);

    return false;
}

$(document).ready(function () {

    $('.xabina-form-narrow .contact-categories-table .delete').confirmation({
        title: 'Are you sure?',
        singleton: true,
        popout: true,
        onConfirm: function () {
            deleteRow($(this).parents('.popover').prev('a'));
            hideAllSelectedCategories()
            return false;
        }
    })

    hideAllSelectedCategories()
})

var showAddNewCategory = function (el) {
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
}

var hideCategoryTextField = function (el) {
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
}

var searchTransactionsLinks = function(button){
    var form = $(button).closest('form')
    backgroundBlack()
    $.ajax({
        url: $(form).attr('action'),
        success: function (response) {
            if (response.success) {
                $('#links-table').html(response.html)
            }
            dellBackgroundBlack()
        },
        cache: false,
        async: true,
        data: form.serialize(),
        type: 'POST',
        dataType: 'json'
    });
}