<!DOCTYPE html>
<html>
<head>
    <title>banking</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="/default/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/css/fonts.css" />
	<link rel="stylesheet" href="/js/jquery-ui-1.10.4/css/ui-lightness/jquery-ui-1.10.4.custom.min.css"/>
    <link  rel="stylesheet/less" type="text/css" href="/css/style.less" />
    <link rel="stylesheet" href="/css/media.css" />
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
					<?php $this->widget('Header'); ?>
				</header>			
				</div>
			</div>
			<div class="row main-container">
				<div class="col-lg-3 col-md-3  col-sm-3 sidebar-container" >
					<div class="sidebar-shadow-container">
						<div class="sidebar-shadow"></div>
						<?php $this->widget('LeftMenu'); ?>	
						<?php $this->widget('ContactsBlock'); ?>								
					</div>
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