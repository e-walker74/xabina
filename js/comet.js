/*** comet functions ***/
var type; //comet type (for msg - 'msg')
var id; //comet type_id (for msg - dialog id)
var user_id; //user_id
var controller; // controller name
var content; // content (for dialogs - text, for, files, cards)
var timeoutWrite; //timeout for write

/*** ajax for dialogs ***/
$(document).ready(function () {
    $('.contact-list li').click(function (event) {
        var xabina_id = $(this).attr('data-xabina-id');
        if (xabina_id && ($('#dialogIndex').length || $('.dialogDetail').length)) {
            var exist = $('.selected-id-list li div#'+xabina_id);
            if (!exist.length) {
                var name = $(this).find('.contact-info .contact-name').html();
                if ($('#dialogIndex [name=newDialog]').length)
                    var input = $('#dialogIndex [name=newDialog]');
                else
                    var input = $('.dialogDetail [name=addDialog]');
                
                if (input.val()) {
                    $('#dialogIndex [name=newDialog]').val($('#dialogIndex [name=newDialog]').val()+','+xabina_id);
                    $('.dialogDetail [name=addDialog]').val($('.dialogDetail [name=addDialog]').val()+','+xabina_id);
                } else {
                    $('#dialogIndex [name=newDialog]').val(xabina_id);
                    $('.dialogDetail [name=addDialog]').val(xabina_id);
                }
                
                $('.selected-id-list').prepend('<li><div class="name" id="'+xabina_id+'">'+name+'</div><a href="#" class="remove" onClick="removeSelectedId($(this));return false;"></a></li>');
            }
        }
        if (event.target.className=='button dialogues')
            return true;
        else
            return false;
    })
    $('.sendContact .one-contact').click(function() {
        var name = $(this).find('.contact-name').html();
        var img = $(this).find('.photo-cont img').attr('src');
        var info = $(this).find('.contact-extra-info').html();
        var cid = $(this).attr('data-id');
        if (cid) {
            if (!$('.send_'+cid).length) {
                if ($('.wrapContacts').length) {
                    var html = '<li class="send_'+cid+'"><div class="btnDelPerson" onClick="delThsPerson($(this));"></div><div class="cImg"><img src="'+img+'" alt="" width="40"></div><div class="cName">'+name+'</div><div class="cInfo">'+info+'</div><div class="hide cId">'+cid+'</div></li>';
                    $('.sendContact .wrapContacts').append(html);
                } else {
                    var html = '<ul class="wrapContacts"><li class="send_'+cid+'"><div class="btnDelPerson" onClick="delThsPerson($(this));"></div><div class="cImg"><img src="'+img+'" alt="" width="40"></div><div class="cName">'+name+'</div><div class="cInfo">'+info+'</div><div class="hide cId">'+cid+'</div></li></ul>';
                    $('.sendContact').prepend(html);
                }
                $(this).hide();
            }
        }
    });
});
function delThsPerson (ths) {
    var ul = ths.closest('ul');
    ths.closest('li').remove();
    if (!ul.find('li').length) {
        ul.remove();
    }
}
function newSendFile () {
    $('.upload-file').removeClass('hide');
    $('.upload-file').show(0);
}
function newSendContact () {   
    $('.sendContact').removeClass('hide');
    $('.sendContact').show(0);
}
function newSendContactHide () {   
    $('.sendContact').hide(0);
    $('.sendContact .wrapContacts').remove();
    $('.sendContact .one-contact').show(0);
}
function deleteSendFile (ths) {
    var uf = ths.closest('.upload-file');
    var count = uf.find('.sendFileForm').length;
    
    ths.closest('.sendFileForm').remove();
    if (count<2) {
        uf.hide();
        uf.find('.clear').remove();
        var html = '<div class="sendFileForm"><span></span><input type="file" name="sendFile[]" onchange="addNewSendFile();"><div class="transaction-buttons-cont btnRemoveDownFile"><a href="#" class="button remove-mini-grey" onClick="deleteSendFile($(this));return false;"></a></div></div><div class="clear"></div>';
        uf.append(html);
    }
}
function deleteAllSendFile () {
    var uf = $('.sendFileForm').closest('.upload-file');
    uf.hide(0);
    uf.html('');
    var html = '<div class="sendFileForm"><span></span><input type="file" name="sendFile[]" onchange="addNewSendFile();"><div class="transaction-buttons-cont btnRemoveDownFile"><a href="#" class="button remove-mini-grey" onClick="deleteSendFile($(this));return false;"></a></div></div><div class="clear"></div>';
    uf.append(html);
}
function addNewSendFile () {
    var uf = $('.upload-file');
    var html = '<div class="sendFileForm"><span></span><input type="file" name="sendFile[]" onchange="addNewSendFile();"><div class="transaction-buttons-cont btnRemoveDownFile"><a href="#" class="button remove-mini-grey" onClick="deleteSendFile($(this));return false;"></a></div></div><div class="clear"></div>';
    uf.append(html);
}
/*
 * delete user from dialog
 */
