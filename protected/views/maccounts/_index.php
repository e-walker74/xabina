<?php
/**
 * @var AccountsController $this
 */
?>

<div class="col-lg-9 col-md-9 col-sm-9" >
	<div class="h1-header"><?= Yii::t('Front', 'Account Management'); ?></div>
	<?php $this->widget('XabinaAlert'); ?>

    <div class="subheader">
        <?= Yii::t('Front', 'My accounts'); ?>

        <a href="<?= Yii::app()->createUrl('/accounts/create') ?>" class="rounded-buttons add-new pull-right" style="font-size: 83.4%;margin:-3px 0 0;"><?= Yii::t('Font', 'OPEN ACCOUNT') ?></a>
    </div>
    <div class="clearfix"></div>
    <div id="accounts-grid">
    <?= $this->renderPartial('_accountsTable', array('accounts' => $accounts)) ?>
    </div>
    <div class="xabina-form-container">
        <div class="form-submit">
            <div class="submit-button button-back" onclick="window.location = '<?= Yii::app()->createUrl('/banking/index') ?>'"><?= Yii::t('Front', 'Back') ?></div>
            <div class="status-legend pull-right" style="margin:0 0 10px;">
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
    <div class="clearfix"></div>
	<?php $this->widget('AdsBlocks'); ?>

<div class="clearfix"></div>
</div>