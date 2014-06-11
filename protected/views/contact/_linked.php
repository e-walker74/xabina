<div class="transaction-table-header">
	<table class="transaction-header table xabina-table-personal  table-defaults">
		<tr class="table-header">
			<th width="15%"><?= Yii::t('Front', 'Date'); ?></th>
			<th width="27%"><?= Yii::t('Front', 'From'); ?></th>
			<th width="35%"><?= Yii::t('Front', 'To'); ?></th>
			<th width="23%"><?= Yii::t('Front', 'Value'); ?></th>
			<th width="0%"> </th>
		</tr>
	</table>
</div>
<div class="transaction-table-overflow">
	<table class="table">
		<?php if(!count($model->getTransactionsArray())): ?>
		<tr>
			<td colspan="5">
				<?= Yii::t('Front', 'This contact was not added to transfer like counteragent'); ?>
			</td>
		</tr>
		<?php else: ?>
			<?php foreach($model->getTransactionsArray() as $trans): ?>
				<tr class="clickable-row" data-url="<?= Yii::app()->createUrl('/accounts/transaction', array('id' => $trans['id'])) ?>">
					<td width="16%"><?= date('d.m.Y', $trans['created_at']) ?></td>
					<td width="28%">
						<strong class="holder"><?= $trans['from_holder'] ?></strong><br>
						<?= $trans['from_number'] ?>
					</td>
					<td width="35%">
						<strong class="holder"><?= $trans['to_holder'] ?></strong><br>
						<?= $trans['to_number'] ?>
					</td>
					<td width="21%"><span class="<?= ($trans['type'] == 'positive') ? 'sum-inc' : 'sum-dec' ?>">
						<?= ($trans['type'] == 'positive') ? '+' : '-' ?>
						<?= number_format($trans['amount'], 2, ".", " ") ?></span> <?= $trans['currency'] ?>
					</td>
					<td width="0%"><!--<a class="attachment-button" href="#"></a>--></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</table>
</div>