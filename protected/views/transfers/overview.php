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
		<table class="xabina-table table table-overview">
			<tbody><tr class="table-header">
				<th></th>
				<th><?= Yii::t('Front', 'From'); ?></th>
				<th><?= Yii::t('Front', 'To'); ?></th>
				<th><?= Yii::t('Front', 'Date'); ?></th>
				<th><?= Yii::t('Front', 'Amount'); ?></th>
				<th></th>
				<th></th>
			</tr>
			<?php if(empty($transfers)):?>
				<tr>
					<td colspan="5" class="with-brdr-td">
						<?= Yii::t('Front', 'No unconfirmed transfers'); ?>
					</td>
				</tr>
			<? endif; ?>
			<?php foreach($transfers as $transfer): ?>
			<?php if(!isset($transGroup)) $transGroup = substr(time(), 5, 11)+$transfer->id; ?>
			<tr>
				<td width="5%" class="with-brdr-td">
					<div class="border-td">
						<input name="<?= $transGroup ?>_<?= $transfer->id ?>" type="checkbox" class="overview-check">
					</div>
				</td>
				<td width="27%">
					<?= chunk_split($transfer->account->number, 4) ?>
				</td>
				<td width="28%">
					<?php switch($transfer->send_to){
							case'own':
								echo chunk_split($transfer->own_account->number, 4);
								break;
							case'xabina':
								echo chunk_split($transfer->account_number, 4);
								break;
							case'external':
								echo $transfer->account_holder . ' ' . $transfer->external_account_number;
								break;
					} ?>
					<br/>
					<?=  $transfer->description ?>
					</td>
				<td width="15%"><?= ($transfer->execution_time) ? date('m.d.Y', $transfer->execution_time) : Yii::t('Front', 'Start').': '. date('m.d.Y', $transfer->start_time) . ' ' . Yii::t('Front', 'End').': '. date('m.d.Y', $transfer->end_time) ?></td>
				<td width="15%"><?= $transfer->amount ?> <span class="currency-code"><?= $transfer->currency->code ?></span></td>
				<td width="5%" style="vertical-align: middle">
					<div class="edit-td">
						<a class="overview-edit" href="<?= Yii::app()->createUrl('/transfers/outgoing', array('transfer' => $transfer->id)); ?>"></a>
					</div>
				</td>
				<td width="5%" style="vertical-align: middle">
					<a class="overview-remove" onclick="js:deleteTransaction(this, '<?= Yii::t('Front', 'A You sure You want to delete'); ?>'); return false" href="<?= Yii::app()->createUrl('/transfers/delete', array('id' => $transfer->id)); ?>"></a>
				</td>
			</tr>
			<?php endforeach;?>
			</tbody>
		</table>

		<div class="table-subheader"><?= Yii::t('Front', 'Total order selected') ?> (<span class="count">0</span>)</div>
		<div class="table-xabina-overview-re">
			<?= $this->renderPartial('_checked', array('transes' => array()), true, false); ?>
		</div>
	</div>
</div>
<?php Yii::app()->clientScript->registerScriptFile('/js/transfers.js'); ?>