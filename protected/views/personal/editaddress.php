<div class="col-lg-9 col-md-9 col-sm-9" >
  <div class="h1-header">
    <?= Yii::t('Front', 'My personal cabinet'); ?>
  </div>
  <?php $this->widget('XabinaAlert'); ?>
	<div id="addresses_view" class="xabina-form-container">
		<div class="subheader"><?= Yii::t('Front', 'My addresses'); ?></div>
        <div class="head-ajax-block">
		    <?= $this->renderPartial('_address_table', array(
                'model' => $model,
                'user' => $user,
            )); ?>
        </div>
		<div class="form-submit">
			<a href="<?= Yii::app()->createUrl('/personal/index') ?>" class="submit-button button-back">Back</a>
		</div>
		<div class="clearfix"></div>
	</div>
</div>