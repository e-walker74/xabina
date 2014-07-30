<div class="col-lg-9 col-md-9 col-sm-9" >
  <div class="h1-header">
    <?= Yii::t('Front', 'My personal cabinet'); ?>
  </div>
  <?php $this->widget('XabinaAlert'); ?>
  <div id="emails_view" class="xabina-form-container">
		<div class="subheader"><?= Yii::t('Front', 'My security questions'); ?></div>
        <div class="head-ajax-block">
            <?php $this->renderPartial('_questions_forms', array('user' => $user, 'model' => $model)) ?>
        </div>
		<div class="form-submit">
			<a href="<?= Yii::app()->createUrl('/banking/personal') . '/' ?>" class="submit-button button-back"><?= Yii::t('Front', 'Back')?></a>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
