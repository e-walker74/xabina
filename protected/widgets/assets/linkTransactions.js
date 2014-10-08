/**
 * Created by ekazak on 28.09.14.
 */

WLinkTransactions = {
    _folder: 0,
    init: function () {
        WLinkTransactions.bindAfterReady()
    },
    bindAfterReady: function () {
        jQuery(document).ready(function () {
            WLinkTransactions.bindSearch()
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
                } else {
                    errorNotify('', data.message, $('.before-transactions').prev())
                }
            }
        })
        return false;
    }
}

WLinkTransactions.init()