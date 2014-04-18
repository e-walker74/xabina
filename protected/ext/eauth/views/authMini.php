<div class="services-mini">
  <ul class="auth-services clear">
  <?php
	foreach ($services as $name => $service) {
		echo '<li class="auth-service-mini '.$service->id.'">';
		$html = '<span class="auth-icon-mini '.$service->id.'"><i></i></span>';
		//$html .= '<span class="auth-title">'.Yii::t('eauth', $service->title).'</span>';
		$html = CHtml::link($html, $this->action . '?service='.$name, array(
			'class' => 'auth-link-mini '.$service->id,
		));
		echo $html;
		echo '</li>';
	}
  ?>
  </ul>
</div>