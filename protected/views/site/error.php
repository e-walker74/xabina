<!DOCTYPE html>
<html>
<head>
    <title>Xabina</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="/default/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/css/fonts.css" />
    <link rel="stylesheet" href="/js/jquery-ui-1.10.4/css/ui-lightness/jquery-ui-1.10.4.custom.min.css"/>
    <link  rel="stylesheet/less" type="text/css" href="/css/style.less" />
    <link rel="stylesheet" href="/css/media.css" />

	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
    <script type="text/javascript" src="/js/less.min.js"></script>
    <script type="text/javascript" src="/js/jquery.liveValidation.js"></script>
    <script type="text/javascript" src="/js/scripts.js"></script>
    <script type="text/javascript" src="/js/jquery.currencyDropDown.js"></script>
    <script type="text/javascript" src="/js/plax.js"></script>
</head>
<body class="page-404">
    <div class="bg-404" >
        <img src="/images/404_main.png" class="img-404" alt=""/>
        <img src="/images/404_bg.png" class="bg-404-img" alt=""/>
        <img src="/images/404_gold_bg.png" id="bg-404-gold" class="gold-404" alt=""/>
        <div class="comments-404-container">
            <div class="comments-404"><?= Yii::t('Front', 'Sorry! The page you’re looking for cannot be found.') ?></div>
            <div class="comments-links"><?= Yii::t('Front', 'Go back <a href=":baseUrl">xabina.com</a> or <a href="#">contact us</a> about a problem ', array(':baseUrl' => Yii::app()->getBaseUrl(true))) ?></div>
            <div class="logo-404"></div>
        </div>

    </div>
</body>
</html>