<div class="col-lg-9 col-md-9 col-sm-9">
<div class="contact-cont ">
<div class="contact-header">
    <div class="contact-photo">
        <img style="width: 40px;" src="<?= $model->getPhotoUrl() ?>" alt=""/>
        <img src="<?= UserService::getStatusImageUrl(Yii::user()->getSelfActivityStatus()) ?>" alt="" class="valid-status self-activity-status"/>

    </div>
    <div class="contact-name">
        <?= $model->first_name ?> <?= $model->last_name ?><br>
        <span class="company-name"><?= Yii::t('Site', 'User ID') ?>: <?= $model->login ?> </span>
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

<div class="edit-tabs contact-tabs personal-tabs">
<ul class="list-unstyled">
    <li style="width: 50%"><a href="#tab1"><?= Yii::t('Personal', 'General Info') ?></a></li>
    <li style="width: 50%"><a href="#accounts" data-url="<?= Yii::app()->createUrl('/personal/accounts') ?>"><?= Yii::t('Personal', 'Accounts') ?></a></li>
</ul>
<div class="clearfix"></div>
<div id="tab1">

<div class="edit-tabs inner-tabs personal-tabs">
<ul class="list-unstyled">
    <li style="width:17%; border-radius: 3px 0 0 0"><a href="#overview" data-url="<?= Yii::app()->createUrl('/personal/index') ?>"><?= Yii::t('Personal', 'Overview') ?></a></li>
    <li style="width:20%;"><a href="#personal" data-url="<?= Yii::app()->createUrl('/personal/personal') ?>"><?= Yii::t('Personal', 'Personal Info') ?></a></li>
    <li style="width:12%;">
        <a href="#emails" data-url="<?= Yii::app()->createUrl('/personal/editemails') ?>"><?= Yii::t('Personal', 'E-Mail') ?></a>
    </li>
    <li style="width:13%;">
        <a href="#phones" data-url="<?= Yii::app()->createUrl('/personal/editphones') ?>"><?= Yii::t('Personal', 'Phone') ?></a>
    </li>
    <li style="width:16%;"><a href="#addresses" data-url="<?= Yii::app()->createUrl('/personal/editaddress') ?>"><?= Yii::t('Personal', 'Address') ?></a></li>
    <li style="width:22%;border-right: 1px solid #b9babf; border-radius:0 3px 0 0;"><a href="#payments" data-url="<?= Yii::app()->createUrl('/personal/paymentinstuments') ?>"><?= Yii::t('Personal', 'Payment Method') ?></a></li>
    <li style="clear: both; width:0;" class="clearfix"></li>
    <li style="width:26%;"><a href="#questions" data-url="<?= Yii::app()->createUrl('/personal/editqustions') ?>"><?= Yii::t('Personal', 'Security Questions') ?></a></li>
    <li style="width:17%;"><a href="#password" data-url="<?= Yii::app()->createUrl('/personal/editpins') ?>"><?= Yii::t('Personal', 'Password') ?></a></li>
    <li style="width:27%;"><a href="#settings" data-url="<?= Yii::app()->createUrl('/personal/settings') ?>"><?= Yii::t('Personal', 'Account Settings') ?></a></li>
    <li style="width:30%;"><a href="#newslatter" data-url="<?= Yii::app()->createUrl('/personal/newsletter') ?>"><?= Yii::t('Personal', 'Notifications') ?></a></li>

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
<div id="other" class="tab">

</div>
</div>


</div>
<div id="accounts" class="tab">
    <?php $this->renderPartial('tabversion/_accounts', array('model' => $model)) ?>
</div>

</div>
</div>

</div>