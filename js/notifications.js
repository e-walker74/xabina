/**
 * Created by ekazak on 04.10.14.
 */

Notifications = {
    init: function(){
        $(".news-tabs-cont").tabs({
            select: function (event, ui) {
                window.location.hash = ui.tab.hash;
            },
            beforeActivate: function (event, ui) {
                var link = ui.newTab.find('a')
                if (link.attr('data-url')) {
                    Notifications.getTab(link.attr('data-url'), link)
                }
            },
            create: function (event, ui) {
                var link = ui.tab.find('a')
                if (link.attr('data-url')) {
                    Notifications.getTab(link.attr('data-url'), link)
                }
            }
        });

        if($('.news_tabs').length)
            $('.news_tabs').lavalamp({
                easing: 'easeInCubic',
                duration:    300,
                activeObj: 'ui-state-active',
                setOnClick:  true
            });
    },
    getTab: function(url, link){
        var link = $(link)

        $.ajax({
            url: url,
            success: function (response) {
                if (response.success) {
                    $(link.attr('href')).html(response.html)
                }
            },
//            async: false,
            cache: false,
            type: 'POST',
            dataType: 'json'
        });
    }
}

Notifications.init()