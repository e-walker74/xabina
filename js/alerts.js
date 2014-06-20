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
    var updateInput = function updateInput(attr, $form, res) {
        var attribute = {inputID:attr,id:attr,errorID:attr+'_em_'};
        $.fn.yiiactiveform.updateInput(attribute, res, $form);
        var cont = $form.find('#' + attribute.inputID).closest('div.block-box');
        cont.find(':input').on('click change blur', function (e) {
            if(this.value != '') {
                $form.find('#'+attribute.errorID).hide();
            }
        });
    };

    var $alertsTable = $('#alerts-table');
    $alertsTable.on('click', '#alert-add-btn', function (e) {
        e.preventDefault();
        var $form = $(this).closest('form'), settings = $form.data('settings'),
            elHiddenId = $form.find('input[type=hidden][id]').attr('id');
        if(settings)
            settings.submitting = true;
        backgroundBlack();
        $.fn.yiiactiveform.validate($form, function (res) {
            if(res.success) {
                $.ajax({
                    url:$form.attr('action'),
                    data:$form.serialize(),
                    type:'post',
                    dataType:'json',
                    success : function (res) {
                        refreshTable(function(){
                            successNotify('Update alert', 'Alert was successfully created', $alertsTable.find('#'+elHiddenId).parent());
                        });
                    }
                });
            } else {
                if(!$.isEmptyObject(res)){
                    for(attr in res) {
                        if(res.hasOwnProperty(attr)){
                            updateInput(attr, $form, res);
                        }
                    }
                }
                dellBackgroundBlack();
            }
        });
    })
        .on('click', '.add-btn', function(){
            $(this).closest('.alert-row').hide();
        })
        .on('change', '.select-invisible', function () {
            $(this).siblings('.select-custom-label').html($(this).find('option[selected]').text());
        })
        .on('change', '.rule-select', function () {
            var tr = $(this).closest('.alert-row');
            var inputRows = tr.find('.rule-input');
            inputRows.addClass('hide')
                .filter('.'+this.value)
                .removeClass('hide');
            inputRows.find('input:text').val('');
        })
        .on('change', '.alert-select select', function () {
            var $row = $(this).closest('.alert-row').find('.rules-row');
            if($(this).find(':selected').data('use-rules')) {
                $row.removeClass('hide');
            } else {
                $row.addClass('hide');
            }
        })
        .on('click', '.button.edit', function(e) {
            resetPage()
            e.preventDefault();
            var tr = $(this).closest('.alert-row');
            tr.find('.edit-doc').show();
            tr.find('.not-edit-doc').hide();
        })
        .on('click', '.edit-doc .button.ok', function (e) {
            e.preventDefault();
            var $form = $(this).closest('form'), settings = $form.data('settings'),
                elHiddenId = $form.find('input[type=hidden][id]:first').attr('id');
            if(settings)
                settings.submitting = true;
            backgroundBlack();
            $.fn.yiiactiveform.validate($form, function (res) {
                if(res.success) {
                    $.ajax({
                        url:$form.attr('action'),
                        data:$form.serialize(),
                        type:'post',
                        dataType:'json',
                        success : function (res) {
                            refreshTable(function(){
                                successNotify('Update alert', 'Alert was successfully created', $alertsTable.find('#'+elHiddenId).parent());
                            });
                        }
                    });
                } else {
                    if(!$.isEmptyObject(res)){
                        for(attr in res) {
                            if(res.hasOwnProperty(attr)){
                                updateInput(attr, $form, res);
                            }
                        }
                    }
                    dellBackgroundBlack();
                }
            });
        })
        .on('click', '#add-rule-form .cancel', function () {
            resetPage();
            $(this).closest('form').find('select').val('').trigger('change');
            $(this).closest('.collapse').collapse('hide');
            $alertsTable.find('.add-btn').closest('.alert-row').show();
            return false;
        })
        .on('click', '.cancel', function () {
            resetPage();
            return false;
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
                        $form.closest('.alert-row').find('form').each(function () {
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
        $('#alerts-table .delete').confirmation({
            title: 'Are you sure?',
            singleton: true,
            popout: true,
            onConfirm: function(){
                var self = $(this).closest('.actions-td').find('.delete');
                $.ajax({
                    type: "POST",
                    url: $(self).data('url'),
                    success: function(data){
                        if(data.success){
                            var tr = $(self).closest('.alert-row');
                            successNotify('Delete alert', 'Alert was successfully deleted', tr.siblings('.alert-row:first'));
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

    $('.xabina-tabs').tabs();
});