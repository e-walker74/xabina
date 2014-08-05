<div class="h1-header"><?= Yii::t('Front', 'Account activation'); ?></div>
<div class="xabina-progress-bar">
	<div class="step step1 ">
		<div class="step-name"><?= Yii::t('Front', 'Personal Information'); ?></div>
		<div class="step-arr"></div>
	</div>
	<div class="step step2 previous">
		<div class="step-name"><?= Yii::t('Front', 'Upload files'); ?></div>
		<div class="step-arr"></div>
	</div>
	<div class="step step3 current">
		<div class="step-name"><?= Yii::t('Front', 'Activation'); ?></div>
		<div class="step-arr"></div>
	</div>
</div>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'activation-form-step-3',
	//'action' => Yii::app()->createUrl('/banking/savefiles').'/',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'errorMessageCssClass' => 'error-message',
	'htmlOptions' => array(
		'class' => 'form-validable',
		'enctype' => 'multipart/form-data'
	),
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
				form.removeClass("success");
				for(var i in data) {
					form.find("#"+i).addClass("input-error");
					form.find("#"+i).parent().addClass("input-error");
					form.find("#"+i).next(".validation-icon").fadeIn();
				}
				return false;
			}
			else {
				return true;
			}
		}',
		'afterValidateAttribute' => 'js:function(form, attribute, data, hasError) {
			if(hasError){
				form.removeClass("success");
				if(!form.find("#"+attribute.id).hasClass("input-error")){
					form.find("#"+attribute.id+"_em_").hide().slideDown();
				}
				form.find("#"+attribute.id).removeClass("valid").parent().removeClass("valid");
				form.find("#"+attribute.id).addClass("input-error").parent().addClass("input-error");
				form.find("#"+attribute.id).next(".validation-icon").fadeIn();
			} else {
				if(form.find("#"+attribute.id).hasClass("input-error")){
					form.find("#"+attribute.id+"_em_").show().slideUp();
				}
				form.find("#"+attribute.id).removeClass("input-error").parent().next("error-message").slideUp().removeClass("input-error"); 
				form.find("#"+attribute.id).next(".validation-icon").fadeIn();
				form.find("#"+attribute.id).addClass("valid");
			}
		}'
	),
)); ?>
<div class="subheader"><?= Yii::t('Front', 'Terms &amp; Conditions') ?></div>
<div class="xabina-form-container">
	<div class="agreement-text">
		<?= Yii::t('Front', '{termsConditionsText}'); ?>
	</div>
	<label class="agreement-check">
		<?= $form->checkBox($activation, 'terms'); ?>
		<?= Yii::t('Front', 'I have read and agree to the terms &amp; conditions'); ?>
		<?= $form->error($activation, 'terms'); ?>
	</label>
	<div class="subheader"><?= Yii::t('Front', 'Fee structure'); ?></div>

	<div class="agreement-text">
		<?= Yii::t('Front', '{feeStructure}'); ?>
	</div>
	<label class="agreement-check">
		<?= $form->checkBox($activation, 'fee_structure'); ?>
		<?= Yii::t('Front', 'I have read and agree to the terms &amp; conditions'); ?>
		<?= $form->error($activation, 'fee_structure'); ?>
	</label>
	<div class="form-submit">
		<div onclick="js:next('<?= Yii::app()->createUrl('/banking/accountsactivation').'/' ?>', this)" class="submit-button button-next activate" ><?= Yii::t('Front', 'Activate') ?></div>
	</div>
</div>
<?php $this->endWidget(); ?>
	