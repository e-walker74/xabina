<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 29.09.14
 * Time: 9:37
 * @var Users_Files $model
 */ ?>

<li class="drive-file-row" >
    <div class="bg-color">
        <div class="cont_check_block">
            <label class="modal-galka-checkbox">
                <input name="files[]" value="<?= $model->id ?>" type="checkbox"/>
            </label>
        </div>
        <div class="account-photo pull-left" onclick="WLinkDrive.openFolder(this, '<?= $model->id ?>')">
            <img style="height: 30px;" src="/css/layout/account/img/folder_img.png" alt="">
        </div>
        <div class="account-data pull-left name-block" onclick="WLinkDrive.openFolder(this, '<?= $model->id ?>')">
            <div class="account-name drive-search-text"><?= $model->name ?></div>
            <div class="account-info"><?= count($model->files_children) ?> <?= Yii::t('Drive', 'files') ?></div>
        </div>
        <div class="account-data pull-left descr-block" style="min-height: 40px" onclick="WLinkDrive.openFolder(this, '<?= $model->id ?>')">
            <div class="one_str drive-search-text"><?= $model->description ?></div>
        </div>
        <div class="account-data pull-left created-block" onclick="WLinkDrive.openFolder(this, '<?= $model->id ?>')">
            <div class="one_str small-text"><?= date('d.m.Y', $model->created_at) ?></div>
        </div>
        <div class="account-data pull-left size-block" onclick="WLinkDrive.openFolder(this, '<?= $model->id ?>')">
            <div class="one_str small-text"></div>
        </div>
        <div class="transaction-buttons-cont book">
            <a href="#" class="book_button"></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <ul class="pay-list list-unstyled file-list" style="display: none;">
        <li><div><span class="title"><?= Yii::t('Drive', 'Type') ?>:</span> <?= Yii::t('Drive', 'Folder') ?></div></li>
        <li><div><span class="title"><?= Yii::t('Drive', 'Directory') ?>:</span> /<?= $model->getDirectories() ?></div></li>
        <li><div><span class="title"><?= Yii::t('Drive', 'Files') ?>:</span> <?= count($model->files_children) ?></div></li>
        <li><div><span class="title"><?= Yii::t('Drive', 'Created at') ?>:</span> <?= SiteService::timeToDate($model->created_at, true) ?></div></li>
    </ul>
</li>