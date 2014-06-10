<?php if(!Yii::app()->request->isAjaxRequest): ?>
<div class="account-search-results-cont-with-searhline" style="display:none">
<div class="ext-account-search">
	<div class="account-number">
		<div class="input">
			<input class="account-search-input pull-left" type="text">
			<a href="#" class="account-search pull-right"></a>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<div class="account-search-results-cont scroll-block">
<?php $this->render('contactsList/alphabet', array()); ?>
<div id="contactsList" >
<?php endif; ?>

	<?php $letter = ''; ?>
	<?php foreach($model as $contact): ?>
	<?php if(!$contact->fullname) continue; ?>
	<?php
		$firstLet = mb_strtoupper(substr(trim($contact->fullname), 0, 1));
	?>

	<?php if($letter && $firstLet != $letter): ?>		
			</ul>
		</div>
	<?php endif; ?>
	
	<?php if($firstLet != $letter): ?>
		<div class="letter-block">
			<div class="letter-header letter_<?= $firstLet ?>"><?= $firstLet ?></div>
			<ul class="search-results-list list-unstyled">
	<?php endif; ?>
	<?php $letter = $firstLet; ?>
		<li class="opened">
			<div class="bg-color">
			<div class="account-photo pull-left">
				<?php if($contact->photo): ?>
					<img width="40" src="<?= $contact->getAvatarUrl() ?>" alt=""/>
				<?php else: ?>
					<img src="/images/contact_no_foto.png" alt=""/>
				<?php endif; ?>
			</div>
			<div class="account-data pull-left">
				<div class="account-name"><?= $contact->fullname ?></div>
				<div class="account-info"></div>
			</div>
			<div class="account-details-button pull-right">
			</div>
			<div class="clearfix"></div>
			</div>
			<?php if($contact->data): ?>
			<ul class="account-resourses list-unstyled">
				<?php foreach($contact->getDataByType('account') as $data): ?>
					<li class="accout-pay-accordion" data-number="<?= $data->account_number ?>" data-account-type="<?= $data->account_type ?>" >
						<div class="account-resourse-cont">
							<a href="" class="account-resourse-link">&nbsp;</a>
							<?= $data->account_number; ?>
						</div>
						<ul class="pay-list list-unstyled">
						</ul>
					</li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
	<?php if(!empty($model)): ?>
		</ul>
	</div>
	<?php endif; ?>
	
<?php if(!Yii::app()->request->isAjaxRequest): ?>
		</div>
	</div>
</div>
<?php endif; ?>