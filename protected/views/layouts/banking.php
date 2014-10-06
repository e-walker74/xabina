<!DOCTYPE html>
<html>
<head>
    <title>Xabina</title>
    <meta charset="utf-8" />
    <?php /*<link rel="stylesheet" href="/css/jquery.pnotify.default.css" />
    <link rel="stylesheet" href="/default/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/css/fonts.css" />
    <link rel="stylesheet" href="/css/media.css" />
	<link rel="stylesheet" href="/css/bg.css" /> */?>
	<link rel="stylesheet/less" type="text/css" href="/css/style.less" />
	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
    <script type="text/javascript" src="/js/less.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/scripts.js"></script>
    <script type="text/javascript" src="/js/jquery.currencyDropDown.js"></script>
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
    <div class="noty-header">Sticky Success</div>
    <div class="noty-text">
        Sticky Success... I'm not even gonna make a joke.
    </div>
</div>
<div class="xabina-notification danger" >
    <div class="noty-header">Uh Oh</div>
    <div class="noty-text">
        Something really terrible happened. You really need to read this, so I won't close atomatically.
    </div>
</div>
<div class="xabina-notification info" >
    <div class="noty-header">Sticky info</div>
    <div class="noty-text">
        Sticky info, you know, like a newspaper covered in honey.
    </div>
</div>

<div class="main-bg" >
	<div class="wrapper">
		<?php $this->widget('TopBar'); ?>
		<div class="container" >
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12">
				<header>
					<?php $this->widget('Header'); ?>
				</header>			
				</div>
			</div>
			<div class="row main-container">
				<div class="col-lg-3 col-md-3  col-sm-3 sidebar-container" >
					<div class="sidebar-shadow-container">
						<div class="sidebar-shadow"></div>
						<?php $this->widget('LeftMenu'); ?>
                        <?php if(Yii::app()->user->checkRbacAccess('show_manager_widget')): ?>
                            <?php $this->widget('PersonalManager'); ?>
                        <?php endif; ?>
                        <?php if(Yii::app()->user->checkRbacAccess('show_contacts')): ?>
                            <?php $this->widget('ContactsBlock'); ?>
                        <?php endif; ?>
					</div>
				</div>
                <div class="col-lg-9 col-md-9 col-sm-9">
				<?php
					$this->widget('XBreadcrumbs', array(
							'links'=>$this->breadcrumbs
					));
				?>
                </div>
				<?= $content ?>
			</div>
		</div>
		<div class="footer-push"></div>
	</div>
	<footer>
		<?php $this->widget('Footer'); ?>
	</footer>	
</div>
</body>
</html>