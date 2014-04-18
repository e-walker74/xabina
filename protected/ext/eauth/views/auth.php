<?php
	foreach ($services as $name => $service) {
		echo CHtml::link(Yii::t('Front', 'Connect'), Yii::app()->getBaseUrl(true).Yii::app()->createUrl('/personal/editsocials', array('service' => $name)), array(
			'class' => 'auth-service soc-net-button '.$service->id,
		));
	}
?>