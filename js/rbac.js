/**
 * Created by pk on 12.06.14.
 */

RBACK = {
    init: function () {

    },
    addRolePage: function () {

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
        $('.country-select').change(event, function () {
            $.ajax({url: $(this).attr('data-url'),
                data: {"roleId": this.value },
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
                }
            });
        });
    }
}

$(function () {
    RBACK.init();
});