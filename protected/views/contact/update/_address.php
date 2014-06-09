<div class=" xabina-form-narrow">
	<table class="table xabina-table-contacts">
		<tr class="table-header">
			<th style="width: 52%"><?= Yii::t('Front', 'Address'); ?></th>
			<th style="width: 23%"><?= Yii::t('Front', 'Category'); ?></th>
			<th style="width: 25%"><?= Yii::t('Front', 'Status'); ?></th>
			<th style="width: 0"></th>
		</tr>
		<?php foreach($model->getDataByType('address') as $address): ?>
		<tr class="data-row">
			<td>
				<?= $address->address ?><br>
				<?= $address->index ?> <?= $address->country_code ?>
			</td>
			<td><?= $address->category ?></td>
			<td><span class="primary"><?= ($address->getDbModel()->is_primary) ? Yii::t('Front', 'Primary') : '' ?></span></td>
			<td>
				<div class="transaction-buttons-cont">
					<a href="javaScript:void(0)" class="button edit"></a>
				</div>
			</td>
		</tr>
		<tr class="edit-row">
			<td colspan="4">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'dataform-form-address'.$address->id,
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
							<?= $form->hiddenField($address, 'id') ?>
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Address') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'address_name_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($address, 'address', array('class' => 'input-text')) ?>
									<?= $form->error($address, 'address') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Country') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'country_name_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($address, 'country_id', array('class' => 'input-text')) ?>
									<?= $form->error($address, 'country_id') ?>
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
					<div class="row">
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Index') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'index_address_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($address, 'index', array('class' => 'input-text')) ?>
									<?= $form->error($address, 'index') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Category') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'category_address_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($address, 'category', array('class' => 'input-text bg')) ?>
									<?= $form->error($address, 'category') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 ">

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
					'id'=>'dataform-form-address',
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
				<?php $address = new Users_Contacts_Data_Address; ?>
				<div class="xabina-form-narrow">
					<div class="row">
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Address') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'address_name_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($address, 'address', array('class' => 'input-text')) ?>
									<?= $form->error($address, 'address') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Country') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'country_name_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($address, 'country_id', array('class' => 'input-text')) ?>
									<?= $form->error($address, 'country_id') ?>
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
					<div class="row">
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Index') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'index_address_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($address, 'index', array('class' => 'input-text')) ?>
									<?= $form->error($address, 'index') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Category') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'category_address_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($address, 'category', array('class' => 'input-text bg')) ?>
									<?= $form->error($address, 'category') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 ">

						</div>
					</div>
				</div>
				<?php $this->endWidget(); ?>
			</td>
		</tr>
	</table>
</div>