<div class="col-lg-9 col-md-9 col-sm-9">
	<div class="h1-header"><?= Yii::t('Front', 'New transfer'); ?></div>
	<div class="xabina-progress-bar transfer-bar">
		<div class="step step1 ">
			<div class="step-name"><?= Yii::t('Front', 'Data input'); ?></div>
			<div class="step-arr"></div>
		</div>
		<div class="step step2 ">
			<div class="step-name"><?= Yii::t('Front', 'Overview'); ?></div>
			<div class="step-arr"></div>
		</div>
		<div class="step step3  previous">
			<div class="step-name"><?= Yii::t('Front', 'SMS-verification'); ?></div>
			<div class="step-arr"></div>
		</div>
		<div class="step step4 current ">
			<div class="step-name"><?= Yii::t('Front', 'Success'); ?></div>
			<div class="step-arr"></div>
		</div>
	</div>
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
				<td width="19%" class="align-right rejected">- <?= number_format($trans->amount, 2, ".", " ") . " " . $trans->currency->code ?></td>
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