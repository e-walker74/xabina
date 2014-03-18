<div class="header-top clearfix">
	<div class="account-status pull-left"><?= Yii::t('Front', 'Account status:'); ?> <span>
	<?php if(Yii::app()->user->status == Users::USER_EMAIL_IS_ACTIVE): ?>
		<?= Yii::t('Front', 'USER_EMAIL_IS_ACTIVED'); ?>
	<?php elseif(Yii::app()->user->status == Users::USER_IS_ACTIVATED): ?>
		<?= Yii::t('Front', 'USER_IS_ACTIVATED'); ?>
	<?php elseif(Yii::app()->user->status == Users::USER_IS_VERIFICATED): ?>
		<?= Yii::t('Front', 'USER_IS_VERIFICATED'); ?>
	<?php endif; ?>
	</span></div>
	<?php if(Yii::app()->user->lastIp || Yii::app()->user->lastTime): ?>
	<div class="last-visit pull-right">
		<?= Yii::t('Front', 'Last enter:'); ?>
		<?php if(Yii::app()->user->lastTime): ?>
			<?= Yii::t('Front', '{day} '.date('F', Yii::app()->user->lastTime).' {year} {time} GMT {p}',
			array(
				'{day}' => date('d', Yii::app()->user->lastTime),
				'{year}' => date('Y', Yii::app()->user->lastTime),
				'{time}' => date('H:i', Yii::app()->user->lastTime),
				'{p}' => date('P', Yii::app()->user->lastTime),
			)); ?>
		<?php endif; ?>
		<?php if(Yii::app()->user->lastIp): ?>
			 • IP:<?= Yii::app()->user->lastIp ?>
		<?php endif; ?>
	</div>
	<?php endif; ?>
</div>
<div class="header-middle clearfix">
	<a href="/" class="logo pull-left"></a>
	<ul class="header-links pull-right list-inline">
		<?php $this->widget('TopAndBottomRepeatMenu'); ?>
	</ul>		
</div>
<div class="header-bottom clearfix">
	<ul class="top-menu pull-left list-unstyled">
		<li class="current"><a href="#"><?= Yii::t('Front', 'Home') ?></a></li>
		<li><a href="#"><?= Yii::t('Front', 'About') ?></a></li>
		<li><a href="#"><?= Yii::t('Front', 'Services') ?></a></li>
		<li><a href="#"><?= Yii::t('Front', 'Credits') ?></a></li>
		<li><a href="#"><?= Yii::t('Front', 'History') ?></a></li>
	</ul>
	<div class="search-cont pull-right">
		<input value="Введите слово..." onfocus="if($(this).val()=='Введите слово...')$(this).val('')" onblur="if($(this).val()=='')$(this).val('Введите слово...')" type="text" class="search-text">
		<div class="search-submit"></div>
	</div>
</div>
