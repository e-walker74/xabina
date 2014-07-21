<table class="inner-totals-table">
	<tbody>
		<?php if(empty($transes)): ?>
		<tr class="totals-tr">
			<td width="31%"><?= Yii::t('Front', 'Transfers') ?>:</td>
			<td width="25%">0</td>
			<td width="22%"><?= Yii::t('Front', 'Transfers') ?>:</td>
			<td width="22%" class="align-right"><span class="total-amount">0</span> <span class="total-currency" >EUR</span></td>
		</tr>
		<?php endif; ?>
		<?php $params = array(); ?>
		<?php foreach($transes as $cur => $tr): ?>
		<tr class="totals-tr">
			<td width="31%"><?= Yii::t('Front', 'Transfers') ?>:</td>
			<td width="25%"><?= $tr['count'] ?></td>
			<td width="22%"><?= Yii::t('Front', 'Transfers') ?>:</td>
			<td width="22%" class="align-right <?php if(!$valid): ?>rejected<?php endif; ?>"><span class="total-amount"><?= $tr['amount'] ?></span> <span class="total-currency" ><?= $cur ?></span></td>
		</tr>
		<?php endforeach; ?>
        <?php if($valid): ?>
		<tr class="footer-tr form-submit">
			<td colspan="4">
				<a onclick="return checkAll($('.overview-payment-sum'));" href="<?= Yii::app()->createUrl('/transfers/smsconfirm') ?>" class="submit-button button-next"><?= Yii::t('Front', 'select all and send') ?></a>
				<a class="submit-button button-back selected" onclick="return checkSelectedTransactions('<?= Yii::t('Front', 'You not selected any transactions') ?>', this);" href="<?= Yii::app()->createUrl('/transfers/smsconfirm') ?>"><?= Yii::t('Front', 'send selected tasks') ?></a>
			</td>
		</tr>
        <?php endif; ?>
	</tbody>
</table>

