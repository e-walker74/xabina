<div class="edit-tabs inner-tabs">
<ul class="list-unstyled">
    <li style="width:16%; border-radius: 3px 0 0 0"><a href="#tab1-0" onclick="updateTab('<?= Yii::app()->createUrl('/contact/updateTab', array('tab' => 'overview', 'url' => $model->url)) ?>')"><?= Yii::t('Front', 'Overview'); ?></a></li>
    <li style="width:17%;"><a href="#tab1-1"><?= Yii::t('Front', 'Personal Info'); ?></a></li>
    <li style="width:17%;"><a href="#tab1-2"><?= Yii::t('Front', 'Accounts'); ?></a></li>
    <li style="width:17%;"><a href="#tab1-3"><?= Yii::t('Front', 'E-Mail'); ?></a></li>
    <li style="width:16%;"><a href="#tab1-4"><?= Yii::t('Front', 'Phone'); ?></a></li>
    <li style="width:17%;border-right: 1px solid #b9babf; border-radius:0 3px 0 0"><a
            href="#tab1-5"><?= Yii::t('Front', 'Address'); ?></a></li>
    <li style="clear: both; width:0;" class="clearfix"></li>
    <li style="width:20%;"><a href="#tab1-6"><?= Yii::t('Front', 'Social Networks'); ?></a></li>
    <li style="width:13%;"><a href="#tab1-7"><?= Yii::t('Front', 'Linking'); ?></a></li>
    <li style="width:22%;"><a href="#tab1-8"><?= Yii::t('Front', 'Instant Messaging'); ?></a></li>
    <li style="width:10%;"><a href="#tab1-9"><?= Yii::t('Front', 'URLs'); ?></a></li>
    <li style="width:11%;"><a href="#tab1-10"><?= Yii::t('Front', 'Date'); ?></a></li>
    <li style="width:12%;"><a href="#tab1-11"><?= Yii::t('Front', 'Categories'); ?></a></li>
    <li style="width:12%;"><a href="#tab1-12"><?= Yii::t('Front', 'Others'); ?></a></li>
</ul>
<div id="tab1-0" class="overview tab">
    <?php $this->renderPartial('update/_overview', array('model' => $model)); ?>
</div>
<div id="tab1-1" class="personal tab">
    <?php $this->renderPartial('update/_personal', array('model' => $model)); ?>
</div>
<div id="tab1-2" class="account tab">
    <?php $this->renderPartial('update/_account', array('model' => $model, 'data_categories' => $data_categories)); ?>
</div>
<div id="tab1-3" class="email tab">
    <?php $this->renderPartial('update/_email', array('model' => $model, 'data_categories' => $data_categories)); ?>
</div>
<div id="tab1-4" class="phone tab">
    <?php $this->renderPartial('update/_phone', array('model' => $model, 'data_categories' => $data_categories)); ?>
</div>
<div id="tab1-5" class="address tab">
    <?php $this->renderPartial('update/_address', array('model' => $model, 'data_categories' => $data_categories)); ?>
</div>
<!--			<div id="tab6" class="default tab">-->
<!--				--><?php //$this->renderPartial('update/_default', array('model' => $model)); ?>
<!--			</div>-->
<div id="tab1-6" class="social tab">
    <?php $this->renderPartial('update/_social', array('model' => $model, 'data_categories' => $data_categories)); ?>
</div>
<div id="tab1-7" class="linking tab">
    <?php $this->renderPartial('update/_contact', array('model' => $model, 'data_categories' => $data_categories)); ?>
</div>
<div id="tab1-8" class="instmessaging tab">
    <?php $this->renderPartial('update/_instmessaging',
        array(
            'model' => $model,
            'data_categories' => $data_categories,
            'instMessengers' => $instMessengers,
        )); ?>
</div>
<div id="tab1-9" class="urls tab">
    <?php $this->renderPartial('update/_urls', array('model' => $model, 'data_categories' => $data_categories)); ?>
</div>
<div id="tab1-10" class="dates tab">
    <?php $this->renderPartial('update/_dates', array('model' => $model, 'data_categories' => $data_categories)); ?>
</div>
<div id="tab1-11" class="categories tab">
    <?php $this->renderPartial('update/_category', array(
            'model' => $model,
            'data_categories' => $data_categories,
            'link' => $link,
            'contact_categories' => $contact_categories
    )); ?>
</div>
<div id="tab1-12" class="others tab">
    <?php $this->renderPartial('update/_others', array(
        'model' => $model,
        'data_categories' => $data_categories,
    )); ?>
</div>
</div>