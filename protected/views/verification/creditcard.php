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
            'id'=>'verification-creditcard',
			'action' => Yii::app()->createUrl('/verification/verificatinmethod', array('modelId' => 'creditcard')).'/',
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
		<div class="h2-header"><?= Yii::t('Front', 'Add credit card account'); ?></div>
		<div class="xabina-form-container ">
			<div class="form-row clearfix">
				<div class="col-lg-5 col-md-5 col-sm-5">
				   <div class="field-lbl">
						<?= $model->getAttributeLabel('account_holder') ?> 
						<span class="tooltip-icon " title="<?= Yii::t('Front', 'Insert Account Holder'); ?>"></span>
					</div>
					<div class="field-input">
						<?= $form->textField($model, 'account_holder', array('autocomplete' => 'off', 'class' => 'input-text jquery-live-validation-on')); ?>
						<span class="validation-icon"></span>
						<?= $form->error($model, 'account_holder', array()); ?>
					</div>
				</div>
			</div>
			<div class="form-row clearfix">
				<div class="col-lg-5 col-md-5 col-sm-5">
				   <div class="field-lbl">
						<?= $model->getAttributeLabel('account_number') ?> 
						<span class="tooltip-icon " title="<?= Yii::t('Front', 'Account number'); ?>"></span>
					</div>
					<div class="field-input">
						<?= $form->textField($model, 'account_number', array('autocomplete' => 'off', 'class' => 'input-text jquery-live-validation-on')); ?>
						<span class="validation-icon"></span>
						<?= $form->error($model, 'account_number', array()); ?>
					</div>
				</div>
			</div>
			<div class="form-row clearfix">
				<div class="col-lg-5 col-md-5 col-sm-5">
				   <div class="field-lbl">
						<?= $model->getAttributeLabel('expiry_year') ?> 
						<span class="tooltip-icon " title="<?= Yii::t('Front', 'Expiry year'); ?>"></span>
					</div>
					<div class="field-input">
						<div class="select-custom">
							<?php
								$years = array('' => Yii::t('Front', 'Choose'));
								$last = date('Y', time());
								$years[$last] = $last;
								for($i = 1; $i <= 10; $i++){
									$last++;
									$years[$last] = $last;
								}
							?>
							<span class="select-custom-label"><?= Yii::t('Front', 'Choose'); ?> </span>
							<?= $form->dropDownList($model, 'expiry_year', $years, array('autocomplete' => 'off', 'class' => 'country-select select-invisible')); ?>
							<span class="validation-icon"></span>
							<?= $form->error($model, 'expiry_year', array()); ?>
						</div>
					</div>
				</div>
				<div class="col-lg-5 col-md-5 col-sm-5">
				   <div class="field-lbl">
						<?= $model->getAttributeLabel('expiry_month') ?> 
						<span class="tooltip-icon " title="<?= Yii::t('Front', 'Expiry month'); ?>"></span>
					</div>
					<div class="field-input">
						<div class="select-custom">
                            <?php
								$months = array('' => Yii::t('Front', 'Choose'));
								for($i = 1; $i <= 12; $i++){
									$month=sprintf("%02d", $i);
									$months[$month] = $month;
								}
							?>
							<span class="select-custom-label"><?= Yii::t('Front', 'Choose'); ?> </span>
							<?= $form->dropDownList($model, 'expiry_month', $months, array('autocomplete' => 'off', 'class' => 'country-select select-invisible')); ?>
							<span class="validation-icon"></span>
							<?= $form->error($model, 'expiry_month', array()); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="form-row clearfix">
				<div class="col-lg-5 col-md-5 col-sm-5">
				   <div class="field-lbl">
						<?= $model->getAttributeLabel('cvc_code') ?> 
						<span class="tooltip-icon " title="<?= Yii::t('Front', 'cvc code'); ?>"></span>
					</div>
					<div class="field-input">
						<?= $form->textField($model, 'cvc_code', array('autocomplete' => 'off', 'class' => 'input-text jquery-live-validation-on')); ?>
						<span class="validation-icon"></span>
						<?= $form->error($model, 'cvc_code', array()); ?>
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