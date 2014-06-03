InvoicePage = {
    init: function () {
        var self = this;
        self.addInvoiceOptionByClick();
        self.addInvoiceOption();
        self.currencyChange();

        // Datapicker initialization
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });

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
        /*$('.button-save-invoice').click(function () {
            $('#invoice-form').submit();
        });*/
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
		$('#Form_Invoice_subtotal').val(subtotalAmount.toFixed(2))

        if ( $('.invoice-discount-type-input').val() == '1') {
            discount = subtotalAmount * (parseFloat($('.invoice-discount-input').val())/100);
        } else {
            discount = $('.invoice-discount-input').val();
        }

        $('.invoice-discount-block').text(parseFloat(discount).toFixed(2));
        $('.invoice-total-block').text((subtotalAmount - parseFloat(discount)).toFixed(2));
		$('#Form_Invoice_total').val((subtotalAmount - parseFloat(discount)).toFixed(2))
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
    },
	
	submitInvoice: function(form){
		url = form.attr('action')
		if(form.find('.clicked-button').hasClass('button-next')){
			url = url + '?next=1'
		}

		$.ajax({
			url: url,
			success: function(response) {
				if(response.success){
					successNotify('Invoice', response.message, $('.button-save-invoice'))
					resetPage()
					InvoicePage.currencyChange();
					InvoicePage.countAmountAll();
					if(response.url) {
						window.location.href = response.url
					}
				} else if(response.message){
					errorNotify('Invoice', response.message, $('.button-save-invoice'))
				}
			},
			cache:false,
			async: false,
			data: form.serialize(),
			type: 'POST',
			dataType: 'json'
		});
	}
}

$(function(){
    InvoicePage.init();
});

afterValidate = function(form, data, hasError) {
	form.find("input").removeClass("input-error");
	form.find("input").parent().removeClass("input-error");
	form.find(".validation-icon").fadeIn();
	if(hasError) {
		for(var i in data) {
			$("#"+i).addClass("input-error");
			$("#"+i).parent().addClass("input-error");
			$("#"+i).next(".validation-icon").fadeIn();
		}
		return false;
	}
	else {
		InvoicePage.submitInvoice(form)
		return false;
	}
	return false;
}

afterValidateAttribute = function(form, attribute, data, hasError) {
	if(hasError){
		if(!$("#"+attribute.id).hasClass("input-error")){
			$("#"+attribute.id+"_em_").hide().slideDown();
		}
		$("#"+attribute.id).removeClass("valid").parent().removeClass("valid");
		$("#"+attribute.id).addClass("input-error").parent().addClass("input-error");
		$("#"+attribute.id).next(".validation-icon").fadeIn();
	} else {
		if($("#"+attribute.id).hasClass("input-error")){
			$("#"+attribute.id+"_em_").show().slideUp();
		}
		$("#"+attribute.id).removeClass("input-error").parent().next("error-message").slideUp().removeClass("input-error");
		$("#"+attribute.id).next(".validation-icon").fadeIn();
		$("#"+attribute.id).addClass("valid");
	}
}