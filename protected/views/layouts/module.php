<!DOCTYPE html>
<html>
<head>
    <title>Xabina</title>
    <meta charset="utf-8" />

	<link rel="stylesheet/less" type="text/css" href="/css/style.less" />
	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/less.min.js"></script>
    <script type="text/javascript" src="/js/scripts.js"></script>
    <script type="text/javascript" src="/js/jquery.currencyDropDown.js"></script>
    <script type="text/javascript" src="/js/browserDetect.js"></script>

    <script type="text/javascript" src="/js/bootstrap-tooltip.js"></script>
    <script type="text/javascript" src="/js/bootstrap-confirmation.js"></script>
    <script type="text/javascript" src="/js/jquery.autosize-min.js"></script>
    <script type="text/javascript" src="/js/jquery.pnotify.min.js"></script>
    <script type="text/javascript" src="/js/jquery.inputmask.js"></script>
    <script type="text/javascript" src="/js/jquery.inputmask.date.extensions.js"></script>
    <script type="text/javascript" src="/js/jquery.form.js"></script>
</head>
<body>

<div class="xabina-notification success" >
    <div class="noty-header"></div>
    <div class="noty-text"></div>
</div>
<div class="xabina-notification danger" >
    <div class="noty-header"></div>
    <div class="noty-text"></div>
</div>
<div class="xabina-notification info" >
    <div class="noty-header"></div>
    <div class="noty-text"></div>
</div>

<div class="main-bg <?php if(Yii::request()->getParam('w', 0, 'int')): ?>module-blank<?php endif; ?>" >
	<div class="wrapper">
        <?php if(!Yii::request()->getParam('w', 0, 'int')): ?>
		<?php $this->widget('TopBar'); ?>
        <?php endif; ?>
		<div class="container" >
            <?php if(!Yii::request()->getParam('w', 0, 'int')): ?>
            <div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12">
				<header>
					<?php $this->widget('Header'); ?>
				</header>			
				</div>
			</div>
            <?php endif; ?>
			<div class="row main-container">
				<div class="col-lg-12 col-md-12 col-sm-12" >
                    <div class="module-container ">
                        <?php if(!Yii::request()->getParam('w', 0, 'int')): ?>
                        <?php $this->widget('WModuleLeftMenu'); ?>
                        <?php endif; ?>
                        <div class="module-content">
                            <?= $content ?>
                        </div>
                    </div>
				</div>
			</div>
		</div>
        <?php if(!Yii::request()->getParam('w', 0, 'int')): ?>
		<div class="footer-push"></div>
        <?php endif; ?>
	</div>
    <?php if(!Yii::request()->getParam('w', 0, 'int')): ?>
	<footer>
		<?php $this->widget('Footer'); ?>
	</footer>
    <?php endif; ?>
</div>
</body>
</html>