function delUserFromDialog (ths) {
    var link = ths.attr('data-url');
    if (!link)
        link = ths.attr('href');
    if (link) {
        var ul = ths.closest('.dropdown-menu');

        $.post( link+'&noredir=1', function( data ) {});

        if (ths.hasClass('delete')) {
            var block = ths.closest('.contact-actions');
            block.closest('li').remove();
        } else {
            ths.closest('li').remove();

            if (!ul.find('li.clearfix').length)
                ul.append('<li>...</li>');
        }
    }
    return false; 
}
/*** ajax for dialogs ***/

/*** ajax for dialogs index page ***/
$(document).ready(function () {
    if ($('#dialogIndex').length) {
       $('#dialogIndex .addNew').click(function () {
            var ids = $('#dialogIndex [name=newDialog]').val();
            if (ids) {
                $.post( '/dialogs/new/?ids='+ids,  function( data ) {
                    if (data) {
                        window.location.href = "/dialogs/detail/?id="+data;
                    }
                }); 
            } else {
                $('.selected-id-list .error-message').slideDown(300);
            }
            return false;
        });
    }
    if ($('.dialogDetail').length) {
        $('.dialogDetail .addMore').click(function () {
            var ids = $('.dialogDetail [name=addDialog]').val();
            if (ids) {
                $.post( '/dialogs/add/?ids='+ids+'&dialog_id='+$('.dialogDetail').attr('id').replace('dialogDetail_', ''),  function( data ) {
                    if (data) {
                        window.location.href = "/dialogs/detail/?id="+data;
                    }
                }); 
            } else {
                $('.selected-id-list .error-message').slideDown(300);
            }
            return false;
        });
        
        $('.viewSettings li .with-ico').click(function(){
            $('.viewSettings li .with-ico').removeClass('active');
            if ($(this).hasClass('group'))
                $(this).closest('ul').find('.action').css({'color': '#000'});
            else
                $(this).closest('ul').find('.action').css({'color': '#8A8997'});
            
            var bmini = $(this).closest('.viewSettings').find('.button-mini');
            
            bmini.removeClass('group').removeClass('planet').removeClass('lock')
            
            if ($(this).hasClass('group')) bmini.addClass('group');
            else if ($(this).hasClass('planet')) bmini.addClass('planet');
            else if ($(this).hasClass('lock')) bmini.addClass('lock');
            
            $(this).addClass('active');
            return false;
        })
    }
});
function outOfDialog () {
    if ($('.dialogDetail').length) {
        $('.dialogDetail textarea').attr('READONLY', '1');
        $('.dialogDetail textarea').val('Вы не в диалоге');
        $('.dialogDetail textarea').closest('.custom-input').css({'background': '#f1f1f3'});
        $('.dialogDetail textarea').css({'background': '#f1f1f3'});
        $('.comments-form-cont .form-lbl').hide()
        $('#msgSend').hide()
    }
}
function inDialog () {
    if ($('.dialogDetail').length) {
        $('.dialogDetail textarea').removeAttr('READONLY');
        $('.dialogDetail textarea').val('');
        $('.dialogDetail textarea').html('');
        $('.dialogDetail textarea').closest('.custom-input').css({'background': '#ffffff'});
        $('.dialogDetail textarea').css({'background': '#ffffff'});
        $('.comments-form-cont .form-lbl').show()
        $('#msgSend').show()
        
    }
}
function editDialog (ths) {
    var dialogEdit = '<div class="edit-dialoque-name"><input class="edit-input" maxlength="60" type="text"><a class="ok" onClick="saveName($(this));return false;" href="#"></a></div>';
    var box = ths.closest('.dialogue-name');
    var name = box.find('.linkDialogName').html();
    box.find('.linkDialogName').hide(0);
    box.prepend(dialogEdit);
    box.find('.edit-dialoque-name .edit-input').val(name);
    ths.closest('.editDialogBtn').hide(0);
}
function saveName (ths) {
    var box = ths.closest('.dialogue-name');
    var newVal = box.find('.edit-input').val();
    var dialog_id = ths.closest('li').attr('id').replace('dialog_', '');
    if (newVal) {   
        if (dialog_id) 
            $.get( '/dialogs/saveName/?dialog_id='+dialog_id+'&dialog_name='+newVal, function( data ) {});
        box.find('.linkDialogName').html(newVal).show(0);
        box.find('.editDialogBtn').show(0);
        box.find('.edit-dialoque-name').remove();
    }
}
function checkUsers (dialog_id) {
    if ($('#dialogDetail_'+dialog_id).length) {
        $.get('/dialogs/checkUsers/?dialog_id='+dialog_id, function( data ) {
            if (data) {
                $('#dialogDetail_'+dialog_id+' .dialogues-header .user-actions .contact-select-dropdown').html(data);
            }
        });
    } else if ($('#dialogIndex').length) {
        $.get('/dialogs/checkUsers/?dialog_id='+dialog_id, function( data ) {
            if (data) {
                $('#dialog_'+dialog_id+' .dialogues-name-actions-cont .contact-select-dropdown').html(data);
            }
        });
    }
}
function removeSelectedId (ths) {
    var li = ths.closest('li');
    var idLi = li.find('div.name').attr('id');
    if ($('#dialogIndex [name=newDialog]').length)
        var input = $('#dialogIndex [name=newDialog]');
    else
        var input = $('.dialogDetail [name=addDialog]');
    var inputVal = input.val();
    input.val(""+inputVal.replace(','+idLi+',', ',').replace(','+idLi, '').replace(idLi+',', '').replace(idLi, '')+"");
    li.remove();
    //alert(input.val())
    return false;
}
/*** ajax for dialogs index page end ***/
    
