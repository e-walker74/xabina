<!DOCTYPE html>
<html>
<head>
    <title>xabina</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
	<link rel="shortcut icon" href="/favicon.ico" />
    <link rel="stylesheet" href="/js/jquery-ui-1.10.4/css/ui-lightness/jquery-ui-1.10.4.custom.min.css"/>
    <link rel="stylesheet" href="/css/main_style.css"/>
    <link rel="stylesheet" href="/js/vegas/jquery.vegas.min.css"/>
	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <script type="text/javascript" src="/js/jquery-ui-1.10.4/js/jquery-ui-1.10.4.custom.min.js"></script>
    <script type="text/javascript" src="/js/jquery.liveValidation.js"></script>
    <script type="text/javascript" src="/js/vegas/jquery.vegas.min.js"></script>
    <script type="text/javascript" src="/js/main_scripts.js"></script>
    <script type="text/javascript" src="/js/lib.js"></script>
</head>
<body >
    <div class="main-bg" >
        <div class="wrapper">
            <header class="header-cont">
                <div class="logo-cont">
                    <a class="logo" href="/"></a>
                </div>
            </header>
            <div class="mobile-language-menu">
                <div class="language-header">Language</div>
                <div class="select-custom">
                    <span>English</span>
                    <select name="" class="language-select">
                        <option value="">English</option>
                        <option value="">Chinese</option>
                        <option value="">Dutch</option>
                        <option value="">German</option>
                        <option value="">French</option>
                        <option value="">Russian</option>
                    </select>
                </div>
            </div>
            <div class="main">
                <?= $content ?>
            </div>
        <div class="push"></div>
        </div>
        <footer>
            <div class="footer-wrapper">
                <ul class="footer-menu">
                    <li><a href="<?= Yii::app()->getBaseUrl(true) ?>">Home</a></li>
                    <!--<li><a href="#">Contacts</a></li>-->
                </ul>

                <div class="footer-copyright">Xabina © 2014 All right reserved</div>
            </div>
        </footer>
    </div>



</body>
</html>