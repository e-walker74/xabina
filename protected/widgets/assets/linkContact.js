/**
 * Created by ekazak on 28.09.14.
 */

WLinkContact = {
    _folder: 0,
    _popupId: '',
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

            $('#' + WLinkContact._popupId).on('show.bs.modal', function (e) {
                WLinkContact.updateContacts()
            })

            $('body').on('dblclick', '#' + WLinkContact._popupId + ' li',
            function(e){
                var modal = $(this).closest('.modal')
                modal.find('input[type=checkbox]').attr('checked', false)
                $(this).find('input[type=checkbox]').attr('checked', true)
                $(this).closest('form').find('input[type=submit]').click()
                e.stopPropagation()
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
    },
    updateContacts: function(){
        var modal = $('#' + WLinkContact._popupId)
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
                    modal.find('.contacts-list').html(data.html)
                    jQuery.fn.searchContactButtonByName({searchLineSelector: '.search-input-contacts', parentSelector: '.scroll-cont'})
                    bindCancelSearchButton()
                    $('.clear-input-but-for-all').hide()
                    $('.clear-input-but-for-all').click(function(){
                        $(this).prev().val('').focus().keyup()
                    })
                } else {
                    errorNotify('', data.message, $('.before-transactions').prev())
                }
            }
        })
        return false;
    }
}

WLinkContact.init()