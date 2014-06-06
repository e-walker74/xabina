var submitForm = function(form) {
    url = form.attr('action');
    $.ajax({
        url: url,
        success: function(response) {
            if (response.success){
                $('#add-more').before(response.html);
                $('.prof-form').css('display', 'none');
                if (response.url) {
                    window.location.href = response.url;
                }
            }
        },
        cache:false,
        async: false,
        data: form.serialize(),
        type: 'POST',
        dataType: 'json'
    });
}
