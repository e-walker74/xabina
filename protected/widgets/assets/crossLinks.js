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
            }).on('hide.bs.dropdown', '.comment.drdn-cont', function(){
                if($(this).find('a.transaction_comment').hasClass('active')){
                    CrossLinks.closeCommentArea($(this), $(this).parent().find('textarea').val())
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
    closeCategoryInput: function(el, id){
		if($(el).closest('.other').find('input[name="category"]').val().length > 0){
			if(id){
				var val = $(el).closest('.other').find('input[name="category"]').val()
				$(el).closest('.other').hide().prev().show().find('select').prepend('<option value="' + id + '">' + val + '</option>');
				$(el).closest('.other').hide().prev().show().find('select option[value="' + id + '"]').attr('selected', true)
			} else {
				$(el).closest('.other').hide().prev().show().find('select option:first').attr('selected', true)
			}
			setAllSelectedValues()
			$(el).closest('.other').find('input[name="category"]').val('')
		} else {
			
		}
        
    },
    changeCategory: function(link){
        var saveButton = $(link)
        var categoryBlock = saveButton.closest('.category-block')
        var selectedOption = categoryBlock.find('select option:selected')
        var new_category = categoryBlock.find('.other input[name="category"]')
        var value = selectedOption.val()
        var new_category_flag = 0
        if(new_category.val().length > 0){
            value = new_category.val()
            new_category_flag = 1
        }
        var cross_type = categoryBlock.find('.other input[name="cross_type"]')

        if(new_category.val().length == 0 && selectedOption.val() == 'other'){
            errorNotify('Error', 'You don`t select category')
            return false;
        }

        $.ajax({
            url: saveButton.attr('data-url'),
            data: {cross_category: value, cross_type: cross_type.val(), new_category: new_category_flag},
            dataType: 'JSON',
            type: 'POST',
            success: function (data) {
                if (data.success) {
                    categoryBlock.find('.change_dropdown').html(data.value)
                    successNotify('', data.message, categoryBlock)
                    CrossLinks.closeCategoryInput(new_category, data.id)
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
        $.ajax({
            url: categoryBlock.attr('data-url'),
            data: {cross_comment: comment},
            dataType: 'JSON',
            type: 'POST',
            success: function (data) {
                if (data.success) {
                    CrossLinks.closeCommentArea(categoryBlock, comment)
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
    },
    closeCommentArea: function(categoryBlock, comment){
//        if(!comment){
//            comment = categoryBlock.find('.casual_text pre').html()
//        }
        if(comment.length){
            categoryBlock.find('.with-info .casual_text pre').html(comment)
            categoryBlock.find('.without-info').hide()
            categoryBlock.find('.with-info').show()
            categoryBlock.find('.transaction_comment').addClass('active')
        } else {
            categoryBlock.find('.with-info .casual_text pre').html('')
            categoryBlock.find('.drdn-cont').removeClass('open')
            categoryBlock.find('.transaction_comment').removeClass('active')
        }
    }
}

CrossLinks.init()