<?php foreach(Yii::app()->user->getNotifications() as $notify): ?>
	<div class="xabina-alert">
		<?= Yii::t('Front', $notify->message, array(':userName' => Yii::app()->user->name)); ?>
	</div>
<?php endforeach; ?>