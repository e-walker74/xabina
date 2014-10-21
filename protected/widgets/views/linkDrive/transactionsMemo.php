<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 28.09.14
 * Time: 18:33
 * @var WLinkDrive  $this
 * @var Users_Files[] $model
 */
?>
<?php if (!Yii::request()->isAjaxRequest): ?>
    <tr class="before-memo" style="display: none"></tr>
<?php endif; ?>
<tr class="title_tr linked_tr drive_memo" <?php if (!$model): ?>style="display: none"<?php endif; ?>>
    <td colspan="5"><?= Yii::t('Drive', 'Memo') ?></td>
</tr>
<?php foreach ($model as $memo): ?>
    <tr class="linked_tr drive_memo">
        <td class="icon_td">
            <?php if($memo->document_type == 'folder'): ?>
                <a href="javaScript:void(0)" onclick="$('#linkNewMemoModal').addClass('no-load'); $('#linkNewMemoModal').modal('show'); WLinkDrive.openFolder('', <?= $memo->id ?>, $('#linkNewMemoModal').find('.modal-body'));">
                    <img width="26" src="/css/layout/account/img/folder_img.png" />
                </a>
            <?php else: ?>
                <a href="javaScript:void(0)" data-memo-id="<?= $memo->id ?>" onclick="WLinkDrive.editMemo(this, 'editCommentModal', <?= $memo->model_id ?>)">
                    <img src="/css/images/one_memo.png">
                </a>
            <?php endif; ?>
        </td>
        <td class="title">
            <?php if($memo->document_type != 'folder'): ?>
                <a href="javaScript:void(0)" data-memo-id="<?= $memo->id ?>" onclick="WLinkDrive.editMemo(this, 'editCommentModal', <?= $memo->model_id ?>)">
            <?php else: ?>
                <a href="javaScript:void(0)" onclick="$('#linkNewMemoModal').addClass('no-load'); $('#linkNewMemoModal').modal('show'); WLinkDrive.openFolder('', <?= $memo->id ?>, $('#linkNewMemoModal').find('.modal-body'));">
            <?php endif; ?>
                <div class="account-data pull-left">
                    <div class="full_text" style="display: none;">
                        <p><?= $memo->description ?></p>
                    </div>
                    <div class="account-name">
                        <?php if($memo->document_type == 'folder'): ?>
                            <?= $memo->user_file_name ?>
                        <?php else: ?>
                            <?= $memo->getShortDescription() ?></div>
                        <?php endif; ?>
                    <div class="account-info">
                        <?php if($memo->document_type == 'folder'): ?>
                            <?= count($memo->memos_children) ?> <?= Yii::t('Transactions', 'memos'); ?>
                        <?php else: ?>
                            <?= $memo->user->fullName ?>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
        </td>
        <td class="edit">
            <?= Widget::get('WCrossLink')->changeCategory($memo->cross_id, $memo->cross_category, 'cross_users_memo') ?>
        </td>
        <td class="comment">
            <?= Widget::get('WCrossLink')->changeComment($memo->cross_id, $memo->cross_comment) ?>
        </td>
        <td class="delete">
            <div class="attach_del_block"><a
                    data-url="<?= Yii::app()->createUrl('/ajax/removetag', array('id' => $memo->id, 'entity' => $memo->form, 'entity_id' => $memo->model_id, 'cross_type' => 'users_files_memo')) ?>"
                    class="del_a"></a></div>
        </td>
    </tr>
<?php endforeach; ?>
<script>
    WLinkDrive.bindUnlinkFile()
</script>