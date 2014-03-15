(function($){
    jQuery.fn.currencyDropDown = function(options){

        options = $.extend({
            currencies: {}   //object with currencies in dropdown menu;
        }, options);

        var $dropDown;

        function createDropDown(){
            var dropDown = '<ul class="currency-dropdown list-unstyled">';
            for ( var prop in options.currencies )
                dropDown += '<li><a href="#">'+  options.currencies[prop] +'</a></li>';
            dropDown += '</ul>';
            return dropDown;
        }

        function removeDropDown(){
            $('.currency-dropdown').remove();
        }

        $(document).click(function(e){
            if($(e.target).hasClass('currency_button')) return;
            if(!$(e.target).hasClass('currency-dropdown'))
                removeDropDown();
        });


         var init = function (){

             var self = $(this);



             self.on('click', onElemClick);


             function onElemClick(){
                 removeDropDown();
                 showDropDown();
             }
             function onListElemClick(e){
                 e.stopPropagation();
                 e.preventDefault();
                 self.text($(this).text());
                 removeDropDown();
				 changeSum($(this).text());
             }

			 function changeSum(currency){
				$('.total_currencies span').hide();
				$('.total_currencies .'+currency).show();
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
