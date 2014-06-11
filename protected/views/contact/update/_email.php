<div class=" xabina-form-narrow">
	<table class="table xabina-table-contacts">
		<tr class="table-header">
			<th style="width: 38%"><?= Yii::t('Front', 'E-Mail') ?></th>
			<th style="width: 21%"><?= Yii::t('Front', 'Category') ?></th>
			<th style="width: 21%"><?= Yii::t('Front', 'Status') ?></th>
			<th style="width: 20%"></th>
		</tr>
		<?php foreach($model->getDataByType('email') as $model): ?>
		<tr class="data-row">
			<td><?= $model->email ?></td>
			<td><?= $model->category ?></td>
			<td><span class="primary"><?= ($model->getDbModel()->is_primary) ? Yii::t('Front', 'Primary') : '' ?></span></td>
			<td>
				<div class="transaction-buttons-cont">
					<a href="javaScript:void(0)" class="button edit"></a>
					<a class="button delete" data-url="<?= Yii::app()->createUrl('/contact/deleteData', array('type' => 'email', 'id' => $model->id)) ?>" ></a>
				</div>
			</td>
		</tr>
		<tr class="edit-row">
			<td colspan="4">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'dataform-form-email'.$model->id,
					'enableAjaxValidation'=>true,
					'enableClientValidation'=>true,
					'errorMessageCssClass' => 'error-message',
					'htmlOptions' => array(
						'class' => 'form-validable',
						'enctype' => 'multipart/form-data',
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
				<div class="xabina-form-narrow">
					<div class="row">
						<div class="col-lg-5 col-md-5 col-sm-5">
							<?= $form->hiddenField($model, 'id') ?>
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'E-mail') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'address_name_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($model, 'email', array('class' => 'input-text')) ?>
									<?= $form->error($model, 'email') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Category') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'country_name_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($model, 'category', array('class' => 'input-text')) ?>
									<?= $form->error($model, 'category') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 ">
							<div class="transaction-buttons-cont edit-submit-cont">
								<input type="submit" class="button ok" value=""/>
								<a href="javaScript:void(0)" class="button cancel"></a>
							</div>
						</div>
					</div>
				</div>
				<?php $this->endWidget(); ?>
			</td>
		</tr>
		<?php endforeach; ?>
		<tr class="data-row">
			<td colspan="4">
				<a href="javaScript:void(0)" class="rounded-buttons upload add-more"><?= Yii::t('Front', 'Add NEW'); ?></a>
			</td>
		</tr>
		<tr class="edit-row">
			<td colspan="4">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'dataform-form-email',
					'enableAjaxValidation'=>true,
					'enableClientValidation'=>true,
					'errorMessageCssClass' => 'error-message',
					'htmlOptions' => array(
						'class' => 'form-validable',
						'enctype' => 'multipart/form-data',
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
				<?php $model = new Users_Contacts_Data_Email; ?>
				<div class="xabina-form-narrow">
					<div class="row">
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'E-mail') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'address_name_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($model, 'email', array('class' => 'input-text')) ?>
									<?= $form->error($model, 'email') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Category') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'country_name_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($model, 'category', array('class' => 'input-text')) ?>
									<?= $form->error($model, 'category') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 ">
							<div class="transaction-buttons-cont edit-submit-cont">
								<input type="submit" class="button ok" value=""/>
								<a href="javaScript:void(0)" class="button cancel"></a>
							</div>
						</div>
					</div>
				</div>
				<?php $this->endWidget(); ?>
			</td>
		</tr>
	</table>
</div>
<script>
$(document).ready(function(){
	$('.transaction-buttons-cont .delete').confirmation({
		title: '<?= Yii::t('Front', 'Are you sure?') ?>',
		singleton: true,
		popout: true,
		onConfirm: function(){
			deleteRow($(this).parents('.popover').prev('a'));
			return false;
		}
	})
})
</script>