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
<?php $i = 0; ?>
<?php foreach($files as $file): ?>
    <?php if($file->document_type == 'folder'): ?>
        <?php $i++; ?>
        <?php $this->render('linkDrive/_memoFolder', array('model' => $file)); ?>
    <?php elseif($file->document_type == 'memo'): ?>
        <?php $memos = $this->getMemos($entity, $entityId); ?>
        <?php if(isset($memos[$file->id])) continue; ?>
        <?php $i++; ?>
        <?php $this->render('linkDrive/_memo', array('model' => $file)); ?>
    <?php endif;?>
<?php endforeach; ?>
<?php if($i == 0): ?>
    <li class="drive-file-row">
        <div class="notify">
            <?= Yii::t('Drive', 'Folder is empty') ?>
        </div>
    </li>
<?php endif; ?>