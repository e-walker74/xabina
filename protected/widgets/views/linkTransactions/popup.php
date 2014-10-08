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

<div class="modal fade" id="<?= $htmlID ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
            <div>
                <div class="transaction-table-overflow linked-transaction">
                        <table class="table new-tran-tab">
                            <?php foreach($transactions as $trans): ?>
                                <tr class="wcategory-row">
                                    <td width="6%">
                                        <label class="modal-galka-checkbox">
                                            <input name="transactions[]" value="<?= $trans->id ?>" type="checkbox"/>
                                        </label>
                                    </td>
                                    <td width="17%" onclick="CrossLinks.clickCheckbox(this)"><?= date('d.m.Y', $trans->execution_time) ?></td>
                                    <td width="25%" class="drive-search-text" onclick="CrossLinks.clickCheckbox(this)">
                                        <strong class="holder"><?= $trans->info->sender ?></strong><br>
                                        <span class="account"><?= $trans->info->sender_description ?></span>
                                    </td>
                                    <td width="25%" class="drive-search-text" onclick="CrossLinks.clickCheckbox(this)">
                                        <strong class="holder"><?= $trans->info->recipient ?></strong><br>
                                        <span class="account"> <?= $trans->info->recipient_description ?></span>
                                    </td>
                                    <td width="20%" class="drive-search-text" class="text-right" onclick="CrossLinks.clickCheckbox(this)">
                                        <?php if($trans->amount > 0): ?>
                                            <span class="sum-inc">+<?= number_format($trans->amount, 2, ".", " ") ?></span> <?= $trans->account->currency->title ?>
                                        <?php elseif($subAccount->balance < 0): ?>
                                            <span class="sum-inc">-<?= number_format($trans->amount, 2, ".", " ") ?></span> <?= $trans->account->currency->title ?>
                                        <?php else: ?>
                                            0 <?= $trans->account->currency->title ?>
                                        <?php endif; ?>
                                    </td>
                                    <td width="7%" style="overflow: visible!important">
                                        <?php if($trans->info->details_of_payment): ?>
                                            <div class="transaction-buttons-cont book">
                                                <a href="#" class="book_button trans-but open"></a>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php if($trans->info->details_of_payment): ?>
                                    <tr class="note-tr wcategory-row" style="display: table-row;">
                                        <td colspan="6">
                                            <div class="note-cont">
                                                <?= $trans->info->details_of_payment ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
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