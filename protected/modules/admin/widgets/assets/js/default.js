$(document).ready(function(e){
	$("#substrate, #disableBg, #disableBgCont").click(function(e){
		if($(e.target).closest(".m-overlay").length) return;
		$("#substrate, .m-overlay, #disableBg, #disableBgCont").hide();
		e.stopPropagation();
	});
	
	if(document.body.scrollWidth > '1024' && !navigator.appVersion.match('Android') && !navigator.appVersion.match('iPhone OS')) {
		MOBILE_DEVICE = false;
	} else {
		MOBILE_DEVICE = true;
	}
	
	var linkNumber = Math.floor(Math.random() * ($('.pop-products-tabs').find('a').length - 1 + 1)) + 1;
	linkNumber = linkNumber - 1
	var links = $('.pop-products-tabs').find('a')
	if(links.length){
		links[linkNumber].click()
	}
});
$.fn.extend({
	goHref: function(url){
	
		$(this).click(function(){
			window.location.href = url;
        });
	},
    searchform: function () {
	var $this = $(this);
		$(".seachline-select").hover(function(){
			$('#search_for').show();
			
			$('#search_for li').click(function () {
				$this.find("input[name='search_type']").val($(this).attr('id'));
				$this.find('#section_name').html($(this).html());
				$('#search_for').hide();
			});
		},function(){
			$('#search_for').hide();
		});
    },
	newsMenu: function() {
		var $current_page = 1;

		$(this).find(".main-nav_news_count").on('click',function(){
			if($(".main-nav_news_popup").find('#sep_line_data').length == 0) {
				$.ajax({
					url: '/widgets/getnews/',
					beforeSend: function(){
						$("#cont_news_menu").show();
					},
					success: function(data){
						var data = JSON.parse(data);

						if(data.success) {
							$("#cont_news_menu").html(data.html);
							$('#substrate').show();
						}
					}
				});
			
			} else {
				if ($(".main-nav_news_popup").css("display")=="none") {
					$(".main-nav_news_popup").css({display: "block"});
					$('#substrate').show();
				} else {
					$(".main-nav_news_popup").css({display: "none"});
					$('#substrate').hide();
				}			
			}
		});

		$('#cont_news_menu').on('click',".radio_button, #go_left, #go_right",function(){
		
			$pstr = $(this).attr('id').split('_');
			if($pstr[0] == 'go') {
				if($pstr[1] == 'right') {
					$pstr[1] = Math.round(parseInt($current_page)+1);
				} else if($pstr[1] == 'left') {
					$pstr[1] = Math.round(parseInt($current_page)-1);
				}
			}

			if($pstr[1] == '3') $('#go_right').hide();
			else $('#go_right').show();
			
			if($pstr[1] == '1') $('#go_left').hide();
			else $('#go_left').show();

		
			$('#radio_'+$current_page).removeClass('isActive');
			$('#radio_'+$pstr[1]).addClass('isActive');
			
			$('#str_'+$current_page).hide();
			$('#str_'+$pstr[1]).show();
			$current_page = $pstr[1];
		});
    },
	newsMain: function() {
		var $current_page = 1;
		$('#main_news').find(".radio_button").click(function () {
			$pstr = $(this).attr('id').split('_');
	
			$('#radio_main_'+$current_page).removeClass('active');
			$('#radio_main_'+$pstr[2]).addClass('active');

			$('#str_main_'+$current_page).hide();
			$('#str_main_'+$pstr[2]).show();
			$current_page = $pstr[2];
		});
    },
    headerPanel: function() {

        $(".widget_hasPopup").mouseover(function () {
            if($(this).find('.count-numbers') && $(this).find('.count-numbers').text() != '') {
                $(this).addClass("widget_opened");
            }
        });

        $(".widget_hasPopup").mouseleave(function () {
			if($(this).attr('id') != 'profile_pointer') $(this).removeClass("widget_opened");
        });
		
		$("#profile_pointer").click(function () {
			if($(this).find('.widget_popup2').css("display") == "none") {
				$(this).addClass("widget_opened");
				$('#substrate').show();
			} else {
				$('#substrate').hide();
				$("#profile_pointer").removeClass("widget_opened");
			}
        });
		
		$("#substrate").click(function () {
			$('#substrate').hide();
            $("#profile_pointer").removeClass("widget_opened");
        });		
		
		$("#left_panel").click(function () {
			$("body,html").animate({scrollTop: 0}, 0);
		});

		$(window).scroll(function() {
			if(!MOBILE_DEVICE) {
			//header scroll
				if($(window).scrollTop() > 60) {
					$("header").addClass("wrapper_head_fixed");
					$("body").addClass("body-paddingTop");
				} else {
					$("header").removeClass("wrapper_head_fixed");
					$("body").removeClass("body-paddingTop");
				}
			//show left panel
				if($(window).scrollTop() > 120) { 
					$op = $(window).scrollTop()*0.001;
					$('#left_panel').show();
					$("#left_panel").css("opacity",$op);
				} else {
					$("#left_panel").hide();
					$("#left_panel").css({opacity:0});
				}
			}
		});
		
		jQuery(function(){$('body').on('keyup','#searchYama',function(event){
                var e = event.keyCode;
                if(e==39) {
                    this.value = $(".seachline-dis").attr('value');
                }
            });
        });

        jQuery(function(){$('body').on('keyup','#autocomplete, #searchYama',function(event){
                if(this.value.length < 2){
                    $(".seachline-dis").attr('value', '');
                    return;
                }
                var e = event.keyCode;
                if(this.value.substring(0, this.value.length) != $(".seachline-dis").attr('value').substring(0,this.value.length)){
                    $(".seachline-dis").attr('value', '');

					jQuery.get('/widgets/hint', {query: this.value}, function(data) {1
                        var result = jQuery.parseJSON(data);
                        $(".seachline-dis").attr('value', result.hint);
                    })

                    return;

                } /*else if(e==39) {
                    this.value = $(".seachline-dis").attr('value');
                }*/
            });
        });
    },
    compareCheck: function(section_id){
        var $this = $(this), ar=$this.attr('id').split('_'), section_id=ar[2];

        var state = function($this){
            $p = $this.closest("p"),
                $label = $p.find("label"),
                textLabels = ["Выбрать для сравнения", "Сравнить выделенные!", "Выберите еще один товар для сравнения"]

            if ($this.attr('checked'))
            {
                $p.addClass("choosen")

                if ($this.hasClass("notext"))
                    $label.css("background-position", "0 -17px")
                else
                    $label.text( textLabels[1] )

                $label.click(function(e){
                    e.preventDefault()
                    //$('.choose input').attr({disabled:true})
                    //window.location="http://"+window.location.host+"/compare/?sec_id="+section_id
                    window.open("http://"+window.location.host+"/compare/?sec_id="+section_id)
                    return false;
                })
            }
            else
            {
                $p.removeClass('choosen')

                if ($this.hasClass("notext"))
                    $label.css("background-position", "0 0")
                else
                    $label.text( textLabels[0] );

                $label.unbind("click")
            }
        };

        if ($this.attr('checked')) state($this);

        $this.change(function(){
            var $inp = $(this)

            $inp.attr({disabled:true})
            $.get("index.php", {block : "c_compare", action : $inp.attr('checked') ? "add" : "delete", pid : $inp.val()},
                function(){
                    state($inp)
                    $inp.attr({disabled:false})
                }
            )
            //loadScript('my_jquery');
            //loadCSS("social");
            //$('#bottom_panel').load("index.php?load_block=bottom_panel");
            return true;
        })

    },
    suggest: function (url) {
        var $this = $(this),
            $container = $("#autocomplete_choices"),
            $items = $container.find(".items"),
            pos = $this.position()

        $this.attr("autocomplete", "off")

        //		$container.css({
        //			top: 0,
        //			left: 0,
        //			position: "relative"
        //		     //width: $this.width() + 43
        //		})

        var BUTTON = {
                UP:38,
                DOWN:40,
                ENTER:13,
                ESC:27,
				RIGHT:39
            },
            MIN_COUNT_TEXT = 2

        $(document).click(function(e)
        {
            if(!$(e.target).closest("#autocomplete_choices").length)
            {
                $container.hide(0)
            }
        });

        var timer = null;

        $this.keyup(function(e) {
            clearTimeout(timer);
            
			if(e.keyCode == BUTTON.RIGHT) {
				$(this).val($("#gs_taif0").val());
			}

			var send_value = $(this).val().split(" ").join('+');

            if(e.keyCode != BUTTON.UP && e.keyCode != BUTTON.DOWN && e.keyCode != BUTTON.ENTER && send_value.length >= MIN_COUNT_TEXT || e.keyCode == BUTTON.RIGHT)
            {
                timer = window.setTimeout(function() {
                    //$this.css("background-image","")
                    $items.load(url+'&search_type='+$("#searchform input[name='search_type']").val()+'&term='+send_value,{},
                        function(data) {
                            //$this.css("background-image","none").empty();

                            data = data.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
                            if (data!='')
                            {
                                $container.show();

                                mouseMarkOut();
                                UpDownMarkOut();

                                clickSelect();

                                /*$container.find(".prices .more a").notifyProduct();*/

                                $container.find('.select_for input').each(function(){$(this).compareCheck(0)});
                            }
                            else
                            {
                                $container.hide();
                            }
                        }
                    );
                }, 700);
            }
        });

        var mouseMarkOut = function()
        {
            $items.find(".item").mouseover(function(){
                $items.find(".selected").removeClass("selected")
                $(this).addClass("selected")
                $(this).find('.choose').show(0)
            });

            $items.find(".item").mouseout(function(){
                $(this).find('.choose').each(function(){
                    if (!$(this).hasClass('choosen'))
                    {
                        $(this).hide(0)
                    }
                })
            })
        }

        var UpDownMarkOut = function() {
            $(document).unbind("keyup")
            $(document).keyup(function(e){
                var c = e.keyCode
                if (c == BUTTON.ESC)
                {
                    clearTimeout(timer)
                    $container.hide(0)
                }
                else if(c == BUTTON.DOWN || c == BUTTON.UP)
                {
                    var li = $items.find(".item")
                    var max_li = li.length - 1

                    var select_li = $items.find(".selected")

                    var index = 0

                    if(select_li.length)
                    {
                        $(li).each(function(i, el){
                            if($(el).attr("id") == select_li.attr("id"))
                            {
                                index = i
                                $(el).removeClass("selected")
                            }
                        })
                    }

                    if(c == BUTTON.UP)
                    {
                        index = (index - 1 < 0) ? max_li : index - 1
                    }
                    if(c == BUTTON.DOWN)
                    {
                        index = (index + 1 > max_li) ? 0 : ((index != 0 || select_li.length) ? index+1 : index)
                    }

                    $(li).each(function(i, el){
                        if(i == index)
                        {
                            $(el).addClass("selected").autoscroll()
                        }
                    })
                }
                else if (c == BUTTON.ENTER)
                {
                    e.preventDefault();
                    enterSelect()
                    return false
                }
                return true
            })
        }

        var clickSelect = function()
        {
            $items.find(".item").click(function(e){
                if ($(e.target).is("a") || $(e.target).closest("a").length>0 || $(e.target).closest(".select_for").length>0) return true;

                setValue( $(this).find(".title a").text() )
                return false
            })
        }

        var enterSelect = function()
        {
            var name = $items.find(".selected").find(".title a").text()

            if(name.length)
            {
                setValue(name)
            }
        }

        var setValue = function(name)
        {
            $this.val(name)
            $container.hide(0)
        }
    },
      bookmark: function(t){
        var $star = $(this).find('#mark-star');
        var defaultStar = $star.attr('class');
        var $edit = 0;
        var $obj = $(this).parent().parent().find('.item');

        $star.mouseover(function () {
            $(this).toggleClass('active');
        });
        $star.mouseout(function () {
            if($edit == 0) {
                $(this).toggleClass('active');
            } else {$edit = 0;}
        }).click(function () {
                var $id = $(this).parent().parent().attr('id');
                if(t != '') {
                    $edit = 1;
                    $.ajax({
                        url: "index.php?block=bookmark&type="+t+"&id="+$id,
                    });
                }
            });
    },
	
/*     bookmark: function(t){
        var $star = $(this).find('#mark-star');
        var defaultStar = $star.attr('class');
        var $edit = 0;
        var $obj = $(this).parent().parent().find('.item');
		var $id = $(this).attr('id');

        $star.mouseover(function () {
            $(this).toggleClass('active');
        });
        $star.mouseout(function () {
            if($edit == 0) {
                $(this).toggleClass('active');
            } else {$edit = 0;}
        }).click(function () {
			$add_bookmark();
        });
			
		$(this).find('.word').click(function () {
			$add_bookmark();
        });
			
		$add_bookmark = function(){
			if(t != '') {
				$edit = 1;
				$.ajax({
					url: "index.php?block=bookmark&type="+t+"&id="+$id,
					success: function(data){
						//$('#bottom_panel').load("index.php?load_block=bottom_panel");
					}
				});
			}
		}	
    }, */
    help: function() {
        var $this = $(this)

        $this.click(function(event){
            event.preventDefault();

            var $popup = $("#popup_help"),
                $mask = $("#mask")

            if ($popup.length==0)
            {
                $popup = $("<div class=\"popup\" id=\"popup_help\"><a href=\"javascript:void(0)\" class=\"close\"><img src=\"img/design/popup_close.gif\" border=0 /></a><div class=\"cont\">Загрузка...</div></div>")
                    .appendTo("body")
                    .css({
                        left:$(document).scrollLeft() + 300,
                        top: $(document).scrollTop() + 100
                    })
            }

            if ($mask.length==0)
            {
                $mask = $("<div id=\"mask\"></div>").appendTo("body")
            }

            var popupHide = function(){
                $popup.hide(0);
                $mask.hide(0)
            }

            $mask
                .css({
                width: $(document).width(),
                height: $(document).height(),
                opacity: 0.3
            })
                .show()
                .click(function(){
                    popupHide()
                })

            $popup
                .css({
                top: 150,
                left: ($(window).width()-$popup.width())/2,
                position: "fixed"
            })
                .show()

            $popup.find(".close").click(function(){
                popupHide()
            })

            $popup.find(".cont").text("Загрузка...").load($(this).attr("href"), function(){
                $popup.css({
                    left: ($(window).width()-$popup.width())/2
                })
            })

            $(document).keydown(function(e){
                if(e.keyCode==27) popupHide();
            })

            return false
        })
    }

});

