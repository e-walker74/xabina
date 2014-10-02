<?php
/**
 * @var Transactions $trans
 */
?>
<div class="col-lg-9 col-md-9 col-sm-9">
<?php $this->renderPartial('_printModal', array('model' => $trans)); ?>
<div class="edit-tabs contact-tabs">
<ul class="list-unstyled">
    <li style="width: 100%"><a href="#tab1"><?= Yii::t('Front', 'Transaction Overview') ?></a></li>
</ul>
<div class="clearfix"></div>
<div class="one_tab" id="tab1">
<table class="xabina-table-upload transaction-table-cont">
<tr class="header-tr">
    <td>
        <?= Yii::t('Front', 'Transaction #{number}', array('{number}' => $trans->url)) ?>
        <div class="transaction-buttons-cont">
            <a class="button upload" href="#downloadFileModal" role="button" data-toggle="modal"></a>
        </div>
    </td>
</tr>
<tr class="form-tr">
<td>
<div class="transaction-info-cont new_transaction">
<table class="transaction-info-table table new_transaction_table">
<?php if($trans->execution_time): ?>
<tr>
    <td class="name" width="20%"><?= Yii::t('Front', 'Date') ?></td>
    <td width="70%"><?= date('d.m.Y', $trans->execution_time); ?></td>
    <td></td>
</tr>
<?php endif; ?>
<tr>
    <td class="name"><?= Yii::t('Front', 'Sender') ?></td>
    <td class="normal-line"><?= $trans->info->sender ?><br/><?= $trans->info->sender_description ?></td>
    <td>
        <?php if ($trans->associated_contact && $trans->incoming_id): ?>
            <div class="new_tran_but">
                <a href="<?= Yii::app()->createUrl('/contact/view', array('url' => $trans->contact->url)); ?>"
                   role="button"
                   data-toggle="modal" class="button book"></a></div>
            <div class="clearfix"></div>
        <?php endif; ?>
    </td>
</tr>
<tr>
    <td class="name"><?= Yii::t('Front', 'Receiver') ?></td>
    <td class="normal-line">
        <?= $trans->info->recipient ?><br/><?= $trans->info->recipient_description ?>
    </td>
    <td>
        <?php if ($trans->associated_contact && $trans->outgoing_id): ?>
            <div class="new_tran_but"><a
                    href="<?= Yii::app()->createUrl('/contact/view', array('url' => $trans->contact->url)); ?>"
                    role="button"
                    data-toggle="modal" class="button book"></a></div>
            <div class="clearfix"></div>
        <?php endif; ?>
    </td>
</tr>
<tr>
    <td class="name"><?= Yii::t('Front', 'Value') ?></td>
    <td>
        <?php if ($trans->type == 'positive'): ?>
            <span class="green_text">+<?= number_format($trans->amount, 2, '.', ' ') ?></span>
            <?php $amount = $trans->amount; ?>
        <?php else: ?>
            <span class="rejected">-<?= number_format($trans->amount, 2, '.', ' ') ?></span>
            <?php $amount = -$trans->amount; ?>
        <?php endif; ?> <?= $trans->account->currency->title ?>
        <?php Widget::create(
            'WCurrencyConverter',
            'WCurrencyConverter',
            array('value' => $amount, 'currency_code' => $trans->account->currency->code)
        ) ?>
    </td>
    <td>
    </td>
</tr>
<?php if ($trans->info->details_of_payment): ?>
    <tr>
        <td class="name"><?= Yii::t('Front', 'Description') ?></td>
        <td><?= $trans->info->details_of_payment ?></td>
        <td></td>
    </tr>
<?php endif; ?>
<tr>
    <td class="name"><?= Yii::t('Front', 'Status') ?></td>
    <td>
        <?= AccountService::getTransactionStatus($trans->status) ?>
        <span class="comment-tr">- <?= Yii::t('Front', $trans->status) ?></span>
        <?php if ($trans->info->status_comment): ?>
            <span class="comment drdn-cont">
                                    <a href="#" class="transaction_comment margin-left active"
                                       data-toggle="dropdown"></a>
                                    <div
                                        class="dropdown-menu no-close contact-select-dropdown2 list-actions-dropdown list-unstyled act-list"
                                        role="menu">
                                        <div class="arr my_arr"></div>
                                        <div class="content-dropdown">
                                            <div class="drop_title">
                                                <?= Yii::t('Front', 'Comment') ?>
                                                <a class="edit-dropdown"></a>
                                                <a class="close-dropdown"></a>
                                            </div>
                                            <div class="casual_text">
                                                <?= $trans->info->status_comment ?>
                                            </div>
                                        </div>
                                    </div>
                                </span>
        <?php endif; ?>
    </td>
    <td></td>
