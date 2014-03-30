<?php foreach(Yii::app()->user->getNotifications() as $notify): ?>
	<div class="xabina-alert <?php if($notify->type == 'close'): ?>green<?php endif; ?>">
		<?php if($notify->type == 'close'): ?>
			<span class="close-button" data-del-alert="<?= Yii::app()->createUrl('/user/deletenotification', array('code' => $notify->code)) ?>"></span>
		<?php endif; ?>
		<?= Yii::t('Front', $notify->message, array(':userName' => Yii::app()->user->name)); ?>
	</div>
<?php endforeach; ?>
<?php if(Yii::app()->user->status == Users::USER_EMAIL_IS_ACTIVE): ?>
	<a href="<?= Yii::app()->createUrl('/banking/accountsactivation/') ?>" class="activate-account-button"><?= Yii::t('Front', 'Activate account'); ?></a>
<?php elseif(Yii::app()->user->status == Users::USER_IS_ACTIVATED): ?>
	<a href="<?= Yii::app()->createUrl('verification/index') ?>" class="activate-account-button"><?= Yii::t('Front', 'Verificate account'); ?></a>
<?php endif;?>