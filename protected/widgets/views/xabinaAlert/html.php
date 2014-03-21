<?php foreach(Yii::app()->user->getNotifications() as $notify): ?>
	<div class="xabina-alert">
		<?php if($notify->type == 'close'): ?>
			<span class="close-button" data-del-alert="<?= Yii::app()->createUrl('/user/deletenotification', array('code' => $notify->code)) ?>"></span>
		<?php endif; ?>
		<?= Yii::t('Front', $notify->message, array(':userName' => Yii::app()->user->name)); ?>
	</div>
<?php endforeach; ?>