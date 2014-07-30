ManagerWidget = {
    init: function () {
        this.changeState();
        this.getWidgetState();
    },
    changeState: function() {
        $('#manager-accordion').on( "accordionactivate", function( event, ui ) {
            var state = ui.newPanel.length;
            $.ajax({
                url: '/ajax/SetManagerWidgetState/',
                data: {state: state},
                cache: false
            })
        });
    },

    getWidgetState: function () {
        var ret;
        $.ajax({
            url: '/ajax/GetManagerWidgetState/',
            cache: false
        }).done(function(data){
            $('#manager-accordion').accordion({
                heightStyle: "content",
                active: data > 0 ? 0 : '', // if widget_state > 0, turn on first tab
                collapsible: true
            })
        })
    }
}

$(function(){
    ManagerWidget.init();
});
