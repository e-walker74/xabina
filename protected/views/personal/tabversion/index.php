<div class="col-lg-9 col-md-9 col-sm-9">
<div class="contact-cont ">
<div class="contact-header">
    <div class="contact-photo">
        <img src="<?= $model->getPhotoUrl() ?>" alt=""/>
        <span class="valid-status ok"></span>
    </div>
    <div class="contact-name">
        <?= $model->first_name ?> <?= $model->last_name ?><br>
        <span class="company-name">ID: <?= $model->login ?> </span>
    </div>
    <div class="contact-actions transaction-buttons-cont">
        <div class="btn-group">
            <a class="button menu" data-toggle="dropdown" href="#"></a>
            <ul class="dropdown-menu">
                <li>
                    <a class="button pdf" href="#"></a>
                </li>
                <li>
                    <a class="button print" href="#"></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<div class="edit-tabs contact-tabs">
<ul class="list-unstyled">
    <li style="width: 25%"><a href="#tab1"><?= Yii::t('Personal', 'General Info') ?></a></li>
    <li style="width: 25%"><a href="#accounts"><?= Yii::t('Personal', 'Accounts') ?></a></li>
    <li style="width: 25%"><a href="#tab6"><?= Yii::t('Personal', 'Dialogue') ?></a></li>
    <li style="width: 25%"><a href="#tab5"><?= Yii::t('Personal', 'Drive') ?></a></li>
</ul>
<div class="clearfix"></div>
<div id="tab1">

<div class="edit-tabs inner-tabs personal-tabs">
<ul class="list-unstyled">
    <li style="width:15%; border-radius: 3px 0 0 0"><a href="#overview" data-url="<?= Yii::app()->createUrl('/personal/index') ?>"><?= Yii::t('Personal', 'Overview') ?></a></li>
    <li style="width:16%;"><a href="#personal" data-url="<?= Yii::app()->createUrl('/personal/personal') ?>"><?= Yii::t('Personal', 'Personal Info') ?></a></li>
    <li style="width:10%;">
        <a href="#emails" data-url="<?= Yii::app()->createUrl('/personal/editemails') ?>"><?= Yii::t('Personal', 'E-Mail') ?></a>
    </li>
    <li style="width:10%;">
        <a href="#phones" data-url="<?= Yii::app()->createUrl('/personal/editphones') ?>"><?= Yii::t('Personal', 'Phone') ?></a>
    </li>
    <li style="width:11%;"><a href="#addresses" data-url="<?= Yii::app()->createUrl('/personal/editaddress') ?>"><?= Yii::t('Personal', 'Address') ?></a></li>
    <li style="width:18%;"><a href="#socials" data-url="<?= Yii::app()->createUrl('/personal/editsocials') ?>"><?= Yii::t('Personal', 'Social Networks') ?></a></li>
    <li style="width:20%;border-right: 1px solid #b9babf; border-radius:0 3px 0 0"><a href="#instmess" data-url="<?= Yii::app()->createUrl('/personal/editmessagers') ?>"><?= Yii::t('Personal', 'Instant Messaging') ?></a></li>
    <li style="clear: both; width:0;" class="clearfix"></li>
    <li style="width:22%;"><a href="#questions" data-url="<?= Yii::app()->createUrl('/personal/editqustions') ?>"><?= Yii::t('Personal', 'Security Questions') ?></a></li>
    <li style="width:15%;"><a href="#password" data-url="<?= Yii::app()->createUrl('/personal/editpins') ?>"><?= Yii::t('Personal', 'Password') ?></a></li>
    <li style="width:25%;"><a href="#settings" data-url="<?= Yii::app()->createUrl('/personal/settings') ?>"><?= Yii::t('Personal', 'Account Settings') ?></a></li>
    <li style="width:20%;"><a href="#payments" data-url="<?= Yii::app()->createUrl('/personal/paymentinstuments') ?>"><?= Yii::t('Personal', 'Payment Method') ?></a></li>
    <li style="width:18%;"><a href="#newslatter" data-url="<?= Yii::app()->createUrl('/personal/newsletter') ?>"><?= Yii::t('Personal', 'Newsletter') ?></a></li>

</ul>
<div id="overview" class="tab">
</div>
<div id="personal" class="tab">
</div>
<div id="emails" class="tab">
</div>
<div id="phones" class="tab">

</div>
<div id="addresses" class="tab">
</div>
<div id="socials" class="tab">

</div>
<div id="questions" class="tab">

</div>
<div id="instmess" class="tab">

</div>
<div id="password" class="tab">

</div>
<div id="settings" class="tab">

</div>
<div id="payments" class="tab">
</div>
<div id="newslatter" class="tab">

</div>
</div>


</div>
<div id="accounts">
    <?php $this->renderPartial('tabversion/_accounts', array('model' => $model)) ?>
</div>
<div id="tab6">
</div>

<div id="tab5">
    <div class="drive-brcr">
        <a href="#">Drive</a>
    </div>
    <div class="drive-add-file">
        <input class="drive-file-search pull-left" type="text"/>
        <a href="#" class="pull-right rounded-buttons add-contact-but">Add New File</a>
    </div>
    <table class="table xabina-table-contacts drive-table-header">
        <tr class="table-header">
            <th style="width: 13%"></th>
            <th style="width: 39%">Title</th>
            <th style="width: 48%">Type</th>
        </tr>
    </table>
    <div class="drive-list-table-overflow">
        <table class="table drive-list-table">
            <tr style="height: 0">
                <td style="border:none; padding: 0;width:6%;"></td>
                <td style="border:none; padding: 0;width:46%;"></td>
                <td style="border:none; padding: 0;width:39%;"></td>
                <td style="border:none; padding: 0;width:9%;"></td>
            </tr>
            <tr class="note-tr">
                <td colspan="4">
                    Для полноценной работы с документами и файлами, пожалуйста перейдите в раздел
                    <a href="#">Drive</a>
                </td>
            </tr>
            <tr>
                <td class="checkbox-td">
                    <input type="checkbox"/>
                </td>
                <td>
                    div class="folder-ico">
    </div>
    <a href="#" class="file-name">Verification documents</a>

    <div class="file-info">7 files</div>
    </td>
    <td>System</td>
    <td style=" overflow: visible!important;">
        <div class="contact-actions transaction-buttons-cont">
            <div class="btn-group">
                <a class="button menu" data-toggle="dropdown" href="#"></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="button download" href="#"></a>
                    </li>
                    <li>
                        <a class="button edit" href="#"></a>
                    </li>
                    <li>
                        <a class="button delete" href="#"></a>
                    </li>
                </ul>
            </div>
        </div>
    </td>
    </tr>
    <tr>
        <td class="checkbox-td">
            <input type="checkbox"/>
        </td>
        <td>
            <div class="folder-ico">
            </div>
            <a href="#" class="file-name">Other</a>

            <div class="file-info">25 files</div>
        </td>
        <td>Business</td>
        <td style=" overflow: visible!important;">
            <div class="contact-actions transaction-buttons-cont">
                <div class="btn-group">
                    <a class="button menu" data-toggle="dropdown" href="#"></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="button download" href="#"></a>
                        </li>
                        <li>
                            <a class="button edit" href="#"></a>
                        </li>
                        <li>
                            <a class="button delete" href="#"></a>
                        </li>
                    </ul>
                </div>
            </div>
        </td>
    </tr>
    </table>
</div>

</div>
</div>

</div>
</div>

<script>

</script>