<div class="header-top clearfix">
	<div class="account-status pull-left"><?= Yii::t('Front', 'Account status:'); ?> 
	<?php if(Yii::app()->user->status == Users::USER_EMAIL_IS_ACTIVE): ?>
		<span><?= Yii::t('Front', 'USER_EMAIL_IS_ACTIVED'); ?></span>
	<?php elseif(Yii::app()->user->status == Users::USER_IS_ACTIVATED): ?>
		<span class="yellow"><?= Yii::t('Front', 'USER_IS_ACTIVATED'); ?></span>
	<?php elseif(Yii::app()->user->status == Users::USER_IS_VERIFICATED): ?>
		<span class="green"><?= Yii::t('Front', 'USER_IS_VERIFICATED'); ?></span>
	<?php endif; ?>
	</div>
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
			 • IP: <?= Yii::app()->user->lastIp ?>
		<?php endif; ?>
	</div>
	<?php endif; ?>
</div>
<div class="header-middle clearfix">
	<a href="<?= Yii::app()->createUrl('/banking/index') ?>" class="logo pull-left"></a>
	<div class="pull-right header-buttons">
		<div style="float:left;margin-right:10px;">
			<select>
				<option>Управляющий 1</option>
				<option>Управляющий 2</option>
			</select>	
		</div>
		
		<a href="<?= Yii::app()->createUrl('/transfers/outgoing') ?>" class="rounded-buttons new-transfer"><?= Yii::t('Front', 'NEW TRANSFER') ?></a>
		<a href="<?= Yii::app()->createUrl('/transfers/incoming') ?>" class="rounded-buttons upload"><?= Yii::t('Front', 'UPLOAD') ?></a>
	</div>	
</div>
<div class="header-bottom clearfix">
	<ul class="top-menu pull-left list-unstyled">
		<li class="current"><a href="<?= Yii::app()->createUrl('/banking/index') ?>"><?= Yii::t('Front', 'Home') ?></a></li>
		<li><a href="<?= Yii::app()->createUrl('pages/index', array('url' => 'About')) ?>"><?= Yii::t('Front', 'About') ?></a></li>
		<li><a href="<?= Yii::app()->createUrl('pages/index', array('url' => 'Services')) ?>"><?= Yii::t('Front', 'Services') ?></a></li>
		<li><a href="<?= Yii::app()->createUrl('pages/index', array('url' => 'Credits')) ?>"><?= Yii::t('Front', 'Credits') ?></a></li>
		<li><a href="<?= Yii::app()->createUrl('pages/index', array('url' => 'History')) ?>"><?= Yii::t('Front', 'History') ?></a></li>
	</ul>
	<div class="search-cont pull-right">
		<!--<input value="<?= Yii::t('Front', 'Search...') ?>" onfocus="if($(this).val()=='<?= Yii::t('Front', 'Search...') ?>')$(this).val('')" onblur="if($(this).val()=='')$(this).val('<?= Yii::t('Front', 'Search...') ?>')" type="text" class="search-text">
		<div class="search-submit"></div>-->
	</div>
</div>


