var submitForm = function(form, method) {
    url = form.attr('action');
    var formId = form.attr('id');
    backgroundBlack()
    $.ajax({
        url: url,
        success: function(response) {
            if (response.success) {
                if (response.url)
                    window.location.href = response.url;
                successNotify('Favorite payments', response.message, form)
                if (response.html) {
                    $('#paymentsList').html(response.html);
                }
            }
            setAllSelectedValues()
            dellBackgroundBlack()
        },
        cache: false,
        async: true,
        data: form.serialize(),
        type: 'POST',
        dataType: 'json'
    });
    return false;
}
var deleteButtonEnable = function(parentTag) {
    if (!parentTag)
        var parentTag = 'tr';

    $('.button.delete').confirmation({
        singleton: true,
        popout: true,
        onConfirm: function() {
            link = $(this).parents('.popover').prev('a');
            editTr = link.parents(parentTag).next('.edit-payment-tr')
            deleteRow(link, function(response){
                if(response.success){
                    editTr.remove()
                }
            }, parentTag);
            return false;
        }
    });

};

//var hideAddNewForm = function() {
//    $('.add-new-form').css('display', 'none');
//    $('#add-more').css('display', 'table-row');
//};
//var hideEditForm = function() {
//    $('.edit-payment-tr').hide();
//    $('.edit-payment-tr').prev('tr.view-payment-tr').show('slow');
//};

//var editButtonEnable = function() {
//    $('.button.edit').click(function() {
//        hideEditForm();
//        hideAddNewForm();
//        $(this).parents('tr').hide().next('.edit-payment-tr').show();
//
//        return false;
//    });
//};

var bindButtons = function(){
//    $('#add-new-payment-instrument').click(function() {
//        hideEditForm();
//        $('.add-new-form').css('display', 'table-row');
//        $('#add-more').css('display', 'none');
//        return false;
//    });
//    $('.add-new-form .button.cancel').click(function() {
//        hideAddNewForm();
//        return false;
//    });

//    $('.edit-payment-tr .button.cancel').click(function() {
//        hideEditForm();
//        return false;
//    });
}

$(document).ready(function() {
//    deleteButtonEnable();
//    editButtonEnable();
//    bindButtons()

});

