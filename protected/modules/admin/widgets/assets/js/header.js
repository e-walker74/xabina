$(document).ready(function(){
    if($(window).width() < 1040){
        $(".wrapper_content").addClass("wrapper_centered_1000px");
        $(".wrapper_head").addClass("wrapper_centered_1000px");
    }
});
$(window).resize(function(){
    if($(document).width() < 1040){
        $(".wrapper_content").addClass("wrapper_centered_1000px");
        $(".wrapper_head").addClass("wrapper_centered_1000px");
    }
    else if($(document).width() > 1040){
        $(".wrapper_content").removeClass("wrapper_centered_1000px");
        $(".wrapper_head").removeClass("wrapper_centered_1000px");
    }
});

$(document).ready(function(){
    $(".widget_hasPopup").mouseover(function () {
             $(this).addClass("widget_opened");
    });
    $(".widget_hasPopup").mouseout(function () {
             $(this).removeClass("widget_opened");
    });
});

$(document).ready(function(){
    $(".main-menu .main-nav_catalog div").mouseover(function () {
        $(".popup-menu_wrapper").addClass("displayBlock");
    });
    $(".popup-menu_wrapper").mouseover(function () {
        $(".popup-menu_wrapper").addClass("displayBlock");
    });
    $(".popup-menu_wrapper").mouseout(function () {
        if($(".popup-menu_levelTwo").css("display")=="none") $(".popup-menu_wrapper").removeClass("displayBlock");
    });
});

jQuery(window).scroll(function() {
    if(jQuery(window).scrollTop() > 60){
        $(".wrapper_head").addClass("wrapper_head_fixed");
        $("body").addClass("body-paddingTop");
    }
    else {
        $(".wrapper_head").removeClass("wrapper_head_fixed");
        $("body").removeClass("body-paddingTop");
    };
});
