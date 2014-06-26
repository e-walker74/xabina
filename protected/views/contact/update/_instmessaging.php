<div class=" xabina-form-narrow">
	<table class="table xabina-table-contacts">
		<tr class="table-header">
			<th style="width: 31%"><?= Yii::t('Front', 'Instant Messaging') ?></th>
			<th style="width: 26%"><?= Yii::t('Front', 'Username') ?></th>
			<th style="width: 16%"><?= Yii::t('Front', 'Category') ?></th>
			<th style="width: 19%"><?= Yii::t('Front', 'Status') ?></th>
			<th style="width: 8%"></th>
		</tr>
		<?php foreach($model->getDataByType('instmessaging') as $m): ?>
		<tr class="data-row">
			<td>
				<div class="messenger-ico <?= $m->messanger ?>"></div>
				<?= $m->messanger ?>
			</td>
			<td><?= $m->name ?></td>
			<td><?= $m->category ?></td>
			<td><span class="primary"><?= ($m->getDbModel()->is_primary) ? 'Primary' : '' ?></span></td>
			<td>
				<div class="transaction-buttons-cont">
					<a class="button delete" data-url="<?= Yii::app()->createUrl('/contact/deleteData', array('type' => 'instmessaging', 'id' => $m->id)) ?>" ></a>
				</div>
			</td>
		</tr>
		<?php endforeach; ?>
		<tr class="data-row">
			<td colspan="5">
				<a href="javaScript:void(0)" class="rounded-buttons upload add-more"><?= Yii::t('Front', 'Add NEW') ?></a>
			</td>
		</tr>
		<tr class="edit-row">
			<td colspan="5">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'dataform-form-instmess',
                    'action' => array('/contact/update', 'url' => $model->url),
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
				<?php $m = new Users_Contacts_Data_Instmessaging; ?>
				<div class="row">
					<div class="col-lg-3 col-md-3  col-sm-3">
						<div class="form-cell">
							<div class="form-lbl">
								<?= Yii::t('Front', 'Inst. Messenger'); ?>
								<span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
							</div>
							<div class="form-input">
								<span class="select-custom-label"></span>
								<div class="select-custom select-narrow ">
									<span class="select-custom-label"></span>
									<?= $form->dropDownList(
										$m,
										'messanger',
										CHtml::listData(InstmessagerSystems::model()->findAll(), 'code', 'name'),
										array(
											'class' => 'select-invisible country-select', 
											'options' => array($m->messanger => array('selected' => true)),
											'empty' => Yii::t('Front', 'Select')
										)
									); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4">
						<div class="form-cell">
							<div class="form-lbl">
								<?= Yii::t('Front', 'Username'); ?>
								<span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
							</div>
							<div class="form-input">
								<div class="form-input">
									<?= $form->textField($m, 'name', array('class' => 'input-text')) ?>
									<?= $form->error($m, 'name') ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3">
						<div class="form-cell">
							<div class="form-lbl">
								<?= Yii::t('Front', 'Type'); ?>
								<span class="tooltip-icon" title="<?= Yii::t('Front', 'type_inst_mess_contact'); ?>"></span>
							</div>
							<div class="form-input">
								<div class="select-custom select-narrow ">
									<span class="select-custom-label"></span>
									<?= $form->dropDownList(
										$m,
										'category',
										CHtml::listData(Categories::model()->findAll(), 'title', 'title'),
										array(
											'class' => 'select-invisible country-select', 
											'options' => array($m->category => array('selected' => true)),
											'empty' => Yii::t('Front', 'Select')
										)
									); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2">
						<div class="transaction-buttons-cont edit-submit-cont">
							<input type="submit" class="button ok" value="" />
							<a href="javaScript:void(0)" class="button cancel"></a>
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