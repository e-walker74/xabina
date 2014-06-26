<div class="col-lg-9 col-md-9 col-sm-9">
    <div class="h1-header"><?= Yii::t('Front', 'My personal cabinet'); ?></div>
    <div id="addresses_view" class="xabina-form-container">
        <div class="subheader"><?= Yii::t('Front', 'PIN 1') ?></div>
        <div class="head-ajax-block">
                    <?php $this->renderPartial('_pin1', array('model' => $model)); ?>
        </div>
        <div class="subheader"><?= Yii::t('Front', 'PIN 2') ?></div>
        <div class="head-ajax-block">
                    <?php $this->renderPartial('_pin2', array('model' => $model)); ?>
        </div>
        <div class="subheader"><?= Yii::t('Front', 'PIN 3') ?></div>
        <div class="head-ajax-block">
                    <?php $this->renderPartial('_pin3', array('model' => $model)); ?>
        </div>
        <div class="form-submit">
            <a href="<?= Yii::app()->createUrl('/banking/personal') . '/' ?>" class="submit-button button-back"><?= Yii::t('Front', 'Back')?></a>
        </div>
        <div class="clearfix"></div>
    </div>
</div>