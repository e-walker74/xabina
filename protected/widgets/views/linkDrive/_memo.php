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
            <img style="height: 30px;" src="/css/images/one_memo.png" alt="">
        </div>
        <div class="account-data pull-left name-block" style="width: 73%; min-height: 29px" onclick="WLinkDrive.clickCheckbox(this)">
            <div class="account-name drive-search-text"><?= $model->getShortDescription(); ?></div>
        </div>
        <div class="account-data pull-left created-block" onclick="WLinkDrive.clickCheckbox(this)">
            <div class="one_str small-text"><?= date('d.m.Y', $model->created_at) ?></div>
        </div>
        <div class="clearfix"></div>
    </div>
</li>