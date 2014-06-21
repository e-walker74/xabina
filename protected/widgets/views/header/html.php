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

<?php /*
<div class="header-middle clearfix">
	<a href="<?= Yii::app()->createUrl('/banking/index') ?>" class="logo pull-left"></a>
	<div class="pull-right header-buttons">
        <?php 
            $rbacAccounts = Yii::app()->user->getRbacAllowedAccounts(); 
        ?>
        <?php if(count($rbacAccounts)):?>
            <div style="float:left;margin-right:10px;">
                <form id="rbac-accounts-switcher-form" 
                      action="<?= Yii::app()->createUrl('/rbac/switchAccount') ?>" 
                      method="POST">
                    <select id="rbac-accounts-switcher" name="account">
                        <option value="<?= Yii::app()->user->getId(); ?>"><?php echo Yii::app()->user->getFullName(); ?></option>
                        <?php foreach ($rbacAccounts as $ra): ?>
                        <option value="<?php echo $ra['id']?>"
                            <?php if($ra['id'] == Yii::app()->user->getRbacCurrentUid()):?> selected="selected"<?php endif?>>
                            <?php echo $ra['account_name'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>	
                </form>
            </div>
        <?php endif;?>
		<a href="<?= Yii::app()->createUrl('/transfers/outgoing') ?>" class="rounded-buttons new-transfer"><?= Yii::t('Front', 'NEW TRANSFER') ?></a>
		<a href="<?= Yii::app()->createUrl('/transfers/incoming') ?>" class="rounded-buttons upload"><?= Yii::t('Front', 'UPLOAD') ?></a>
	</div>	
</div>
<?php /*
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
</div>*/?>
<div class="header-middle clearfix">
    <a href="<?= Yii::app()->createUrl('/banking/index') ?>" class="logo pull-left"></a>
    <div class="person-select-cont">
        <?php 
            $rbacMenu = Yii::app()->user->getRbacAccountSwitcherMenu();        
        ?>
        <form id="rbac-accounts-switcher-form" 
                      action="<?= Yii::app()->createUrl('/rbac/switchAccount') ?>" 
                      method="POST">
            <input type="hidden" name="account" value="<?=$rbacMenu['active']['id']?>"/>
            <div class="person-select clearfix" onclick="$(this).next().toggleClass('show')">
                <div class="select-lbl"><?php echo $rbacMenu['active']['account_name']; ?></div>
                <div class="select-arr">
                    <!--<span class="alert">!</span>-->
                </div>
            </div>
            <?php if(count($rbacMenu['other'])):?>
            <ul class="person-list list-unstyled">
                <?php foreach ($rbacMenu['other'] as $r): ?>
                    <li class="person-ico-2"><a href="#" data-uid="<?=$r['id'];?>"><?=$r['account_name'];?></a></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </form>

    </div>
</div>
<div class="header-down clearfix">
    <ul class="top-navigation list-unstyled">
        <li class="apps">
            <a href="#">
                <div class="menu-ico"></div>
                <div class="menu-name">Apps</div>
            </a>
            <div class="apps-dropdown-cont">
                <div class="apps-arr"></div>
                <div class="apps-dropdown">
                    <ul class="apps-list list-unstyled">
                        <li class="drive">
                            <a href="#">
                                <div class="app-ico"></div>
                                <div class="app-name">Drive</div>
                            </a>
                        </li>
                        <li class="analytic">
                            <a href="#">
                                <div class="app-ico"></div>
                                <div class="app-name">Analytic</div>
                            </a>
                        </li>
                        <li class="address-book">
                            <a href="<?= Yii::app()->createUrl('/contact/index'); ?>">
                                <div class="app-ico"></div>
                                <div class="app-name">Address book</div>
                            </a>
                        </li>
                        <li class="loans">
                            <a href="#">
                                <div class="app-ico"></div>
                                <div class="app-name">Loans</div>
                            </a>
                        </li>
                        <li class="cards">
                            <a href="#">
                                <div class="app-ico"></div>
                                <div class="app-name">Cards</div>
                            </a>
                        </li>
                        <li class="profile">
                            <a href="<?= Yii::app()->createUrl('/personal/index') ?>">
                                <div class="app-ico"></div>
                                <div class="app-name"><?= Yii::t('Front', 'Profile') ?></div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
        <li class="invoicing">
            <a href="<?= Yii::app()->createUrl('/invoices/list') ?>">
                <div class="menu-ico"></div>
                <div class="menu-name"><?= Yii::t('Front', 'Invoicing') ?></div>
            </a>
        </li>
        <li class="alerts">
            <a href="<?= Yii::app()->createUrl('/personal/alerts') ?>">
                <div class="menu-ico"></div>
                <div class="menu-name"><?= Yii::t('Front', 'Alerts') ?></div>
            </a>
        </li>
        <li class="dialogues">
            <a href="#">
                <div class="menu-ico"></div>
                <div class="menu-name">Dialogues</div>
            </a>
        </li>
    </ul>
</div>


