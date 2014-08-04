<div class="header-top clearfix">
    <div class="account-status pull-left">
        <?php if(Yii::app()->user->checkRbacAccess('show_account_status')): ?>
            <?= Yii::t('Front', 'Account status:'); ?>
            <?php if(Yii::app()->user->status == Users::USER_EMAIL_IS_ACTIVE): ?>
                <span><?= Yii::t('Front', 'USER_EMAIL_IS_ACTIVED'); ?></span>
            <?php elseif(Yii::app()->user->status == Users::USER_IS_ACTIVATED): ?>
                <span class="yellow"><?= Yii::t('Front', 'USER_IS_ACTIVATED'); ?></span>
            <?php elseif(Yii::app()->user->status == Users::USER_IS_VERIFICATED): ?>
                <span class="green"><?= Yii::t('Front', 'USER_IS_VERIFICATED'); ?></span>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <?php if((Yii::app()->user->lastIp || Yii::app()->user->lastTime) && Yii::app()->user->checkRbacAccess('show_last_visit')): ?>
        <div class="last-visit pull-right">
            <?= Yii::t('Front', 'Last enter:'); ?>
            <?php if(Yii::app()->user->lastTime): ?>
				<?= Yii::t('Front', '{day} '.date('F', Yii::app()->user->lastTime).' {year} {time} GMT {p}',
				array(
					'{day}' => date('d', Yii::app()->user->lastTime),
					'{year}' => date('Y', Yii::app()->user->lastTime),
					'{time}' => date('H:i', Yii::app()->user->lastTime),
					'{p}' => Zone::getOffset(Yii::user()->getTimeZone()),
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
    <?php if(Yii::app()->user->checkRbacAccess('show_invironment_selector')): ?>
    <div class="person-select-cont">
        <?php
        $rbacMenu = Yii::app()->user->getRbacAccountSwitcherMenu();
        ?>

        <div class="person-select-cont">
            <div class="person-select clearfix" onclick="$(this).next().toggleClass('show')">
                <div class="select-lbl">
                    Main Environment <br>
                    <em><?php echo $rbacMenu['active']['account_name']; ?></em>
                </div>
                <div class="select-arr">
                    <span class="alert">!</span>
                </div>

            </div>
            <ul class="person-list list-unstyled">
                <li class="person-ico-2">
                    <a href="#">Konstantin Petrov <br>
                        <em>Konstantin Petrov</em>
                        <span class="quty-alert">3</span>
                    </a>
                </li>
                <li class="person-ico-2">
                    <a href="#">Ivan Ivanov<br>
                        <em>Konstantin Petrov</em>
                        <span class="quty-alert">3</span>
                    </a>
                </li>
                <li class="person-ico-1">
                    <a href="#">Ivan Ivanov B.V.<br>
                        <em>Konstantin Petrov</em>
                        <span class="quty-alert">3</span>
                    </a>
                </li>
                <li class="add-env">
                    <a href="#">ADD NEW environment</a>
                </li>
            </ul>

        </div>
    </div>
    <?php endif; ?>
</div>
<div class="header-down clearfix">
    <ul class="top-navigation list-unstyled">
        <? if(Yii::app()->user->checkRbacAccess('apps_menu')): ?>
            <li class="apps">
                <a href="#">
                    <div class="menu-ico"></div>
                    <div class="menu-name"><?= Yii::t('Front', 'Apps'); ?></div>
                </a>
                <? if(Yii::app()->user->checkRbacAccess('apps_menu_drive') ||
                    Yii::app()->user->checkRbacAccess('apps_menu_analytic') ||
                    Yii::app()->user->checkRbacAccess('apps_menu_invoicing') ||
                    Yii::app()->user->checkRbacAccess('apps_menu_loans') ||
                    Yii::app()->user->checkRbacAccess('apps_menu_cards') ||
                    Yii::app()->user->checkRbacAccess('apps_menu_users') ||
                    Yii::app()->user->checkRbacAccess('apps_menu_roles') ||
                    Yii::app()->user->checkRbacAccess('apps_menu_settings')
                ): ?>
                    <div class="apps-dropdown-cont">
                        <div class="apps-arr"></div>
                        <div class="apps-dropdown">
                            <ul class="apps-list list-unstyled">
                                <? if(Yii::app()->user->checkRbacAccess('apps_menu_drive')): ?>
                                    <li class="drive">
                                        <a href="#">
                                            <div class="app-ico"></div>
                                            <div class="app-name"><?= Yii::t('Front', 'Drive'); ?></div>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <? if(Yii::app()->user->checkRbacAccess('apps_menu_analytic')): ?>
                                    <li class="analytic">
                                        <a href="#">
                                            <div class="app-ico"></div>
                                            <div class="app-name"><?= Yii::t('Front', 'Analytic'); ?></div>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <? if(Yii::app()->user->checkRbacAccess('apps_menu_invoicing')): ?>
                                    <li class="invoicing">
                                        <a href="<?= Yii::app()->createUrl('/invoices/list') ?>">
                                            <div class="app-ico"></div>
                                            <div class="app-name"><?= Yii::t('Front', 'Invoicing') ?></div>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <? if(Yii::app()->user->checkRbacAccess('apps_menu_loans')): ?>
                                    <li class="loans">
                                        <a href="#">
                                            <div class="app-ico"></div>
                                            <div class="app-name"><?= Yii::t('Front', 'Loans'); ?></div>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <? if(Yii::app()->user->checkRbacAccess('apps_menu_cards')): ?>
                                    <li class="cards">
                                        <a href="#">
                                            <div class="app-ico"></div>
                                            <div class="app-name"><?= Yii::t('Front', 'Cards'); ?></div>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <? if(Yii::app()->user->checkRbacAccess('apps_menu_users')): ?>
                                    <li class="users">
                                        <a href="<?= Yii::app()->createUrl('/rbac/manageusers') ?>">
                                            <div class="app-ico"></div>
                                            <div class="app-name"><?= Yii::t('Front', 'Users') ?></div>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <? if(Yii::app()->user->checkRbacAccess('apps_menu_roles')): ?>
                                    <li class="roles">
                                        <a href="<?= Yii::app()->createUrl('settings/roles') ?>">
                                            <div class="app-ico"></div>
                                            <div class="app-name"><?= Yii::t('Front', 'Roles') ?></div>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <? if(Yii::app()->user->checkRbacAccess('apps_menu_settings')): ?>
                                    <li class="settings">
                                        <a href="#">
                                            <div class="app-ico"></div>
                                            <div class="app-name"><?= Yii::t('Front', 'settings') ?></div>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
            </li>
        <?php endif; ?>
        <? if(Yii::app()->user->checkRbacAccess('adresbook_menu')): ?>
            <li class="address-book">
                <a href="<?= Yii::app()->createUrl('/contact/index'); ?>">
                    <div class="menu-ico"></div>
                    <div class="menu-name"><?= Yii::t('Front', 'Address book'); ?></div>
                </a>
            </li>
        <?php endif; ?>
        <? if(Yii::app()->user->checkRbacAccess('dialogues_menu')): ?>
            <li class="dialogues">
                <a href="#">
                    <div class="menu-ico"></div>
                    <div class="menu-name"><?= Yii::t('Front', 'Dialogues')?></div>
                </a>
            </li>
        <?php endif; ?>
        <? if(Yii::app()->user->checkRbacAccess('messaging_menu')): ?>
            <li class="messaging">
                <a href="#">
                    <div class="menu-ico"><span class="messages-count">1</span></div>
                    <div class="menu-name"><?= Yii::t('Front', 'Messaging') ?></div>
                </a>
            </li>
        <?php endif; ?>
        <? if(Yii::app()->user->checkRbacAccess('alerts_menu')): ?>
            <li class="alerts">
                <a href="<?= Yii::app()->createUrl('/personal/alerts') ?>">
                    <div class="menu-ico"></div>
                    <div class="menu-name"><?= Yii::t('Front', 'Alerts') ?></div>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</div>


