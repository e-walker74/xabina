<?php if(!Yii::app()->request->isAjaxRequest): ?>
<div class="col-lg-9 col-md-9 col-sm-9">
<?php endif; ?>
	<div class="h1-header"><?= Yii::t('Front', 'Verification'); ?></div>
	<div class="xabina-progress-bar verification-page">
		<div class="step step1">
			<div class="step-name"><?= Yii::t('Front', 'Verification Method') ?></div>
			<div class="step-arr"></div>
		</div>
		<div class="step step2 previous">
			<div class="step-name"><?= Yii::t('Front', 'Verification Steps') ?></div>
			<div class="step-arr"></div>
		</div>
		<div class="step step3 current">
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
	<div class="xabina-bubble">
		<span><?= Yii::t('Front', 'Thank you!'); ?></span><br>
		<?= Yii::t('Front', 'You have completed the process of verification of the account. In the near future your profile will <br> verified and you will get a message to your email address.'); ?>
		<div class="habina-bubble-arr"></div>
	</div>
<?php if(!Yii::app()->request->isAjaxRequest): ?>
</div>
<?php endif; ?>