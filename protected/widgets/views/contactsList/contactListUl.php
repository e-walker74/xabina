<?php $letter = ''; ?>
<?php foreach($model as $contact): ?>
	<?php
		$firstLet = mb_strtoupper(substr($contact->fullname, 0, 1));
	?>
	<?php if($letter && $firstLet != $letter): ?>			
			</ul>
		</div>
	<?php endif; ?>
	
	<?php if($firstLet != $letter): ?>
		<div class="letter-block">
			<div class="letter-header letter_<?= $firstLet ?>"><?= $firstLet ?></div>
			<ul class="contact-list list-unstyled">
	<?php endif; ?>
	<?php $letter = $firstLet; ?>
		<li data-id="<?= $contact->id ?>">
			<a href="<?= Yii::app()->createUrl('/contact/view', array('id' => $contact->id)) ?>">
				<div class="photo-cont pull-left">
					<?php if($contact->photo): ?>
						<img width="40" src="<?= $contact->getAvatarUrl() ?>" alt=""/>
					<?php else: ?>
						<img src="/images/contact_no_foto.png" alt=""/>
					<?php endif; ?>
				</div>
				<div class="contact-info pull-left">
					<div class="contact-name"><?= $contact->fullname ?></div>
					<div class="contact-extra-info">
						<?php $accArr = array(); ?>
						<?php foreach($contact->getDataByType('account') as $account): ?>
							<?php $accArr[] = $account->account_number ?>
						<?php endforeach; ?>
						<?= implode(' - ', $accArr); ?>
					</div>
				</div>
				<div class="clearfix"></div>
			</a>
		</li>
<?php endforeach; ?>
<?php if(!empty($model)): ?>
		</ul>
	</div>
<?php endif; ?>