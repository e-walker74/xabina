<?php if(!Yii::app()->request->isAjaxRequest): ?>
<div class="account-search-results-cont with-out-searchline"  style="display:none">
	<div id="contactsList-searchTransfers">
<?php endif; ?>
	
	<ul class="search-results-list list-unstyled">
		<?php foreach($model as $m): ?>
		<?php $amountArr = explode('.', $m->amount); ?>
		<li class="account-item" 
			data-amount="<?= $amountArr[0] ?>" 
			data-cent="<?= (isset($amountArr[1])) ? $amountArr[1] : '' ?>" 
			data-number="<?= $m->to_account_number ?>" 
			data-currency="<?= $m->currency->id ?>" 
			data-holder="<?= $m->to_account_holder ?>" 
			data-description="<?= $m->description ?>">
			<div class="bg-color">
				<div class="account-photo pull-left">
					<img src="/images/account-photo-r.png" alt="">
				</div>
				<div class="account-data pull-left">
					<div class="account-name"><?= $m->to_account_holder ?></div>
					<div class="account-info"><?= $m->to_account_number ?></div>

				</div>
				<div class="account-extra pull-right">
					<?= $m->description ?>&nbsp;
				</div>
				<div class="account-sum-date pull-right">
					<?= $m->amount ?> <?= $m->currency->code ?> <br>
					<?= date('d.m.Y', $m->created_at) ?>
				</div>


				<div class="clearfix"></div>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>

<?php if(!Yii::app()->request->isAjaxRequest): ?>
	</div>
</div>
<?php endif; ?>