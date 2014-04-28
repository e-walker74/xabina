<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>XABINA</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="XABINA">

    <!-- <link href="<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/less/styles.less" rel="stylesheet/less" media="all">  -->
    <link rel="stylesheet" href="<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/css/styles.min.css?=113">
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>


        <link href='<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'>

            <link href='<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'>

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->
	<!--[if lt IE 9]>
        <link rel="stylesheet" href="<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/css/ie8.css">
		<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/plugins/charts-flot/excanvas.min.js"></script>
	<![endif]-->

	<!-- The following CSS are included as plugins and can be removed if unused-->
<link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/plugins/datatables/dataTables.css' />
<link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/plugins/codeprettifier/prettify.css' />
<link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/plugins/form-toggle/toggles.css' />
<link href='<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/demo/variations/sidebar-green.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'>


<!-- <script type="text/javascript" src="<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/js/less.js"></script> -->
</head>

<body class=" ">

	<?php $this->widget('Header'); ?>

    <div id="page-container">
        <!-- BEGIN SIDEBAR -->
        <nav id="page-leftbar" role="navigation">
                <!-- BEGIN SIDEBAR MENU -->
			<?php $this->widget('LeftMenu'); ?>
            <!-- END SIDEBAR MENU -->
        </nav>

        <!-- BEGIN RIGHTBAR -->

        <!-- END RIGHTBAR -->
<div id="page-content">
	<div id='wrap'>
		<div id="page-heading">
			<!--<ol class="breadcrumb">
				<li><a href="index.htm">Dashboard</a></li>
				<li>Extras</li>
			</ol>-->
			<?= $content ?>
			<!--<div class="options">
				<div class="btn-toolbar">
					<div class="btn-group hidden-xs">
						<a href='#' class="btn btn-default dropdown-toggle" data-toggle='dropdown'><i class="fa fa-cloud-download"></i><span class="hidden-sm"> Export as  </span><span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="#">Text File (*.txt)</a></li>
							<li><a href="#">Excel File (*.xlsx)</a></li>
							<li><a href="#">PDF File (*.pdf)</a></li>
						</ul>
					</div>
					<a href="#" class="btn btn-default"><i class="fa fa-cog"></i></a>
				</div>
			</div>-->
		</div>
		<div class="container">

		</div> <!-- container -->
	</div> <!--wrap -->
</div> <!-- page-content -->

    <footer role="contentinfo">
        <div class="clearfix">
            <ul class="list-unstyled list-inline">
                <li>XABINA &copy; <?= d('Y') ?></li>
                <button class="pull-right btn btn-inverse-alt btn-xs hidden-print" id="back-to-top"><i class="fa fa-arrow-up"></i></button>
            </ul>
        </div>
    </footer>

</div> <!-- page-container -->

<!--
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<script>!window.jQuery && document.write(unescape('%3Cscript src="<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/js/jquery-1.10.2.min.js"%3E%3C/script%3E'))</script>
<script type="text/javascript">!window.jQuery.ui && document.write(unescape('%3Cscript src="<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/js/jqueryui-1.10.3.min.js'))</script>
-->

<!--<script type='text/javascript' src='<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/js/jquery-1.10.2.min.js'></script>
<!--<script type='text/javascript' src='<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/js/jqueryui-1.10.3.min.js'></script>  -->
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
<script type='text/javascript' src='<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/js/bootstrap.min.js'></script>
<script type='text/javascript' src='<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/js/enquire.js'></script>
<script type='text/javascript' src='<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/js/jquery.cookie.js'></script>
<script type='text/javascript' src='<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/js/jquery.nicescroll.min.js'></script>
<script type='text/javascript' src='<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/plugins/codeprettifier/prettify.js'></script>
<script type='text/javascript' src='<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/plugins/easypiechart/jquery.easypiechart.min.js'></script>
<script type='text/javascript' src='<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/plugins/sparklines/jquery.sparklines.min.js'></script>
<script type='text/javascript' src='<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/plugins/form-toggle/toggle.min.js'></script>
<script type='text/javascript' src='<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/plugins/form-inputmask/jquery.inputmask.bundle.min.js'></script>
<script type='text/javascript' src='<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/demo/demo-mask.js'></script>
<!--<script type='text/javascript' src='<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/demo/demo-formcomponents.js'></script> -->
<script type='text/javascript' src='<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/js/placeholdr.js'></script>
<script type='text/javascript' src='<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/js/application.js'></script>
<script type='text/javascript' src='<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/demo/demo.js'></script>
<script type='text/javascript' src='<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/demo/demo-modals.js'></script>
<script type='text/javascript' src='<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/plugins/bootbox/bootbox.min.js'></script>
<script type='text/javascript' src='<?php echo Yii::app()->getModule('admin')->assetsUrl; ?>/plugins/form-datepicker/js/bootstrap-datepicker.js'></script> 

</body>
</html>