//внешние функции
function setCookie(name, value, expires) {
    var oneWeek = expires * 24 * 60 * 60 * 1000;
    var expDate = new Date () ;
    expDate.setTime (expDate.getTime() + oneWeek);
    document.cookie=name+"="+value+";expires="+expDate. toGMTString()+"; path=/; "+document.location.host;
}
function getCookie(name) {
    var prefix = name + "="
    var cookieStartIndex = document.cookie.indexOf(prefix)
    if (cookieStartIndex == -1)
        return null
    var cookieEndIndex = document.cookie.indexOf
        (";", cookieStartIndex + prefix.length)
    if (cookieEndIndex == -1)
        cookieEndIndex = document.cookie.length
    return unescape(document.cookie.substring
        (cookieStartIndex + prefix.length, cookieEndIndex))
}
function loadCSS(id) {
    var head = document.getElementsByTagName("head")[0] || document.documentElement;
    link = head.getElementsByTagName("link");
    flagcss = '0';
    if(flagcss == '0') {
        for ( var i = 0; i < link.length; i++ ) {
            if(link[i].getAttribute('id') == id+'_css') {flagcss = '1';}
        }
    }        if(flagcss == '0') {
        var el = document.createElement('link');
        el.id=id+'_css';
        el.rel='stylesheet';
        el.media='all';
        el.type='text/css';
        el.href='http://migom.by/css/'+id+'.css';
        head.appendChild(el);
    }
}
function loadScript(id) {
    var head = document.getElementsByTagName("head")[0] || document.documentElement;
    script = head.getElementsByTagName("script");
    flagjs = '0';
    if(flagjs == '0') {
        for ( var i = 0; i < script.length; i++ ) {
            if(script[i].getAttribute('id') == id+'_js') {flagjs = '1';}
        }
    }
    if(flagjs == '0') {
        var el = document.createElement('script');
        el.id=id+'_js';
        el.type='text/javascript';
        el.language='javascript';
        el.src='http://migom.by/js/'+id+'.js';
        head.appendChild(el);
    }
}
function CreatElement(element,id,classN) {
    var el = document.createElement(element);
    if(id) {el.id = id;}
    if(classN) {el.className = classN;}
    document.body.appendChild(el);
    return document.getElementById(id);
}
function cElem(element,id,classN,app) {
    var el = document.createElement(element);
    if(id) {el.id = id;}
    if(classN) {el.className = classN;}
    app.appendChild(el);
    return el;
}
function trim(str) {
    var newstr=str.replace(/^\s+|\s+$/,"");
    return newstr;
}
function remove(idElem) {
    elem = document.getElementById(idElem);
    if (elem) elem.parentNode.removeChild(elem);
}

function hide(idElem) {
    elem = document.getElementById(idElem);
    if (elem) elem.style.display = "none";
}

document.onkeyup = function(e){
    e = e || window.event;
    if(e.keyCode == 27) {hide('disableBg');}
}
