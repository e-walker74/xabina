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

(function($){
    jQuery.fn.dropDown = function(options){

        options = $.extend({
            list: {},   //object with elements to be in dropdown menu;
            toChange: true,  //change layout
			callback: function(){}
        }, options);


        var $dropDown;

        function createDropDown(){
            var dropDown = '<ul class="dropdown_list list-unstyled ' + options.listClass + '">';
            for ( var prop in options.list )
                dropDown += '<li><a href="#">'+  options.list[prop] +'</a></li>';
            dropDown += '</ul>';
            return dropDown;
        }

        function removeDropDown(){
            $('.dropdown_list').remove();
        }

         var init = function (){

             var self = $(this);


             $('body').click({self: self}, function(e){
                 debugger;
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
                 removeDropDown();
				 options.callback()
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

