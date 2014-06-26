/**
 * Created by ekazak on 12.06.14.
 * @author evgeniy.kazak@gmail.com
 */

Personal = {
    init: function () {
        this.bindDeleteButton()
        resetPage()
        setAllSelectedValues()
        self = this
    },
    bindDeleteButton: function(){
        $(".delete").confirmation({
            title: "Are you sure?",
            singleton: true,
            popout: true,
            onConfirm: function(){

                link = $(this).parents(".popover").prev("a")
                var parent = $(link).parents('.head-ajax-block')
                deleteRow(link, function(response){
                    if(response.html){
                        parent.html(response.html)
                    }
                    if(response.success){
//                        successNotify("Personal account", response.message)
                    }
                });
                return false;
            }
        })
    },
    resendSms: function(link){
        link = $(link)
        $.ajax({
            url: link.attr('href'),
            success: function(response){
                if(response.success){
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
        value = $(link).parents('.field-row').find('.input-text-sms').val();
        if(!value){
            var field = $(link).parent().next('.error-message')
            this.showError(field, 'Sms code is incorrect')
            return false;
        }
        backgroundBlack()
        if (value) {
            $.ajax({
                url: url + value,
                success: function (response) {
                    self.successUpdateTable(response, link)
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
    sendForm: function(form) {
        backgroundBlack()
        $.ajax({
            url: $(form).attr('action'),
            success: function(response) {
                self.successUpdateTable(response, form)
            },
            cache:false,
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
    successUpdateTable: function(response, element){
        var headAjaxBlock = $(element).parents('.head-ajax-block')
        if(response.success){
            headAjaxBlock.html(response.html)
            successNotify('Payment', response.message, $(headAjaxBlock).find('tr:visible:last'))
        } else {
            errorNotify('Payment', response.message, $(headAjaxBlock).find('tr:visible:last'))
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
    showError: function(field, message){
        if($(field).is(':visible')){
            $(field).html(message)
        } else {
            $(field).html(message).slideDown().delay(3000).slideUp();
        }
    }
}

$(function () {
    Personal.init();
});