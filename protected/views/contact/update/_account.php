<div class=" xabina-form-narrow">
	<table class="table xabina-table-contacts">
		<tr class="table-header">
			<th style="width: 20%"><?= Yii::t('Front', 'Account Type') ?></th>
			<th style="width: 34%"><?= Yii::t('Front', 'Account Holder') ?></th>
			<th style="width: 29%"><?= Yii::t('Front', 'Account Number') ?></th>
			<th style="width: 16%"><?= Yii::t('Front', 'Status') ?></th>
			<th style="width: 0"></th>
		</tr>
		<?php foreach($model->getDataByType('account') as $account): ?>
		<tr class="data-row">
			<?php 
				$name = $account->account_type;
				if($ps = PaymentSystems::model()->findByPk($account->account_type)){
					$name = $ps->name;
				}
				
			?>
			<td><?= $name ?></td> <?php //TODO:: dont user this any where!!! ?>
			<td><?= $account->account_holder ?></td>
			<td><?= $account->account_number ?></td>
			<td><span class="primary"><?= ($account->getDbModel()->is_primary) ? Yii::t('Front', 'Primary') : '' ?></span></td>
			<td>
				<div class="transaction-buttons-cont">
					<a href="javaScript:void(0)" class="button edit"></a>
				</div>
			</td>
		</tr>
		<tr class="edit-row">
			<td colspan="5">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'dataform-form-accout'.$account->id,
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
						<div class="col-lg-10 col-md-10 col-sm-10">
							<?= $form->hiddenField($account, 'id') ?>
							<div class="form-cell">
								<div class="form-lbl">
									<?php Yii::t('Front', 'Account Type'); ?>
									<span class="tooltip-icon" title="<?php Yii::t('Front', 'Add Your first name using latin alphabet'); ?>"></span>
								</div>
								<div class="form-input">
									<div class="select-custom select-narrow ">
										<span class="select-custom-label"></span>
										<?= $form->dropDownList(
											$account,
											'account_type',
											CHtml::listData(PaymentSystems::model()->findAll(), 'id', 'name'),
											array(
												'class' => 'select-invisible country-select', 
												'options' => array($account->account_type => array('selected' => true)),
												'empty' => Yii::t('Front', 'Select')
											)
										); ?>
									</div>
									<?= $form->error($account, 'account_type'); ?>
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
									<?= Yii::t('Front', 'Account Holder') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'account_holder_name_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($account, 'account_holder', array('class' => 'input-text')) ?>
									<?= $form->error($account, 'account_holder') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Account Number') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'account_number_name_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($account, 'account_number', array('class' => 'input-text')) ?>
									<?= $form->error($account, 'account_number') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 ">

						</div>
					</div>
					<div class="row">
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'BIC (SWIFT Adres)') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'bic_name_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($account, 'bic', array('class' => 'input-text')) ?>
									<?= $form->error($account, 'bic') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Bank Name') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'banc_name_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($account, 'bank_name', array('class' => 'input-text bg')) ?>
									<?= $form->error($account, 'bank_name') ?>
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
			<td colspan="5">
				<a href="javaScript:void(0)" class="rounded-buttons upload add-more"><?= Yii::t('Front', 'Add NEW'); ?></a>
			</td>
		</tr>
		<tr class="edit-row">
			<td colspan="5">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'dataform-form-account',
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
				<?php $account = new Users_Contacts_Data_Account; ?>
				<div class="xabina-form-narrow">
					<div class="row">
						<div class="col-lg-10 col-md-10 col-sm-10">
							<?= $form->hiddenField($account, 'id') ?>
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Account Type'); ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'Add Your first name using latin alphabet'); ?>"></span>
								</div>
								<div class="form-input">
									<div class="select-custom select-narrow ">
										<span class="select-custom-label"></span>
										<?= $form->dropDownList(
											$account,
											'account_type',
											CHtml::listData(PaymentSystems::model()->findAll(), 'id', 'name'),
											array(
												'class' => 'select-invisible country-select', 
												'options' => array($account->account_type => array('selected' => true)),
												'empty' => Yii::t('Front', 'Select')
											)
										); ?>
									</div>
									<?= $form->error($account, 'account_type'); ?>
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
									<?= Yii::t('Front', 'Account Holder') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'account_holder_name_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($account, 'account_holder', array('class' => 'input-text')) ?>
									<?= $form->error($account, 'account_holder') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Account Number') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'account_number_name_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($account, 'account_number', array('class' => 'input-text')) ?>
									<?= $form->error($account, 'account_number') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 ">

						</div>
					</div>
					<div class="row">
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'BIC (SWIFT Adres)') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'bic_name_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($account, 'bic', array('class' => 'input-text')) ?>
									<?= $form->error($account, 'bic') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Bank Name') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'banc_name_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($account, 'bank_name', array('class' => 'input-text bg')) ?>
									<?= $form->error($account, 'bank_name') ?>
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