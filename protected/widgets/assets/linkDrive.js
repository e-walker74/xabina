/**
 * Created by ekazak on 28.09.14.
 */

WLinkDrive = {
    _folder: 0,
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
//            $('.modal-galka-checkbox').click(function () {
//                if ($(this).find('input').prop('checked')) {
//                    $(this).addClass('active');
//                } else {
//                    $(this).removeClass('active');
//                }
//                event.stopPropagation();
//            });
            $('.book_button').on('click', function () {
                $(this).toggleClass('open');
                $(this).parents('li').find('.pay-list').slideToggle();
                return false;
            });
            WLinkDrive.bindSearch()
        })
    },
    addNewMemo: function (blockId, url) {
        var block = $('#' + blockId)
        if (block.find('textarea.redactor').val() == "") {
            block.find('.memo_edit .error-message').slideDown().delay(3000).slideUp()
            return false;
        }
        var memo_id = block.find('input[name=memo_id]').val()
        $.ajax({
            url: url,
            data: {text: block.find('textarea.redactor').val(), memo_id: memo_id},
            dataType: 'JSON',
            method: 'POST',
            success: function (data) {
                if (data.success) {
                    successNotify('', data.message, $('.before-memo').prev())
                    block.find('textarea').focus()
                    $('.redactor_editor').html('')
                    block.modal('hide')
                    $('#linkNewMemoModal').find('.drive-file-row').remove()
                    $(data.html).insertAfter($('#linkNewMemoModal .add-new-folder'))
                    $('#linkNewMemoModal').modal('show')
                    resetCheckeBox()
                } else {
                    errorNotify('', data.message, $('.before-memo').prev())
                }
            }
        })
    },
    editMemo: function(link, blockId, memo_id){
        $('#'+blockId).modal('show');
        var html = $(link).find('.full_text').html()
        $('#'+blockId + ' .redactor_editor').html(html)
        $('#'+blockId + ' textarea').val(html)
        $('#'+blockId).find('input[name=memo_id]').val($(link).attr('data-memo-id'))

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
                        $('.drive-file-row').remove()
                        $(response.html).insertAfter($('.file-directions li:first'))
                        WLinkDrive.bindAfterReady()
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
                    WLinkDrive.bindAfterReady()
                    resetCheckeBox()
                } else {
                    errorNotify('Drive', response.message, $('.file-directions'))
                }
            }
        };
        form.ajaxSubmit(options);
        return false;
    },
    openFolder: function (link, folder) {
        if (folder) {
            var data = {folder: folder}
        } else if (this._folder != 0) {
            var data = {folder: this._folder, up: true}
        }
        $.ajax({
            url: $(link).closest('.modal-body').attr('data-folder-url'),
            data: data,
            dataType: 'JSON',
            type: 'POST',
            success: function (response) {
                dellBackgroundBlack()
                if (response.success) {
                    resetPage()
                    $('.drive-file-row').remove()
                    $(response.html).insertAfter($('.file-directions li:first'))
                    WLinkDrive.bindAfterReady()
                    WLinkDrive._folder = response.folder
                    resetCheckeBox()
                    WLinkDrive.search($(link).closest('.modal-body').find('.search-results-list'), $(link).closest('.modal-body').find('.search-input-drive').val())

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
            block.find(".drive-search-text:contains('" + value + "')").closest('li.drive-file-row').show();
        } else {
            block.find('li.drive-file-row').show()
        }
    },
    bindSearch: function () {
        $('.search-input-drive').keyup(function (event) {
            WLinkDrive.search($(this).closest('.modal-body').find('.search-results-list'), this.value)
        })
    },
    sort: function (link) {
        var url = $(link).closest('.file_top_menu').attr('data-url')
        $.ajax({
            url: url,
            data: {
                sort: $(link).attr('data-sort'),
                param: $(link).attr('data-sort-param'),
                folder: this._folder,
                sorting: true
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
                    $('.drive-file-row').remove()
                    $(response.html).insertAfter($('.file-directions li:first'))
                    resetCheckeBox()
                    WLinkDrive.bindAfterReady()
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
    }
}

WLinkDrive.init()