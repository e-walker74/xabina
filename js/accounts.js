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
                    if($('#accounts-grid').length == 0){
                        $('#tab2').html(response.html)
                    } else {
                        $('#accounts-grid').html(response.html)
                    }

                    successNotify('Payment', response.message)
                    bindHoverBtnGroups()
                }
            },
            complete : function(){
                dellBackgroundBlack()
            }
        });
    }
}