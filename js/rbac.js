/**
 * Created by pk on 12.06.14.
 */

RBAC = {
    init: function () {

    },
    addRolePage: function () {

        var self = this;

        self.getRoleRigths($('.select-role-type').val())

        $('.checkbox-custom').on('click', 'label', function (e) {
            if ($(this).find('input').prop('checked')) {
                $(this).addClass('checked');
                e.stopPropagation();
            } else {
                $(this).removeClass('checked');
                e.stopPropagation();
            }
        });

        $('.xabina-accordion').accordion({
            heightStyle: "content",
            active: false,
            collapsible: true
        });
        $('.details-accordion').accordion({
            heightStyle: "content",
            active: 0,
            collapsible: true
        });
        $('.select-role-type').change(event, function () {
            self.getRoleRigths($('.select-role-type').val())
        });
        $('input[type=checkbox]').on('change', this.changeRightsArr)
    },
    getRoleRigths: function(role_id){
        $.ajax({url: $('.select-role-type').attr('data-url'),
            data: {"roleId": role_id },
            type: 'get',
            success: function (response) {
                response = eval(response);
                $('div.xabina-accordion').find('input:checkbox').each(function () {
                    $(this).attr('checked', false);
                    $(this).parent().removeClass('checked');
                });
                for (i = 0; i < response.length; i++) {
                    $checkbox = $('.xabina-accordion').find('input:checkbox[name="RbacRoles[rights][' + response[i].acces_right_id + ']"]');
                    $checkbox.attr('checked', true);
                    $checkbox.parent().addClass('checked');
                }
                RBAC.changeRightsArr()
            }
        });
    },
    changeRightsArr: function(){
        if($('#RbacRoles_parent_id').val() !== ''){
            $('#RbacRoles_rightsArr').val(1)
        } else if($('input[type=checkbox]:checked').length != 0){
            $('#RbacRoles_rightsArr').val(1)
        } else {
            $('#RbacRoles_rightsArr').val('')
        }
    },
    afterValidate: function(form, data, hasError) {
        form.find("input").removeClass("input-error");
        form.find("input").parent().removeClass("input-error");
        form.find(".validation-icon").fadeIn();
        for(var i in data.notify) {
            $(form).find("."+i).html(data.notify[i]).slideDown().delay(3000).slideUp();
        }
        if(hasError) {
            for(var i in data) {
                $("#"+i).addClass("input-error");
                $("#"+i).parent().addClass("input-error");
                $("#"+i).next(".validation-icon").fadeIn();
            }
            return false;
        }
        else {
            return true;
        }
        return false;
    },
    afterValidateAttribute: function(form, attribute, data, hasError) {
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
        for(var i in data.notify) {
            $(form).find("."+i).html(data.notify[i]).slideDown().delay(3000).slideUp();
        }
    }
}

$(function () {
    RBAC.init();
});