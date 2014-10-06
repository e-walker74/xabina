<? /*
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
	<li class="payments">
		<a class="with-menu" href="#"><?= Yii::t('Front', 'Apps') ?></a>
		<div class="sidebar-arrow"></div>
	</li>
	<ul class="sidebar-submenu list-unstyled">
		<li><a href="<?= Yii::app()->getBaseUrl(true) ?><?=Yii::app()->createUrl('/message/index') ?>"><?= Yii::t('Front', 'Messaging') ?></a></li>
		<li><a href="<?= Yii::app()->getBaseUrl(true) ?><?=Yii::app()->createUrl('/invoices/list') ?>"><?= Yii::t('Front', 'Invoicing') ?></a></li>
		<li><a href="#"><?= Yii::t('Front', 'Drive') ?></a></li>
		<li><a href="#"><?= Yii::t('Front', 'Dialogues') ?></a></li>
	</ul>
	<li class="extra">
		<a class="with-menu" href="<?= Yii::app()->createUrl('personal/index') ?>"><?= Yii::t('Front', 'Extra  Services') ?></a>
		<div class="sidebar-arrow"></div>
	</li>
	<ul class="sidebar-submenu list-unstyled">
		<li><a href="<?= Yii::app()->getBaseUrl(true) ?><?=Yii::app()->createUrl('personal/index') ?>"><?= Yii::t('Front', 'Account settings') ?></a></li>
		<li><a href="<?= Yii::app()->getBaseUrl(true) ?><?=Yii::app()->createUrl('message/index') ?>"><?= Yii::t('Front', 'Message center') ?></a></li>
	</ul>
</ul>
 */ ?>
<ul class="sidebar-menu list-unstyled">
    <li class="overview "><a href="<?= Yii::app()->getBaseUrl(true) ?><?=Yii::app()->createUrl('/banking/index') ?>"><?= Yii::t('Front', 'Overview') ?></a></li>
    <li class="accounts"><a href="<?= Yii::app()->getBaseUrl(true) ?><?=Yii::app()->createUrl('/accounts/index') ?>"><?= Yii::t('Front', 'Accounts') ?></a></li>
