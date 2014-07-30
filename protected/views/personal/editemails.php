<div class="col-lg-9 col-md-9 col-sm-9" >
  <div class="h1-header">
    <?= Yii::t('Front', 'My personal cabinet'); ?>
  </div>
  <?php $this->widget('XabinaAlert'); ?>
  <div id="emails_edit">
    <div class="xabina-form-container">
      <div class="subheader">
        <?= Yii::t('Front', 'My E-Mail addresses'); ?>
      </div>
        <div class="head-ajax-block">
            <?php $this->renderPartial('_emails', array('users_emails' => $users_emails, 'model_emails' => $model_emails)); ?>
        </div>
    </div>
    <div class="clearfix"></div>
  </div>
</div>
