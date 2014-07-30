$.fn.extend({

    buttonvoice: function () { //TODO убрать из шаблона вызов
        $('.button-voice').live('click', function(event){});
	
	},
});

var allPermitCount = 1024;

function voteJson($type, $btn){
	var $id = $btn.parent().parent().parent().find('.comment_id').val();
	var $entity_type_id = $('#entity_type_id').val();
	$.ajax({
		type: 'GET',
		url: '/api/likes/' + $type + '/',
		data: { "entity_type_id": $entity_type_id, 'id':$id, 'type':'json', 'entity_id':$('#addcomm').find('.entity_id').val()},
		success: function(data){
			if(data.success == true){
				var mainVote = $('#comment_'+$id+' .vote').first();
				var mainVoteVal = parseFloat(mainVote.text().replace("+",""));
				if(isNaN(mainVoteVal)){
					mainVoteVal = 0;
				}
				var result = parseFloat($($btn).prev().text()) + 1;
				$($btn).prev().hide(); 
				$($btn).prev().text(result);
				$($btn).prev().slideDown("slow");
				
				var classSecond;
				var voteDiff;
				
				if($type == 'voiceup'){
					voteDiff = 1;
					classSecond = 'down';
				}else{
					voteDiff = -1;
					classSecond = 'up';
				}
				
				if(data.new == false){
					voteDiff = voteDiff * 2;
					result = $($btn).parent().parent().find('.'+classSecond+ ' span').first();
					var cnt = parseFloat(result.text()) - 1;
					result.text(cnt);
				}
				mainVoteVal = (mainVoteVal + voteDiff);
				
				if(mainVoteVal > 0){
					mainVoteVal = '+'+mainVoteVal;
					mainVote.removeClass('red').addClass('green');
				}else{
					mainVote.removeClass('green').addClass('red');
				}
				mainVote.hide(); 
				mainVote.text(mainVoteVal);
				mainVote.slideDown("slow");
				
			}
		},
	  dataType: 'json'
	});
}

function commentFormHide(){
	$('.b-news-comments__item .b-news-comments__reply-form').removeClass('active');
	$('.b-news-comments__item-bottom').removeClass('active');
}

$(document).ready(function(){
	var id = window.location.hash;
	if(id != ''){
		var dist = $(id).offset().top-80;
		jQuery("html,body").animate({scrollTop: dist}, 450);
		$(id + ' > .b-news-comments__one_item .b-news-comments__reply-form').addClass('active').find('textarea').focus(); 
	}

	if(window.location.hash == '#commentform') {
		$('#author-message').focus();
	}

	//Vote-up
	$(".up .b-vote-up__link").live('click',function(e){
		e.preventDefault();
		voteJson('voiceup', $(this));
	});
	$(".down .b-vote-up__link").live('click',function(e){
		e.preventDefault();
		voteJson('voicedown', $(this));
	});
	
	//Toggle-comments
	$(".b-news-comments__item .toggle-link").click(function(e){
		e.preventDefault();
		$(this).toggleClass('active');
		$(this).prevAll('.b-news-comments__item').toggle();
	});
	
	//Toggle-comments-form
	$('.b-news-comments__item-bottom .answer-link').live('click',function(e){
		e.preventDefault();
		commentFormHide();
		$(this).parent().parent().toggleClass('active');
		$(this).parent().parent().next().toggleClass('active').find('textarea').focus();
	});
	//$('#news_title').text('«' + $('.b-news-item h1.b-news-item__title-1 span').text());
	
	$('.b-news-comments__one_item').live("mouseover", function () {
		$('.b-news-comments__item_answer', this).css('visibility','visible');
	});
	$('.b-news-comments__one_item').live("mouseleave", function () {
		$('.b-news-comments__item_answer', this).css('visibility','hidden');
	});
	
    $('form .btn-submit-1').live('click', function(event){
		event.preventDefault();
		var objSubmit = $(this);
        $(this).parent().parent().each(function(){
            var $frm = $(this)
			comment  = trim($frm.find('textarea').attr('value'));
			
			if(comment == 0) {alert('Вы не написали комментарий!!');return false;}
			//if(comment.length > allPermitCount) {alert('Извините, но в данное поле Вы можете ввести не более '+allPermitCount+' символов!');return false;}
			
			level = parseInt($frm.parent().parent().attr('id'));
			if(!level && level != 0) {level=0;margin=0;mainClass='box-comment';bappendTo = $frm.parent().parent();}
			else {level =  Math.round((level+1)*100)/100;margin = Math.round((level*20)*100)/100;mainClass='box-answer';bappendTo = $frm.parent().parent().parent()}
			t = new Date();
			
			//submit
			$(objSubmit).attr('disabled','disabled');
			var $parent_id = $frm.find('.parent_id').val();
			$.ajax({
				type: 'POST',
				url: '/api/comments/add/',
				data: { "entity": $('.entity').val(), 'entity_id':$('.entity_id').val(), 'parent_id':$parent_id, 'text':$frm.find('textarea').val()},
				success: function(data){
					var $insert_mark = $('.next_insert_'+$parent_id);
					$insert_mark.before(data);
					//$insert_mark.html(data);
					jQuery("html,body").animate({scrollTop: $insert_mark.prev().offset().top-280}, 350);
					
					$frm.find('textarea').val('');
					$(objSubmit).attr('disabled', false);
					var $cnt = $('#countcomments').text();
					$cnt++
					$('#countcomments').text($cnt);
					var result = parseFloat($('.comments b').text()) + 1;
					$('.comments b').text(result);
					commentFormHide();
					$('.b-news-comments__title-1').show();
				},
			  dataType: 'html'
			});
			   
		});
    });
	
	        $('.txt-editor').markItUp({
            resizeHandle: 0,
            markupSet: [
                {name:'Жирный текст', key:'B', openWith:'[b]', closeWith:'[/b]', className: 'bold'},
                {name:'Наклонный текст', key:'I', openWith:'[i]', closeWith:'[/i]', className: 'em'},
                {name:'Цитата', openWith:'[quote]', closeWith:'[/quote]', className: 'quote'},
                {name:'Ссылка', key:'L', openWith:'[url=[![Url]!]]', closeWith:'[/url]', placeHolder:'Введите текст', className: 'url'}
            ]
        });

        $('.b-news-comments__reply-form .markItUpHeader').append('<!--small>не менее 20 символов</small-->');
    //$('.box-comment').prodresponses();
});
