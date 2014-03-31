<table class="table">
	<tbody>
		<?php foreach($transactions as $trans): ?>
			<tr data-transaction-info-url="<?= Yii::app()->createUrl('/accounts/transaction', array('id' => $trans->id)) ?>">
				<td width="15%"><?= date('d.m.Y', $trans->created_at) ?></td>
				<td width="10%">OV</td>
				<td width="40%">
					<b><?= $trans->info->sender ?></b>
					<br/>
					<?= $trans->operation ?>
				</td>
				<td width="22%">
					<?php if($trans->type == 'positive'): ?>
						<span class="sum-inc">+<?= number_format($trans->sum, 0, "", " ") ?></span>
					<?php else: ?>
						<span class="sum-dec">-<?= number_format($trans->sum, 0, "", " ") ?></span>
					<?php endif; ?>
					<?= $selectedAcc->currency->code ?></td>
				<td width="13%"><?= number_format($trans->acc_balance, 0, "", " ") ?></td>
				<td width="0%"><!--<a class="attachment-button" href="#"></a>--></td>
			</tr>
		<?php endforeach; ?>
		<?php if(empty($transactions)): ?>
			<tr>
				<td colspan="5"><?= Yii::t('Front', 'Oops. There was no transaction associated with this account.') ?></td>
			</tr>
		<?php endif; ?>
	</tbody>
</table>