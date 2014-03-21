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
	<div class="subheader"><?= Yii::t('Front', 'Step 1.') ?></div>
	
	<table class=" xabina-table-choose">
		<tbody>
		<tr class="tr-header">
			<td><?= Yii::t('Front', 'Add bank account') ?></td>
		</tr>
		<tr class="list-tr">
			<td>
				<table class="verification-code-table">
					<tbody><tr>
						<td width="20%"><?= $model->getAttributeLabel('country_id') ?>:</td>
						<td width="80%" class="header"><?= $model->id ?></td>
					</tr>
					<tr>
						<td><?= $model->getAttributeLabel('swift') ?>:</td>
						<td class="header"><?= $model->swift ?></td>
					</tr>
					<tr>
						<td><?= $model->getAttributeLabel('account_number') ?>:</td>
						<td class="header"><?= $model->account_number ?></td>
					</tr>
				</tbody></table>
			</td>
		</tr>
		</tbody>
	</table>
	<div class="xabina-alert-success">
		<?= Yii::t('Front', 'You have successfully passed the first stage of verification. We sent to Your bank account in the amount of 0.01EUR. In the description of the transaction specified 6-digit code that you need to enter the second stage to complete the process of verification.'); ?>		
	</div>
	<div class="subheader"><?= Yii::t('Front', 'Step 2.') ?></div>
	<div class="xabina-form-container">
	<?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'verification-creditcard',
			'action' => Yii::app()->createUrl('/verification/creditcard').'/',
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>true,
			'errorMessageCssClass' => 'error-message',
			'htmlOptions' => array(
				'class' => 'form-validable',
				//'onsubmit'=>"return false;",/* Disable normal form submit */
				//'onkeypress'=>" if(event.keyCode == 13){ send(); } "
			),
            //'focus'=>array($model,'first_name'),
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
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
	<table class=" xabina-table-choose">
		<tbody>
		<tr class="tr-header">
			<td><?= Yii::t('Front', 'Verification Code') ?></td>
		</tr>
		<tr class="comment-tr">
			<td colspan="4"><?= Yii::t('Front', 'About verification code. How to find') ?></td>
		</tr>
		<tr class="list-tr">
			<td>
				<div class="field-row field-code">
					<div class="field-lbl">
						<?= $model->getAttributeLabel('verification_code') ?> 
						<span class="tooltip-icon " title="<?= Yii::t('Front', 'Insert verification code'); ?>"></span>
					</div>
					<div class="field-input">
						<?= $form->textField($model, 'verification_code', array('autocomplete' => 'off', 'class' => 'input-text jquery-live-validation-on')); ?>
						<span class="validation-icon"></span>
						<?= $form->error($model, 'verification_code', array()); ?>
					</div>
				</div>
			</td>
		</tr>
		</tbody>
	</table>

	<div class="form-submit">
		<div class="submit-button button-back"><?= Yii::t('Front', 'Back'); ?></div>
		<div class="submit-button button-next" onclick="js:next(this); return false;"><?= Yii::t('Front', 'Next'); ?></div>
	</div>
	<?php $this->endWidget(); ?>
	</div>
<?php if(!Yii::app()->request->isAjaxRequest): ?>
</div>
<?php endif; ?>
<?php Yii::app()->clientScript->registerScriptFile('/js/verification.js'); ?>