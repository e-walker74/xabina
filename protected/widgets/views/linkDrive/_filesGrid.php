<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 29.09.14
 * Time: 15:28
 * @var WLinkDrive $this
 */ ?>

<?php foreach($files as $file): ?>
    <?php if($file->document_type == 'folder'): ?>
        <?php $this->render('linkDrive/_folder', array('model' => $file)); ?>
    <?php elseif($file->document_type == 'memo'): ?>
        <?php $memos = $this->getMemos($entity, $entityId); ?>
        <?php if(isset($memos[$file->id])) continue; ?>
        <?php $this->render('linkDrive/_memo', array('model' => $file)); ?>
    <?php else: ?>
        <?php $fs = $this->getFiles($entity, $entityId); ?>
        <?php if(isset($fs[$file->id])) continue; ?>
        <?php $this->render('linkDrive/_file', array('model' => $file)); ?>
    <?php endif;?>
<?php endforeach; ?>
<?php if(empty($files)): ?>
    <li class="drive-file-row">
        <div class="notify">
            <?= Yii::t('Drive', 'Folder is empty') ?>
        </div>
    </li>
<?php endif; ?>