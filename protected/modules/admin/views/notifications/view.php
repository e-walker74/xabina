<div id="wrap">
	<div id="page-heading">
		<h1><?= Yii::t('Notifications', 'Notifications') ?></h1>
	</div>

	<div class="container">
		<div class="panel panel-midnightblue">
			<div class="panel-heading ">
				<h4><?= Yii::t('Notifications', 'Update') ?></h4>
				<div class="options">
					<!--<a href="javascript:;"><i class="fa fa-cog"></i></a>
					<a href="javascript:;"><i class="fa fa-wrench"></i></a>-->
					<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
				</div>
			</div>
			<div class="panel-body collapse in">

<div class="form-group clearfix">
	<??>
	<?php echo CHtml::activeLabel($model, 'type', array('class' => 'col-sm-3 control-label')); ?>
	<div class="col-sm-6">
		<?=$model->type?>
	</div>
</div>

<div class="form-group clearfix">
	<??>
	<?php echo CHtml::activeLabel($model, 'manager_id', array('class' => 'col-sm-3 control-label')); ?>
	<div class="col-sm-6">
		<?=$model->manager_id?>
	</div>
</div>

<div class="form-group clearfix">
	<??>
	<?php echo CHtml::activeLabel($model, 'title', array('class' => 'col-sm-3 control-label')); ?>
	<div class="col-sm-6">
		<?=$model->title?>
	</div>
</div>

<div class="form-group clearfix">
	<??>
	<?php echo CHtml::activeLabel($model, 'announce', array('class' => 'col-sm-3 control-label')); ?>
	<div class="col-sm-6">
		<?=$model->announce?>
	</div>
</div>

<div class="form-group clearfix">
	<??>
	<?php echo CHtml::activeLabel($model, 'text', array('class' => 'col-sm-3 control-label')); ?>
	<div class="col-sm-6">
		<?=$model->text?>
	</div>
</div>

<div class="form-group clearfix">
	<??>
	<?php echo CHtml::activeLabel($model, 'section', array('class' => 'col-sm-3 control-label')); ?>
	<div class="col-sm-6">
		<?=$model->section?>
	</div>
</div>

<div class="form-group clearfix">
	<??>
	<?php echo CHtml::activeLabel($model, 'section_link', array('class' => 'col-sm-3 control-label')); ?>
	<div class="col-sm-6">
		<?=$model->section_link?>
	</div>
</div>

<div class="form-group clearfix">
	<??>
	<?php echo CHtml::activeLabel($model, 'button', array('class' => 'col-sm-3 control-label')); ?>
	<div class="col-sm-6">
		<?=$model->section?>
	</div>
</div>

<div class="form-group clearfix">
	<??>
	<?php echo CHtml::activeLabel($model, 'button_link', array('class' => 'col-sm-3 control-label')); ?>
	<div class="col-sm-6">
		<?=$model->section_link?>
	</div>
</div>



			</div>
		</div>
	</div>
</div>
