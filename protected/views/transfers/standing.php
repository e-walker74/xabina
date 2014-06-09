<div class="col-lg-9 col-md-9 col-sm-9" >
	<div class="h1-header"><?= Yii::t('Front', 'Standing Payments') ?></div>
	<table class="xabina-table table table-standing">
		<tr class="table-header">
			<th width="30%"><?= Yii::t('Front', 'From') ?></th>
			<th width="30%"><?= Yii::t('Front', 'To') ?></th>
			<th width="24%"><?= Yii::t('Front', 'Amount') ?></th>
			<th width="16%"></th>
		</tr>
		<tr>
			<td colspan="4">
				<ul class="standing-list list-unstyled">
					<?php foreach($model as $m): ?>
					<li>
						<div class="standing-from">
							<div class="name"><?= $m->user->fullname ?></div>
							<div class="account"><?= chunk_split($m->account->number, 4) ?></div>
						</div>
						<div class="standing-to">
							<div class="name"><?= $m->getToAccountHolder() ?></div>
							<div class="account"><?= chunk_split($m->to_account_number, 4) ?></div>
						</div>
						<div class="standing-amount">
							<?= number_format($m->amount, 2, ".", " ") ?> <?= $m->currency->code ?>
						</div>
						<div class="transaction-buttons-cont">
							<a href="<?= Yii::app()->createUrl('/transfers/outgoing', array('standing' => $m->id)) ?>" class="button edit"></a>
							<a data-url="<?= Yii::app()->createUrl('/transfers/deletestanding', array('id' => $m->id)) ?>" class="button delete" title="<?=Yii::t('Front', 'Are you sure?')?>"></a>
						</div>
						<div class="more-info">
							<div class="more-line">
								<div class="each">
									<span><?= Yii::t('Front', 'Each') ?>:</span> 
									<?= $m->each_period ?> <?= Yii::t('Front', $m->period) ?>
								</div>
								<div class="from"><span><?= Yii::t('Front', 'From') ?>:</span> <?= date('d.m.Y', $m->start_date) ?></div>
								<div class="to"> <span><?= Yii::t('Front', 'To') ?>:</span> <?= date('d.m.Y', $m->end_date) ?>  </div>
								<?php if($m->remaining_balance): ?>
									<div class="remaining"><span><?= Yii::t('Front', 'Remaining balance') ?>:</span> 
									<?= number_format($m->remaining_balance, 2, ".", " ") ?> <?= $m->currency->code ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</li>
					<?php endforeach; ?>
				</ul>
			</td>
		</tr>
	</table>
</div>
<script type="text/javascript" src="/js/deleteButton.js"></script>
<script type="text/javascript">
    deleteButtonEnable('li');
</script>