/*** ajax for dialogs detail page ***/
$(document).ready(function () {
    var messanger = new Messanger();
    if ($('.dialogDetail').length) {
        $('#msgTextarea').focusin(function () {$(this).attr('placeholder', '');});//delete placeholder when this focus in
        $('#msgTextarea').keypress(function (event) {
            if(event.keyCode==13 && !event.ctrlKey) {//event.keyCode==10 || (event.ctrlKey && 
                $('[name=msgSendForm]').submit();
                return false;
            } else if(event.keyCode==10 || (event.ctrlKey && event.keyCode==13)) {
                $('#msgTextarea').val($('#msgTextarea').val()+'\n');
            }
        });
        
        $('[name=msgSendForm]').submit(function () {
            sendMessage($(this));
            return false;
        });
        /*** for detail page ***/ 

        var dialoguesBox = document.getElementById("dialogues-list-cont");
        dialoguesBox.scrollTop = dialoguesBox.scrollHeight;


        $('.dialogues-list-cont').scroll(function () {
            if ($(this).scrollTop()<1 && ($('.dialogues-loading').hasClass('hide') || !$('.dialogues-loading').is(':visible'))) {
                loadMsg();
            }
        });
        
        /*** writeMsg start ***/
        $('[name=msgSendForm]').find('#msgTextarea').keyup(function () {
            if ($('[name=msgSendForm]').find('#msgTextarea').val()) {
                clearTimeout(timeoutWrite);
                timeoutWrite = setTimeout(function () {writeMsg()},500);
            }
        });
    }
});
function showMeMsgs () {
    var type_msg = $('.type_msg_show option:selected').val();
    var color_msg = $('.color_msg_show option:selected').val();
    if (color_msg) {
        if (color_msg!='all') {
            $('.dialogues-list li .message-container').closest('li').hide(0);
            $('.dialogues-list li .message-container.'+color_msg+'-border').closest('li').show(0);
        } else {
            $('.dialogues-list li').show(0);
        }
    }
    if (type_msg) {
        if (type_msg=='inc') {
            $('.dialogues-list li .interlocutor-name.author_you:visible').closest('li').hide(0);
            $('.dialogues-list li .interlocutor-name.author_not_you:visible').closest('li').show(0);
        } else if (type_msg=='out') {
            $('.dialogues-list li .interlocutor-name.author_you:visible').closest('li').show(0);
            $('.dialogues-list li .interlocutor-name.author_not_you:visible').closest('li').hide(0);
        } 
    }
    var dialoguesBox = document.getElementById("dialogues-list-cont");
    dialoguesBox.scrollTop = dialoguesBox.scrollHeight;
    //alert(type_msg+'-'+color_msg);
}
function markMsgRead (ths) {
    if (ths.find('.message-container').hasClass('grey')) {
        ths.find('.message-container').removeClass('grey');
        ths.find('.message-container').addClass(ths.find('.message-container').attr('rel'));
    }
}
/*
 * read msg function
 */
