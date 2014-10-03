<div id="wrap">
	<div id="page-heading">
		<h1><?= Yii::t('Notifications', 'Notifications') ?></h1>
	</div>

	<div class="container">

		<div class="panel panel-midnightblue">
			<div class="panel-heading ">
				<h4><?= Yii::t('Notifications', 'Create') ?></h4>
				<div class="options">
					<!--<a href="javascript:;"><i class="fa fa-cog"></i></a>
					<a href="javascript:;"><i class="fa fa-wrench"></i></a>-->
					<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
				</div>
			</div>
			<div class="panel-body collapse in">
				<?php $this->renderPartial('_form', array('model' => $model)); ?>
			</div>
		</div>
	</div>
</div>

