<?php if(!Yii::app()->request->isAjaxRequest): ?>
<div class="col-lg-9 col-md-9 col-sm-9" id="steps">
<?php endif; ?>
	<div class="h1-header"><?= Yii::t('Front', 'Verification'); ?></div>
	<div class="xabina-progress-bar verification-page previous">
		<div class="step step1">
			<div class="step-name"><?= Yii::t('Front', 'Verification Method') ?></div>
			<div class="step-arr"></div>
		</div>
		<div class="step step2 current">
			<div class="step-name"><?= Yii::t('Front', 'Verification Steps') ?></div>
			<div class="step-arr"></div>
		</div>
		<div class="step step3">
			<div class="step-name"><?= Yii::t('Front', 'Verification') ?></div>
			<div class="step-arr"></div>
		</div>
	</div>

	<ul class="list-unstyled list-with-icos">
		<li><?= Yii::t('Front', 'We are required to verify your identity before you can send or receive over EUR 2500/00 or equivalent.') ?></li>
		<li><?= Yii::t('Front', 'Verifying your identity increases transactin limits and gives you access to the full wallet functionality.') ?></li>
		<li><?= Yii::t('Front', 'Verification is quick, easy and free.') ?></li>
	</ul>

	<div class="subheader"><?= Yii::t('Front', 'Verification steps') ?></div>
	
	<?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'verification-bankaccount',
			'action' => Yii::app()->createUrl('/verification/verificatinmethod', array('modelId' => 'bankaccount')).'/',
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
		<div class="h2-header"><?= Yii::t('Front', 'Add bank account'); ?></div>
		<div class="xabina-form-container ">
		   <div class="form-row clearfix">
				<div class="col-lg-5 col-md-5 col-sm-5">
					<div class="field-lbl">
						<?= $model->getAttributeLabel('country_id') ?> 
						<span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
					</div>
					<div class="field-input">
						<div class="select-custom">
							<span class="select-custom-label"><?= Yii::t('Front', 'Select'); ?> </span>
							<?= $form->dropDownList($model, 'country_id', $countries, array('class' => 'country-select select-invisible')); ?>
							<span class="validation-icon"></span>
						</div>
						<?= $form->error($model, 'country_id', array()); ?>
					</div>
				</div>
			</div>
			<div class="form-row clearfix">
				<div class="col-lg-5 col-md-5 col-sm-5">
					<div class="field-lbl">
						<?= $model->getAttributeLabel('swift') ?> 
						<span class="tooltip-icon " title="<?= Yii::t('Front', 'Add SWIFT code'); ?>"></span>
					</div>
					<div class="field-input">
						<?= $form->textField($model, 'swift', array('autocomplete' => 'off', 'class' => 'input-text jquery-live-validation-on')); ?>
						<span class="validation-icon"></span>
						<?= $form->error($model, 'swift', array()); ?>
					</div>
				</div>
		   </div>
		   <div class="form-row clearfix">
			   <div class="col-lg-5 col-md-5 col-sm-5">
				   <div class="field-lbl">
						<?= $model->getAttributeLabel('account_number') ?> 
						<span class="tooltip-icon " title="<?= Yii::t('Front', 'Add SWIFT code'); ?>"></span>
					</div>
					<div class="field-input">
						<?= $form->textField($model, 'account_number', array('autocomplete' => 'off', 'class' => 'input-text jquery-live-validation-on')); ?>
						<span class="validation-icon"></span>
						<?= $form->error($model, 'account_number', array()); ?>
					</div>
			   </div>
		   </div>
		   <div class="form-submit">
				<a href="<?= Yii::app()->createUrl('/verification/index') ?>" class="submit-button button-back"><?= Yii::t('Front', 'Back'); ?></a>
				<input type="submit" class="submit-button button-next" onclick="js:next(this); return false;" value="<?= Yii::t('Front', 'Next'); ?>" />
			</div>
		</div>
		<?php $this->endWidget(); ?>
<?php if(!Yii::app()->request->isAjaxRequest): ?>
</div>
<?php endif; ?>
<?php Yii::app()->clientScript->registerScriptFile('/js/verification.js'); ?>