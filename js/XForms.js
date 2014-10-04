/**
 * Created by ekazak on 08.09.14.
 */

XForms = {
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
            return true;
        }
        return false;
    },afterValidateAttribute: function (form, attribute, data, hasError) {
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
    showAddNewCategory: function (el) {
        var select = $(el)
        if (select.val() == 'add') {
            select
                .attr('disabled', 'disabled')
                .val(select.prop('defaultSelected'))
                .closest('.form-input')
                .hide()
                .next('.add-new-category')
                .show()
                .find('input')
                .attr('disabled', false)
        }
    },
    hideCategoryTextField: function (el) {
        $(el)
            .closest('.form-input')
            .find('input')
            .attr('disabled', 'disabled')
            .val('')
            .closest('.form-input')
            .hide()
            .prev('.category-select')
            .show()
            .find('select')
            .attr('disabled', false)
        return false;
    }
}