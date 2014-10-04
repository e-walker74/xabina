<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 29.09.14
 * Time: 15:28
 */ ?>

<?php foreach($files as $file): ?>
    <?php if($file->document_type == 'folder'): ?>
        <?php $this->render('linkDrive/_folder', array('model' => $file)); ?>
    <?php elseif($file->document_type == 'memo'): ?>
        <?php $this->render('linkDrive/_memo', array('model' => $file)); ?>
    <?php else: ?>
        <?php $this->render('linkDrive/_file', array('model' => $file)); ?>
    <?php endif;?>
<?php endforeach; ?>
<?php if(empty($files)): ?>
    <li class="drive-file-row">
        <div class="notify">
            <?= Yii::t('Drive', 'folder_is_empty') ?>
        </div>
    </li>
<?php endif; ?>