function readMsg(msg_id) {
    $('#msg_'+msg_id+' .message-status').removeClass('waiting');
    $('#msg_'+msg_id+' .message-status').addClass('sent');
    
    var delDrop = $('#msg_'+msg_id+' .action.delete').closest('.list-actions-dropdown');
        $('#msg_'+msg_id+' .action.delete, #msg_'+msg_id+' .action.edit').remove();
        if ($('#msgTextarea').length) {
            if ($('#msgTextarea').hasClass('edit')) {
                $('#msgTextarea').val('');
                $('#msgTextarea').html('');
                $('#msgTextarea').css({'background': '#fff'});
                $('#msgTextarea').removeClass('edit').attr('rel', '');
                $('#msgTextarea').closest('.custom-input').css({'background': '#fff'});
            }
        }
    if (!delDrop.find('.clearfix a').length)
        delDrop.closest('.drdn-cont').remove();
    return false;
}
/*
 * write msg function
 */
function writeMsg() {
    controller = 'dialogs';
    type = 'writeMsg';
    id = $('[name=dialogId]').val();
    content = {
        'text': '',
        'for': 'all',
        'files': '',
        'cards': ''
    };
    
    if ($('[name=msgSendForm]').find('#msgTextarea').val())
        push(controller, type, id, content);
    return false;
}
/*
 * write msg view
 */
function writeMsgView(dialog_id, author_id, content) {
    var dialogBox = $("#dialogDetail_"+dialog_id);
        if (dialogBox) {
        var dialoguesBox = document.getElementById("dialogues-list-cont");
        var goto = '';
        if (dialoguesBox)
            if (parseInt((dialoguesBox.scrollTop+490))>(parseInt($('.dialogues-list-cont .dialogues-list').css('height'))-20))
                goto = 1;

        if (dialogBox.length) {

            var dialogUl = dialogBox.find('ul.dialogues-list');

            if (dialogUl.length) {
                var msgExist = dialogUl.find('#write_'+author_id);

                if (!msgExist.length) {

                    dialogUl.append(content);
                    setTimeout(function () {delWriteMsg(author_id);}, 5000);
                    if (dialoguesBox)
                        if (goto)
                            dialoguesBox.scrollTop = dialoguesBox.scrollHeight;
                }
            }
        }
    }
}
function delWriteMsg (author_id) {
    $('#write_'+author_id).remove();
}

