<div class="col-lg-9 col-md-9 col-sm-9" >
	<div class="h1-header"><?= Yii::t('Front', 'New transfer'); ?></div>
	<?php $this->widget('XabinaAlert'); ?>
	<div class="xabina-progress-bar transfer-bar">
		<div class="step step1 current" >
			<div class="step-name"><?= Yii::t('Front', 'Data input'); ?></div>
			<div class="step-arr"></div>
		</div>
		<div class="step step2">
			<div class="step-name"><?= Yii::t('Front', 'Overview'); ?></div>
			<div class="step-arr"></div>
		</div>
		<div class="step step3">
			<div class="step-name"><?= Yii::t('Front', 'SMS-verification'); ?></div>
			<div class="step-arr"></div>
		</div>
		<div class="step step4 ">
			<div class="step-name"><?= Yii::t('Front', 'Success'); ?></div>
			<div class="step-arr"></div>
		</div>
	</div>
	
	<div class="transfer-first-step">
		<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'transfer-outgoint-from',
				//'action' => Yii::app()->createUrl('/banking/accountsactivation').'/',
				'enableAjaxValidation'=>true,
				'enableClientValidation'=>false,
				'errorMessageCssClass' => 'error-message',
				'htmlOptions' => array(
					'class' => 'form-validable',
					//'onsubmit'=>"return false;",/* Disable normal form submit */
					//'onkeypress'=>" if(event.keyCode == 13){ send(); } "
				),
				//'focus'=>array($model,'first_name'),
				'clientOptions'=>array(
					'validateOnSubmit'=>true,
					'validateOnChange'=>true,
					'errorCssClass'=>'input-error',
					'successCssClass'=>'valid',
					'afterValidate' => 'js:function(form, data, hasError) {
						form.find("input").removeClass("input-error");
						form.find("input").parent().removeClass("input-error");
						form.find(".validation-icon").fadeIn();
						if(hasError) {
							$(".clicked-button").removeClass("clicked-button")
							for(var i in data) {
								$("#"+i).addClass("input-error");
								$("#"+i).parent().addClass("input-error");
								$("#"+i).next(".validation-icon").fadeIn();
							}
							return false;
						}
						else {
							saveTransactions(form)
							$(".clicked-button").removeClass("clicked-button")
						}
						return false;
					}',
					'afterValidateAttribute' => 'js:function(form, attribute, data, hasError) {
						if(hasError){	
							if(!$("#"+attribute.id).hasClass("input-error")){
								$("#"+attribute.id+"_em_").hide().slideDown();
							}
							$("#"+attribute.id).removeClass("valid").parent().removeClass("valid");
							$("#"+attribute.id).addClass("input-error").parent().addClass("input-error");
							$("#"+attribute.id).next(".validation-icon").fadeIn();
						} else {
							if($("#"+attribute.id).hasClass("input-error")){
								$("#"+attribute.id+"_em_").show().slideUp();
							}
							$("#"+attribute.id).removeClass("input-error").parent().next("error-message").slideUp().removeClass("input-error"); 
							$("#"+attribute.id).next(".validation-icon").fadeIn();
							$("#"+attribute.id).addClass("valid");
						}
					}'
				),
		)); ?>
		<div class="transfer-form">
			<table class="transfer-table">
				<tr class="amount">
					<td width="8%"><?= Yii::t('Front', 'Amount'); ?></td>
					<td width="92%">
						
						<?= $form->textField($model, 'amount', array('autocomplete' => 'off', 'class' => 'amount-sum')); ?>
						<span class="delimiter">.</span>
						<?= $form->textField($model, 'amount_cent', array('autocomplete' => 'off', 'class' => 'amount-cent', 'maxlength'=>2)); ?>
						<?= $form->error($model, 'amount', array()); ?>
						<?= $form->error($model, 'amount_cent', array()); ?>
						

						<div class="amount-currency">
							<?= Yii::t('Front', 'Currency'); ?>
							<div class="select-custom currency-select">
								<span class="select-custom-label"><?= ($model->isNewRecord) ? 'EUR' : $model->currency->code; ?></span>
								<?= $form->dropDownList($model, 'currency_id', CHtml::listData($currencies, 'id', 'code'), array('autocomplete' => 'off', 'class' => 'select-invisible')); ?>
							</div>
						</div>
					</td>
				</tr>
				<tr class="account">
					<td><?= Yii::t('Front', 'Account') ?></td>
					<td>
						<div class="select-custom account-select">
							<span class="select-custom-label">
								<?= $selectedAcc->user->fullName ?>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<?= chunk_split($selectedAcc->number, 4) ?>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<?= number_format($selectedAcc->balance, 0, "", " ") ?>
								<?= $selectedAcc->currency->title ?>
							</span>
							<select name="Transfers_Outgoing[account_id]" class="select-invisible">
								<?php foreach($accounts as $acc): ?>
								<option <?php if($acc->number == $selectedAcc->number): ?>selected<?php endif; ?> value="<?= $acc->id ?>">
									<?= $acc->user->fullName ?>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<?= chunk_split($acc->number, 4) ?>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<?= number_format($acc->balance, 0, "", " ") ?>
									<?= $acc->currency->title ?>
								</option>
								<?php endforeach; ?>
							</select>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<div class="select-banner">
			<?= Yii::t('Front', 'Select one of the transfer types'); ?>															
		</div>
		<div class="select-banner-arrow">
			<img src="/images/transfer_select.png" alt=""/>
		</div>

		<div class="transfer-accordion-cont">
			<div class="transfer-accordion" id="transfer_accordion">
				<div class="accordion-header"><a href="#"><?= Yii::t('Front', 'Own account'); ?></a></div>
				<div class="accordion-content own-account">
					<div class="accordion-form xabina-form-container">
						<div class="row-cont">
						<div class="account-select-lbl"><?= Yii::t('Front', 'Account'); ?></div>
						<div class="select-custom account-select">
						<span class="select-custom-label">
							<?= $selectedAcc->user->fullName ?>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<?= chunk_split($selectedAcc->number, 4) ?>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<?= number_format($selectedAcc->balance, 0, "", " ") ?>
							<?= $selectedAcc->currency->title ?>
						</span>
						<select name="Transfers_Outgoing[own_account_id]" class="select-invisible" id="Transfers_Outgoing_own_account_id">
							<?php foreach($accounts as $acc): ?>
							<option <?php if($acc->number == $selectedAcc->number): ?>selected<?php endif; ?> value="<?= $acc->id ?>">
								<?= $acc->user->fullName ?>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<?= chunk_split($acc->number, 4) ?>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<?= number_format($acc->balance, 0, "", " ") ?>
								<?= $acc->currency->title ?>
							</option>
							<?php endforeach; ?>
						</select>
						</div>
						<?= $form->error($model, 'own_account_id', array()); ?>
						</div>
						<div class="form-cont">
						<div class="own-description-cont">
							<div class="own-description-lbl"><?= Yii::t('Front', 'Description'); ?> <span>(0/140)</span></div>
							<?= $form->textArea($model, 'description', array('autocomplete' => 'off', 'class' => 'own-descrition')); ?>
						</div>
							<div class="recurrence-form">
								<div class="recurrence-select">
									<a href="#" class="one-time active"><?= Yii::t('Front', 'One-time') ?></a>
									<a href="#" class="standing"><?= Yii::t('Front', 'Standing') ?></a>
								</div>
								<div class="one_time_form">
									<div class="exec-date-cont">
										<div class="lbl"><?= Yii::t('Front', 'Execution date') ?></div>
										<?= $form->textField($model, 'execution_time', array('autocomplete' => 'off', 'class' => 'exec-date with_datepicker')); ?>
										<?= $form->error($model, 'execution_time', array()); ?>
									</div>
									<div class="urgent-cont">
										<label>
											<?= $form->checkbox($model, 'urgent') ?><?= Yii::t('Front', 'Urgent'); ?>
											<span class="tooltip-icon" title="<?= Yii::t('Front', '[text for urgent tooltip]'); ?>"></span>
										</label>
									</div>
								</div>
								<div class="standing-form">
									<div class="each">
										<div class="lbl"><?= Yii::t('Front', 'Each'); ?></div>
										<div class="select-custom select-quantity">
											<span class="select-custom-label"><?= $model->each_transfer ?></span>
											<?= $form->dropDownList($model, 'each_transfer', array(1 => 1, 2 => 2, 3 => 3), array('autocomplete' => 'off', 'class' => 'select-invisible country-select')); ?>
										</div>
										<div class="select-custom select-digit">
											<span class="select-custom-label"><?php if(!$model->each_period) $model->each_period = 3; ?><?= Yii::t('Front', Transfers_Outgoing::$periods[$model->each_period]) ?></span>
											<?= $form->dropDownList($model, 'each_period', array(1 => Yii::t('Front', 'Day(s)'), 2 => Yii::t('Front', 'Week(s)'), 3 => Yii::t('Front', 'Month(s)')), array('autocomplete' => 'off', 'class' => 'select-invisible country-select')); ?>
										</div>
									</div>
									<div class="exec-date-cont">
										<div class="lbl"><?= Yii::t('Front', 'Starte date'); ?></div>
										<?= $form->textField($model, 'start_time', array('autocomplete' => 'off', 'class' => 'exec-date with_datepicker')); ?>
										<?= $form->error($model, 'start_time', array()); ?>
									</div>
									<div class="exec-date-cont">
										<div class="lbl"><?= Yii::t('Front', 'End date'); ?></div>
										<?= $form->textField($model, 'end_time', array('autocomplete' => 'off', 'class' => 'exec-date with_datepicker')); ?>
										<?= $form->error($model, 'end_time', array()); ?>
									</div>
								</div>
							</div>
							<input name="Transfers_Outgoing[send_to]" id="Transfers_Outgoing_send_to" type="hidden" value="own">
						</div>
						<div class="form-submit">
							<input name="save" onclick="$(this).addClass('clicked-button')" type="submit" value="<?= Yii::t('Front', 'SAVE AND NEW TRANSFER'); ?>" class="submit-button button-save" />
							<input name="save_next" onclick="$(this).addClass('clicked-button')" type="submit" value="<?= Yii::t('Front', 'Next'); ?>" class="submit-button button-next" />
						</div>
					</div>
				</div>
				<div class="accordion-header"><a href="#"><?= Yii::t('Front', 'Another Xabina account'); ?></a></div>
				<div class="accordion-content">
					<div class="accordion-form xabina-form-container">
						<div class="row-cont">
							<div class="account-select-lbl"><?= Yii::t('Front', 'Account number'); ?></div>
							<?= $form->textField($model, 'account_number', array('autocomplete' => 'off', 'class' => 'account-number-input')); ?>
							<?= $form->error($model, 'account_number', array()); ?>
						</div>
						<div class="form-cont">
							<div class="own-description-cont">
								<div class="own-description-lbl"><?= Yii::t('Front', 'Description'); ?> <span>(0/140)</span></div>
								<?= $form->textArea($model, 'description', array('autocomplete' => 'off', 'class' => 'own-descrition')); ?>
							</div>
							<div class="recurrence-form">
								<div class="recurrence-select">
									<a href="#" class="one-time active"><?= Yii::t('Front', 'One-time') ?></a>
									<a href="#" class="standing"><?= Yii::t('Front', 'Standing') ?></a>
								</div>
								<div class="one_time_form">
									<div class="exec-date-cont">
										<div class="lbl"><?= Yii::t('Front', 'Execution date') ?></div>
										<?= $form->textField($model, 'xabina_execution_time', array('autocomplete' => 'off', 'class' => 'exec-date with_datepicker')); ?>
										<?= $form->error($model, 'xabina_execution_time', array()); ?>
									</div>
									<div class="urgent-cont">
										<label>
											<?= $form->checkbox($model, 'urgent') ?><?= Yii::t('Front', 'Urgent'); ?>
											<span class="tooltip-icon" title="<?= Yii::t('Front', '[text for urgent tooltip]'); ?>"></span>
										</label>
									</div>
								</div>
								<div class="standing-form">
									<div class="each">
										<div class="lbl"><?= Yii::t('Front', 'Each'); ?></div>
										<div class="select-custom select-quantity">
											<span class="select-custom-label"><?= $model->each_transfer ?></span>
											<?= $form->dropDownList($model, 'each_transfer', array(1 => 1, 2 => 2, 3 => 3), array('autocomplete' => 'off', 'class' => 'select-invisible country-select')); ?>
										</div>
										<div class="select-custom select-digit">
											<span class="select-custom-label"><?= Yii::t('Front', Transfers_Outgoing::$periods[$model->each_period]) ?></span>
											<?= $form->dropDownList($model, 'each_period', array(1 => Yii::t('Front', 'Day(s)'), 2 => Yii::t('Front', 'Week(s)'), 3 => Yii::t('Front', 'Month(s)')), array('autocomplete' => 'off', 'class' => 'select-invisible country-select')); ?>
										</div>
									</div>
									<div class="exec-date-cont">
										<div class="lbl"><?= Yii::t('Front', 'Starte date'); ?></div>
										<?= $form->textField($model, 'xabina_start_time', array('autocomplete' => 'off', 'class' => 'exec-date with_datepicker')); ?>
										<?= $form->error($model, 'xabina_start_time', array()); ?>
									</div>
									<div class="exec-date-cont">
										<div class="lbl"><?= Yii::t('Front', 'End date'); ?></div>
										<?= $form->textField($model, 'xabina_end_time', array('autocomplete' => 'off', 'class' => 'exec-date with_datepicker')); ?>
										<?= $form->error($model, 'xabina_end_time', array()); ?>
									</div>
								</div>
							</div>
							<input name="Transfers_Outgoing[send_to]" id="Transfers_Outgoing_send_to" type="hidden" value="xabina">
						</div>
						<div class="form-submit">
							<input name="save" onclick="$(this).addClass('clicked-button')" type="submit" value="<?= Yii::t('Front', 'SAVE AND NEW TRANSFER'); ?>" class="submit-button button-save" />
							<input name="save_next" onclick="$(this).addClass('clicked-button')" type="submit" value="<?= Yii::t('Front', 'Next'); ?>" class="submit-button button-next" />
						</div>
					</div>
				</div>
				<div class="accordion-header"><a href="#"><?= Yii::t('Front', 'External bank transfer'); ?></a></div>
				<div class="accordion-content">
					<div class="accordion-form xabina-form-container">
						<div class="row-cont">
							<?= $form->textField($model, 'account_holder', array('autocomplete' => 'off', 'class' => 'acc-holder', 'placeholder' => Yii::t('Front', 'Account Holder'))); ?>
							<?= $form->error($model, 'account_holder', array()); ?>
							<?= $form->textField($model, 'external_account_number', array('autocomplete' => 'off', 'class' => 'acc-number', 'placeholder' => Yii::t('Front', 'Account Number'))); ?>
							<?= $form->error($model, 'external_account_number', array()); ?>
							<a href="#" class="addresses-button"><?= Yii::t('Front', 'Addresses'); ?></a>
						</div>
						<div class="iban-block">
						   <table class="iban-table">
							   <tr>
								   <td width="59%" class="left-col">
										<div class="input-lbl"><?= Yii::t('Front', 'Country') ?></div>
										<div class="select-custom">
											<span class="select-custom-label">
												<?php 
													if($model->isNewRecord || !$model->country_id) { 
														$model->country_id = 3205; 
														echo Yii::t('Front', 'Russian Federation'); 
													} else { 
														echo $model->country->name;
													} ?></span>
											<?= $form->dropDownList($model, 'country_id', CHtml::listData($countries, 'id', 'name'), array('class' => 'select-invisible country-select')); ?>
										</div>
								   </td>
								   <td width="41%">
									   <div class="input-lbl"><?= Yii::t('Front', 'BIC (SWIFT Adres)') ?></div>
									   <?= $form->textField($model, 'swift', array('autocomplete' => 'off', 'class' => 'input-text')); ?>
									   <?= $form->error($model, 'swift', array()); ?>
								   </td>
							   </tr>
							   <tr class="second-row">
								   <td class="left-col ">
									   <div class="input-lbl"><?= Yii::t('Front', 'Bank beneficiary') ?></div>
									   <?= $form->textField($model, 'bank_beneficiary', array('autocomplete' => 'off', 'class' => 'input-text')); ?>
									   <?= $form->error($model, 'bank_beneficiary', array()); ?>
								   </td>
								   <td>
									   <div class="input-lbl"><?= Yii::t('Front', 'postcode and/or city') ?></div>
									   <?= $form->textField($model, 'postcode', array('autocomplete' => 'off', 'class' => 'input-text')); ?>
									   <?= $form->error($model, 'postcode', array()); ?>
								   </td>
							   </tr>
						   </table>
						</div>
						<div class="form-cont">
							<div class="own-description-cont">
								<div class="own-description-lbl"><?= Yii::t('Front', 'Description'); ?> <span>(0/140)</span></div>
								<?= $form->textArea($model, 'description', array('autocomplete' => 'off', 'class' => 'own-descrition')); ?>
							</div>
							<div class="recurrence-form">
								<div class="recurrence-select">
									<a href="#" class="one-time active"><?= Yii::t('Front', 'One-time') ?></a>
									<a href="#" class="standing"><?= Yii::t('Front', 'Standing') ?></a>
								</div>
								<div class="one_time_form">
									<div class="exec-date-cont">
										<div class="lbl"><?= Yii::t('Front', 'Execution date') ?></div>
										<?= $form->textField($model, 'external_execution_time', array('autocomplete' => 'off', 'class' => 'exec-date with_datepicker')); ?>
										<?= $form->error($model, 'external_execution_time', array()); ?>
									</div>
									<div class="urgent-cont">
										<label>
											<?= $form->checkbox($model, 'urgent') ?><?= Yii::t('Front', 'Urgent'); ?>
											<span class="tooltip-icon" title="<?= Yii::t('Front', '[text for urgent tooltip]'); ?>"></span>
										</label>
									</div>
								</div>
								<div class="standing-form">
									<div class="each">
										<div class="lbl"><?= Yii::t('Front', 'Each'); ?></div>
										<div class="select-custom select-quantity">
											<span class="select-custom-label"><?= $model->each_transfer ?></span>
											<?= $form->dropDownList($model, 'each_transfer', array(1 => 1, 2 => 2, 3 => 3), array('autocomplete' => 'off', 'class' => 'select-invisible country-select')); ?>
										</div>
										<div class="select-custom select-digit">
											<span class="select-custom-label"><?= Yii::t('Front', Transfers_Outgoing::$periods[$model->each_period]) ?></span>
											<?= $form->dropDownList($model, 'each_period', array(1 => Yii::t('Front', 'Day(s)'), 2 => Yii::t('Front', 'Week(s)'), 3 => Yii::t('Front', 'Month(s)')), array('autocomplete' => 'off', 'class' => 'select-invisible country-select')); ?>
										</div>
									</div>
									<div class="exec-date-cont">
										<div class="lbl"><?= Yii::t('Front', 'Starte date'); ?></div>
										<?= $form->textField($model, 'external_start_time', array('autocomplete' => 'off', 'class' => 'exec-date with_datepicker')); ?>
										<?= $form->error($model, 'external_start_time', array()); ?>
									</div>
									<div class="exec-date-cont">
										<div class="lbl"><?= Yii::t('Front', 'End date'); ?></div>
										<?= $form->textField($model, 'end_time', array('autocomplete' => 'off', 'class' => 'exec-date with_datepicker')); ?>
										<?= $form->error($model, 'end_time', array()); ?>
									</div>
								</div>
							</div>

						</div>
						<div class="charges-cont">
							<div class="lbl"><?= Yii::t('Front', 'Charges'); ?></div>
							<div class="select-custom select-charges">
								<span class="select-custom-label"><?= Yii::t('Front', 'Shared (mandatory for EC payments)'); ?></span>
								<?= $form->dropDownList($model, 'charges', array('1' => Yii::t('Front', 'Shared (mandatory for EC payments)'), 2 => Yii::t('Front', 'Receiver pays the fees'), 3 => Yii::t('Front', 'Sender pays the fees')), array('class' => 'select-invisible country-select')); ?>
							</div>
						</div>
						<input name="Transfers_Outgoing[send_to]" id="Transfers_Outgoing_send_to" type="hidden" value="external">
						<div class="form-submit">
							<input name="save" onclick="$(this).addClass('clicked-button')" type="submit" value="<?= Yii::t('Front', 'SAVE AND NEW TRANSFER'); ?>" class="submit-button button-save" />
							<input name="save_next" onclick="$(this).addClass('clicked-button')" type="submit" value="<?= Yii::t('Front', 'Next'); ?>" class="submit-button button-next" />
						</div>
					</div>
				</div>

			</div>
		</div>
		<?php $this->endWidget(); ?>
	</div>
</div>
<?php Yii::app()->clientScript->registerScriptFile('/js/transfers.js'); ?>
<?php if(!$model->isNewRecord):?>
<script>
$(document).ready(function(){
	<?php if($model->send_to == 'own'): ?>
	$( "#transfer_accordion" ).accordion( "option", "active", 0 );
	<?php elseif($model->send_to == 'xabina'): ?>
	$( "#transfer_accordion" ).accordion( "option", "active", 1 );
	<?php else: ?>
	$( "#transfer_accordion" ).accordion( "option", "active", 2 );
	<?php endif; ?>
})
</script>
<?php endif; ?>