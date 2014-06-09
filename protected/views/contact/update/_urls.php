<div class=" xabina-form-narrow">
	<table class="table xabina-table-contacts">
		<tr class="table-header">
			<th style="width: 54%"><?= Yii::t('Front', 'URL') ?></th>
			<th style="width: 46%"><?= Yii::t('Front', 'Category') ?></th>
			<th style="width: 0"></th>
		</tr>
		<?php foreach($model->getDataByType('urls') as $model): ?>
		<tr class="data-row">
			<td><?= $model->url ?></td>
			<td><?= $model->category ?></td>
			<td>
				<div class="transaction-buttons-cont">
					<a href="javaScript:void(0)" class="button edit"></a>
				</div>
			</td>
		</tr>
		<tr class="edit-row">
			<td colspan="3">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'dataform-form-urls'.$model->id,
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
				<?= $form->hiddenField($model, 'id') ?>
				<div class="row">
					<div class="col-lg-6 col-md-6  col-sm-6">
						<div class="form-cell">
							<div class="form-lbl">
								<?= Yii::t('Front', 'Type URL Adress') ?>
								<span class="tooltip-icon" title="<?= Yii::t('Front', '') ?>"></span>
							</div>
							<div class="form-input">
								<div class="form-input">
									<?= $form->textField($model, 'url', array('class' => 'input-text')) ?>
									<?= $form->error($model, 'url') ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4">
						<div class="form-cell">
							<div class="form-lbl">
								<?= Yii::t('Front', 'Category'); ?>
								<span class="tooltip-icon" title="<?= Yii::t('Front', 'category_tooltip'); ?>"></span>
							</div>
							<div class="form-input">
								<span class="select-custom-label"></span>
								<div class="select-custom select-narrow ">
									<span class="select-custom-label"></span>
									<?= $form->dropDownList(
										$model,
										'category',
										CHtml::listData(Categories::model()->findAll(), 'title', 'title'),
										array(
											'class' => 'select-invisible country-select', 
											'options' => array($model->category => array('selected' => true)),
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
		<?php endforeach; ?>
		<tr class="data-row">
			<td colspan="3">
				<a href="javaScript:void(0)" class="rounded-buttons upload add-more"><?= Yii::t('Front', 'Add NEW') ?></a>
			</td>
		</tr>
		<tr class="edit-row">
			<td colspan="3">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'dataform-form-urls',
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
				<?php $model = new Users_Contacts_Data_Urls; ?>
				<div class="row">
					<div class="col-lg-6 col-md-6  col-sm-6">
						<div class="form-cell">
							<div class="form-lbl">
								<?= Yii::t('Front', 'Type URL Adress') ?>
								<span class="tooltip-icon" title="<?= Yii::t('Front', '') ?>"></span>
							</div>
							<div class="form-input">
								<div class="form-input">
									<?= $form->textField($model, 'url', array('class' => 'input-text')) ?>
									<?= $form->error($model, 'url') ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4">
						<div class="form-cell">
							<div class="form-lbl">
								<?= Yii::t('Front', 'Category'); ?>
								<span class="tooltip-icon" title="<?= Yii::t('Front', 'category_tooltip'); ?>"></span>
							</div>
							<div class="form-input">
								<span class="select-custom-label"></span>
								<div class="select-custom select-narrow ">
									<span class="select-custom-label"></span>
									<?= $form->dropDownList(
										$model,
										'category',
										CHtml::listData(Categories::model()->findAll(), 'title', 'title'),
										array(
											'class' => 'select-invisible country-select', 
											'options' => array($model->category => array('selected' => true)),
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