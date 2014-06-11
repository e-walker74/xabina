<div class="col-lg-9 col-md-9 col-sm-9" >
	<div class="xabina-form-container">
		<div class="h1-header"><?= Yii::t('Front', 'Invoices Overview') ?></div>
		<table class="table xabina-table">
			<tbody><tr class="table-header">
				<th><?= Yii::t('Front', 'Recipient') ?></th>
				<th><?= Yii::t('Front', 'Date/Invoice #') ?></th>
				<th><?= Yii::t('Front', 'Amount') ?></th>
				<th><?= Yii::t('Front', 'Status') ?></th>
				<th>&nbsp;</th>
			</tr>
			<?php foreach($model as $invoice): ?>
			<tr>
				<td>
					<b><?= $invoice->user->fullname ?></b><br>
					<!--<span class="grey">0121 0101 2585 01541</span>-->
				</td>
				<td>
					<?php if($invoice->invoice_date): ?><?= date('d.m.Y', $invoice->invoice_date) ?> <br><?php endif; ?>
					<span class="grey"><?= $invoice->number ?></span>
				</td>

				<td>
					<?= $invoice->total ?> <?= $invoice->currency->code ?>
				</td>
				<td>
					<!--<span class="approved">Approved</span>-->
				</td>
				<td>
					<div class="transaction-buttons-cont">
						<a class="button edit" href="#"></a>
						<div class="btn-group">
							<a class="button list" href="#"></a> <button class="list-caret" data-toggle="dropdown"></button>
							<ul class="dropdown-menu">
								<li><a class="button download" href="#"></a></li>
								<li><a class="button send" href="#"></a></li>
								<li><a class="button print" href="#"></a></li>
								<li><a class="button eye" href="#"></a></li>
								<li><a class="button delete" href="#"></a></li>

							</ul></div>
					</div>
				</td>
			</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>