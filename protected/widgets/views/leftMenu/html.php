<ul class="sidebar-menu list-unstyled">
	<li class="overview">
		<a href="<?= Yii::app()->getBaseUrl(true) ?><?=Yii::app()->createUrl('/banking') ?>/"><?= Yii::t('Front', 'Overview') ?></a>
	</li>
	<li class="accounts">
		<a href="<?= Yii::app()->getBaseUrl(true) ?><?=Yii::app()->createUrl('/banking/accountsactivation') ?>/"><?= Yii::t('Front', 'Accounts') ?></a>
	</li>
	<li class="payments">
		<a href="accounts_activation.html"><?= Yii::t('Front', 'Payments') ?></a>
	</li>
	<li class="balance">
		<a href="#"><?= Yii::t('Front', 'Balance') ?></a>
	</li>
	<li class="credit">
		<a href="#"><?= Yii::t('Front', 'Credit') ?></a>
	</li>
	<li class="extra">
		<a href="#"><?= Yii::t('Front', 'Extra  Services') ?></a>
	</li>
</ul>