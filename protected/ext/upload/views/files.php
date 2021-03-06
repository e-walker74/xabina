<div id="<?=$this->formId?>-attachments-block" class="transaction-info-cont custom attachments-block">
<?php if(count($files)): ?>
    <table class="inner-table attachments-table">
        <tbody>
        <tr>
            <th style="width:13%"><?= Yii::t('Front', 'File type') ?></th>
            <th style="width:42%"><?= Yii::t('Front', 'File comments') ?></th>
            <th style="width:25%"><?= Yii::t('Front', 'Sender') ?></th>
            <th style="width:20%"></th>
        </tr>
        <tr>
            <td colspan="4">
                <ul class="attachments-list list-unstyled">
                    <?php foreach($files as $file): ?>
                        <li>
                            <div class="attach-img">
                                <a href="<?= Yii::app()->createUrl('/file/get', array('id' => $file->id, 'name' => $file->user_file_name)) ?>">
                                    <img alt="" src="<?= Yii::app()->createUrl('/file/getMinimize', array('id' => $file->id, 'name' => $file->user_file_name)) ?>">
                                </a>
                            </div>
                            <div class="attach-comment">
                                <div class="not-edit-doc">
                                    <?= $file->shortDescription ?>
                                </div>
                                <div class="edit-doc">
                                    <span class="qtity">(<span class="len-num">0</span>/140)</span>
                                    <textarea class="len" name="edit_file_comment" maxlength="250" ><?= $file->description ?></textarea>
                                    <div class="error-message"></div>
                                </div>
                            </div>
                            <div class="attach-sender">
                                <?= $file->user->fullName; ?>
                                <div class="datetime"><span><?= date('d.m.Y', $file->created_at) ?></span><?= date('H:i', $file->created_at) ?></div>

                            </div>
                            <div class="attach-actions">
                                <div class="not-edit-doc transaction-buttons-cont">
                                    <a class="button download" href="<?= Yii::app()->createUrl('/file/get', array('id' => $file->id, 'name' => $file->user_file_name)) ?>"></a>
                                    <a class="button edit" href="javaScript:void(0)" onclick="editRow($(this).parents('li'))"></a>
                                    <a class="button delete dialog-file-delete" data-url="<?= Yii::app()->createUrl('/file/delete', array('id' => $file->id)) ?>" href="javaScript:void(0)"></a>
                                </div>
                                <div class="edit-doc transaction-buttons-cont">
                                    <a class="button ok" href="<?= Yii::app()->createUrl('/file/edit', array('id' => $file->id)) ?>"></a>
                                    <a class="button cancel" href="javaScript:void(0)"></a>
                                </div>
                            </div>
                            <input type="hidden" name="file_ids[]" value="<?= $file->id ?>">
                        </li>
                    <?php endforeach; ?>
                </ul>
            </td>
        </tr>
        </tbody>
    </table>
<?php endif; ?>
</div>



