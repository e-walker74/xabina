<div class="col-lg-9 col-md-9 col-sm-9">
	<div class="h1-header"><?= Yii::t('Front', 'New transfer'); ?></div>
	<?php $this->widget('XabinaAlert'); ?>
	<div class="xabina-progress-bar transfer-bar">
		<div class="step step1  previous">
			<div class="step-name"><?= Yii::t('Front', 'Data input'); ?></div>
			<div class="step-arr"></div>
		</div>
		<div class="step step2 current">
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

	<div class="overview-cont">
		<div class="subheader"><?= Yii::t('Front', 'Overview'); ?></div>
		
		<table class="xabina-table table table-overview xabina-form-container">
			<tbody>
			<tr class="table-header">
				<th width="4%"> <input type="checkbox" class="overview-check"></th>
				<th width="23%"><?= Yii::t('Front', 'From') ?></th>
				<th width="30%"><?= Yii::t('Front', 'To') ?></th>
				<th width="14%"><?= Yii::t('Front', 'Date') ?></th>
				<th width="14%"><?= Yii::t('Front', 'Amount') ?></th>
				<th width="15%"></th>
			</tr>
			<?php foreach($transfers as $transfer): ?>
			<?php if(!isset($transGroup)) $transGroup = substr(time(), 5, 11)+$transfer->id; ?>
			<tr>
				<td class="td-cont" colspan="6">
					<table class="inner-table">
						<tbody><tr>
							<td width="4%" class="with-brdr-td">
								<div class="border-td">
									<input name="<?= $transGroup ?>_<?= $transfer->id ?>" type="checkbox" class="overview-check">
								</div>
							</td>
							<td width="23%">
								<?= chunk_split($transfer->account->number, 4) ?>
							</td>
							<td width="30%">
								<?php switch($transfer->form_type){
											case'own':
												echo chunk_split($transfer->to_account_number, 4);
												break;
											case'xabina':
												echo chunk_split($transfer->to_account_number, 4);
												break;
											case'external':
												echo $transfer->to_account_holder . ' ' . $transfer->to_account_number;
												break;
									} ?>
									<br/>
									<?=  $transfer->description ?>
							</td>
							<td width="14%"><?= ($transfer->frequency_type == 1) ? date('m.d.Y', $transfer->execution_date) : Yii::t('Front', 'Start').': '. date('m.d.Y', $transfer->start_time) . ' ' . Yii::t('Front', 'End').': '. date('m.d.Y', $transfer->end_time) ?></td>
							<td width="14%"><?= $transfer->amount ?> <span class="currency-code"><?= $transfer->currency->code ?></span></td>
							<td width="15%" style="text-align: right">
								<a class="overview-edit" href="<?= Yii::app()->createUrl('/transfers/outgoing', array('transfer' => $transfer->id)); ?>"></a>
								<a class="overview-remove remove-with-dialog" href="<?= Yii::app()->createUrl('/transfers/delete', array('id' => $transfer->id)); ?>"></a>
							</td>
						</tr>
					</tbody></table>
				</td>
				<!--
				<td width="5%" style="vertical-align: middle" >
					<a class="overview-remove" href="#"></a>
				</td>-->
			</tr>
			<?php endforeach;?>
			<tr>
				
				<td class="td-cont overview-payment-sum" colspan="6">
					<?= $this->renderPartial('_checked', array('transes' => array()), true, false); ?>
				</td>
			</tr>
			</tbody>
		</table>
		<div class="remove-dialog xabina-dialog">
			<div class="arr"></div>
			<?= Yii::t('Front', 'Are you sure you want to remove this payment?') ?>
			<a href="#" class="no" tabindex="-1"><?= Yii::t('Front', 'No'); ?></a>
			<a href="#"  class="yes" tabindex="-1"><?= Yii::t('Front', 'Yes'); ?></a>
		</div>
	</div>
</div>
<?php Yii::app()->clientScript->registerScriptFile('/js/transfers.js'); ?>