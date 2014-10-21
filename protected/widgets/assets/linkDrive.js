/**
 * Created by ekazak on 28.09.14.
 */

WLinkDrive = {
    _folder: 0,
    _memoPopupId: '',
    _filesPopupId: '',
    _newMemoPopupId: '',
    init: function () {
        WLinkDrive.bindAfterReady()
        WLinkDrive.bindUnlinkFile()
        WLinkDrive.bindUploadFile()
    },
    bindAfterReady: function () {
        jQuery(document).ready(function () {
            $('.redactor').redactor({
                plugins: ['fontcolor', 'fontsize'],
                buttons: ['formatting', 'bold', 'italic', 'deleted', 'unorderedlist', 'orderedlist', 'table', 'link', 'alignment', 'horizontalrule']
            });
            $('body').on('dblclick', '#' + WLinkDrive._filesPopupId + ' li, #' + WLinkDrive._memoPopupId + ' li',
            function(e){
                var modal = $(this).closest('.modal')
                modal.find('input[type=checkbox]').attr('checked', false)
                $(this).find('input[type=checkbox]').attr('checked', true)
                $(this).closest('form').find('input[type=submit]').click()
                e.stopPropagation()
            })
            WLinkDrive.bindSearch()

            $('#' + WLinkDrive._memoPopupId).on('show.bs.modal', function (e) {
                if($('#' + WLinkDrive._memoPopupId).hasClass('no-load')){
                    $('#' + WLinkDrive._memoPopupId).removeClass('no-load')
                } else {
                    WLinkDrive.openFolder('', 0, $('#' + WLinkDrive._memoPopupId + ' .modal-body'))
                }
            })

            $('#' + WLinkDrive._filesPopupId).on('show.bs.modal', function (e) {
                if($('#' + WLinkDrive._filesPopupId).hasClass('no-load')){
                    $('#' + WLinkDrive._filesPopupId).removeClass('no-load')
                } else {
                    WLinkDrive.openFolder('', 0, $('#' + WLinkDrive._filesPopupId + ' .modal-body'))
                }

            })
            $('#' + WLinkDrive._newMemoPopupId).on('show.bs.modal', function (e) {
                $('#' + WLinkDrive._newMemoPopupId).find('.redactor_editor').html('')
                $('#' + WLinkDrive._newMemoPopupId).find('textarea').val('')
                $('#' + WLinkDrive._newMemoPopupId).find('input[name=memo_id]').val('')
                $('#' + WLinkDrive._newMemoPopupId).find('input[name=transaction_id]').val('')
                $('#' + WLinkDrive._newMemoPopupId).find('input[name=folder_id]').val('')
            })

        })
    },
    addNewMemo: function (blockId, url) {
        var block = $('#' + blockId)
        if (block.find('textarea.redactor').val() == "") {
            block.find('.memo_edit .error-message').slideDown().delay(3000).slideUp()
            return false;
        }
        var memo_id = block.find('input[name=memo_id]').val()
        var transaction_id = block.find('input[name=transaction_id]').val()
        var folder_id = block.find('input[name=folder_id]').val()
        $.ajax({
            url: url,
            data: block.find('form').serialize(),
            dataType: 'JSON',
            type: 'POST',
            success: function (data) {
                if (data.success) {
                    successNotify('', data.message, $('.before-memo').prev())
                    block.find('textarea').focus()
                    $('.redactor_editor').html('')
                    block.modal('hide')
                    block.find('input[name=memo_id]').val('')
                    if(memo_id){
                        $('.drive_memo').remove()
                        $(data.html).insertAfter($('.before-memo'))
                        $('.linked_tr').show()
                        $('.drop_links').addClass('active')
                        successNotify('', data.message, $('.before-memo').prev())
                    } else {
                        $('#linkNewMemoModal').addClass('no-load')
                        $('#linkNewMemoModal').modal('show')
                        $('#linkNewMemoModal').find('.drive-file-row').remove()
                        $(data.html).insertAfter($('#linkNewMemoModal .add-new-folder'))
                    }
                    resetCheckeBox()
                } else {
                    errorNotify('', data.message, $('.before-memo').prev())
                }
            }
        })

        return false;
    },
    editMemo: function(link, blockId, transaction_id){
        $('#'+blockId).modal('show');
        var html = $(link).find('.full_text').html()
        $('#'+blockId + ' .redactor_editor').html(html)
        $('#'+blockId + ' textarea').val(html)
        $('#'+blockId).find('input[name=memo_id]').val($(link).attr('data-memo-id'))
        $('#'+blockId).find('input[name=transaction_id]').val(transaction_id)
        $('#'+blockId).find('input.rounded-buttons.submit').addClass('edit-submit')

    },
    bindUnlinkFile: function () {
        jQuery(document).ready(function () {
            $('.del_a').confirmation({
                singleton: true,
                popout: true,
                onConfirm: function () {
                    link = $(this).parents('.popover').prev('a');
                    deleteRow(link);
                    return false;
                }
            });
        })
    },
    linkFiles: function (b) {
        var button = $(b)
        form = button.closest('form')
        if (form.find('input[type=checkbox]:checked').length <= 0) {
            form.find('.error-message').slideDown().delay(3000).slideUp()
            return false;
        }

        $.ajax({
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'JSON',
            type: 'POST',
            success: function (data) {
                if (data.success) {
                    $('.drive_files').remove()
                    $(data.html).insertAfter($('.before-files'))
                    $('.linked_tr').show()
                    $('.drop_links').addClass('active')
                    successNotify('', data.message, $('.before-files').prev())
                    button.closest('.modal').modal('hide')
                    resetPage()
                    resetCheckeBox()
                } else {
                    errorNotify('', data.message, $('.before-files').prev())
                }
            }
        })
        return false;
    },
    linkMemo: function (b) {
        var button = $(b)
        form = button.closest('form')
        if (form.find('input[type=checkbox]:checked').length <= 0) {
            form.find('.error-message').slideDown().delay(3000).slideUp()
            return false;
        }

        $.ajax({
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'JSON',
            type: 'POST',
            success: function (data) {
                if (data.success) {
                    $('.drive_memo').remove()
                    $(data.html).insertAfter($('.before-memo'))
                    successNotify('', data.message, $('.before-memo').prev())
                    button.closest('.modal').modal('hide')
                    $('.linked_tr').show()
                    $('.drop_links').addClass('active')
                    resetPage()
                    resetCheckeBox()
                } else {
                    errorNotify('', data.message, $('.before-memo').prev())
                }
            }
        })
        return false;
    },
    createFolderButton: function (link) {
        var parent = $(link).closest('.modal-body')
        var li = parent.find('ul .add-new-folder')
        var input = li.toggle().find('input[type=text]')
        input.focus().focusout(function () {
            WLinkDrive.createFolder(li, input)
        }).keyup(function (event) {
            if (event.keyCode == 13) {
                event.stopPropagation();
                WLinkDrive.createFolder(li, input)
            }
        })
        return false;
    },
    createFolder: function (li, input) {
        var modal = $(li).closest('.modal')
        var val = $(input).val()
        if (val.length > 0) {
            backgroundBlack()
            $.ajax({
                url: li.attr('data-url'),
                data: {parent: WLinkDrive._folder, name: val},
                dataType: 'JSON',
                type: 'POST',
                success: function (response) {
                    dellBackgroundBlack()
                    if (response.success) {
                        resetPage()
                        successNotify('Drive', response.message, $('.file-directions'))
                        modal.find('.drive-file-row').remove()
                        $(response.html).insertAfter(modal.find('.file-directions li:first'))
                        resetCheckeBox()
                    } else {
                        errorNotify('Drive', response.message, $('.file-directions'))
                    }
                }
            })
        }
        li.hide()
        input.val('')

    },
    bindUploadFile: function () {
        $('document').ready(function () {
            $('.drive-upload-form input').on('change', function () {
                $(this).closest('.drdn-cont').removeClass('open')
                form = $(this).closest('form')
                return WLinkDrive.uploadFile(form)
            })
        })
    },
    uploadFile: function (form, data, hasError, callBack) {
        var error = false

        backgroundBlack()
        var options = {
            url: form.attr('action') + '&folder=' + WLinkDrive._folder,
            type: 'POST',
            dataType: 'json',
            data: form.serialize(),
            success: function (response) {
                dellBackgroundBlack()
                if (response.success) {
                    resetPage()
                    successNotify('Drive', response.message, $('.file-directions'))
                    $('.drive-file-row').remove()
                    $(response.html).insertAfter($('.file-directions li:first'))
                    resetCheckeBox()
                } else {
                    errorNotify('Drive', response.message, $('.file-directions'))
                }
            }
        };
        form.ajaxSubmit(options);
        return false;
    },
    openFolder: function (link, folder, body) {
        if(!body){
            body = $(link).closest('.modal-body')
        }
        var modal = body.closest('.modal')
        if (folder) {
            var data = {folder: folder, entity: modal.attr('data-entity'), entity_id: modal.attr('data-entity-id')}
        } else if (this._folder != 0) {
            var data = {folder: this._folder, up: true, entity: modal.attr('data-entity'), entity_id: modal.attr('data-entity-id')}
        } else if(body){
            var data = {folder: 0, type: modal.attr('data-type'), entity: modal.attr('data-entity'), entity_id: modal.attr('data-entity-id')}
        }
        $.ajax({
            url: body.attr('data-folder-url'),
            data: data,
            dataType: 'JSON',
            type: 'POST',
            success: function (response) {
                dellBackgroundBlack()
                if (response.success) {
                    resetPage()
                    modal.find('.drive-file-row').remove()
                    $(response.html).insertAfter(modal.find('.file-directions li:first'))
                    WLinkDrive._folder = response.folder
                    resetCheckeBox()
                    WLinkDrive.search(modal.find('.search-results-list'), modal.find('.search-input-drive').val())

                } else {
                    errorNotify('Drive', response.message, $('.file-directions'))
                }
            }
        })
        return false;
    },
    search: function (block, value) {
        if (value) {
            block.find('li.drive-file-row').hide()

            var rows = block.find(".drive-search-text")

            rows.each(function () {
                if ($(this).text().toLowerCase().indexOf(value.toLowerCase()) != -1) {
                    $(this).closest('li.drive-file-row').show()
                }
            })

//            block.find(".drive-search-text")
//            block.find(".drive-search-text:contains('" + value + "')").closest('li.drive-file-row').show();
        } else {
            block.find('li.drive-file-row').show()
        }
    },
    bindSearch: function () {
        $('.search-input-drive').keyup(function (event) {
            WLinkDrive.search($(this).closest('.modal-body').find('.search-results-list'), this.value)
        })
        $('.clear-input-but-for-all').click(function(){
            $(this).prev().val('').focus().keyup()
        })
    },
    sort: function (link) {
        var modal = $(link).closest('.modal')
        var url = $(link).closest('.file_top_menu').attr('data-url')
        var type = modal.attr('data-type')
        $.ajax({
            url: url,
            data: {
                sort: $(link).attr('data-sort'),
                param: $(link).attr('data-sort-param'),
                folder: this._folder,
                sorting: true,
                type: type,
                entity: modal.attr('data-entity'),
                entity_id: modal.attr('data-entity-id')
            },
            dataType: 'JSON',
            type: 'POST',
            success: function (response) {
                if (response.success) {

                    if($(link).attr('data-sort') == 'asc'){
                        $(link).attr('data-sort', 'desc')
                        $(link).addClass('desc').removeClass('asc')
                    } else {
                        $(link).attr('data-sort', 'asc')
                        $(link).addClass('asc').removeClass('desc')
                    }

                    resetPage()
                    modal.find('.drive-file-row').remove()
                    $(response.html).insertAfter(modal.find('.file-directions li:first'))
                    resetCheckeBox()
                    WLinkDrive._folder = response.folder

                    WLinkDrive.search($(link).closest('.modal-body').find('.search-results-list'), $(link).closest('.modal-body').find('.search-input-drive').val())

                } else {
                    errorNotify('Drive', response.message, $('.file-directions'))
                }
            }
        })
    },
    clickCheckbox: function(link){
        var tr = $(link).closest('li')
        if(tr.find('.modal-galka-checkbox').hasClass('active')){
            tr.find('.modal-galka-checkbox').removeClass('active');
            tr.find('.modal-galka-checkbox input').attr('checked', false);
        } else{
            tr.find('.modal-galka-checkbox').addClass('active');
            tr.find('.modal-galka-checkbox input').attr('checked', true);
        }
    },
    addNewMemoToFolder: function(){
        $('#' + WLinkDrive._newMemoPopupId).modal('show')
        $('#' + WLinkDrive._newMemoPopupId).find('input[name=folder_id]').val(WLinkDrive._folder)
    }
}

WLinkDrive.init()