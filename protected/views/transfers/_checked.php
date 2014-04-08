<table class="xabina-table table table-overview">
	<tbody>
	<tr class="table-header">
		<th class="align-left" colspan="2"><?= Yii::t('Front', 'Selected') ?></th>
		<th class="align-right" colspan="2"><?= Yii::t('Front', 'Total amount') ?></th>
	</tr>
	<?php if(empty($transes)): ?>
	<tr>
		<td width="31%"><?= Yii::t('Front', 'Transfers') ?>:</td>
		<td width="25%"><span class="count">0</span></td>
		<td width="22%"><?= Yii::t('Front', 'Transfers') ?>:</td>
		<td width="22%" class="align-right"><span class="total-amount">0</span> <span class="total-currency" >EUR</span></td>
	</tr>
	<?php endif; ?>
	<?php $params = array(); ?>
	<?php foreach($transes as $cur => $tr): ?>
	<tr>
		<td width="31%"><?= Yii::t('Front', 'Transfers') ?>:</td>
		<td width="25%"><span class="count"><?= $tr['count'] ?></span></td>
		<td width="22%"><?= Yii::t('Front', 'Transfers') ?>:</td>
		<td width="22%" class="align-right"><span class="total-amount"><?= $tr['amount'] ?></span> <span class="total-currency" ><?= $cur ?></span></td>
	</tr>
	<?php endforeach; ?>
	<tr class="footer-tr">
		<td colspan="4">
			<a class="back-button" href="<?= Yii::app()->createUrl('/transfers/outgoing') ?>"><span><?= Yii::t('Front', 'Back') ?></span></a>

			<a class="send-button" onclick="js:checkAll(this);" href="<?= Yii::app()->createUrl('/transfers/smsconfirm') ?>"><?= Yii::t('Front', 'select all and send') ?></a>
			<a class="send-selected-button" href="<?= Yii::app()->createUrl('/transfers/smsconfirm') ?>"><?= Yii::t('Front', 'send selected tasks') ?></a>
		</td>
	</tr>
	</tbody>
</table>

