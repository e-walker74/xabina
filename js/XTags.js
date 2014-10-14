/**
 * Created by ekazak on 08.09.14.
 */

XTags = {
    deleteButtons: function () {
        $(".close-tags").confirmation({
            title: "Are you sure?",
            singleton: true,
            popout: true,
            onConfirm: function () {
                link = $(this).parents(".popover").prev("a")
                $.ajax({
                    url: link.attr('data-url'),
                    success: function(data){
                        if(data.success){
                            successNotify('', data.message, link)
                            link.closest('li').remove()
                        }
                    },
                    dataType: "JSON"
                })
                var parent = $(link).parents('.head-ajax-block')
                return false;
            }
        })
    },
    addTags: function (url) {
        $('#tags-select-dropdown .drop_tags_ul li').on('click', function(){
                    var tag = $(this)
                    $.ajax({
                        url: url,
                    data: {tag_id: tag.attr('data-tag')},
                    dataType: 'JSON',
                        method: 'POST',
                        success: function(data){
                        if(data.success){
                            $('.tags_ul').html(data.entityTagsHtml)
                            successNotify('', data.message, $('.tags_ul'))
                            tag.hide()
                        } else {
                            errorNotify('', data.message, $('.tags_ul'))
                        }
                    }
                })
            })
        $('#tags-add-dropdown').on('click', '.save-dropdown', function(){
            $.ajax({
                url: url,
                data: {text: $('#tags-add-dropdown textarea').val()},
                dataType: 'JSON',
                    method: 'POST',
                    success: function(data){
                    if(data.success){
                        $('.tags_ul').html(data.entityTagsHtml)
                        successNotify('', data.message, $('.tags_ul'))
                        $('.drop_main_block textarea').focus()
                        $('.drop_main_block textarea').val('')
                        $('#tags-add-dropdown').hide()
                        $('#tags-add-dropdown').closest('.drdn-cont').removeClass('open')
                    } else {
                        errorNotify('', data.message, $('.tags_ul'))
                    }
                }
            })
        }).on('keypress', '.drop_main_block textarea', function(event){
            if(event.keyCode == 13){
                $('#tags-add-dropdown .save-dropdown').click();
            }
        })
    }
}