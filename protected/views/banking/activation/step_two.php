
<div class="h1-header"><?= Yii::t('Front', 'Account activation'); ?></div>
<div class="xabina-progress-bar">
	<div class="step step1  previous">
		<div class="step-name"><?= Yii::t('Front', 'Personal information'); ?></div>
		<div class="step-arr"></div>
	</div>
	<div class="step step2 current">
		<div class="step-name"><?= Yii::t('Front', 'File upload'); ?></div>
		<div class="step-arr"></div>
	</div>
	<div class="step step3">
		<div class="step-name"><?= Yii::t('Front', 'Activation'); ?></div>
		<div class="step-arr"></div>
	</div>
</div>
<div class="xabina-form-container">

	<div class="xabina-alert">
		<?= Yii::t('Front', 'Please upload a scanned version of your identity document. 
			This can be a passport, residence permit, driving license or any other 
			official document that identifies you personally. You can upload up to 3 
			files in the following formats: PDF, JPG, PNG, GIFF.'); ?>
	</div>
	<?php $this->widget('WidgetUpload')->getFilesTable($activation, Yii::app()->user->id)?>
	<?php $this->widget('WidgetUpload')->html($activation)?>
	<div class="form-submit">
		<div class="submit-button button-back" onclick="js:back('<?= Yii::app()->createUrl('/banking/accountsactivationback').'/' ?>')">Back</div>
		<div class="submit-button button-next" onclick="js:last('<?= Yii::app()->createUrl('/banking/accountsactivation').'/' ?>', this)">Далее</div>
	</div>
</div>
