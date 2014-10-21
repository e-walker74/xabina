<div class="module-sidebar ">
    <ul class="module-sidebar-list list-unstyled">
        <li class="home"><a href="<?= Yii::app()->getBaseUrl(true) ?><?=Yii::app()->createUrl('/banking/index') ?>"></a></li>
        <li class="accounts"><a href="<?= Yii::app()->getBaseUrl(true) ?><?=Yii::app()->createUrl('/accounts/index') ?>"></a></li>
        <li class="payments"><a href="#"></a></li>
        <li class="apps"><a href="#"></a></li>
    </ul>

    <div class="sidebar-shadow-container">
        <div class="sidebar-shadow"></div>
        <ul class="sidebar-menu list-unstyled">
            <li class="overview "><a href="<?= Yii::app()->getBaseUrl(true) ?><?=Yii::app()->createUrl('/banking/index') ?>"><?= Yii::t('Front', 'Overview') ?></a></li>
            <li class="accounts"><a href="<?= Yii::app()->getBaseUrl(true) ?><?=Yii::app()->createUrl('/accounts/index') ?>"><?= Yii::t('Front', 'Accounts') ?></a></li>
            <li class="apps  "><a href="#"><?= Yii::t('Front', 'Apps') ?></a><div class="sidebar-arrow"></div></li>
            <ul class="sidebar-submenu list-unstyled">
                <? if(Yii::app()->user->checkRbacAccess('dialogues_menu')): ?>
                    <li class="dialogues-ico"><a href="<?= Yii::app()->createUrl('/dialogs/index') ?>"><?= Yii::t('Front', 'Dialogues')?></a></li>
                <?php endif; ?>
                <? if(Yii::app()->user->checkRbacAccess('adresbook_menu')): ?>
                    <li class="address-book-ico"><a href="<?= Yii::app()->createUrl('/contact/index'); ?>"><?= Yii::t('Front', 'Address book'); ?></a></li>
                <?php endif; ?>
            </ul>
        </ul>
    </div>
</div>