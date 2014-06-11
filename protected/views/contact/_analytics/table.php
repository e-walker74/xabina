<table class="table xabina-table-personal table-defaults">
	<tr class="table-header">
		<th style="width: 30%"><?= Yii::t('Front', 'Quantity') ?></th>
		<th style="width: 35%"><?= Yii::t('Front', 'Value') ?></th>
		<th style="width: 35%"><?= Yii::t('Front', 'Average') ?></th>
	</tr>
	<?php foreach($search->search() as $analytic): ?>
		<tr class="color" >
			<td><?= $analytic['count_transfers'] ?></td>
			<td>
				<span class="<?= ($analytic['value'] > 0) ? 'sum-inc' : 'sum-dec'?>">
					<?= ($analytic['value'] > 0) ? '+' : ''?> <?= number_format($analytic['value'], 2, ".", " ") ?>
				</span> 
				<?= $analytic['currency'] ?>
			</td>
			<td>
				<span class="<?= ($analytic['average'] > 0) ? 'sum-inc' : 'sum-dec'?>">
					<?= ($analytic['average'] > 0) ? '+' : ''?> <?= number_format($analytic['average'], 2, ".", " ") ?>
				</span> 
				<?= $analytic['currency'] ?>
			</td>
		</tr>
	<?php endforeach;?>
	<?php if(!count($search->search())): ?>
		<tr class="color" >
			<td colspan="3"><?= Yii::t('Front', 'Empty analytics') ?></td>
		</tr>
	<?php endif; ?>
</table>