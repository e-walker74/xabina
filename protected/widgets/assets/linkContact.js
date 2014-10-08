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

            $('.modal-galka-radiobutton').on('click', function(){
                $('.modal-galka-radiobutton').removeClass('active').find('input').attr('checked', false)
                $(this).addClass('active').find('input').attr('checked', true)
            })
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
                    resetCheckeBox()
                    resetPage()
                } else {
                    errorNotify('', data.message, $('.before-contacts').prev())
                }
            }
        })
        return false;
    },
    createContact: function(sub){
        var form = $(sub).closest('form')
        $.ajax({
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'JSON',
            type: 'POST',
            success: function (data) {
                if (data.success) {
                    successNotify('', data.message, $('.before-contacts').prev())
                    $(sub).closest('.modal').modal('hide')
                    $('#addLinkModal').modal('show')
                    $('#addLinkModal').find('.contacts-list').html(data.html)
                    resetPage()

                    jQuery.fn.searchContactButtonByName({searchLineSelector: '.search-input-contacts', parentSelector: '.scroll-cont'})
                } else {
                    errorNotify('', data.message, $('.before-contacts').prev())
                }
            }
        })
        return false;
    }
}

WLinkContact.init()