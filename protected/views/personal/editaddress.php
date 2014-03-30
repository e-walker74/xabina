<div class="col-lg-9 col-md-9 col-sm-9" >
  <div class="h1-header">
    <?= Yii::t('Front', 'My personal cabinet'); ?>
  </div>
  <?php $this->widget('XabinaAlert'); ?>
  <div id="emails_edit">
    <div class="xabina-form-container">
      <div class="subheader">
        <?= Yii::t('Front', 'Change addresses'); ?>
      </div>
      <?php $this->renderPartial('_address', array('users_address' => $users_address, 'model_address' => $model_address)); ?>
    </div>
    <div class="clearfix"></div>
  </div>
</div>
