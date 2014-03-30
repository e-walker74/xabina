<div class="col-lg-9 col-md-9 col-sm-9" >
  <div class="h1-header">
    <?= Yii::t('Front', 'My personal cabinet'); ?>
  </div>
  <?php $this->widget('XabinaAlert'); ?>
  <div id="emails_edit">
    <div class="xabina-form-container">
      <div class="subheader">
        <?= Yii::t('Front', 'Change phone numbers'); ?>
      </div>
      <?php $this->renderPartial('_phones', array('users_phones' => $users_phones, 'model_phones' => $model_phones)); ?>
    </div>
    <div class="clearfix"></div>
  </div>
</div>
