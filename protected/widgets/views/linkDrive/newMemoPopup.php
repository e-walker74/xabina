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

<div class="modal fade" id="<?= $htmlID ?>" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <script>WLinkDrive._newMemoPopupId = "<?= $htmlID ?>"</script>
    <form action="" method="POST">
    <div class="xabina-modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="/css/layout/account/img/close.png"></button>
            <h3 id="myModalLabel"><?= Yii::t('Drive', 'Memo') ?></h3>
        </div>
        <div class="modal-body">
            <div class="xabina-form-container">
                <div class="form-lbl">
                    <?= Yii::t('Drive', 'Memo') ?> <span class="tooltip-icon" title="<?= Yii::t('Drive', 'memo_label_tooltip') ?>"></span>
                </div>
            </div>
            <div class="memo_edit">
                <textarea name="text" class="redactor"></textarea>
                <div class="error-message"><?= Yii::t('Drive', 'memo_is_empty') ?></div>
            </div>
            <div>
                <input type="hidden" name="folder_id" value=""/>
                <input type="hidden" name="memo_id" value=""/>
                <input type="hidden" name="transaction_id" value=""/>
                <input onclick="return WLinkDrive.addNewMemo('<?= $htmlID ?>', '<?= Yii::app()->createUrl('/file/addMemo', array('entity' => 'transactions', 'entity_id' => $entity_id)) ?>')" class="rounded-buttons marg-right-15 submit pull-left" type="submit" value="<?= Yii::t('Drive', 'Submit') ?>">
            </div>
        </div>
    </div>
    </form>
</div>