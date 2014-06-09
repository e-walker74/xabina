<div class=" xabina-form-narrow">
	<table class="table xabina-table-contacts">
		<tr class="table-header">
			<th style="width: 53%"><?= Yii::t('Front', 'Default'); ?></th>
			<th style="width: 47%"><?= Yii::t('Front', 'Category'); ?></th>
			<th style="width: 0"></th>
		</tr>
		<?php foreach(Users_Contacts_Data_Default::$types as $key => $value): ?>
		<?php $default = Users_Contacts_Data_Default::getModelForType($model, $key); ?>
		<tr class="data-row">
			<td><?= Yii::t('Front', Users_Contacts_Data_Default::$types[$key]) ?></td>
			<td><?= $default->value ?></td>
			<td>
				<div class="transaction-buttons-cont">
					<a href="javaScript:void(0)" class="button edit"></a>
				</div>
			</td>
		</tr>
		<tr class="edit-row">
			<td><?= Yii::t('Front', Users_Contacts_Data_Default::$types[$key]) ?></td>
			<td colspan="2">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'dataform-form-dafault'.$key,
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
				<?php if($default->id): ?>
					<?= $form->hiddenField($default, 'id') ?>
				<?php endif; ?>
				<?= $form->hiddenField($default, 'type') ?>
				<div class="xabina-form-narrow">
					<div class="row">
						<div class="col-lg-8 col-md-8 col-sm-8 ">
							<?php if(Users_Contacts_Data_Default::$types[$key] == 'currency'): ?>
							<div class="select-custom select-narrow ">
								<span class="select-custom-label"></span>
								<?= $form->dropDownList(
									$default,
									'value',
									CHtml::listData(Currencies::model()->findAll(), 'code', 'title'),
									array(
										'class' => 'select-invisible country-select', 
										'options' => array($default->value => array('selected' => true)),
										'empty' => Yii::t('Front', 'Select')
									)
								); ?>
								
							</div>
							<?= $form->error($default, 'value'); ?>
							<?php else: ?>
							<div class="form-input">
								<?= $form->textField($default, 'value', array('class' => 'input-text')) ?>
								<?= $form->error($default, 'value') ?>
							</div>
							<?php endif; ?>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4  edit-submit-cont" style="margin: 0">
							<div class="transaction-buttons-cont">
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
	</table>
</div>