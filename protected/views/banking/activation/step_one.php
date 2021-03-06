
	<div class="h1-header"><?= Yii::t('Front', 'Account activation'); ?></div>
	<div class="xabina-progress-bar">
		<div class="step step1 current">
			<div class="step-name"><?= Yii::t('Front', 'Personal information'); ?></div>
			<div class="step-arr"></div>
		</div>
		<div class="step step2">
			<div class="step-name"><?= Yii::t('Front', 'Upload files'); ?></div>
			<div class="step-arr"></div>
		</div>
		<div class="step step3">
			<div class="step-name"><?= Yii::t('Front', 'Activation'); ?></div>
			<div class="step-arr"></div>
		</div>
	</div>
	<?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'activation-from-first-step',
			'action' => Yii::app()->createUrl('/banking/accountsactivation').'/',
            'enableAjaxValidation'=>true,
            'enableClientValidation'=>false,
			'errorMessageCssClass' => 'error-message',
			'htmlOptions' => array(
				'class' => 'form-validable',
				//'onsubmit'=>"return false;",/* Disable normal form submit */
				//'onkeypress'=>" if(event.keyCode == 13){ send(); } "
			),
            //'focus'=>array($model,'first_name'),
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
				'validateOnChange'=>true,
				'errorCssClass'=>'input-error',
				'successCssClass'=>'valid',
				'afterValidate' => 'js:function(form, data, hasError) {
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
						return true;
					}
				}',
				'afterValidateAttribute' => 'js:function(form, attribute, data, hasError) {
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
				}'
			),
	)); ?>
	<div class="h2-header"><?= Yii::t('Front', 'Personal information'); ?></div>
	<div class="xabina-form-container ">
	   <div class="form-row clearfix">
			<div class="col-lg-5 col-md-5 col-sm-5">
				<div class="field-lbl">
					<?= $model->getAttributeLabel('first_name') ?> 
					<span class="tooltip-icon " title="<?= Yii::t('Front', 'Add Your first name using latin alphabet'); ?>"></span>
				</div>
				<div class="field-input">
					<?= $form->textField($model, 'first_name', array('autocomplete' => 'off', 'class' => 'input-text jquery-live-validation-on')); ?>
					<span class="validation-icon"></span>
					<?= $form->error($model, 'first_name', array()); ?>
				</div>
			</div>
			<div class="col-lg-5 col-md-5 col-sm-5">
				<div class="field-lbl">
					<?= $model->getAttributeLabel('last_name') ?> 
					<span class="tooltip-icon " title="<?= Yii::t('Front', 'Add Your last name using latin alphabet'); ?>"></span>
				</div>
				<div class="field-input">
					<?= $form->textField($model, 'last_name', array('autocomplete' => 'off', 'class' => 'input-text jquery-live-validation-on')); ?>
					<span class="validation-icon"></span>
					<?= $form->error($model, 'last_name', array()); ?>
				</div>
			</div>
	   </div>
	   <div class="form-row clearfix">
		   <div class="col-lg-5 col-md-5 col-sm-5">
			   <div class="field-lbl">
					<?= $model->getAttributeLabel('email') ?> 
					<span class="tooltip-icon " title="<?= Yii::t('Front', 'Add Your E-Mail that you will use to access online banking'); ?>"></span>
				</div>
				<div class="field-input">
					<?= $form->textField($model, 'email', array('disabled' => 'disabled', 'autocomplete' => 'off', 'class' => 'input-text jquery-live-validation-on')); ?>
				</div>
		   </div>
		   <div class="col-lg-5 col-md-5 col-sm-5">
				<div class="field-lbl">
					<?= $model->getAttributeLabel('phone') ?> 
					<span class="tooltip-icon " title="<?= Yii::t('Front', 'Add Your mobile phone in an international format (e.g. +3100000000)'); ?>"></span>
				</div>
				<div class="field-input">
					<?php if($model->phone){$model->phone = '+'.$model->phone;} ?>
					<?= $form->textField($model, 'phone', array('disabled' => 'disabled', 'autocomplete' => 'off', 'class' => 'input-text jquery-live-validation-on')); ?>
				</div>
		   </div>
	   </div>
	</div>
	<div class="h2-header"><?= Yii::t('Front', 'Personal data'); ?></div>
	<div class="xabina-form-container">
		<div class="form-row clearfix">
			<div class="col-lg-5 col-md-5 col-sm-5">
				<div class="field-lbl">
					<?= $model->getAttributeLabel('address_line_1') ?> 
					<span class="tooltip-icon " title="<?= Yii::t('Front', 'Address line: (Add the street and  house number using Latin alphabet)'); ?>"></span>
				</div>
				<div class="field-input">
					<?= $form->textField($model, 'address_line_1', array('autocomplete' => 'off', 'class' => 'input-text jquery-live-validation-on')); ?>
					<span class="validation-icon"></span>
					<?= $form->error($model, 'address_line_1', array()); ?>
				</div>
			</div>
			<div class="col-lg-5 col-md-5 col-sm-5">
				<div class="field-lbl">
					<?= $model->getAttributeLabel('address_line_2') ?> 
					<span class="tooltip-icon " title="<?= Yii::t('Front', 'Address line 2: (Fill this field if necessary using Latin alphabet)'); ?>"></span>
				</div>
				<div class="field-input">
					<?= $form->textField($model, 'address_line_2', array('autocomplete' => 'off', 'class' => 'input-text jquery-live-validation-on')); ?>
					<span class="validation-icon"></span>
					<?= $form->error($model, 'address_line_2', array()); ?>
				</div>
			</div>
		</div>
		<div class="form-row clearfix">
			<div class="col-lg-5 col-md-5 col-sm-5">
				<div class="field-lbl">
					<?= $model->getAttributeLabel('zip_code') ?> 
					<span class="tooltip-icon " title="<?= Yii::t('Front', 'Zip Code: (Add the Zip Code using Latin alphabet)'); ?>"></span>
				</div>
				<div class="field-input">
					<?= $form->textField($model, 'zip_code', array('autocomplete' => 'off', 'class' => 'input-text jquery-live-validation-on')); ?>
					<span class="validation-icon"></span>
					<?= $form->error($model, 'zip_code', array()); ?>
				</div>
			</div>
			<div class="col-lg-5 col-md-5 col-sm-5">
				<div class="field-lbl">
					<?= $model->getAttributeLabel('town') ?> 
					<span class="tooltip-icon " title="<?= Yii::t('Front', 'Town: (Add the town using Latin alphabet)'); ?>"></span>
				</div>
				<div class="field-input">
					<?= $form->textField($model, 'town', array('autocomplete' => 'off', 'class' => 'input-text jquery-live-validation-on')); ?>
					<span class="validation-icon"></span>
					<?= $form->error($model, 'town', array()); ?>
				</div>
			</div>
		</div>
		<div class="form-row clearfix">
			<div class="col-lg-5 col-md-5 col-sm-5">
				<div class="field-lbl">
					<?= $model->getAttributeLabel('country_id') ?> 
					<span class="tooltip-icon " title="<?= Yii::t('Front', 'Country: (Choose the country from the drop-down menu)'); ?>"></span>
				</div>
				<div class="field-input">
					<div class="select-custom">
						<span class="select-custom-label">
							<?php if($model->country_id): ?>
								<?= Countries::model()->findByPk($model->country_id)->name; // TODO::get from select by js!!! ?>
							<?php else: ?>
								<?= Yii::t('Front', 'Select'); ?> 
							<?php endif; ?>
						</span>
						<?= $form->dropDownList($model, 'country_id', $countries, array('class' => 'country-select select-invisible')); ?>
						<span class="validation-icon"></span>
					</div>
					<?= $form->error($model, 'country_id', array()); ?>
				</div>
			</div>
			<div class="col-lg-5 col-md-5 col-sm-5">
                <!--
				<div class="offert-link">
					<?= Yii::t('Front', 'You have read and agree to the'); ?>
					<a target="_blank" href="<?= Yii::app()->createUrl('site/terms') ?>"><?= Yii::t('Front', 'terms & conditions of Xabina Online Banking'); ?></a>
				</div>
                -->
			</div>
		</div>
		<div class="form-submit">
			<div class="submit-button button-next" onclick="js:next('<?= Yii::app()->createUrl('/banking/accountsactivation').'/' ?>', this)"><?= Yii::t('Front', 'Next'); ?></div>
		</div>
	</div>
	<?php $this->endWidget(); ?>