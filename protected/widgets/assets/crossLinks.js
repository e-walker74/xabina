/**
 * Created by ekazak on 28.09.14.
 */

CrossLinks = {
    init: function () {
        $(document).ready(function(){
            $('.transaction-table-cont').on('click', '.edit_select,.no-close,#tags-add-dropdown', function(event){
                event.stopPropagation();
            }).on('click', function(event){
                CrossLinks.closeCategories()
            }).on('click', '.trans-but', function(event){
                $(this).parent().parent().parent().next().toggle();
            }).on('click', '.change_dropdown', function(event){
                $('.edit_select').hide();
                $('.change_dropdown').show();
                $(this).hide();
                $(this).parent().find('.edit_select').show();
                event.stopPropagation();
            })
        })
    },
    changeCategory: function(link){
        var saveButton = $(link)
        var categoryBlock = saveButton.closest('.category-block')
        var selectedOption = categoryBlock.find('select option:selected')
        $.ajax({
            url: saveButton.attr('data-url'),
            data: {cross_category: selectedOption.val()},
            dataType: 'JSON',
            type: 'POST',
            success: function (data) {
                if (data.success) {
                    categoryBlock.find('.change_dropdown').html(selectedOption.html())
                    successNotify('', data.message, categoryBlock)
                    CrossLinks.closeCategories()
                } else {
                    errorNotify('', data.message, $('.before-files').prev())
                }
            }
        })
        return false;
    },
    closeCategories: function(){
        $('.edit_select').hide();
        $('#tags-add-dropdown').hide();
        $('.change_dropdown').show();
    },
    changeComment: function(link){
        var saveButton = $(link)
        var categoryBlock = saveButton.closest('.comment-block')
        var comment = categoryBlock.find('textarea').val()
        if(comment.length == 0){
            return false;
        }
        $.ajax({
            url: categoryBlock.attr('data-url'),
            data: {cross_comment: comment},
            dataType: 'JSON',
            type: 'POST',
            success: function (data) {
                if (data.success) {
                    categoryBlock.find('.with-info .casual_text').html(comment)
                    categoryBlock.find('.without-info').hide()
                    categoryBlock.find('.with-info').show()
                    categoryBlock.find('.transaction_comment').addClass('active')
                } else {
                    errorNotify('', data.message, $('.before-files').prev())
                }
            }
        })
        return false;
    },
    editComment: function(edit_button){
        var but = $(edit_button)
        var categoryBlock = but.closest('.comment-block')
        categoryBlock.find('.without-info').show()
        categoryBlock.find('.with-info').hide()
        return false;
    }
}

CrossLinks.init()