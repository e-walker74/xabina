<ul class="acc-menu" id="sidebar">
	<!--<li id="search">
		<a href="javascript:;"><i class="fa fa-search opacity-control"></i></a>
		 <form>
			<input type="text" class="search-query" placeholder="Search...">
			<button type="submit"><i class="fa fa-search"></i></button>
		</form>
	</li>-->
	<li class="divider"></li>
	<li ><a href="<?= Yii::app()->createUrl('/admin')	?>/"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
	<li class="divider"></li>
	<li ><a href="javascript:;"><i class="fa fa-group"></i> <span><?= Yii::t('Users', 'Users'); ?></span></a>
		<ul class="acc-menu">
			<li ><a href="<?= Yii::app()->createUrl('/admin/users/admin/') ?>/"><?= Yii::t('Users', 'Manage Users'); ?></a></li>
			<li ><a href="<?= Yii::app()->createUrl('/admin/users/create/') ?>/"><?= Yii::t('Users', 'Create User'); ?></a></li>
		</ul>
	</li>
	<li><a href="javascript:;"><i class="fa fa-sitemap"></i> <span><?= Yii::t('Mailer', 'Mailer'); ?></span></a>
		<ul class="acc-menu">
			<li><a href="<?= Yii::app()->createUrl('/admin/mailer/mails/') ?>/"><?= Yii::t('Mailer', 'Templates'); ?></a></li>
		</ul>
	</li>
	<li><a href="<?= Yii::app()->createUrl('/admin/accounts/index/') ?>/"><i class="fa fa-sitemap"></i> <span><?= Yii::t('Accounts', 'Accounts'); ?></span></a></li>
	<li><a href="<?= Yii::app()->createUrl('/admin/accounts/activations/') ?>/"><i class="fa fa-sitemap"></i> <span><?= Yii::t('Accounts', 'Activations'); ?></span><span class="badge badge-danger"><?= $activations ?></span></a></li>
	<li><a href="<?= Yii::app()->createUrl('/admin/accounts/verifications/') ?>/"><i class="fa fa-sitemap"></i> <span><?= Yii::t('Accounts', 'Verifications'); ?></span><span class="badge badge-danger"><?= $verifications ?></span></a></li>
	<li><a href="javascript:;"><i class="fa fa-sitemap"></i> <span><?= Yii::t('Logs', 'Logs'); ?></span></a>
		<ul class="acc-menu">
			<li><a href="<?= Yii::app()->createUrl('/admin/logs/mail/') ?>/"><?= Yii::t('Logs', 'Mail'); ?></a></li>
			<li><a href="<?= Yii::app()->createUrl('/admin/logs/users/') ?>/"><?= Yii::t('Logs', 'Users'); ?></a></li>
		</ul>
	</li>
	<li><a href="<?= Yii::app()->createUrl('/admin/messages/index/') ?>/"><i class="fa fa-sitemap"></i> <span><?= Yii::t('Messages', 'Messages'); ?></span></a></li>
	<li><a href="javascript:;"><i class="fa fa-sitemap"></i> <span><?= Yii::t('Transfers', 'Transfers'); ?></span></a>
		<ul class="acc-menu">
			<li><a href="<?= Yii::app()->createUrl('/admin/transfers/create/') ?>/"><?= Yii::t('Transfers', 'Create'); ?></a></li>
			<li><a href="<?= Yii::app()->createUrl('/admin/transfers/outgoing/') ?>/"><?= Yii::t('Transfers', 'Outgoing'); ?></a></li>
		</ul>
	</li>
</ul>