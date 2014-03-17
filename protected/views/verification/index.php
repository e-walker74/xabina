<div class="col-lg-9 col-md-9 col-sm-9" >
	<div class="h1-header"><?= Yii::t('Front', 'Verification'); ?></div>
	
	<?php $this->widget('XabinaAlert'); ?>

	<div class="xabina-progress-bar verification-page">
		<div class="step step1 current" >
			<div class="step-name">Verification Method</div>
			<div class="step-arr"></div>
		</div>
		<div class="step step2">
			<div class="step-name">Verification Steps</div>
			<div class="step-arr"></div>
		</div>
		<div class="step step3 ">
			<div class="step-name">Verification</div>
			<div class="step-arr"></div>
		</div>
	</div>

	<ul class="list-unstyled list-with-icos">
		<li>We are required to verify your identity before you can send or receive over EUR 2500/00 or equivalent.</li>
		<li>Verifying your identity increases transactin limits and gives you access to the full wallet functionality.</li>
		<li>Verification is quick, easy and free.</li>
	</ul>
	<div class="subheader">Choose verification method</div>
	<div class="subheader-comment">Выберите один из способов верификации и следуйте инструкции.</div>
	<table class=" xabina-table-choose">

		<tr class="tr-header">
			<td>Credit/debit card</td>
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
				<div class="violet-button">Verify credit/debit card</div>
			</td>
		</tr>
	</table>
	<table class=" xabina-table-choose">

		<tr class="tr-header">
			<td>Bank account</td>
		</tr>

		<tr class="list-tr">
			<td>
				<ul class="list-inline payments-list">
					<li>
						<label>
							<input type="radio"/>
							<img src="/images/bank_ico.png" alt=""/>
						</label>

					</li>
					<li>
						<label>
							<input type="radio"/>
							<img src="/images/bank_ico2.png" alt=""/>
						</label>

					</li>
					<li>
						<label>
							<input type="radio"/>
							<img src="/images/bank_ico3.png" alt=""/>
						</label>

					</li>
					<li>
						<label>
							<input type="radio"/>
							<img src="/images/bank_ico4.png" alt=""/>
						</label>

					</li>
					<li>
						<label>
							<input type="radio"/>
							<img src="/images/bank_ico5.png" alt=""/>
						</label>

					</li>
					<li>
						<label>
							<input type="radio"/>
							<img src="/images/bank_ico6.png" alt=""/>
						</label>

					</li>
				</ul>
			</td>
		</tr>
		<tr class="tr-choose-payment">
			<td>
				<div class="violet-button">Verify bank account</div>
			</td>
		</tr>
	</table>
	<table class=" xabina-table-choose">

		<tr class="tr-header">
			<td>Your e-wallet</td>
		</tr>

		<tr class="list-tr">
			<td>
				<ul class="list-inline payments-list">
					<li>
						<label>
							<input type="radio"/>
							<img src="/images/payment_system1.png" alt=""/>
						</label>

					</li>
					<li>
						<label>
							<input type="radio"/>
							<img src="/images/payment_system2.png" alt=""/>
						</label>

					</li>
					<li>
						<label>
							<input type="radio"/>
							<img src="/images/payment_system3.png" alt=""/>
						</label>

					</li>
					<li>
						<label>
							<input type="radio"/>
							<img src="/images/payment_system4.png" alt=""/>
						</label>

					</li>
					<li>
						<label>
							<input type="radio"/>
							<img src="/images/payment_system5.png" alt=""/>
						</label>

					</li>
					<li>
						<label>
							<input type="radio"/>
							<img src="/images/payment_system6.png" alt=""/>
						</label>

					</li>
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
				<div class="violet-button">Verify your e-wallet</div>
			</td>
		</tr>
	</table>
	<table class=" xabina-table-choose">

		<tr class="tr-header">
			<td>Notary</td>
		</tr>

		<tr class="list-tr">
			<td>
				<ul class="list-inline payments-list">
					<li>
						<label>
							<input type="radio"/>
							<img src="/images/notary_ico.png" alt=""/>
						</label>

					</li>
					<li>
						<label>
							<input type="radio"/>
							<img src="/images/notary_ico2.png" alt=""/>
						</label>

					</li>
					<li>
						<label>
							<input type="radio"/>
							<img src="/images/notary_ico3.png" alt=""/>
						</label>

					</li>
					<li>
						<label>
							<input type="radio"/>
							<img src="/images/notary_ico4.png" alt=""/>
						</label>

					</li>
				</ul>
			</td>
		</tr>
		<tr class="tr-choose-payment">
			<td>
				<div class="violet-button">Verify through a notary</div>
			</td>
		</tr>
	</table>
</div>