<!--    <li class="payments "><a href="--><?//= Yii::app()->getBaseUrl(true) ?><!----><?//=Yii::app()->createUrl('/transfers/outgoing') ?><!--">--><?//= Yii::t('Front', 'Payments') ?><!--</a><div class="sidebar-arrow"></div></li>-->
<!--    <ul class="sidebar-submenu list-unstyled">-->
<!--        <li><a href="--><?//= Yii::app()->getBaseUrl(true) ?><!----><?//=Yii::app()->createUrl('/transfers/outgoing') ?><!--">--><?//= Yii::t('Front', 'New payment') ?><!--</a></li>-->
<!--        <li><a href="--><?//= Yii::app()->getBaseUrl(true) ?><!----><?//=Yii::app()->createUrl('/transfers/overview') ?><!--">--><?//= Yii::t('Front', 'Transfer overview') ?><!--</a></li>-->
<!--        <li><a href="--><?//= Yii::app()->getBaseUrl(true) ?><!----><?//=Yii::app()->createUrl('/transfers/history') ?><!--">--><?//= Yii::t('Front', 'Payments overview') ?><!--</a></li>-->
<!--        <li><a href="--><?//= Yii::app()->getBaseUrl(true) ?><!----><?//=Yii::app()->createUrl('/transfers/incoming') ?><!--">--><?//= Yii::t('Front', 'Upload') ?><!--</a></li>-->
<!--        <li><a href="--><?//= Yii::app()->getBaseUrl(true) ?><!----><?//=Yii::app()->createUrl('/transfers/incomingoverview') ?><!--">--><?//= Yii::t('Front', 'Upload overview') ?><!--</a></li>-->
<!--        <li><a href="--><?//= Yii::app()->getBaseUrl(true) ?><!----><?//=Yii::app()->createUrl('/transfers/standing') ?><!--">--><?//= Yii::t('Front', 'Standing Payments') ?><!--</a></li>-->
<!--        <li><a href="--><?//= Yii::app()->getBaseUrl(true) ?><!----><?//=Yii::app()->createUrl('/invoices/create') ?><!--">--><?//= Yii::t('Front', 'Create Invoice') ?><!--</a></li>-->
<!--        <li><a href="--><?//= Yii::app()->getBaseUrl(true) ?><!----><?//=Yii::app()->createUrl('/invoices/list') ?><!--">--><?//= Yii::t('Front', 'Invoices List') ?><!--</a></li>-->
<!--    </ul>-->
    <li class="apps  "><a href="#"><?= Yii::t('Front', 'Apps') ?></a><div class="sidebar-arrow"></div></li>
    <ul class="sidebar-submenu list-unstyled">
        <!--<? if(Yii::app()->user->checkRbacAccess('messaging_menu')): ?>
            <li class="messaging-ico"><a href="#"><?= Yii::t('Front', 'Messaging') ?></a></li>
        <?php endif; ?>
        <? if(Yii::app()->user->checkRbacAccess('alerts_menu')): ?>
            <li class="alert-ico"><a href="<?= Yii::app()->createUrl('/personal/alerts') ?>"><?= Yii::t('Front', 'Alerts') ?></a></li>
        <?php endif; ?>-->
        <? if(Yii::app()->user->checkRbacAccess('dialogues_menu')): ?>
            <li class="dialogues-ico"><a href="<?= Yii::app()->createUrl('/dialogs/index') ?>"><?= Yii::t('Front', 'Dialogues')?></a></li>
        <?php endif; ?>
        <!--<? if(Yii::app()->user->checkRbacAccess('apps_menu_drive')): ?>
            <li class="drive-ico"><a href="#"><?= Yii::t('Front', 'Drive'); ?></a></li>
        <?php endif; ?>
        <? if(Yii::app()->user->checkRbacAccess('apps_menu_analytic')): ?>
            <li class="analytic-ico"><a href="#"><?= Yii::t('Front', 'Analytic'); ?></a></li>
        <?php endif; ?>-->
        <? if(Yii::app()->user->checkRbacAccess('adresbook_menu')): ?>
            <li class="address-book-ico"><a href="<?= Yii::app()->createUrl('/contact/index'); ?>"><?= Yii::t('Front', 'Address book'); ?></a></li>
        <?php endif; ?>
        <!--<? if(Yii::app()->user->checkRbacAccess('apps_menu_loans')): ?>
            <li class="loans-ico"><a href="#"><?= Yii::t('Front', 'Loans'); ?></a></li>
        <?php endif; ?>
        <? if(Yii::app()->user->checkRbacAccess('apps_menu_cards')): ?>
            <li class="cards-ico"><a href="#"><?= Yii::t('Front', 'Cards'); ?></a></li>
        <?php endif; ?>
        <? if(Yii::app()->user->checkRbacAccess('apps_menu_invoicing')): ?>
            <li class="invoicing-ico"><a href="<?= Yii::app()->createUrl('/invoices/list') ?>"><?= Yii::t('Front', 'Invoicing') ?></a></li>
        <?php endif; ?>
        <? if(Yii::app()->user->checkRbacAccess('apps_menu_users')): ?>
            <li class="users-ico"><a href="<?= Yii::app()->createUrl('/rbac/manageusers') ?>"><?= Yii::t('Front', 'Users') ?></a></li>
        <?php endif; ?>
        <? if(Yii::app()->user->checkRbacAccess('apps_menu_roles')): ?>
            <li class="roles-ico"><a href="<?= Yii::app()->createUrl('/settings/roles') ?>"><?= Yii::t('Front', 'Roles') ?></a></li>
        <?php endif; ?>-->
    </ul>
</ul>