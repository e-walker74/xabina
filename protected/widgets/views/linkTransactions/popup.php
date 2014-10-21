<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 30.09.14
 * Time: 23:11
 * @var Transactions[] $transactions
 */ ?>

<div class="modal fade" data-backdrop="static" id="<?= $htmlID ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-update-url="<?= Yii::app()->createUrl('/transaction/getpopupgrid') ?>" data-entity="<?= $entity ?>" data-entity-id="<?= $entity_id ?>">
    <script>WLinkTransactions._popupId = "<?= $htmlID ?>"</script>
    <div class="xabina-modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="/css/layout/account/img/close.png"></button>
            <h3 id="myModalLabel"><?= Yii::t('Transactions', 'Linked transaction') ?></h3>
        </div>
        <div class="modal-body">
            <div class="change_dialog_block">
                <div class="select-custom account-select">
                    <span class="select-custom-label" rel="addTranModal"></span>
                    <select name="" class="select-invisible change_modal_select">
                        <option value="addTranModal">
                            <?= Yii::t('Linking', 'Linked Transactions') ?>
                        </option>
                        <option value="linkNewMemoModal">
                            <?= Yii::t('Linking', 'Memo') ?>
                        </option>
                        <option value="addNewFileModal">
                            <?= Yii::t('Linking', 'Linked Files') ?>
                        </option>
                        <option value="addLinkModal">
                            <?= Yii::t('Linking', 'Linked Contact') ?>
                        </option>
                        <option value="addBuhModal">
                            <?= Yii::t('Linking', 'Linked Category') ?>
                        </option>
                    </select>
                </div>
            </div>
            <div class="xabina-form-container">
                <div class="form-lbl">
                    <?= Yii::t('Transactions', 'Transaction') ?> <span class="tooltip-icon" title="<?= Yii::t('Transactions', 'transactions_link_popup_tooltip') ?>"></span>
                </div>
                <div class="form-block">
                    <div class="relative pull-left" style="width: 100%" >
                        <input class="add-input big-add-input pull-left search-input-transaction" type="text">
                        <span class="clear-input-but-for-all" id="clear-keyword"></span>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <form action="<?= Yii::app()->createUrl('/transaction/link', array(
                'entity' => $entity,
                'entity_id' => $entity_id,
            )) ?>">
            <div class="tran-popup-tab transactions-table-height">
                <div class="transaction-table-overflow linked-transaction">
                        <table class="table new-tran-tab">
                            <?php $this->renderTransactionsRows($entity, $entity_id, false); ?>
                        </table>
                </div>
            </div>
            <div style="margin: 15px 0 0;">
                <input onclick="return WLinkTransactions.link(this)" class="rounded-buttons marg-right-15 submit pull-left" type="submit" value="<?= Yii::t('Transactions', 'Link Transaction') ?>">
            </div>
            </form>
        </div>
    </div>
</div>