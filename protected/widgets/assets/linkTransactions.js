/**
 * Created by ekazak on 28.09.14.
 */

WLinkTransactions = {
    _folder: 0,
    _popupId: '',
    init: function () {
        WLinkTransactions.bindAfterReady()
    },
    bindAfterReady: function () {
        jQuery(document).ready(function () {
            WLinkTransactions.bindSearch()

            $('#' + WLinkTransactions._popupId).on('show.bs.modal', function (e) {
                WLinkTransactions.updateTransactionsGrid()
            })

            $('body').on('dblclick', '#' + WLinkTransactions._popupId + ' tr',
            function(e){
                var modal = $(this).closest('.modal')
                modal.find('input[type=checkbox]').attr('checked', false)
                $(this).find('input[type=checkbox]').attr('checked', true)
                $(this).closest('form').find('input[type=submit]').click()
                e.stopPropagation()
            })
        })
    },
    search: function (block, value) {
        if (value) {
            block.find('tr.wcategory-row').hide()
            block.find(".drive-search-text:contains('" + value + "')").closest('tr.wcategory-row').show();
        } else {
            block.find('tr.wcategory-row').show()
        }
    },
    bindSearch: function () {
        $('.search-input-transaction').keyup(function (event) {
            WLinkTransactions.search($(this).closest('.modal-body').find('.linked-transaction'), this.value)
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
                    $('.transaction-transactions-row').remove()
                    $(data.html).insertAfter($('.before-transactions'))
                    successNotify('', data.message, $('.before-transactions').prev())
                    button.closest('.modal').modal('hide')
                    resetPage()
                    resetCheckeBox()
                } else {
                    errorNotify('', data.message, $('.before-transactions').prev())
                }
            }
        })
        return false;
    },
    updateTransactionsGrid: function(){
        var modal = $('#' + WLinkTransactions._popupId)
        $.ajax({
            url: modal.attr('data-update-url'),
            data: {
                entity: modal.attr('data-entity'),
                entity_id: modal.attr('data-entity-id')
            },
            dataType: 'JSON',
            type: 'POST',
            success: function (data) {
                if (data.success) {
                    modal.find('table.new-tran-tab').html(data.html)
                } else {
                    errorNotify('', data.message, $('.before-transactions').prev())
                }
            }
        })
        return false;
    }
}

WLinkTransactions.init()