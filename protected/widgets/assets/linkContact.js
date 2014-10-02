/**
 * Created by ekazak on 28.09.14.
 */

WLinkContact = {
    _folder: 0,
    init: function () {
        WLinkContact.bindAfterReady()
    },
    bindAfterReady: function () {
        jQuery(document).ready(function () {
            jQuery.fn.searchContactButtonByName({searchLineSelector: '.search-input-contacts', parentSelector: '.scroll-cont'})
        })
    },
    link: function (b) {
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
                    $('.transaction-contact').remove()
                    $(data.html).insertAfter($('.before-contacts'))
                    successNotify('', data.message, $('.before-contacts').prev())
                    button.closest('.modal').modal('hide')
                    resetPage()
                } else {
                    errorNotify('', data.message, $('.before-contacts').prev())
                }
            }
        })
        return false;
    }
}

WLinkContact.init()