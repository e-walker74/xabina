InvoicePage = {
    init: function () {
        var self = this;
        self.addInvoiceOptionByClick();
        self.addInvoiceOption();
        self.currencyChange();

        // Datapicker initialization
        $('.datepicker').datepicker();

        // Only float selector
        $('.invoice-only-float').live('keypress', function(event) {
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
        $('.invoice-only-float').live('change', function(event) {
            if ( $(this).val() == '' ) {
                $(this).val(0);
                $(this).change();
            }
        });

        $('.invoice-discount-input,.invoice-discount-type-input').change(function () {
            self.countAmountAll();
        });

        $('.invoice-current-currency-input').change(function () {
            self.currencyChange();
        });
    },
    addInvoiceOptionByClick: function () {
        var self = this;
        $('#add-invoice-option').click(function(event){
            event.preventDefault();
            self.addInvoiceOption();
        })
    },
    addInvoiceOption: function () {
        var self = this;
        $.ajax({
            url: $('#add-invoice-option').attr('href'),
            cache: false
        })
            .done(function(html) {
                $( ".invoice-options" ).append(html);
                self.countAmountForOption();
                self.currencyChange();
                self.reloadToolTips();
            });
    },
    countAmountForOption: function () {
        var self = this;
        var $optionItem = $('.invoice-options-block');

        $optionItem.each(function(){
            var $itemAll = $(this).find('.invoice-option-quantity-input,.invoice-option-price-input,.invoice-option-tax-input');
            var $quantityInput = $(this).find('.invoice-option-quantity-input');
            var $priceInput = $(this).find('.invoice-option-price-input');
            var $amountBlock = $(this).find('.invoice-item-amount-block');
            var $taxInput = $(this).find('.invoice-option-tax-input');

            $itemAll.on('change', function(){
                var price = parseFloat($priceInput.val()),
                quantity = parseFloat($quantityInput.val()),
                amount = (price * quantity),
                tax = amount * (parseFloat($taxInput.val())/100);

                $amountBlock.text((amount + tax).toFixed(2));
                self.countAmountAll();
            })
        })
    },
    countAmountAll: function () {
        var subtotalAmount = 0;
        var discount = 0;
        $('.invoice-item-amount-block').each(function(){
            subtotalAmount = subtotalAmount + parseFloat($(this).text());
        })
        $('.invoice-subtotal-block').text(subtotalAmount.toFixed(2));

        if ( $('.invoice-discount-type-input').val() == '1') {
            discount = subtotalAmount * (parseFloat($('.invoice-discount-input').val())/100);
        } else {
            discount = $('.invoice-discount-input').val();
        }

        $('.invoice-discount-block').text(parseFloat(discount).toFixed(2));
        $('.invoice-total-block').text((subtotalAmount - parseFloat(discount)).toFixed(2));
    },
    currencyChange: function () {
        var currencyTitle = $('.invoice-current-currency-input option:selected').text();

        $('.invoice-current-currency-block').text(currencyTitle);
        $('.invoice-discount-type-input option').each(function () {
            if ($(this).val() == '2') {
                $(this).text(currencyTitle);
            }
        });
    },
    reloadToolTips: function () {
        $('.tooltip-icon').tooltip({
            tooltipClass: 'xabina-tooltip',
            placement: 'right',
            position:{
                my: "left+25 top-12",
                at: "right top",
                using: function( position, feedback ) {
                    $( this ).css( position );
                    $( "<div>" )
                        .addClass( "tooltip-arrow" )
                        .addClass( feedback.vertical )
                        .addClass( feedback.horizontal )
                        .appendTo( this );
                }
            }
        });
    }
}

$(function(){
    InvoicePage.init();
});