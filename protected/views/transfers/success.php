<div class="col-lg-9 col-md-9 col-sm-9">
	<div class="h1-header"><?= Yii::t('Front', 'New transfer'); ?></div>
	<div class="xabina-progress-bar transfer-bar">
		<div class="step step1 ">
			<div class="step-name"><?= Yii::t('Front', 'Data input'); ?></div>
			<div class="step-arr"></div>
		</div>
		<div class="step step2 ">
			<div class="step-name"><?= Yii::t('Front', 'Overview'); ?></div>
			<div class="step-arr"></div>
		</div>
		<div class="step step3  previous">
			<div class="step-name"><?= Yii::t('Front', 'SMS-verification'); ?></div>
			<div class="step-arr"></div>
		</div>
		<div class="step step4 current ">
			<div class="step-name"><?= Yii::t('Front', 'Success'); ?></div>
			<div class="step-arr"></div>
		</div>
	</div>
	<div class="transfer-success-cont">
		<div class="subheader"><?= Yii::t('Front', 'Success'); ?></div>
		<div class="xabina-bubble">
			<span><?= Yii::t('Front', 'Thank you'); ?></span>
			<br>
			<?= Yii::t('Front', 'The verification process was successful. You see the status of the transaction can archive transaction'); ?>

			<div class="habina-bubble-arr"></div>
		</div>
	</div>


</div>