var submitTransaction = function(form){
    url = form.attr('action')
    if(form.find('.clicked-button').hasClass('button-right'))
        url = url + '&next=1'

    $.ajax({
        url: url,
        success: function(response) {
            if(response.success){
                var li = $(form).parents('li').prev('li')
                var receiver = $(form).find('.acc-to-num select option:selected').text()
                var amount = $(form).find('input.amount-input').val()
                var amount_cent = $(form).find('input.cent-input').val()
                var currency = $(form).find('.upload-price select option:selected').text()
                
                li.find('.acc-to-num').html(receiver)
                li.find('.upload-price .amount').html(amount+"."+amount_cent)
                li.find('.upload-price .currency').html(currency)
                
                $('.row-edit').hide().prev('li').show()
                if(response.url) {
                    window.location.href = response.url
                }
            } else {

            }
        },
        cache:false,
        async: false,
        data: form.serialize(),
        type: 'POST',
        dataType: 'json'
    });
}