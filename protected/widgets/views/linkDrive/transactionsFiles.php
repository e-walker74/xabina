<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 28.09.14
 * Time: 23:00
 * @var Users_Files $file
 */ ?>

<?php if (!Yii::request()->isAjaxRequest): ?>
    <tr class="before-files" style="display: none"></tr>
<?php endif; ?>
<?php if($model): ?>
<tr class="title_tr linked_tr drive_files">
    <td colspan="5"><?= Yii::t('Drive', 'Files') ?></td>
</tr>
<?php endif; ?>
<?php foreach ($model as $file): ?>
<tr class="linked_tr drive_files">
    <td class="icon_td">
        <?php if($file->document_type == 'folder'): ?>
            <img width="26" src="/css/layout/account/img/folder_img.png" />
        <?php else: ?>
        <a href="<?= Yii::app()->createUrl('/file/get', array('id' => $file->id, 'name' => $file->name)) ?>">
            <img src="/css/images/message-file.png" />
        </a>
        <?php endif; ?>
    </td>
    <td class="title">
        <?php if($file->document_type != 'folder'): ?>
        <a href="<?= Yii::app()->createUrl('/file/get', array('id' => $file->id, 'name' => $file->name)) ?>">
        <?php else: ?>
            <a href="javaScript:void(0)" onclick="$('#addNewFileModal').addClass('no-load'); $('#addNewFileModal').modal('show'); WLinkDrive.openFolder('', <?= $file->id ?>, $('#addNewFileModal').find('.modal-body'));">
        <?php endif; ?>
        <div class="account-data pull-left">
            <div class="account-name"><?= $file->user_file_name ?></div>
            <div class="account-info">
                <?php if($file->document_type == 'folder'): ?>
                    <?= count($file->files_children) ?> <?= Yii::t('Transactions', 'files'); ?>
                <?php else: ?>
                    <?= SiteService::subStrEx($file->description, 30) ?>
                <?php endif; ?>
            </div>
        </div>
        </a>
    </td>
    <td class="edit">
        <?= Widget::get('WCrossLink')->changeCategory($file->cross_id, $file->cross_category, 'cross_users_files') ?>
    </td>
    <td class="comment">
        <?= Widget::get('WCrossLink')->changeComment($file->cross_id, $file->cross_comment) ?>
    </td>
    <td class="delete"><div class="attach_del_block"><a class="del_a" data-url="<?= Yii::app()->createUrl('/ajax/removetag', array('id' => $file->id, 'entity' => $file->form, 'entity_id' => $file->model_id, 'cross_type' => $file->tableName())) ?>"></a></div></td>
</tr>
<?php endforeach; ?>
<script>
    WLinkDrive.bindUnlinkFile()
</script>