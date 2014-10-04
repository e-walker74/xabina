<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 28.09.14
 * Time: 18:52
 * @var WLinkDrive $this
 */ ?>

<div class="modal fade" id="<?= $htmlID ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="xabina-modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="/css/layout/account/img/close.png"></button>
            <h3 id="myModalLabel"><?= Yii::t('Drive', 'Memo') ?></h3>
        </div>
        <div class="modal-body">
            <div class="change_dialog_block">
                <div class="select-custom account-select">
                    <span class="select-custom-label" rel="editCommentModal">Memo</span>
                    <select name="" class="select-invisible change_modal_select">
                        <option value="editCommentModal">
                            <?= Yii::t('Drive', 'Memo') ?>
                        </option>
                        <option value="addBuhModal">
                            <?= Yii::t('Drive', 'Linked Category') ?>
                        </option>
                        <option value="addLinkModal">
                            <?= Yii::t('Drive', 'Linked Contact') ?>
                        </option>
                        <option value="addTranModal">
                            <?= Yii::t('Drive', 'Linked Transactions') ?>
                        </option>
                        <option value="addTagModal">
                            <?= Yii::t('Drive', 'Tags') ?>
                        </option>
                        <option value="addNewFileModal">
                            <?= Yii::t('Drive', 'Linked Files') ?>
                        </option>
                    </select>
                </div>
            </div>
            <div class="xabina-form-container">
                <div class="form-lbl">
                    <?= Yii::t('Drive', 'Memo') ?> <span class="tooltip-icon" title="<?= Yii::t('Drive', 'memo_label_tooltip') ?>"></span>
                </div>
            </div>
            <div class="memo_edit">
                <textarea class="redactor"></textarea>
                <div class="error-message"><?= Yii::t('Drive', 'memo_is_empty') ?></div>
            </div>
            <div>
                <input onclick="WLinkDrive.addNewMemo('<?= $htmlID ?>', '<?= Yii::app()->createUrl('/file/addMemo', array('entity' => 'transactions', 'entity_id' => $entity_id)) ?>')" class="rounded-buttons marg-right-15 submit pull-left" type="submit" value="<?= Yii::t('Drive', 'Send') ?>">
            </div>
        </div>
    </div>
</div>