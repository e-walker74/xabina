
$(function(){

    $('.mask-toggle').on('mouseenter', function(e){
        var $maskedEl = $(this).parents('td').find('.masked-value');
        var $originalEl = $(this).parents('td').find('.original-value');
        $maskedEl.html($originalEl.val());
    })
    $('.mask-toggle').on('mouseleave', function(e){
        var $maskedEl = $(this).parents('td').find('.masked-value');
        var $originalEl = $(this).parents('td').find('.original-value');
        $maskedEl.html(new Array($originalEl.val().length + 3).join('*'));
    });

    if($( ".escape-dialog").length)
    $( ".escape-dialog" ).dialog({
        autoOpen: false,
        appendTo: '#top_container .clearfix',
        dialogClass: 'xabina-popup-alerts',
        height: 'auto',
        minHeight: 0,
        position:{
            my: 'right top',
            at: 'right bottom',
            of: ".user-logout"
        },
        show: 'fadeIn',
        resizable: false
    });

    $( ".user-logout" ).click(function() {
        var $dialog = $( ".escape-dialog" );
        $dialog.dialog( "option", "width", $(this).parents('.clearfix').width());
        $dialog.dialog( "open" );
        return false;
    });
    $('.xabina-dialog .no').click(function(){
        $(this).parents('.xabina-dialog').dialog('close');
        return false;
    });
    $('.xabina-dialog .yes').click(function(){
        // yes callback
    });
    if($( ".remove-dialog").length)
    $( ".remove-dialog" ).dialog({
        autoOpen: false,
        dialogClass: 'xabina-popup-alerts',
        height: 'auto',
        minHeight: 0,
        show: 'fadeIn'
    });

    $('.remove-with-dialog').click(function() {
        var $dialog =  $( ".remove-dialog" );
        $dialog.dialog( "option", "appendTo", $(this));
        $dialog.dialog( "option", "width", $(this).parents('.xabina-form-container').width());
        $dialog.dialog( "option", "position", {
            my: 'right+11 top+15',
            at: 'right bottom',
            of: $(this)
        } );
        $dialog.dialog( "open" );
        return false;
    })

    $('.search-ico').click(function(){
        $(this).hide();
        $(this).parents('.search-opt-cont').find('.messages-addressbook').show();
        $('.messages-header-cont').addClass('open');
        return false;
    });
	
	$('.change_dropdown').click(function(){
        $(this).hide();
        $(this).parent().find('.select-custom').show();
    });

    $('.checkbox-custom').on('click', 'label', function(e){
        if($(this).find('input').prop('checked')){
            $(this).addClass('checked');
            e.stopPropagation();
        }else{
            $(this).removeClass('checked');
            e.stopPropagation();
        }
    });

    if($( ".escape-dialog").length)
    $( ".escape-dialog" ).dialog({
        autoOpen: false,
        appendTo: '#top_container .clearfix',
        dialogClass: 'xabina-popup-alerts',
        height: 'auto',
        minHeight: 0,
        position:{
            my: 'right top',
            at: 'right bottom',
            of: ".user-logout"
        },
        show: 'fadeIn',
        resizable: false
    });

    $('.files-toggle').on('click', function(){
       $(this).toggleClass('closed');
        $(this).hasClass('closed') ? $(this).html('<span>Show all</span>') : $(this).html('<span>Hide</span>');
        $(this).parents('.attachments-cont').find('.attachments-files-list').slideToggle();
        return false;
    });
	
	$('.book_button').on('click', function(){
       $(this).toggleClass('open');
        $(this).parents('li').find('.pay-list').slideToggle();
        return false;
    });
	
	$('.modal-checkbox').on('click', 'label', function(e){
        if($(this).find('input').prop('checked')){
            $(this).addClass('active');
            e.stopPropagation();
        }else{
            $(this).removeClass('active');
            e.stopPropagation();
        }
    });
	
	$('.modal-galka-checkbox').click(function(){
       if($(this).find('input').prop('checked')){
            $(this).addClass('active');
        }else{
            $(this).removeClass('active');
        }
    });
	$('.modal-galka-radiobutton').click(function(){
        debugger;
       if($(this).find('input').prop('checked')){
            $(this).addClass('active');
           $('[name="' + $(this).find('input').prop('name') + '"]').parents('.modal-galka-checkbox').removeClass('active')
        }else{
            $(this).removeClass('active');
        }
    });
	
	/*$('.modal-galka-checkbox').on('click', 'label', function(e){
		alert('asasas');
        if($(this).find('input').prop('checked')){
            $(this).addClass('active');
           // e.stopPropagation();
        }else{
            $(this).removeClass('active');
         //  e.stopPropagation();
        }
    });*/
	
	$('.table-arrow').on('click', function(){
		$(this).toggleClass('open');
		if($(this).hasClass('open'))
			$(this).html('Hide <span></span>');
		else
			$(this).html('Show More <span></span>');
        $(this).parents('.one_tab').find('.hide-tr').slideToggle();
        return false;
    });
	
	$('.no-close').click(function(event){
		event.stopPropagation();
	});
	
	$('.close-dropdown').click(function(){
		$(this).parent().parent().parent().parent().toggleClass('open');
	});
	
	$('.news-files-toggle').on('click', function(){
       $(this).toggleClass('closed');
        $(this).parents('.attachments-cont').find('.attachments-files-list').slideToggle();
        return false;
    });
	
	$('.news-tags-toggle').on('click', function(){
       $(this).toggleClass('closed');
        $(this).parents('.attachments-cont').find('.attachments-tags-list').slideToggle();
        return false;
    });
	
	$('.news-contacts-toggle').on('click', function(){
       $(this).toggleClass('closed');
        $(this).parents('.attachments-cont').find('.attachments-contacts-list').slideToggle();
        return false;
    });
	
	$('.news-category-toggle').on('click', function(){
       $(this).toggleClass('closed');
        $(this).parents('.attachments-cont').find('.attachments-category-list').slideToggle();
        return false;
    });
	
	$('.news-transaction-toggle').on('click', function(){
       $(this).toggleClass('closed');
        $(this).parents('.attachments-cont').find('.attachments-transaction-list').slideToggle();
        return false;
    });
	
	$('.news-arrow-but').on('click', function(){
       $(this).toggleClass('closed');
        $(this).parents('.message-container').find('.news_content').slideToggle();
        return false;
    });
	
	$('.news-filter-but').on('click', function(){
       $(this).toggleClass('closed');
        $(this).hasClass('closed') ? $(this).html('<span>Show Filter</span>') : $(this).html('<span>Hide Filter</span>');
        $(this).parents('.news-filter').find('.filter-content').slideToggle();
        return false;
    });
	
	$('.list_year span').on('click', function(){
		$(".list_year").hide();
		$(".year_and_month .active_year .val_year").html($(this).html());
		$(".year_and_month").show();
    });
	
	$('.active_year').on('click', function(){
		$(".year_and_month").hide();
		$(".list_year").show();
	});
	
	$('.year_and_month label').on('click', function(){
		$(this).toggleClass('active');
		return false;
    });

    $('#add_contact').on('click', function(e){
        $('#search-dropdown').toggleClass('show');
        return false;
    });
	
	$('.ckeditor').redactor({
		 buttons: ['html', 'formatting', 'bold', 'italic', 'deleted', 'unorderedlist', 'orderedlist', 'outdent', 'indent', 'file', 'table', 'link', 'alignment', 'horizontalrule']
	});

    $('.select-img').on('click', '.img-dropdown a', function(e){
        var $context = $(e.delegateTarget);
        $context.find('input[type=hidden]').val($(this).data('id'));
        $context.find('.selected-img img').attr('src', $(this).find('img').attr('src'));
        e.preventDefault();
    })

    $('.dropdown-toggle').on('click', function(){
        $(this).toggleClass('closed');

        $(this).parents('.dropdown-list-cont').find('.list-dropdown-toggle').slideToggle();
        return false;
    })

    $('#personal_manager_toggle').on('click', function(){

        $(this).next('#personal_manager_cont').slideToggle(400, function(){
            $(this).prev('#personal_manager_toggle').toggleClass('opened');
        });
    })

    $('.sidebar-menu').on('click', '> li', function(){
        if($(this).next('.sidebar-submenu').length){
            if($(this).next('.sidebar-submenu:visible').length){
                $('.sidebar-submenu').slideUp(400).prev().removeClass('active');
                $(this).next('.sidebar-submenu').toggleClass('inv').slideUp(400);
            } else{
                $('.sidebar-submenu').slideUp(400).prev().removeClass('active');
                $(this).next('.sidebar-submenu').toggleClass('inv').slideDown();
                $(this).toggleClass('active');
            }

            return false;
        }

    })
    $('.activation-arr').on('click', function(){
        $(this).addClass('opened').parents('.dialogues-messages').find('.dialogues-header').slideDown()
        return false;
    });
    $('.notification-popup').on('click', function(){
        return false;
    })
    $( ".popup-tabs" ).tabs({active: 0});


    $('.message-to-dropdown').on('click', '.checkable', function(){
        $(this).toggleClass('check');
        return false;
    })

    $('.slide-toggle').on('click', function(){
        $(this).toggleClass('closed');
        $(this).parents('.slide-list-cont').find('.list-slide-toggle').slideToggle();
        return false;
    });
});
