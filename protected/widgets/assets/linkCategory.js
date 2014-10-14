/**
 * Created by ekazak on 28.09.14.
 */

WLinkCategory = {
    _folder: 0,
    _popupBlockId: '',
    init: function () {
        WLinkCategory.bindAfterReady()
        WLinkCategory.bindCheckbox()
    },
    bindAfterReady: function () {
        jQuery(document).ready(function () {
            WLinkCategory.bindSearch()
            $('#' + WLinkCategory._popupBlockId).on('show.bs.modal', function (e) {
                WLinkCategory.updatePopupGrid()
            })

            $('body').on('dblclick', '#' + WLinkCategory._popupBlockId + ' tr',
            function(e){
                var modal = $(this).closest('.modal')
                modal.find('input[type=checkbox]').attr('checked', false)
                $(this).find('input[type=checkbox]').attr('checked', true)
                $(this).closest('form').find('input[type=submit]').click()
                e.stopPropagation()
            })
        })
    },
    bindCheckbox: function () {
        jQuery(document).ready(function () {
            $('.modal-body').on('click', '.modal-galka-checkbox', function (event) {
                if ($(this).find('input').prop('checked')) {
                    $(this).addClass('active');
                } else {
                    $(this).removeClass('active');
                }
                event.stopPropagation();
            });
        })
    },
    updatePopupGrid: function(){
        var block = $('#'+WLinkCategory._popupBlockId)
        if(block.length == 0){
            alert('WLinkCategory need the PopupBlockId');
        }
        $.ajax({
            url: block.attr('data-grid-url'),
            data: {entity: block.attr('data-entity'), entity_id: block.attr('data-entity-id')},
            dataType: 'JSON',
            type: 'POST',
            success: function (response) {
                if (response.success) {
                    resetPage()
                    $('#'+WLinkCategory._popupBlockId+' .wcategory-row').remove()
                    $(response.html).insertAfter($('#'+WLinkCategory._popupBlockId+' .wcategory-table tr:first'))
                } else {
                    errorNotify('Drive', response.message, $('.file-directions'))
                }
            }
        })


    },
    showCreateCategoryRow: function (link) {
        var parent = $(link).closest('.modal-body')
        var tr = parent.find('tr.add-new-category-row')
        tr.show()
        $(link).closest('.form-block').find('input').addClass('gray_bg').attr('disabled', true)
        $(link).addClass('gray-add-new')
        return false;
    },
    createCategory: function (button) {
        var row = $(button).closest('tr')
        var title = row.find('input.short-input').val()
        var description = row.find('input.long-input').val()

        if (title.length == 0) {
            row.find('.error-message').slideDown().delay(3000).slideUp()
            return false;
        }
        backgroundBlack()
        $.ajax({
            url: row.attr('data-url'),
            data: {title: title, description: description},
            dataType: 'JSON',
            type: 'POST',
            success: function (response) {
                dellBackgroundBlack()
                if (response.success) {
                    resetPage()
                    $('.wcategory-row').remove()
                    $(response.html).insertAfter($('.wcategory-table tr:first'))
                    WLinkCategory.cancel(row)
                } else {
                    errorNotify('Drive', response.message, $('.file-directions'))
                }
            }
        })
        return false;
    },
    cancel: function (link) {
        var parent = $(link).closest('.modal-body')
        var tr = parent.find('tr.add-new-category-row')
        tr.hide()
        parent.find('.xabina-form-container .form-block input, .xabina-form-container .form-block a')
            .removeClass('gray_bg')
            .removeClass('gray-add-new')
            .attr('disabled', false)
        return false;
    },
    search: function (block, value) {
        if (value) {
            block.find('tr.wcategory-row').hide()
            var rows = block.find(".drive-search-text")
            rows.each(function () {
                if ($(this).text().toLowerCase().indexOf(value.toLowerCase()) != -1) {
                    $(this).closest('tr.wcategory-row').show()
                }
            });
        } else {
            block.find('tr.wcategory-row').show()
        }
    },
    bindSearch: function () {
        $('.clear-input-but-for-all').hide()
        $('.search-input-category').keyup(function (event) {
            WLinkCategory.search($(this).closest('.modal-body').find('.wcategory-table'), this.value)
        })
        $('.clear-input-but-for-all').click(function(){
            $(this).prev().val('').focus().keyup()
        })
    },
    link: function (b) {
        var button = $(b)
        var form = button.closest('form')
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
                    $('.transaction-category').remove()
                    $(data.html).insertAfter($('.before-categories'))
                    successNotify('', data.message, $('.before-categories').prev())
                    button.closest('.modal').modal('hide')
                    form.find('input[type=checkbox]:checked').closest('tr').remove()
                    resetPage()
                    resetCheckeBox()
                } else {
                    errorNotify('', data.message, $('.before-categories').prev())
                }
            }
        })
        return false;
    },
    updatePopUpCategoriesGrid: function(){

    }
}

WLinkCategory.init()