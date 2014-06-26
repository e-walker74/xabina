<div class="col-lg-9 col-md-9 col-sm-9">
    <div class="h1-header">
        <?= Yii::t('Front', 'My personal cabinet'); ?>
    </div>
    <?php $this->widget('XabinaAlert'); ?>
    <div id="emails_view" class="xabina-form-container">
        <div class="subheader"><?= Yii::t('Front', 'My instant messengers'); ?></div>
        <div class="head-ajax-block">
            <?php $this->renderPartial('_instmessangers_form',
                array(
                    'model' => new Users_Instmessagers(),
                    'user' => $user,
                )); ?>
        </div>
        <div class="form-submit">
            <a href="<?= Yii::app()->createUrl('/personal/index') . '/' ?>"
               class="submit-button button-back"><?= Yii::t('Front', 'Back') ?></a>
        </div>
        <div class="clearfix"></div>
    </div>
</div>