(function($){
    jQuery.fn.dropDown = function(options){

        options = $.extend({
            list: {},   //object with elements to be in dropdown menu;
            toChange: true  //change layout
        }, options);


        var $dropDown;

       function createDropDown(){
		   console.log(options.list);
		  	
            var dropDown = '<ul class="dropdown_list list-unstyled ' + options.listClass + '">';
            for ( var prop in options.list ){
                dropDown += '<li><a href="#" data-id=' + options.list[prop].id +'>'+  options.list[prop].name +'</a></li>';
			}
		
            dropDown += '</ul>';
			
			
			
            return dropDown;
        }


        function removeDropDown(){
            $('.dropdown_list').remove();
        }

        var init = function (){

            var self = $(this);


            $('body').click({self: self}, function(e){
                //debugger;
                if($(e.target).hasClass('dropdown_button') || $(e.target).parents('.dropdown_button').length ) {
                    e.preventDefault();
                    e.stopPropagation();
                    return;
                }

                if(!$(e.target).hasClass('dropdown_list'))
                    removeDropDown();
            });

            self.on('click', onElemClick);


            function onElemClick(){		
                removeDropDown();
                showDropDown();
            }
            function onListElemClick(e){
                e.stopPropagation();
                e.preventDefault();
                if(options.toChange){
                    self.html($(this).text()+' <span class="currency_drdn_arr"></span>');

                }
				var id = $(this).data('id');
				self.parents('tr').find('input:hidden.type').val(id);
				self.parents('tr').css('background-color',options.bgEdit);
				
                removeDropDown();
            }


            function showDropDown(){
                $dropDown = $(createDropDown());
                $dropDown.on('click', 'a', onListElemClick);
                self.after($dropDown);
				
            }
        };
		
		
		
        return this.each(init);
    }
})(jQuery);
