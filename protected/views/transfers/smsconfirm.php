<div class="col-lg-9 col-md-9 col-sm-9">
	<div class="h1-header"><?= Yii::t('Front', 'New transfer') ?></div>
	<?php $this->widget('XabinaAlert'); ?>
	<div class="xabina-progress-bar transfer-bar">
		<div class="step step1 ">
			<div class="step-name"><?= Yii::t('Front', 'Data input') ?></div>
			<div class="step-arr"></div>
		</div>
		<div class="step step2  previous">
			<div class="step-name"><?= Yii::t('Front', 'Overview') ?></div>
			<div class="step-arr"></div>
		</div>
		<div class="step step3 current">
			<div class="step-name"><?= Yii::t('Front', 'SMS-verification') ?></div>
			<div class="step-arr"></div>
		</div>
		<div class="step step4 ">
			<div class="step-name"><?= Yii::t('Front', 'Success') ?></div>
			<div class="step-arr"></div>
		</div>
	</div>
	<div class="transfer-sms-container ">
		<div class="subheader"><?= Yii::t('Front', 'SMS-verification') ?></div>
		<div class="xabina-alert">
			<?= Yii::t('Front', 'We have send an SMS with the verification code on the phone number +x xxx xxx {num}.', array('{num}' => $num)) ?>
			<br/>
			<a onclick="return resendSms('<?= Yii::t('Front', 'Sms was successfully sent') ?>', this);" href="<?= Yii::app()->createUrl('/transfers/resendsms'); ?>" class="violet-link"><?= Yii::t('Front', 'Send verification code once again'); ?></a>
		</div>
		<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'sms-confirmation-code',
				'enableAjaxValidation'=>true,
				'enableClientValidation'=>false,
				'errorMessageCssClass' => 'error-message',
				'htmlOptions' => array(
					'class' => 'form-validable',
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
							$(".clicked-button").removeClass("clicked-button")
							for(var i in data) {
								$("#"+i).addClass("input-error");
								$("#"+i).parent().addClass("input-error");
								$("#"+i).next(".validation-icon").fadeIn();
							}
							return false;
						}
						else {
							confirmSms(form)
						}
						return false;
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
		<!--<div class="xabina-form-container">
			<div class="sms-form">
				<div class="lbl"><?= Yii::t('Front', 'Verification code') ?></div>
				<?= $form->textField($model, 'code', array('class' => 'sms-input')) ?>
				<?= $form->error($model, 'code'); ?>
			</div>
			<div class="form-submit">
				<a class="submit-button button-back" href="<?= Yii::app()->createUrl('transfers/overview') ?>"><?= Yii::t('Front', 'Back') ?></a>
				<input type="submit" class="submit-button button-next" value="<?= Yii::t('Front', 'Next') ?>" />
			</div>
		</div>-->
		<div class="xabina-form-container">
            <div class="sms-verification-cont">
				
				<div class="lbl"><?= Yii::t('Front', 'Verification code'); ?></div>
				<?= $form->textField($model, 'code', array('class' => 'sms-input')) ?>
				<?= $form->error($model, 'code'); ?>

                <div class="total-value">
                    <span><?= Yii::t('Front', 'Total Value'); ?></span>
					<?php foreach($transes as $currency => $value): ?>
					<br>
					<?= number_format($value['amount'], 2, ".", " ") ?> <?= $currency ?>
					<?php endforeach; ?>
                </div>
                <div class="transaction-num">
                    <span><?= Yii::t('Front', 'Transactions #'); ?></span><br/>
					<?= count($confirmations) ?>
                </div>
            </div>
            <div class="form-submit">
                <input type="submit" class="submit-button button-next" value="<?= Yii::t('Front', 'Next') ?>" />
            </div>
        </div>
		<?php $this->endWidget(); ?>
	</div>
</div>
<?php Yii::app()->clientScript->registerScriptFile('/js/transfers.js'); ?>