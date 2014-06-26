<div class=" xabina-form-narrow">
	<table class="table xabina-table-contacts">
		<tr class="table-header">
			<th style="width: 17%"><?= Yii::t('Front', 'Account Type') ?></th>
			<th style="width: 27%"><?= Yii::t('Front', 'Account Holder') ?></th>
			<th style="width: 24%"><?= Yii::t('Front', 'Account Number') ?></th>
			<th style="width: 11%"><?= Yii::t('Front', 'Status') ?></th>
			<th style="width: 20%"></th>
		</tr>
		<?php foreach($model->getDataByType('account') as $account): ?>
		<tr class="data-row">
			<td><?= Users_Contacts_Data_Account::$contacts_account_types[$account->account_type] ?></td> <?php //TODO:: dont user this any where!!! ?>
			<td><?= $account->account_holder ?></td>
			<td><?= $account->account_number ?></td>
			<td>
                <?php if($account->getDbModel()->is_primary): ?>
                    <span class="primary">
                        <?= Yii::t('Front', 'Primary') ?>
                    </span>
                <?php else: ?>
                    <a class="make-primary" href="javaScript:void(0)" data-url="<?= Yii::app()->createUrl('/contact/makePrimary', array('entity' => $account->getDbModel()->data_type, 'id' => $account->getDbModel()->id)) ?>" onclick="makePrimary(this)"><?= Yii::t('Front', 'Make primary') ?></a>
                <?php endif; ?>
			</td>
			<td>
				<div class="transaction-buttons-cont">
					<a href="javaScript:void(0)" class="button edit"></a>
					<a class="button delete" data-url="<?= Yii::app()->createUrl('/contact/deleteData', array('type' => 'account', 'id' => $account->id)) ?>" ></a>
				</div>
			</td>
		</tr>
		<tr class="edit-row">
			<td colspan="5">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'dataform-form-accout'.$account->id,
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
				<div class="xabina-form-narrow">
					<div class="row">
						<div class="col-lg-10 col-md-10 col-sm-10">
							<?= $form->hiddenField($account, 'id') ?>
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Account Type'); ?>
									<span class="tooltip-icon" title="<?php Yii::t('Front', 'Add Your first name using latin alphabet'); ?>"></span>
								</div>
								<div class="form-input">
									<div class="select-custom select-narrow" style="background: #e1e1e7">
										<span class="select-custom-label"></span>
										<?= $form->dropDownList(
											$account,
											'account_type',
											Users_Contacts_Data_Account::$contacts_account_types,
											array(
												'class' => 'select-invisible country-select accout_type_select',
												'disabled' => 'disabled',
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
									<?= Yii::t('Front', 'Details of Payments') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'details_account_name_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($account, 'details', array('class' => 'input-text')) ?>
									<?= $form->error($account, 'details') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Category') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'category_name_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($account, 'category', array('class' => 'input-text')) ?>
									<?= $form->error($account, 'category') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 ">
						</div>
					</div>
					<div class="account_type_fields data_1 <?= ($account->account_type == '1') ? "selected" : "" ?>">
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
										<?= $form->textField($account, 'bic', array('class' => 'input-text bank-swift', 'data-url' => Yii::app()->createUrl('/transfers/GetBankName'))) ?>
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
										<?= $form->textField($account, 'bank_name', array('class' => 'input-text bg bankinfo-name', 'disabled' => 'disabled')) ?>
										<?= $form->error($account, 'bank_name') ?>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-md-2 col-sm-2 ">

							</div>
						</div>
					</div>
					<div class="account_type_fields data_2 <?= ($account->account_type == '2') ? "selected" : "" ?>">
						<div class="row">
							<div class="col-lg-10 col-md-10 col-sm-10">
								<div class="form-cell">
									<div class="form-lbl">
										<?= Yii::t('Front', 'Paypal') ?>
										<span class="tooltip-icon" title="<?= Yii::t('Front', 'account_paypal_name_contact') ?>"></span>
									</div>
									<div class="form-input">
										<?= $form->textField($account, 'paypal_acc', array('class' => 'input-text')) ?>
										<?= $form->error($account, 'paypal_acc') ?>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-md-2 col-sm-2 ">

							</div>
						</div>
					</div>
					<div class="account_type_fields data_3 <?= ($account->account_type == 3) ? "selected" : "" ?>">
						<div class="row">
							<div class="col-lg-10 col-md-10 col-sm-10">
								<div class="form-cell">
									<div class="form-lbl">
										<?= Yii::t('Front', 'Scrill account') ?>
										<span class="tooltip-icon" title="<?= Yii::t('Front', 'account_scrill_acc_name_contact') ?>"></span>
									</div>
									<div class="form-input">
										<?= $form->textField($account, 'scrill_acc', array('class' => 'input-text')) ?>
										<?= $form->error($account, 'scrill_acc') ?>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-md-2 col-sm-2 ">

							</div>
						</div>
					</div>
					<div class="account_type_fields data_4 <?= ($account->account_type == 4) ? "selected" : "" ?>">
						<div class="row">
							<div class="col-lg-10 col-md-10 col-sm-10">
								<div class="form-cell">
									<div class="form-lbl">
										<?= Yii::t('Front', 'Webmoney account') ?>
										<span class="tooltip-icon" title="<?= Yii::t('Front', 'account_webmoney_acc_name_contact') ?>"></span>
									</div>
									<div class="form-input">
										<?= $form->textField($account, 'webmoney_acc', array('class' => 'input-text')) ?>
										<?= $form->error($account, 'webmoney_acc') ?>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-md-2 col-sm-2 ">

							</div>
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
											Users_Contacts_Data_Account::$contacts_account_types,
											array(
												'class' => 'select-invisible country-select accout_type_select', 
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
									<?= Yii::t('Front', 'Details of Payments') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'details_account_name_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($account, 'details', array('class' => 'input-text')) ?>
									<?= $form->error($account, 'details') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Category') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'category_name_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($account, 'category', array('class' => 'input-text')) ?>
									<?= $form->error($account, 'category') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 ">
						</div>
					</div>
					<div class="account_type_fields data_1">
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
										<?= $form->textField($account, 'bic', array('class' => 'input-text bank-swift', 'data-url' => Yii::app()->createUrl('/transfers/GetBankName'))) ?>
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
										<?= $form->textField($account, 'bank_name', array('class' => 'input-text bg bankinfo-name', 'disabled' => 'disabled')) ?>
										<?= $form->error($account, 'bank_name') ?>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-md-2 col-sm-2 ">

							</div>
						</div>
					</div>
					<div class="account_type_fields data_2">
						<div class="row">
							<div class="col-lg-10 col-md-10 col-sm-10">
								<div class="form-cell">
									<div class="form-lbl">
										<?= Yii::t('Front', 'Paypal') ?>
										<span class="tooltip-icon" title="<?= Yii::t('Front', 'account_paypal_name_contact') ?>"></span>
									</div>
									<div class="form-input">
										<?= $form->textField($account, 'paypal_acc', array('class' => 'input-text')) ?>
										<?= $form->error($account, 'paypal_acc') ?>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-md-2 col-sm-2 ">

							</div>
						</div>
					</div>
					<div class="account_type_fields data_3">
						<div class="row">
							<div class="col-lg-10 col-md-10 col-sm-10">
								<div class="form-cell">
									<div class="form-lbl">
										<?= Yii::t('Front', 'Scrill account') ?>
										<span class="tooltip-icon" title="<?= Yii::t('Front', 'account_scrill_acc_name_contact') ?>"></span>
									</div>
									<div class="form-input">
										<?= $form->textField($account, 'scrill_acc', array('class' => 'input-text')) ?>
										<?= $form->error($account, 'scrill_acc') ?>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-md-2 col-sm-2 ">

							</div>
						</div>
					</div>
					<div class="account_type_fields data_4">
						<div class="row">
							<div class="col-lg-10 col-md-10 col-sm-10">
								<div class="form-cell">
									<div class="form-lbl">
										<?= Yii::t('Front', 'Webmoney account') ?>
										<span class="tooltip-icon" title="<?= Yii::t('Front', 'account_webmoney_acc_name_contact') ?>"></span>
									</div>
									<div class="form-input">
										<?= $form->textField($account, 'webmoney_acc', array('class' => 'input-text')) ?>
										<?= $form->error($account, 'webmoney_acc') ?>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-md-2 col-sm-2 ">

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