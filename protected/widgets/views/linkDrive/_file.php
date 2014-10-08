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

<li class="drive-file-row">
    <div class="bg-color">
        <div class="cont_check_block">
            <label class="modal-galka-checkbox">
                <input name="files[]" value="<?= $model->id ?>" type="checkbox"/>
            </label>
        </div>
        <div class="account-photo pull-left" onclick="WLinkDrive.clickCheckbox(this)">
            <img style="height: 30px;" src="/css/layout/account/img/jpg_img.png" alt="">
        </div>
        <div class="account-data pull-left name-block" onclick="WLinkDrive.clickCheckbox(this)">
            <div class="one_str drive-search-text"><?= SiteService::subStrEx(trim($model->user_file_name), 15); ?></div>
        </div>
        <div class="account-data pull-left descr-block" style="min-height: 40px" onclick="WLinkDrive.clickCheckbox(this)">
            <div title="" class="one_str drive-search-text"><?= SiteService::subStrEx($model->getShortDescription(), 15) ?></div>
        </div>
        <div class="account-data pull-left created-block" onclick="WLinkDrive.clickCheckbox(this)">
            <div class="one_str small-text"><?= date('d.m.Y', $model->created_at) ?></div>
        </div>
        <div class="account-data pull-left size-block" onclick="WLinkDrive.clickCheckbox(this)">
            <div class="one_str small-text"><?= FileService::fromBytes($model->file_size) ?></div>
        </div>
        <div class="transaction-buttons-cont book" onclick="WLinkDrive.clickCheckbox(this)">
            <a href="#" class="book_button"></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <ul class="pay-list list-unstyled file-list" style="display: none;">
        <li><div><span class="title"><?= Yii::t('Drive', 'File type') ?>:</span> <?= $model->ext ?></div></li>
        <li><div><span class="title"><?= Yii::t('Drive', 'Directory') ?>:</span> /<?= $model->getDirectories() ?></div></li>
        <li><div><span class="title"><?= Yii::t('Drive', 'Size') ?>:</span> <?= FileService::fromBytes($model->file_size) ?> (<?= number_format($model->file_size, 0, '.', ' ') ?> <?= Yii::t('Drive', 'bytes') ?>)</div></li>
        <li><div><span class="title"><?= Yii::t('Drive', 'Uploaded') ?>:</span> <?= SiteService::timeToDate($model->created_at, true) ?></div></li>
    </ul>
</li>