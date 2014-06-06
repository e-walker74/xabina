<?php foreach($model as $trans): ?>
	<li class="transfer-data" 
			<?php $amountArr = explode('.', $trans->amount); ?>
			data-amount="<?= $amountArr[0] ?>" 
			data-cent="<?= (isset($amountArr[1])) ? $amountArr[1] : '' ?>" 
			data-number="<?= $trans->to_account_number ?>" 
			data-currency="<?= $trans->currency->id ?>" 
			data-holder="<?= $trans->to_account_holder ?>" 
			data-description="<?= $trans->description ?>">
		<span class="date">(<?= date('d.m.Y', $trans->execution_date) ?>) </span> <span class="name"><?= $trans->description ?></span>  <span class="sum"><?= $trans->amount ?> <?= $trans->currency->code ?></span>
	</li>
<?php endforeach; ?>