/*
 * load old msgs
 */
function loadMsg () {
    if ($('.dialogues-list li:visible').length>9) {
        
        $('.dialogues-loading').removeClass('hide');
        $('.dialogues-loading').slideDown(300);
        var first = parseInt($('.dialogues-list li.msg_li').attr('id').replace('msg_', ''));
        var dialoguesBox = document.getElementById("dialogues-list-cont");
        var scrollHeight = dialoguesBox.scrollHeight;
        $.get( '/dialogs/loadMsg/?msg_id='+first+'&dialog_id='+$('[name=dialogId]').val(), function( data ) {

            var items = data.split('{newLine}');
            if (items.length<11)
                $('.dialogues-loading').remove();
            if (items.length<1) return false;
            for (var i=0;i<items.length;i++) {
                eval(items[i]);
            }

            dialoguesBox.scrollTop = dialoguesBox.scrollHeight-scrollHeight-440;
            $('.dialogues-loading').slideUp(0);
        }); 
        
    }
    
}
/*
 * set color (group) for msg
 */
function setMsgColor (color, msg_id) {
    if (msg_id && color) {
            $('#msg_'+msg_id).find('.message-container').removeClass('grey-border blue-border green-border red-border yellow-border');
            $('#msg_'+msg_id).find('.message-container').addClass(color+'-border')
            $('#msg_'+msg_id).find('.drdn-cont .button-mini.category').removeClass('grey blue green red yellow');
            $('#msg_'+msg_id).find('.drdn-cont .button-mini.category').addClass(color);
        $.get( '/dialogs/setMsgColor/?color='+color+'&msg_id='+msg_id, function( data ) {
            //alert(data)
        }); 
    }
}
/*
 * set color (group) for msg
 */
function markMsg (msg_id) {
    if (msg_id) {      
        $.get( '/dialogs/markMsg/?msg_id='+msg_id, function( data ) {
            $('#msg_'+msg_id+' .message-container').removeClass('white');
            $('#msg_'+msg_id+' .message-container').removeClass('pink');
            $('#msg_'+msg_id+' .message-container').addClass('grey');
			window.location.href = "/dialogs/";
        }); 
    }
    return false;
}
/*
 * delete msg
 */
function deleteMsg (msg_id) {
    if (msg_id) {
        $.get( '/dialogs/deleteMsg/?msg_id='+msg_id, function( data ) {
            if (data)
                $('#msg_'+msg_id).remove();
        }); 
    }
    return false;
}
/*
 * edit msg
 */