</tr>
<tr>
    <td class="name"><?= Yii::t('Front', 'Tags') ?></td>
    <td>
        <?php Widget::get('UsersTagsWidget')->renderTransactionTags($trans->id); ?>
        <div class="clearfix"></div>
    </td>
    <td>
        <?php Widget::get('UsersTagsWidget')->renderUserTopTags(); ?>
        <div class="clearfix"></div>
    </td>
</tr>
<tr style="border-style: hidden;">
<td colspan="3" class="nopadding_td" style="border-style: hidden;">
<table class="link_table">
<tr class="link_tr">
    <td class="icon_td"><a href="#" class="drop_links"></a></td>
    <td class="title"><span class="bolder_link">Linking</span></td>
    <td colspan="3">
															<span class="drdn-cont pull-right">
																<a class="rounded-buttons linkbut pull-right"
                                                                   data-toggle="dropdown">LINK AN ITEM</a>
																<div
                                                                    class="dropdown-menu no-close link-select-dropdown list-actions-dropdown list-unstyled act-list"
                                                                    role="menu">
                                                                    <div class="content-dropdown">
                                                                        <div class="drop_main_block">
                                                                            <ul class="drop_link_ul">
                                                                                <li onclick="$('#linkNewMemoModal').modal('show');"
                                                                                    class="memo">Link memo
                                                                                </li>
                                                                                <li onclick="$('#addBuhModal').modal('show');"
                                                                                    class="category">Link Category
                                                                                </li>
                                                                                <li onclick="$('#addLinkModal').modal('show');"
                                                                                    class="contact">Link Contact
                                                                                </li>
                                                                                <li onclick="$('#addTranModal').modal('show');"
                                                                                    class="transaction">Link Transaction
                                                                                </li>
                                                                                <li onclick="$('#addNewFileModal').modal('show');"
                                                                                    class="files">Link files
                                                                                </li>
                                                                            </ul>

                                                                        </div>
                                                                    </div>
                                                                </div>
															</span>
    </td>
</tr>
<?php Widget::get('WLinkDrive')->renderTransactionMemo($trans->id) ?>
<?php Widget::get('WLinkCategory')->renderTransactionsCategories($trans->id) ?>
<?php Widget::get('WLinkContact')->renderTransactionsContacts($trans->id) ?>
<?php Widget::get('WLinkTransactions')->renderTransactionsTrans($trans->id) ?>
<?php Widget::get('WLinkDrive')->renderTransactionsFiles($trans->id) ?>
</table>
<?php Widget::get('WLinkDrive')->renderLinkFilesPopup('transactions', $trans->id) ?>
<?php Widget::get('WLinkDrive')->renderAddNewMemo('transactions', $trans->id, 'editCommentModal') ?>
<?php Widget::get('WLinkDrive')->renderLinkMemoPopup('transactions', $trans->id, 'linkNewMemoModal') ?>
<?php Widget::get('WLinkCategory')->renderPopup('transactions', $trans->id, 'addBuhModal') ?>
<?php Widget::get('WLinkContact')->renderPopup('transactions', $trans->id, 'addLinkModal') ?>
    <?php Widget::get('WLinkTransactions')->renderPopup('transactions', $trans->id, 'addTranModal') ?>
</td>
</tr>
<tr>
    <td class="wrap_td" colspan="3"></td>
</tr>
<tfoot class="hide-tr" style="display: none;">
<tr>
    <td class="name"><?= Yii::t('Transactions', 'Created At') ?></td>
    <td><?= date('d.m.Y', $trans->created_at) ?></td>
    <td></td>
</tr>
<tr>
    <td class="name"><?= Yii::t('Transactions', 'Type') ?></td>
    <td><?= $trans->info->type ?></td>
    <td></td>
</tr>
</tfoot>
</table>
</div>
</td>
</tr>
</table>
<a class="table-arrow"><?= Yii::t('Transactions', 'SHOW MORE') ?><span></span></a>
</div>
<!--<div class="submit-button button-back" onclick="window.location = 'personal_account_new.html'">Back</div>-->
</div>
</div>