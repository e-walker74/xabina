<table class="table">
	<tbody>
		<?php foreach($transactions as $trans): ?>
			<?php if($trans->transfer_type == 'outgoing'): ?>
				<tr class="clickable-row" data-transaction-info-url="<?= Yii::app()->createUrl('/accounts/transaction', array('id' => $trans->url)) ?>">
					<td width="15%"><?= date('d.m.Y', $trans->created_at) ?></td>
					<td width="10%">OV</td>
					<td width="35%">
						<b>
						<?php if($trans->type == 'positive'): ?>
							<?= $trans->info->sender ?>
						<?php elseif($trans->type == 'negative'): ?>
							<?= ($trans->info) ? $trans->info->recipient : ""?>
						<?php endif; ?>
						</b>
						<br/>
						<?= $trans->operation ?>
					</td>
					<td width="15%" style="text-align:right;">
						<?php if($trans->type == 'positive'): ?>
							<span class="sum-inc">+<?= number_format($trans->sum, 2, ".", " ") ?></span>
						<?php else: ?>
							<span class="sum-dec">-<?= number_format($trans->sum, 2, ".", " ") ?></span>
						<?php endif; ?>
						<?= $selectedAcc->currency->code ?></td>
					<td width="18%" style="text-align:right;">
						<?php if($trans->acc_balance >= 0): ?>
							<span class="sum-inc"><?= number_format($trans->acc_balance, 2, ".", " ") ?></span>
						<?php else: ?>
							<span class="sum-dec"><?= number_format($trans->acc_balance, 2, ".", " ") ?></span>
						<?php endif; ?>
						<?= $selectedAcc->currency->code ?></td>
					</td>
					<td width="7%"><!--<a class="attachment-button" href="#"></a>--></td>
				</tr>
			<?php elseif($trans->transfer_type == 'incoming'): ?>
				<tr class="clickable-row" data-transaction-info-url="<?= Yii::app()->createUrl('/accounts/transaction', array('id' => $trans->url)) ?>">
					<td width="15%"><?= date('d.m.Y', $trans->created_at) ?></td>
					<td width="10%">OV</td>
					<td width="35%">
						<b>
						<?php if($trans->type == 'positive'): ?>
							<?= ($trans->info) ? $trans->info->sender : ""?>
						<?php endif; ?>
						</b>
						<br/>
						<?= $trans->operation ?>
					</td>
					<td width="15%" style="text-align:right;">
						<?php if($trans->type == 'positive'): ?>
							<span class="sum-inc">+<?= number_format($trans->sum, 2, ".", " ") ?></span>
						<?php else: ?>
							<span class="sum-dec">-<?= number_format($trans->sum, 2, ".", " ") ?></span>
						<?php endif; ?>
						<?= $selectedAcc->currency->code ?></td>
					<td width="18%" style="text-align:right;">
						<?php if($trans->acc_balance >= 0): ?>
							<span class="sum-inc"><?= number_format($trans->acc_balance, 2, ".", " ") ?></span>
						<?php else: ?>
							<span class="sum-dec"><?= number_format($trans->acc_balance, 2, ".", " ") ?></span>
						<?php endif; ?>
						<?= $selectedAcc->currency->code ?></td>
					</td>
					<td width="7%"><!--<a class="attachment-button" href="#"></a>--></td>
				</tr>
			<?php endif; ?>
		<?php endforeach; ?>
		<?php if(empty($transactions)): ?>
			<tr>
				<td colspan="5"><?= Yii::t('Front', 'No transaction match the filter criterias. Please, change the filter criterias in Advanced Search tab.') ?></td>
			</tr>
		<?php endif; ?>
	</tbody>
</table>