<div class="col-lg-9 col-md-9 col-sm-9">
	<div class="h1-header"><?= Yii::t('Front', 'New transfer') ?></div>
	<?php $this->widget('XabinaAlert'); ?>
	<div class="transfer-sms-container ">
		<div class="subheader"><?= Yii::t('Front', 'Payments Overview') ?></div>
		
		<div class="transaction-table-header">
			<table class="transaction-header">
				<tbody><tr>
					<td width="14%"><?= Yii::t('Front', 'Date'); ?></td>
					<td width="9%"><?= Yii::t('Front', 'Type'); ?></td>
					<td width="29%"><?= Yii::t('Front', 'Description'); ?></td>
					<td width="19%" class="align-right"><?= Yii::t('Front', 'Value'); ?></td>
					<td width="15%"><?= Yii::t('Front', 'Status'); ?></td>
					<td width="14%"> </td>
				</tr>
			</tbody></table>
		</div>
		<div class="transaction-table-overflow  new-transfer-table">
			<table class="table">
				<tbody>
				<?php foreach($transfers as $trans): ?>
				<!-- <?php if($trans->status == $trans::APPROVED_STATUS): ?>class="clickable-row" data-url="<?= Yii::app()->createUrl('/accounts/transaction', array('id' => $trans->id)) ?>"<?php endif; ?> -->
				<tr >
					<td width="15%">
						<?= date('m.d.Y', $trans->created_at) ?>
					</td>
					<td width="9%">OV</td>
					<td width="30%">
						<?= $trans->htmlOperationDescription ?>
					</td>
					<td width="19%" class="align-right">- <?= number_format($trans->amount, 2, ".", " ") . " " . $trans->currency->code ?></td>
					<td width="14%">
						<?= $trans->htmlStatus ?>
					</td>
					<td width="13%">
						<?php if($trans->status == $trans::APPROVED_STATUS): ?>
							<a class="button send-button active" href="#"></a>
						<?php else: ?>
							<a class="button send-button" href="#"></a>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody></table>
		</div>

	</div>
</div>