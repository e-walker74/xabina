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
		<li class="one-contact categories type_<?= $contact->type ?> category_<?= implode(' category_', CHtml::listData($contact->categories, 'id', 'id')) ?>" data-id="<?= $contact->id ?>" data-url="<?= Yii::app()->createUrl('/contact/view', array('url' => $contact->url)) ?>">
            <div class="bg-color">
                <div class="cont_check_block">
                    <label class="modal-galka-checkbox">
                        <input name="contacts[]" value="<?= $contact->id ?>" type="checkbox"/>
                    </label>
                </div>
                <div class="account-photo pull-left" onclick="clickCheckboxContacts(this)">
                    <?php if($contact->photo): ?>
                        <img width="30" src="<?= $contact->getAvatarUrl() ?>" alt=""/>
                    <?php else: ?>
                        <img src="/images/contact_no_foto.png" alt=""/>
                    <?php endif; ?>
                    <?php if ($contact->xabina_id): ?>
                        <?php $activityState = Yii::app()->user->getActivityStatus($contact->xabina_id); ?>
                        <?php if ($activityState == Users::USER_ACTIVITY_STATUS_ONLINE){
                            $cssClass = 'ok';
                        } elseif ($activityState == Users::USER_ACTIVITY_STATUS_BUSY) {
                            $cssClass = 'time';
                        } else {
                            $cssClass = 'err';
                        }
                        ?>
                        <a class="ico <?=$cssClass?>" href="#"></a>
                    <?php endif ?>
                </div>
                <div class="account-data pull-left" style="width: 70%;height: 40px;" onclick="clickCheckboxContacts(this)">
                    <div class="account-name"><?= $contact->fullname ?></div>
                    <div class="account-info"><?= $contact->getNameWithCompany() ?></div>
                </div>
                <div class="transaction-buttons-cont book">
                    <a href="#" class="book_button"></a>
                </div>
                <div class="clearfix" ></div>
            </div>
            <ul class="pay-list list-unstyled" style="display: none;">
                <li><div><span class="title">E-mail:</span> anet@xabina.com</div></li>
                <li><div><span class="title">E-mail:</span> anet@xabina.com</div></li>
                <li><div><span class="title">E-mail:</span> anet@xabina.com</div></li>
            </ul>
		</li>
<?php endforeach; ?>
<?php if(!empty($model)): ?>
		</ul>
	</div>
<?php endif; ?>
<div class="letter-block <?php if(count($model)): ?>hidden<?php endif; ?> empty-list">
    <ul class="contact-list list-unstyled ">
        <li>
            <div class="note ">
                <p><span class=""><?= Yii::t('Front', 'No search results') ?></span></p>
            </div>
        </li>
    </ul>
</div>

