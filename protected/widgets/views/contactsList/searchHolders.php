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
<div class="account-search-results-cont">
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
				<img src="/images/contact_no_foto.png" alt=""/>
			</div>
			<div class="account-data pull-left">
				<div class="account-name"><?= $contact->fullname ?></div>
				<div class="account-info">NUMBER</div>
			</div>
			<div class="account-details-button pull-right">

			</div>
			<div class="clearfix"></div>
			</div>
			<ul class="account-resourses list-unstyled">
				<li>
					<div class="account-resourse-cont">
						X1231 1231 1231
					</div>
				</li>
				<li class="accout-pay-accordion">
					<div class="account-resourse-cont">
						X1231 1231 1231
					</div>
					<ul class="pay-list list-unstyled">
						<li><span class="date">(03.03.2014) </span> <span class="name">Cum sociis natoque penatibus et magnis</span>  <span class="sum">8 000 EUR</span></li>
						<li><span class="date">(03.03.2014) </span> <span class="name">Cum sociis natoque penatibus et magnis</span>  <span class="sum">12 000 EUR</span></li>
						<li><span class="date">(03.03.2014) </span> <span class="name">Cum sociis natoque penatibus et magnis</span>  <span class="sum">300 EUR</span></li>
					</ul>
				</li>
				<li class="open">
					<div class="account-resourse-cont">
						X1231 1231 1231
					</div>
					<ul class="pay-list list-unstyled">
						<li><span class="date">(03.03.2014) </span> <span class="name">Cum sociis natoque penatibus et magnis</span>  <span class="sum">8 000 EUR</span></li>
						<li><span class="date">(03.03.2014) </span> <span class="name">Cum sociis natoque penatibus et magnis</span>  <span class="sum">12 000 EUR</span></li>
						<li><span class="date">(03.03.2014) </span> <span class="name">Cum sociis natoque penatibus et magnis</span>  <span class="sum">300 EUR</span></li>
					</ul>
				</li>
			</ul>
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