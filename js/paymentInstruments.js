var submitForm = function(form, method) {
    url = form.attr('action');
    var formId = form.attr('id');
    $.ajax({
        url: url,
        success: function(response) {
            if (response.success) {
                if (response.url)
                    window.location.href = response.url;

                if (method=='create') {
                    $('#add-more').before(response.html);
                    $('#add-more').css('display', 'table-row');
                    $('.add-new-form').css('display', 'none');
                    deleteButtonEnable();
                    editButtonEnable();
                } else {
                    $('.edit-payment-tr').css('display', 'none');
                    $('.view-payment-tr').css('display', 'table-row');
                }
            }
        },
        cache: false,
        async: false,
        data: form.serialize(),
        type: 'POST',
        dataType: 'json'
    });
    return false;
}
