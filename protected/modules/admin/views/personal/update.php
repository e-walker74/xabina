<div id="wrap">
	<div id="page-heading">
		<h1><?= Yii::t('Users', 'Document') ?></h1>
	</div>

	<div class="container">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><?= Yii::t('Users', 'Update document') ?></h4>
				<div class="options">   
					<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
				</div>
			</div>
			<div class="panel-body collapse in">


<?php
		$form = $this->beginWidget('CActiveForm', array(
			'id' => 'users-form',
			'htmlOptions' => array('class' => 'form-horizontal row-border'),
			'enableAjaxValidation' => true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
				'validateOnChange'=>true,
				'errorCssClass'=>'has-error',
				'afterValidate' => 'js:function(form, data, hasError) {
					form.find("input").parents(".form-group").removeClass("has-error");
					form.find(".validation-icon").show();
					if(hasError) {
						for(var i in data) {
							$("#"+i).parents(".form-group").addClass("has-error");
							$("#"+i).next(".validation-icon").show();
						}
						return false;
					}
					else {
						return true;
					}
				}',
				'afterValidateAttribute' => 'js:function(form, attribute, data, hasError) {
					if(hasError){	
						$("#"+attribute.id).parents(".form-group").addClass("has-error");
						$("#"+attribute.id).next(".validation-icon").show();
					} else {
						$("#"+attribute.id).parents(".form-group").removeClass("has-error"); 
						$("#"+attribute.id).next(".validation-icon").show();
					}
				}'
			),
		));
    ?>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="form-group">
		<?php echo $form->labelEx($model, 'file_type', array('class' => 'col-sm-3 control-label')); ?>
		<div class="col-sm-6">
			<?php echo $form->textField($model, 'file_type', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
			
		</div>
		<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'file_type'); ?></div></div>
	</div>
	
	<div class="form-group">
		<?php echo $form->labelEx($model, 'expiry_date', array('class' => 'col-sm-3 control-label')); ?>
		<div class="col-sm-6">
			<div class="input-group date">
				<?php echo $form->textField($model, 'expiry_date', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
				<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			</div>
		</div>
		<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'expiry_date'); ?></div></div>
	</div>
	
	<div class="panel-footer">
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3">
				<div class="btn-toolbar">
					<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('Admin', 'Save') : Yii::t('Admin', 'Save'), array('class' => 'btn-primary btn')); ?>
				</div>
			</div>
		</div>
	</div>

<?php $this->endWidget(); ?>

			</div>
		</div>
	</div>
</div>