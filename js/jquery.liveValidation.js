/***
@title:
Live Validation

@version:
2.0

@author:
Andreas Lagerkvist

@date:
2008-08-31

@url:
http://andreaslagerkvist.com/jquery/live-validation/

@license:
http://creativecommons.org/licenses/by/3.0/

@copyright:
2008 Andreas Lagerkvist (andreaslagerkvist.com)

@requires:
jquery, jquery.liveValidation-valid.png, jquery.liveValidation-invalid.png

@does:
Use this plug-in to add live validation to any form on your page. The plug-in indicates whether a form control is valid or not by switching between any icons of you choosing as the user types.

@howto:
jQuery(document.body).liveValidation();

Run the plug-in on a parent-element of the form-controls you want to affect. If you run it on document.body every form-control in the document will get live validation.

@exampleHTML:
<form method="post" action="">

	<p>
		<label>
			Name<br />
			<input type="text" name="name" />
		</label>
	</p>

	<p>
		<label>
			Email<br />
			<input type="text" name="email" />
		</label>
	</p>

	<p>
		<label>
			Foo<br />
			<input type="text" name="foo" />
		</label>
	</p>

	<p>
		<label>
			Bar<br />
			<input type="text" name="bar" />
		</label>
	</p>

	<p><input type="submit" value="Ok" /></p>

</form>

@exampleJS:
jQuery('#jquery-live-validation-example').liveValidation({
	validIco:	WEBROOT + 'aFramework/Modules/Base/gfx/jquery.liveValidation-valid.png', 
	invalidIco: WEBROOT + 'aFramework/Modules/Base/gfx/jquery.liveValidation-invalid.png', 
	required:	['name', 'email', 'foo'], 
	fields:		{foo: /^\S.*$/}
});
***/
jQuery.fn.liveValidation = function (conf, addedFields) {
	var config = jQuery.extend({
		validIco:		'',						// src to valid icon
		invalidIco:		'',						// src to invalid ico
		valid:			'Valid',				// alt for valid icon
		invalid:		'Invalid',				// alt for invalid icon
		validClass:		'valid',				// valid class
		invalidClass:	'invalid',				// invalid class
		required:		[],						// json/array of required fields
        requiredFields:		{},						// json/array of required fields
		optional:		[], 					// json/array of optional fields
		fields:			{},					// json of fields and regexps
        selects:			{}						// json of fields and regexps
	}, conf);

	var fields = jQuery.extend({
		name: 			/^\S.*$/,				// name (at least one character)
		content: 		/^\S.*$/m,				// "content" (at least one character)
		dimensions:		/^\d+x\d+$/,			// dimensions (DIGITxDIGIT)
		price:			/^\d+$/,				// price (at least one digit)
		url: 			/(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/,	// url
		email: 			/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/	// email
	}, config.fields);

	fields.website = fields.url;
	fields.title = fields.author = fields.name;
	fields.message = fields.comment = fields.description = fields.content;

	var formControls = jQuery.merge(config.required, config.optional);

	if (!formControls.length) {
		return this;
	}

	for (var i in formControls) {
		formControls[i] = ':input[name="' + formControls[i] + '"]:not([disabled])';
	}

	formControls = formControls.join(',');
    var $submitButton = $(config.submitButton);
    var $form = $(this);

    $submitButton.click(function(){
        $form.submit();
    });



	return this.each(function () {
        for( var k in config.selects){
            var $select = $("[name=" + config.selects[k] + "]");
            jQuery('<span class="validation-icon"></span>').insertAfter($select);
            $select.on('change', function(){
                if(!$select.val()){
                    $select.removeClass(config.validClass).addClass(config.invalidClass);
                    $select.next('.validation-icon').hide().fadeIn(500);
                }else{
                    $select.removeClass(config.invalidClass).addClass(config.validClass);
                    $select.next('.validation-icon').hide().fadeIn(500);
                }
            });
        }




		jQuery(formControls, this).each(function () {
			var t			= jQuery(this);
			var isOptional	= false;
			var fieldName	= t.attr('name');
            var message = jQuery('<div class="error-message">Не правильный формат<div class="error-message-arr"></div></div>');


			for (var i in config.optional) {
				if (fieldName == config.optional[i]) {
					isOptional = true;
					break;
				}
			}

			if (t.is('.jquery-live-validation-on')) {
				return;
			}
			else {
				t.addClass('jquery-live-validation-on');
			}

			// Add (in)valid icon
//			var imageType = isOptional ? 'valid' : 'invalid';
			var validator = jQuery('<span class="validation-icon"></span>').insertAfter(t);

            message.insertAfter(validator);
            
            $form.on('submit', onFormSubmit);
            function onFormSubmit(e){
                validate();
                validateSelects();

                if($form.find('.input-error')){
                    e.preventDefault();
                }
            }



            function validateSelects(){
                for( var k in config.selects){
                    var $select = $("[name=" + config.selects[k] + "]");
                    if(!$select.val() && !$select.hasClass(config.invalidClass)){
                        $select.removeClass(config.validClass).addClass(config.invalidClass);
                        $select.next('.validation-icon').hide().fadeIn(500);
                    }
                }
            }

			// This function is run now and on key up
			function validate() {
                
				var key = t.attr('name');
				var val = t.val();
				var tit = t.attr('title');

				// If value and title are the same it is assumed formHints is used
				// set value to empty so validation isn't done on the hint
				val = tit == val ? '' : val;

				// Make sure the value matches
				if (config.requiredFields[key] && val !== ''&&fields[key].match.test(val)) {
					// If it's not already valid
					if (!t.hasClass(config.validClass)) {
						t.removeClass(config.invalidClass).addClass(config.validClass).parents('.form-block').find('.error-message').hide();

                        t.parents('.form-block').find('.mobile-view').hide();
                        t.next('.validation-icon').hide().fadeIn(500);
                        t.parents('.field-input').find('.error-message').slideUp(500);

					}
				}
				// It didn't validate
				else {
					// If it's not already invalid 
					if (!t.hasClass(config.invalidClass)) {
						t.removeClass(config.validClass).addClass(config.invalidClass).parents('.form-block').find('.error-message').show();
                        t.parents('.form-block').find('.mobile-view').show();
                        t.next('.validation-icon').hide().fadeIn(500);
                        t.parents('.field-input').find('.error-message').slideDown(500);
					}
				}
			};

//			validate();
			t.blur(validate);
		});

		// If form contains any invalid icon on submission, return false
		jQuery('form', this).submit(function () {
			return !jQuery(this).find('img[alt="' + config.invalid + '"]').length;
		});
	});
};
