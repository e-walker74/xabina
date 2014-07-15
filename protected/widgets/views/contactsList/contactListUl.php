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
		<li class="one-contact clickable-row categories type_<?= $contact->type ?> category_<?= implode(' category_', CHtml::listData($contact->categories, 'id', 'id')) ?>" data-id="<?= $contact->id ?>" data-url="<?= Yii::app()->createUrl('/contact/view', array('url' => $contact->url)) ?>">
			<a href="<?= Yii::app()->createUrl('/contact/view', array('url' => $contact->url)) ?>">
				<div class="photo-cont pull-left">
					<?php if($contact->photo): ?>
						<img width="40" src="<?= $contact->getAvatarUrl() ?>" alt=""/>
					<?php else: ?>
						<img src="/images/contact_no_foto.png" alt=""/>
					<?php endif; ?>
                    <a class="ico ok" href="#"></a>
				</div>
				<div class="contact-info pull-left">
					<div class="contact-name"><?= $contact->fullname ?></div>
					<div class="contact-extra-info">
                        <?= $contact->getNameWithCompany() ?>
					</div>
				</div>
                <?php if($contact->xabina_id): ?>
                <div class="transaction-buttons-cont pull-right">
                    <a class="button dialogues " href="#"></a>
                </div>
                <?php endif; ?>
				<div class="clearfix"></div>
			</a>
		</li>
<?php endforeach; ?>
<?php if(!empty($model)): ?>
		</ul>
	</div>
<?php endif; ?>
<div class="letter-block hidden empty-list">
    <ul class="contact-list list-unstyled ">
        <li>
            <div class="note ">
                <p><span class="rejected"><?= Yii::t('Front', 'No search results') ?></span></p>
            </div>
        </li>
    </ul>
</div>

