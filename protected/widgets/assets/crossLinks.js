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
            }).on('click', '.clear-but', function(){
                CrossLinks.closeCategoryInput(this)
            }).on('change', '.select-category', function(){
                if($(this).val() == 'other'){
                    $(this).closest('.select').hide().next().show()
                }
            })
        })
    },
    clickCheckbox: function(link){
        var tr = $(link).closest('tr')
        if(tr.find('.modal-galka-checkbox').hasClass('active')){
            tr.find('.modal-galka-checkbox').removeClass('active');
            tr.find('.modal-galka-checkbox input').attr('checked', false);
        } else{
            tr.find('.modal-galka-checkbox').addClass('active');
            tr.find('.modal-galka-checkbox input').attr('checked', true);
        }
    },
    closeCategoryInput: function(el){
        $(el).closest('.other').hide().prev().show().find('select option:first').attr('selected', true)
        setAllSelectedValues()
        $(el).closest('.other').find('input').val('')
    },
    changeCategory: function(link){
        var saveButton = $(link)
        var categoryBlock = saveButton.closest('.category-block')
        var selectedOption = categoryBlock.find('select option:selected')
        var new_category = categoryBlock.find('.other input')
        var value = selectedOption.val()
        if(new_category.val().length > 0){
            value = new_category.val()
        }

        if(new_category.val().length == 0 && selectedOption.val() == 'other'){
            errorNotify('Error', 'You don`t select category')
            return false;
        }

        $.ajax({
            url: saveButton.attr('data-url'),
            data: {cross_category: value},
            dataType: 'JSON',
            type: 'POST',
            success: function (data) {
                if (data.success) {
                    categoryBlock.find('.change_dropdown').html(data.value)
                    successNotify('', data.message, categoryBlock)
                    CrossLinks.closeCategoryInput(new_category)
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