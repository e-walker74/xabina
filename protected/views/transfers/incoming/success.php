<div class="col-lg-9 col-md-9 col-sm-9">
	<div class="h1-header"><?= Yii::t('Front', 'Upload money'); ?></div>
	<div class="transfer-success-cont">
		<div class="subheader"><?= Yii::t('Front', 'Success'); ?></div>
		<div class="xabina-bubble">
			<span><?= Yii::t('Front', 'Thank You!'); ?></span>
			<br>
			<?= Yii::t('Front', 'Your transaction(s) have been successfully planned and going to be proccessed soon. You can see all the planned transactions in the table below.'); ?>
			<div class="habina-bubble-arr"></div>
		</div>
	</div>
	
	<div class="subheader"><?= Yii::t('Front', 'Transactions') ?></div>
		
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
	
	<?php $this->renderPartial('incoming/_table', array('transfers' => $transfers)); ?>

</div>