function editMsg (msg_id) {
    if (msg_id) {
        if ($('#msg_'+msg_id+' .message-text').length) {
            $('#msgTextarea').val($('#msg_'+msg_id+' .message-text').html());
            $('#msgTextarea').html($('#msg_'+msg_id+' .message-text').html());
            $('#msgTextarea').css({'background': '#f1f1f3'});
            $('#msgTextarea').addClass('edit').attr('rel', msg_id);
            $('#msgTextarea').closest('.custom-input').css({'background': '#f1f1f3'});
        }
        /*$.get( '/dialogs/deleteMsg/?msg_id='+msg_id, function( data ) {
            if (data)
                $('#msg_'+msg_id).remove();
        });*/
    }
    return false;
}
/*** msg send function ***/
function sendMessage(ths) {
    clearTimeout(timeoutWrite);
    var haveMsg = 0;
    var msg = ths.find('#msgTextarea').val().replace('"', '&quot;');
    if ($('.dialogues-list li.msg_li').last().find('.message-container').hasClass('grey')) {
        $('.dialogues-list li.msg_li').last().find('.message-container').removeClass('grey');
        $('.dialogues-list li.msg_li').last().find('.message-container').addClass($('.dialogues-list li.msg_li').last().find('.message-container').attr('rel'));
    }
    var filesWrap = $('.sendFileForm').closest('.upload-file');
    var fid = '';
    if (filesWrap.find('.sendFileForm input').is(':visible')) {
        var fid = filesWrap.find('.sendFileForm .fId').val();
    }
    var cardsWrap = $('.wrapContacts');
    var cid = '';
    if (cardsWrap.is(':visible')) {
        var ncid;
        $('.sendContact .wrapContacts li').each(function() {
            ncid = parseInt($(this).find('.cId').html());
            if (ncid) {
                if (cid)
                    cid = cid+','+ncid;
                else
                    cid = ncid;
            }
            if (cid) {
                haveMsg = 1;
            }
        })
    }
    if (msg || haveMsg) {
        if (ths.find('#msgTextarea').hasClass('edit')) {
            var msg_id = $('#msgTextarea').attr('rel');
            
            $.post('/dialogs/editMsg/', {
                    'msg_id': msg_id,
                    'text': msg
            }, function( data ) {
                //alert(data)
            });
            
            $('#msg_'+msg_id+' .message-text').html(msg);
            $('#msgTextarea').val('');
            $('#msgTextarea').html('');
            $('#msgTextarea').css({'background': '#fff'});
            $('#msgTextarea').removeClass('edit').attr('rel', '');
            $('#msgTextarea').closest('.custom-input').css({'background': '#fff'});
        } else {
            var idFor = '';
            if ($('.with-ico.group.active').length) {
                $('.withIdFor [type=checkbox]:checked').each(function(){
                    if (idFor)
                        idFor = idFor+','+parseInt($(this).attr('class'));
                    else
                        idFor = parseInt($(this).attr('class'));

                });
            } else if ($('.with-ico.lock.active').length) {
                idFor = 'me';
            } else {
                idFor = 'all';
            }

            controller = 'dialogs';
            type = 'msg';
            id = ths.find('[name=dialogId]').val();

            //if ()
            
            content = {'text': msg,'for': idFor,'files': fid+'','cards': cid+''};
            
            push(controller, type, id, content);
            
            $('[name=msgSendForm]').find('#msgTextarea').val('') 
            $('[name=msgSendForm]').find('#msgTextarea').html('') 

            newSendContactHide();
            deleteAllSendFile();
        }
    }
    return false;
}
/*** msg send function END ***/

/*
 * put msg count on dialogs index
 */
