<?php
/**
 * @var CDataProvider $accounts
 * @var MController $this
 */
?>
<div class="module-window">
<div class="module-control-panel">
    <div class="module-control sidebar-toggle">

    </div>
    <div class="header"><?= Yii::t('Accounts', 'Accounts') ?></div>
    <div class="window-controls pull-right">
<!--        <a class="module-control settings" href="#"></a>-->
        <a class="module-control blank" target="_blank" href="?w=1"></a>
        <a class="module-control module-close" href="<?= Yii::app()->createUrl('/banking/index') ?>"></a>
    </div>

</div>
<div class="module-menu-panel">
    <ul class="menu list-unstyled list-inline">
        <li>
            <?= Html::link(Yii::t('Accounts', 'Open account'), array('/maccounts/create')) ?>
        </li>
<!--        <li><a class="chart" href="#"></a></li>-->
    </ul>
<!--    <a class="download " href="#"></a>-->
</div>
<div class="module-search-panel">
                <span class="pop_up_input_wrap">
                    <input type="text" class="search"/>
                    <a class="clear_text_box" href="#" style="display: none"></a>
                </span>
                <?php Widget::get('UsersTagsWidget')->renderUserTopTags(false, false, 'accounts'); ?>
    <?= Html::link(Yii::t('Accounts', 'NEW ACCOUNT'), array('/maccounts/create'), array(
        'class' => 'rounded-buttons add-new pull-right'
    )) ?>
</div>
<div class="module-breadcrumbs-panel">
    <?php
    $this->widget('XBreadcrumbsForModule', array(
        'links'=>$this->breadcrumbs
    ));
    ?>
    <div class="controls" style="display: none;">
<!--        <a href="#" class="download"></a>-->
<!--        <a href="#" class="info"></a>-->
        <?= Html::link('', array('/maccounts/balance'), array(
            'class' => 'watch',
            'onclick' => 'return Accounts.controlsButtonClick(this)',
        )) ?>
<!--        <a href="" class="watch"></a>-->
<!--        <a href="#" class="remove"></a>-->
    </div>

    <div class="clearfix"></div>
</div>
<div class="window-content">
<form action="#" method="get">
<table class="layout">
<tr>
<td style="width: 18%" class="layout-sidebar">
    <?php $this->renderPartial('_filters', array(
        'currencies'=>$currencies,
        'account_types' => $account_types,
        'statuses' => $statuses
    )) ?>
</td>
<td style="width: 82%" class="layout-main">
<div class="accounts-frame">
<div class="account-header">
<?php $this->renderPartial('_sorting') ?>
<div class="accounts-list-cont">
<ul id="accounts-list" class="list-unstyled accounts-list">
<?php $this->renderPartial('_items', array('accounts' => $accounts)); ?>
</ul>
<div class="status-legend pull-right">
    <span>
        <?= AccountService::getAccountStatusIcon(Accounts::STATUS_APPROVED) ?>
        - <?= Yii::t('Front', 'Approved') ?>
    </span>
    <span>
        <?= AccountService::getAccountStatusIcon(Accounts::STATUS_PENDING) ?>
        - <?= Yii::t('Front', 'Pending') ?>
    </span>
    <span>
        <?= AccountService::getAccountStatusIcon(Accounts::STATUS_REJECTED) ?>
        - <?= Yii::t('Front', 'Rejected') ?>
    </span>
    <span>
        <?= AccountService::getAccountStatusIcon(Accounts::STATUS_LOCKED) ?>
        - <?= Yii::t('Front', 'Locked') ?>
    </span>
    <span>
        <?= AccountService::getAccountStatusIcon(Accounts::STATUS_CLOSED) ?>
        - <?= Yii::t('Front', 'Closed') ?>
    </span>
</div>
</div>
</div>
</div>
<div class="clearfix"></div>
</td>
</tr>
</table>
</form>
</div>
</div>