<div class="transaction-table-overflow  new-transfer-table">
	<table class="table">
		<tbody>
		<?php foreach($transfers as $trans): ?>
		<!-- <?php if($trans->status == $trans::APPROVED_STATUS): ?>class="clickable-row" data-url="<?= Yii::app()->createUrl('/accounts/transaction', array('id' => $trans->id)) ?>"<?php endif; ?> -->
		<tr>
			<td width="15%">
				<?= date('m.d.Y', $trans->created_at) ?>
			</td>
			<td width="9%">OV</td>
			<td width="30%">
				<?= $trans->htmlOperationDescription ?>
			</td>
			<td width="19%" class="align-right"><span class="approved"><?= number_format($trans->amount, 2, ".", " ") ?></span> <?= $trans->currency->code ?></td>
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