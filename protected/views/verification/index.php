<div class="col-lg-9 col-md-9 col-sm-9" >
	<div class="h1-header"><?= Yii::t('Front', 'Verification'); ?></div>
	
	<?php $this->widget('XabinaAlert'); ?>

	<div class="xabina-progress-bar verification-page">
		<div class="step step1 current" >
			<div class="step-name"><?= Yii::t('Front', 'Verification Method') ?></div>
			<div class="step-arr"></div>
		</div>
		<div class="step step2">
			<div class="step-name"><?= Yii::t('Front', 'Verification Steps') ?></div>
			<div class="step-arr"></div>
		</div>
		<div class="step step3 ">
			<div class="step-name"><?= Yii::t('Front', 'Verification') ?></div>
			<div class="step-arr"></div>
		</div>
	</div>

	<ul class="list-unstyled list-with-icos">
		<li><?= Yii::t('Front', 'We are required to verify your identity before you can send or receive over EUR 2500/00 or equivalent.') ?></li>
		<li><?= Yii::t('Front', 'Verifying your identity increases transactin limits and gives you access to the full wallet functionality.') ?></li>
		<li><?= Yii::t('Front', 'Verification is quick, easy and free.') ?></li>
	</ul>
	<div class="subheader"><?= Yii::t('Front', 'Choose verification method') ?></div>
	<div class="subheader-comment"><?= Yii::t('Front', 'Choose one of the methods of verification and follow the instructions.') ?></div>
	<table class=" xabina-table-choose">

		<tr class="tr-header">
			<td><?= Yii::t('Front', 'Credit/debit card') ?></td>
		</tr>

		<tr class="list-tr">
			<td>
				<ul class="list-inline payments-list">
					<li>
						<label>
							<input type="radio"/>
							<img src="/images/payment_card2.png" alt=""/>
						</label>
						
					</li>
					<li>
						<label>
							<input type="radio"/>
							<img src="/images/payment_card6.png" alt=""/>
						</label>

					</li>
					<li>
						<label>
							<input type="radio"/>
							<img src="/images/payment_card3.png" alt=""/>
						</label>

					</li>
					<li>
						<label>
							<input type="radio"/>
							<img src="/images/payment_card4.png" alt=""/>
						</label>

					</li>
					<li>
						<label>
							<input type="radio"/>
							<img src="/images/payment_card5.png" alt=""/>
						</label>

					</li>
					<li>
						<label>
							<input type="radio"/>
							<img src="/images/payment_card1.png" alt=""/>
						</label>

					</li>
				</ul>
			</td>
		</tr>
		<tr class="tr-choose-payment">
			<td>
				<a class="violet-button" href="<?= Yii::app()->createUrl('/verification/verificatinmethod', array('modelId' => 'creditcard')) ?>"><?= Yii::t('Front', 'Verify credit/debit card') ?></a>
			</td>
		</tr>
	</table>
	<table class=" xabina-table-choose">

		<tr class="tr-header">
			<td><?= Yii::t('Front', 'Bank account') ?></td>
		</tr>

		<tr class="list-tr">
			<td>
				<ul class="list-inline payments-list">
					<li>
						<label>
							<input type="radio"/>
							<img src="/images/bank_ico5.png" alt=""/>
						</label>

					</li>
				</ul>
			</td>
		</tr>
		<tr class="tr-choose-payment">
			<td>
				<a class="violet-button" href="<?= Yii::app()->createUrl('/verification/verificatinmethod', array('modelId' => 'bankaccount')) ?>"><?= Yii::t('Front', 'Verify bank account') ?></a>
			</td>
		</tr>
	</table>
	<table class=" xabina-table-choose">

		<tr class="tr-header">
			<td><?= Yii::t('Front', 'Your e-wallet') ?></td>
		</tr>

		<tr class="list-tr">
			<td>
				<ul class="list-inline payments-list">
					<li>
						<label>
							<input type="radio"/>
							<img src="/images/payment_system7.png" alt=""/>
						</label>

					</li>
				</ul>
			</td>
		</tr>
		<tr class="tr-choose-payment">
			<td>
				<a class="violet-button" href="<?= Yii::app()->createUrl('/verification/verificatinmethod', array('modelId' => 'paypal')) ?>"><?= Yii::t('Front', 'Verify your e-wallet') ?></a>
			</td>
		</tr>
	</table>
	<table class=" xabina-table-choose">

		<tr class="tr-header">
			<td><?= Yii::t('Front', 'Notary') ?></td>
		</tr>

		<tr class="list-tr">
			<td>
				<ul class="list-inline payments-list">
					<li>
						<label>
							<input type="radio"/>
							<img src="/images/notary_ico2.png" alt=""/>
						</label>

					</li>
				</ul>
			</td>
		</tr>
		<tr class="tr-choose-payment">
			<td>
				<a href="<?= Yii::app()->createUrl('/verification/notary') ?>" class="violet-button"><?= Yii::t('Front', 'Verify through a notary') ?></a>
			</td>
		</tr>
	</table>
</div>

