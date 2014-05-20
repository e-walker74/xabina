$(function () {
    function refreshTable(successCallback) {
        backgroundBlack();
        var number = $('#account-number-select').val();
        $.ajax({
            url : location.protocol + '//' + location.host + location.pathname,
            data : {account:number},
            dataType : 'json',
            success : function (res) {
                if(res.success) {
                    $('#alerts-table').html(res.html);
                    bindConfirmEvent();
                    if(typeof successCallback == 'function')
                        successCallback();
                }
            },
            complete : function(){
                dellBackgroundBlack();
            }
        });
    }

    $('#account-number-select').change(refreshTable);

    $('#alerts-table').on('click', '#alert-add-btn', function (e) {
        e.preventDefault();
        var $form = $(this).closest('form'),
            $tr = $(this).closest('tr'),
            data = $tr.find(':input').serialize();
        backgroundBlack();
        $.ajax({
            url : $form.attr('action'),
            type : 'post',
            data : data,
            dataType : 'json',
            complete : dellBackgroundBlack,
            success : function (res) {
                if(res.success) {
                    refreshTable(function(){
                        successNotify('Create alert', 'Alert was successfully added', $tr);
                    });
                }
            }
        });
    })
        .on('change', '.select-invisible', function () {
            $(this).siblings('.select-custom-label').html($(this).find('option[selected]').text());
        })
        .on('click', '.button.edit', function(e) {
            e.preventDefault();
            var tr = $(this).closest('tr');
            tr.find('.edit-doc').show();
            tr.find('.not-edit-doc').hide();
        })
        .on('click', '.button.ok', function (e) {
            e.preventDefault();
            var tr = $(this).closest('tr');
            backgroundBlack();
            $.ajax({
                url : $(this).data('url'),
                data : tr.find(':input').serialize(),
                type : 'post',
                dataType : 'json',
                success : function (res) {
                    if(res.success) {
                        refreshTable(function(){
                            successNotify('Update alert', 'Alert was successfully updated', tr);
                        });
                    }
                },
                complete : dellBackgroundBlack
            });
        })
    ;

    $('#static-alerts').on('click', '[type=checkbox]', function() {
        var $form = $(this).closest('form');
        backgroundBlack();
        $.ajax({
            url : $form.attr('action'),
            data : $form.serialize(),
            type : 'post',
            dataType : 'json',
            success : function (res) {
                if(res.success) {
                    if($form.data('new') == true) {
                        $form.closest('tr').find('form').each(function () {
                            $(this).attr('action', ($(this).attr('action').replace(/new$/, res.data)));
                        });
                    }
                    successNotify('Update alert', 'Alert was successfully updated', $form);
                }
            },
            complete : dellBackgroundBlack
        });
    });

    function bindConfirmEvent() {
        $('#alerts-table .remove').confirmation({
            title: 'Are you sure?',
            singleton: true,
            popout: true,
            onConfirm: function(){
                var self = $(this).closest('.actions-td').find('.remove');
                $.ajax({
                    type: "POST",
                    url: $(self).data('url'),
                    success: function(data){
                        if(data.success){
                            var tr = $(self).closest('tr');
                            successNotify('Delete alert', 'Alert was successfully deleted', tr.prev());
                            tr.remove();
                        }
                    },
                    dataType: 'json'
                });
                return false;
            }
        });
    }
    bindConfirmEvent();

    $('.slide-but[data-toggle="collapse"]').click(function () {
        $(this).toggleClass('active');
    });

});