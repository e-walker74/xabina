/**
 * Created by ekazak on 08.09.14.
 */

Accounts = {
    makeAccountPrimary: function(url, id){
        backgroundBlack()
        $.ajax(
        {
            data: {id: id },
            type: 'POST',
            dataType: 'json',
            url: url,
            success: function (response) {
                if(response.success){
                    $('#accounts-grid').html(response.html)
                    successNotify('Payment', response.message)
                }
            },
            complete : function(){
                dellBackgroundBlack()
            }
        });
    }
}