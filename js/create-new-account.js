NewAccountPage = {
    init: function () {
        var self = this;
        self.getAccountsType();

        $('#Accounts_type_id, #Accounts_currency_id').change(function(){
            self.getAccountsType();
        })

        $('.type-order-btn').live('click', function(){
            $('#account-type-id').val($(this).attr('data-type_id'));
        });
    },

    getAccountsType: function () {
        var categoryId = $('#Accounts_type_id').val();
        var currencyId = $('#Accounts_currency_id').val();
        $.ajax({
            url: "/accounts/getnewaccountstypes",
            type: "GET",
            data: {currencyId: currencyId, categoryId: categoryId},
            success: function(data){
                $('#type-container .type-block, #type-container .clear').remove();
                $('#type-container').append(data);
            }
        });
    },

    submitForm: function(form){
        var url = form.attr('action');

        $.ajax({
            url: url,
            success: function(response) {
                if(response.success){
                    successNotify('Accounts', response.message, $('.form-submit'));
                    resetPage();
                      if(response.url) {
                        window.location.href = response.url
                    }
                } else if(response.message){
                    errorNotify('Accounts', response.message, $('.form-submit'));
                }
            },
            cache:false,
            async: false,
            data: form.serialize(),
            type: 'POST',
            dataType: 'json'
        });
    }
}

$(function(){
    NewAccountPage.init();
});

afterValidate = function(form, data, hasError) {
    form.find("input").removeClass("input-error");
    form.find("input").parent().removeClass("input-error");
    form.find(".validation-icon").fadeIn();
    if(hasError) {
        for(var i in data) {
            $("#"+i).addClass("input-error");
            $("#"+i).parent().addClass("input-error");
            $("#"+i).next(".validation-icon").fadeIn();
        }
        return false;
    }
    else {
        NewAccountPage.submitForm(form);
        return false;
    }
    return false;
}

afterValidateAttribute = function(form, attribute, data, hasError) {
    if(hasError){
        if(!$("#"+attribute.id).hasClass("input-error")){
            $("#"+attribute.id+"_em_").hide().slideDown();
        }
        $("#"+attribute.id).removeClass("valid").parent().removeClass("valid");
        $("#"+attribute.id).addClass("input-error").parent().addClass("input-error");
        $("#"+attribute.id).next(".validation-icon").fadeIn();
    } else {
        if($("#"+attribute.id).hasClass("input-error")){
            $("#"+attribute.id+"_em_").show().slideUp();
        }
        $("#"+attribute.id).removeClass("input-error").parent().next("error-message").slideUp().removeClass("input-error");
        $("#"+attribute.id).next(".validation-icon").fadeIn();
        $("#"+attribute.id).addClass("valid");
    }
}