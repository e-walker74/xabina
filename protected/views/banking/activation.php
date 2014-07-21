<div class="col-lg-9 col-md-9 col-sm-9" id="steps">
	<?php if($activation->step == 1): ?>
		<?php $this->renderPartial('activation/step_one', array('model' => $model, 'activation' => $activation, 'countries' => $countries)); ?>
	<?php elseif($activation->step == 2): ?>
		<?php $this->renderPartial('activation/step_two', array('model' => $model, 'activation' => $activation)); ?>
	<?php elseif($activation->step == 3): ?>
		<?php $this->renderPartial('activation/step_three', array('activation' => $activation)); ?>
	<?php elseif($activation->step == 4): ?>
		<?php $this->renderPartial('activation/step_four', array('activation' => $activation)); ?>
	<?php endif; ?>
</div>
<?php Yii::app()->clientScript->registerScriptFile('/js/activation.js'); ?>