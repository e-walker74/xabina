<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'analytics-form',
	'action' => Yii::app()->createUrl('/contact/analytics', array('id' => $model->id)),
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'errorMessageCssClass' => 'error-message',
	'htmlOptions' => array(
		'class' => 'form-validable',
	),
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
		'validateOnChange'=>true,
		'errorCssClass'=>'input-error',
		'successCssClass'=>'valid',
		'afterValidate' => 'js:afterValidate',
		'afterValidateAttribute' => 'js:afterValidateAttribute'
	),
)); ?>
<div class="analytics-form xabina-form-container">
	<div class="input-cell">
		<div class="field-lbl">
			<?= Yii::t('Front', 'Category'); ?>
		</div>
		<div class="field-input">
			<div class="select-custom select-narrow account-select">
				<span class="select-custom-label"><?= Yii::t('Front', 'All payments'); ?></span>
				<?= $form->dropDownList(
					$search,
					'type',
					array(
						'all' => Yii::t('Front', 'All payments'),
						'outgoing' => Yii::t('Front', 'Outgoing payments'),
						'incoming' => Yii::t('Front', 'Incoming payments'),
					),
					array('class' => 'select-invisible country-select', 'options' => array('' => array('selected' => true, 'disabled' => true)))
				) ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6">
			<div class="input-cell">
				<div class="field-lbl">
					<?= Yii::t('Front', 'Date From'); ?>
				</div>
				<div class="field-input">
					<?php  $search->from_date = date('d.m.Y', $search->from_date) ?>
					<?= $form->textField($search, 'from_date', array('class' => 'date-input with_datepicker')) ?>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6">
			<div class="input-cell">
				<div class="field-lbl">
					<?= Yii::t('Front', 'Date To'); ?>
				</div>
				<div class="field-input">
					<?php  $search->to_date = date('d.m.Y', $search->to_date) ?>
					<?= $form->textField($search, 'to_date', array('class' => 'date-input with_datepicker')) ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="analytics-results">
	<?= $this->renderPartial('_analytics/table', array('search' => $search)); ?>
</div>
<?php $this->endWidget(); ?>