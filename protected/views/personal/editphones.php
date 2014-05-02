<div class="col-lg-9 col-md-9 col-sm-9" >
  <div class="h1-header">
    <?= Yii::t('Front', 'My personal cabinet'); ?>
  </div>
  <?php $this->widget('XabinaAlert'); ?>
  <div id="emails_edit">
    <div class="xabina-form-container">
      <div class="subheader">
        <?= Yii::t('Front', 'My phone numbers'); ?>
      </div>
      <?php $this->renderPartial('_mobile_phones', array('users_phones' => $users_phones, 'model_phones' => $model_phones)); ?>
	  
	  <div class="subheader">
        <?= Yii::t('Front', 'Change phone numbers'); ?>
      </div>
      <?php $this->renderPartial('_phones', array('model_telephones' => $model_telephones, 'user' => $user)); ?>
	  
    </div>
    <div class="clearfix"></div>
  </div>
</div>