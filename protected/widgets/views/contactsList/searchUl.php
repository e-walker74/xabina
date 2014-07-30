<?php $letter = ''; ?>
<?php foreach($model as $contact): ?>
	<?php
		$firstLet = mb_strtoupper(substr($contact->fullname, 0, 1));
        if(is_numeric($firstLet)){
            $firstLet = '0-9';
        }elseif(preg_match("/^[a-zA-Z]$/", $firstLet) === 0) {
            // string only contain the a to z , A to Z
            $firstLet = '#';
        }
	?>
	<?php if($letter && $firstLet != $letter): ?>			
			</ul>
		</div>
	<?php endif; ?>
	<?php if($firstLet != $letter): ?>
		<div class="letter-block">
			<div class="letter-header letter_<?= ($firstLet == "#") ? 'else' : $firstLet ?>"><?= $firstLet ?></div>
			<ul class="contact-list list-unstyled">
	<?php endif; ?>
	<?php $letter = $firstLet; ?>
		<li class="one-contact" data-id="<?= $contact->id ?>" data-name="<?= mb_strtolower($contact->fullname, 'utf8') ?>" data-xabina="<?= $contact->xabina_id ?>">
            <div class="photo-cont pull-left">
                <?php if($contact->photo): ?>
                    <img width="30" src="<?= $contact->getAvatarUrl() ?>" alt=""/>
                <?php else: ?>
                    <img width="30" src="/images/contact_no_foto.png" alt=""/>
                <?php endif; ?>
            </div>
            <div class="contact-info pull-left">
                <div class="contact-name"><?= $contact->fullname ?></div>
                <div class="contact-extra-info">
                    <?= $contact->getNameWithCompany() ?>
                </div>
            </div>
            <div class="clearfix"></div>
		</li>
<?php endforeach; ?>
<?php if(!empty($model)): ?>
		</ul>
	</div>
<?php endif; ?>