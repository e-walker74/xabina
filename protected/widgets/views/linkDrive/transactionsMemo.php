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
        <td class="icon_td"><img src="/css/images/one_memo.png"></td>
        <td class="title">
            <a href="javaScript:void(0)" data-memo-id="<?= $memo->id ?>" onclick="WLinkDrive.editMemo(this, 'editCommentModal', <?= $memo->model_id ?>)">
                <div class="account-data pull-left">
                    <div class="full_text" style="display: none;">
                        <p><?= $memo->description ?></p>
                    </div>
                    <div class="account-name"><?= $memo->getShortDescription() ?></div>
                    <div class="account-info">
                        <?= $memo->user->fullName ?>
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
                    data-url="<?= Yii::app()->createUrl('/ajax/removetag', array('id' => $memo->id, 'entity' => $memo->form, 'entity_id' => $memo->model_id, 'cross_type' => $memo->tableName())) ?>"
                    class="del_a"></a></div>
        </td>
    </tr>
<?php endforeach; ?>
<script>
    WLinkDrive.bindUnlinkFile()
</script>