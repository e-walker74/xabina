<!DOCTYPE html>
<html>
<head>
    <title>banking</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="/default/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/css/fonts.css" />

    <link  rel="stylesheet/less" type="text/css" href="/css/style.less" />
    <link rel="stylesheet" href="/css/media.css" />
    <!--<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>-->
	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
    <script type="text/javascript" src="/js/less.min.js"></script>
    <script type="text/javascript" src="/js/scripts.js"></script>
    <script type="text/javascript" src="/js/jquery.currencyDropDown.js"></script>
</head>
<body>
<div class="main-bg" >
    <div class="wrapper">
<?php $this->widget('TopBar'); ?>

<div class="container" >
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <header>
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
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Site map</a></li>
                        <li><a href="#">Language</a></li>
                        <li><a href="#">Cards</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Site map</a></li>
                    </ul>
                </div>
                <div class="header-bottom clearfix">
                    <ul class="top-menu pull-left list-unstyled">
                        <li class="current"><a href="#">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Credits</a></li>
                        <li><a href="#">History</a></li>
                    </ul>
                    <div class="search-cont pull-right">
                        <input value="Введите слово..." onfocus="if($(this).val()=='Введите слово...')$(this).val('')" onblur="if($(this).val()=='')$(this).val('Введите слово...')" type="text" class="search-text">
                        <div class="search-submit"></div>
                    </div>
                </div>
            </header>
        </div>
    </div>
    <div class="row main-container">
        <div class="col-lg-3 col-md-3  col-sm-3 sidebar-container" >
            <div class="sidebar-shadow-container">
                <div class="sidebar-shadow"></div>
            <ul class="sidebar-menu list-unstyled">
                <li class="overview active"><a href="http://xabina.intwall.com/banking/">Overview</a></li>
                <li class="accounts"><a href="http://xabina.intwall.com/banking/accountsactivation/">Accounts</a></li>
                <li class="payments"><a href="accounts_activation.html">Payments</a></li>
                <li class="balance"><a href="#">Balance</a></li>
                <li class="credit"><a href="#">Credit</a></li>
                <li class="extra"><a href="#">Extra  Services</a></li>
            </ul>
            <ul class="sidebar-contacts list-unstyled">
                <li class="phones">
                    <div class="contact-ico"></div>
                    <div class="contact-text">
                    (912) 555-1234  <br>
                    (912) 567-8904
                    </div>
                </li>
                <li  class="address">
                    <div class="contact-ico"></div>
                    <div class="contact-text">
                    1600 Pennsylvania  <br>
                    Ave NW, Washington  <br>
                    DC 20500, USA
                    </div>
                </li>
                <li  class="emails">

                    <div class="contact-ico"></div>
                    <div class="contact-text">
                    hello@xabina.com   <br>
                    office@xabina.com
                    </div>
                </li>
            </ul>
            </div>

        </div>
        <?= $content ?>



    </div>
</div>
        <div class="footer-push"></div>
    </div>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class=" clearfix">
                        <div class="copyright pull-left">© 2014 Xabina</div>
                        <ul class="footer-menu pull-right list-inline">
                            <li><a href="#">Services</a></li>
                            <li><a href="#">Site map</a></li>
                            <li><a href="#">Language</a></li>
                            <li><a href="#">Cards</a></li>
                            <li><a href="#">Services</a></li>
                            <li><a href="#">Site map</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </footer>
</div>
</body>
</html>