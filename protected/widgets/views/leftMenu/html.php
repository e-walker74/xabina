<ul class="sidebar-menu list-unstyled">
	<li class="overview">
		<a href="<?= Yii::app()->getBaseUrl(true) ?><?=Yii::app()->createUrl('/banking/index') ?>"><?= Yii::t('Front', 'Overview') ?></a>
	</li>
	<li class="accounts">
		<a href="<?= Yii::app()->getBaseUrl(true) ?><?=Yii::app()->createUrl('/accounts/index') ?>"><?= Yii::t('Front', 'Accounts') ?></a>
	</li>
	<li class="payments">
		<a class="with-menu" href="<?= Yii::app()->getBaseUrl(true) ?><?=Yii::app()->createUrl('/transfers/outgoing') ?>"><?= Yii::t('Front', 'Payments') ?></a>
		<div class="sidebar-arrow"></div>
	</li>
	<ul class="sidebar-submenu list-unstyled">
		<li><a href="<?= Yii::app()->getBaseUrl(true) ?><?=Yii::app()->createUrl('/transfers/outgoing') ?>"><?= Yii::t('Front', 'New payment') ?></a></li>
		<li><a href="<?= Yii::app()->getBaseUrl(true) ?><?=Yii::app()->createUrl('/transfers/overview') ?>"><?= Yii::t('Front', 'Transfer overview') ?></a></li>
		<li><a href="<?= Yii::app()->getBaseUrl(true) ?><?=Yii::app()->createUrl('/transfers/history') ?>"><?= Yii::t('Front', 'Payments overview') ?></a></li>
		<li><a href="<?= Yii::app()->getBaseUrl(true) ?><?=Yii::app()->createUrl('/transfers/incoming') ?>"><?= Yii::t('Front', 'Upload') ?></a></li>
		<li><a href="<?= Yii::app()->getBaseUrl(true) ?><?=Yii::app()->createUrl('/transfers/incomingoverview') ?>"><?= Yii::t('Front', 'Upload overview') ?></a></li>
		<li><a href="<?= Yii::app()->getBaseUrl(true) ?><?=Yii::app()->createUrl('/transfers/standing') ?>"><?= Yii::t('Front', 'Standing Payments') ?></a></li>
		<li><a href="<?= Yii::app()->getBaseUrl(true) ?><?=Yii::app()->createUrl('/invoices/create') ?>"><?= Yii::t('Front', 'Create Invoice') ?></a></li>
		<li><a href="<?= Yii::app()->getBaseUrl(true) ?><?=Yii::app()->createUrl('/invoices/list') ?>"><?= Yii::t('Front', 'Invoices List') ?></a></li>
	</ul>
	<!--<li class="balance">
		<a href="<?= Yii::app()->createUrl('pages/index', array('url' => 'Balance')) ?>"><?= Yii::t('Front', 'Balance') ?></a>
	</li>-->
	<li class="credit">
		<a href="<?= Yii::app()->createUrl('pages/index', array('url' => 'Credit')) ?>"><?= Yii::t('Front', 'Credit') ?></a>
	</li>
	<li class="extra">
		<a class="with-menu" href="<?= Yii::app()->createUrl('personal/index') ?>"><?= Yii::t('Front', 'Extra  Services') ?></a>
		<div class="sidebar-arrow"></div>
	</li>
	<ul class="sidebar-submenu list-unstyled">
		<li><a href="<?= Yii::app()->getBaseUrl(true) ?><?=Yii::app()->createUrl('personal/index') ?>"><?= Yii::t('Front', 'Account settings') ?></a></li>
		<li><a href="<?= Yii::app()->getBaseUrl(true) ?><?=Yii::app()->createUrl('message/index') ?>"><?= Yii::t('Front', 'Message center') ?></a></li>
	</ul>
</ul>