function putNewMsgCount (count, dialog_id, text, add_time) {
    if (parseInt(dialog_id)>0) {
        if ($('#dialog_'+dialog_id).length) {
            if (count>0) {
                //alert($('#dialog_'+dialog_id+' .dialogue-count').length)
                if ($('#dialog_'+dialog_id+' .dialogue-count').length) {
                    $('#dialog_'+dialog_id+' .dialogue-count').html(''+count+'');
                } else {
                    if ($('#dialog_'+dialog_id+' .datetime').length)
                        $('#dialog_'+dialog_id+' .datetime').after('<div class="dialogue-count">'+count+'</div>');
                    else if ($('#dialog_'+dialog_id+' .contact-actions').length)
                        $('#dialog_'+dialog_id+' .contact-actions').after('<div class="dialogue-count">'+count+'</div>');
                    else if ($('#dialog_'+dialog_id+' .dialogue-info').length)
                        $('#dialog_'+dialog_id+' .dialogue-info').after('<div class="dialogue-count">'+count+'</div>');
                }
            } else {
                $('#dialog_'+dialog_id+' .dialogue-count').remove();
            }
            /*if (author)
                $('#dialog_'+dialog_id+' .dialogue-name').html(author);*/
            if (text)
                $('#dialog_'+dialog_id+' .dialoque-text').html(text);
            if (add_time)
                $('#dialog_'+dialog_id+' .datetime').html(add_time);
        }
        var html = $('#dialog_'+dialog_id).html();
        $('#dialog_'+dialog_id).remove();
        if (html) {
            $('.dialogues-all-list').prepend('<li id="dialog_'+dialog_id+'">'+html+'</li>')
        } else {
            $.get( '/dialogs/getOneDialog/?dialog_id='+dialog_id+'&ajax=1', function( data ) {
                if (!$('#dialog_'+dialog_id).length) {
                    $('.dialogues-all-list').prepend(data)
                }
            }); 
        }
    }
}
/*** msg put ***/
function putMessage (msg_id, dialog_id, content, direction) {
    //var b = document.createElement('div');
    //b.innerHTML = '<span style="color: red;">'+name+'</span> '+text;
    //$('#messages').append(b);
    var dialogBox = $("#dialogDetail_"+dialog_id);
    var dialoguesBox = document.getElementById("dialogues-list-cont");
    var goto = '';

    if (parseInt((dialoguesBox.scrollTop+490))>(parseInt($('.dialogues-list-cont .dialogues-list').css('height'))-20))
        goto = 1;
    //alert(content);
    if (dialogBox.length) {

        var dialogUl = dialogBox.find('ul.dialogues-list');

        if (dialogUl.length) {
            var msgExist = dialogUl.find('#msg_'+msg_id);
            var last = 1;
            if ($('.dialogues-list li.msg_li').last().length)
                last = parseInt($('.dialogues-list li.msg_li').last().attr('id').replace('msg_', ''));

            if (!last) last = 1;
            //alert(last)
            if (!msgExist.length && last!=msg_id) {

                if (direction=='up') {
                    dialogUl.prepend(content);
                } else {
                    if ($('.dialogues-list .writeMsg').length)
                        $('.dialogues-list .writeMsg').first().before(content);
                    else
                        dialogUl.append(content);
                }

                if (goto)
                    dialoguesBox.scrollTop = dialoguesBox.scrollHeight;
            }
        }
    }
}
/*** msg put END ***/

function Messanger() {
    this.timeout = 3;
    this.comet = 0;
    if ($('.dialogues-list li.msg_li').last().length)
        this.last = parseInt($('.dialogues-list li.msg_li').last().attr('id').replace('msg_', ''));
    if (!this.last) this.last = 1;
    var self = this;
    this.parseData = function(message) {
		
        // split msg
        var items = message.split('{newLine}');
        if (items.length<1) return false;
        for (var i=0;i<items.length;i++) {
            //alert(items[i])
            eval(items[i]);
        }
        if ($('.dialogues-list li.msg_li').last().length)
            self.last = parseInt($('.dialogues-list li.msg_li').last().attr('id').replace('msg_', ''));
        if (!self.last) self.last = 1;
        setTimeout(self.connection,1000);
    }
    this.connection = function() {
        // open connection with server
        if (!self.last) self.last = 1;
        
        if ($('#dialogIndex').length) {
            self.comet = $.ajax({
                    type: "GET",
                    url:  "/comet/?last_id="+self.last+"&page=index",
                    dataType: "text",
                    timeout: self.timeout*2000,
                    success: self.parseData,
                    error: function(){
                        // if something wrong - restart connection
                        setTimeout(self.connection,3000);
                   }
                });
        } else {
            self.comet = $.ajax({
                    type: "GET",
                    url:  "/comet/?last_id="+self.last,
                    dataType: "text",
                    timeout: self.timeout*1000,
                    success: self.parseData,
                    error: function(){
                        // if something wrong - restart connection
                        setTimeout(self.connection,3000);
                   }
                });
        }
    }
    this.init = function() {
        self.connection();
    }
    this.init();
}
/*** ajax for dialogs detail page END ***/

/*
 * push function - push to table "comet"
 * pages: all
 */
function push (controller, type, id, content) {
    if (controller) {  
        $.post( '/'+controller+'/ajaxPush', {
                    'type': type,
                    'id': id,
                    'content': content
                }, function( data ) {
                //alert(data);
        });    
    }
}