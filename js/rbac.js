/**
 * Created by pk on 12.06.14.
 */

RBAC = {
    init: function () {

    },
    bindCheckRoleRights: function(){
        $('.select-role-type').change(event, function () {
            RBAC.getRoleRigths($('.select-role-type').val())
        });
//        self.getRoleRigths($('.select-role-type').val())
    },

    addRolePage: function () {

        var self = this;

        $('.checkbox-custom').on('click', 'label', function (e) {
            if ($(this).find('input').prop('checked')) {
                $(this).addClass('checked');
                e.stopPropagation();
            } else {
                $(this).removeClass('checked');
                e.stopPropagation();
            }
        });

        $('input[type=checkbox]').change(function(){
            if ($(this).prop('checked')) {
                self.checkParentsOn(this)
            } else{
                self.checkParentsOff(this)
            }
        })

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

        $('input[type=checkbox]').on('change', this.changeRightsArr)

        return this;
    },
    bindCheckUsersForAccount: function(){
        $('#usersForAccount').on('change', RBAC.getUsersForAccount)
        return this;
    },
    getUsersForAccount: function () {
        backgroundBlack()
        $.ajax(
            {
                data: {"acc_id": $('#usersForAccount').val() },
                type: 'get',
                dataType: 'json',
                success: function (response) {
                    if(response.success){
                        $('#ajax-users-table').html(response.html)
                    }
                },
                complete : function(){
                    dellBackgroundBlack()
                }
            });
    },
    getUserAccessRights: function(url){
        $.ajax(
        {
            url: url,
            data: $('.select-role-type').parents('form').serialize(),
            type: 'get',
            dataType: 'json',
            success: function (response) {
                $('div.xabina-accordion').find('input:checkbox').each(function () {
                    $(this).attr('checked', false);
                    $(this).parent().removeClass('checked');
                });
                for (i = 0; i < response.length; i++) {
                    $checkbox = $('.xabina-accordion').find('input:checkbox[name="RbacRoles[rights][' + response[i].access_right_id + ']"]');
                    $checkbox.attr('checked', true);
                    $checkbox.parent().addClass('checked');
                }
                RBAC.changeRightsArr()
            }
        });
    },
    getRoleRigths: function (role_id) {
        $.ajax(
            {
                url: $('.select-role-type').attr('data-url'),
                data: {"roleId": role_id },
                type: 'get',
                success: function (response) {
                    response = eval(response);
                    $('div.xabina-accordion').find('input:checkbox').each(function () {
                        $(this).attr('checked', false);
                        $(this).parent().removeClass('checked');
                    });
                    for (i = 0; i < response.length; i++) {
                        $checkbox = $('.xabina-accordion').find('input:checkbox[name="RbacRoles[rights][' + response[i].access_right_id + ']"]');
                        $checkbox.attr('checked', true);
                        $checkbox.parent().addClass('checked');
                    }
                    RBAC.changeRightsArr()
                }
            });
    },
    changeRightsArr: function () {
        if ($('#RbacRoles_parent_id').val() !== '') {
            $('#RbacRoles_rightsArr').val(1)
        } else if ($('input[type=checkbox]:checked').length != 0) {
            $('#RbacRoles_rightsArr').val(1)
        } else {
            $('#RbacRoles_rightsArr').val('')
        }
    },
    afterValidate: function (form, data, hasError) {
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
            return true;
        }
        return false;
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
    checkParentsOff: function(elem){
        var childs = $(elem).closest('.head-of-param').find('input[type=checkbox]')

        childs.val('')
            .attr('checked', false)
            .parent()
            .removeClass('checked')

        var top_r = $(elem).closest('.top-right')

        if(top_r.find('input[type=checkbox]:checked').length == 0){
            top_r.prev('.head-accordion-param')
                .find('input[type=hidden]:first')
                .val('').attr('checked', false)
        }

    },
    checkParentsOn: function(elem){

//        $(elem)
//            .parents('.head-of-param')
//            .find('input[type=checkbox]:first')
//            .attr('checked','checked')
//            .parent()
//            .addClass('checked')
//
//        $(elem).parents('.top-right').prev('.head-accordion-param').find('input[type=hidden]:first').val(1)

        var head = $(elem).parents('.head-of-param').each(function(){
            if($(this).hasClass('top-right')){
                $(this).prev('.head-accordion-param').find('input[type=hidden]:first').val(1).attr('checked', 'checked')
            } else {
                el = $(this).find('input[type=checkbox]:first')
                el.attr('checked','checked').parent().addClass('checked')
            }
        })
    }
}

$(function () {
    RBAC.init();
});