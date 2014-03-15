
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
		<?php echo $form->labelEx($model, 'login', array('class' => 'col-sm-3 control-label')); ?>
		<div class="col-sm-6">
			<?php echo $form->textField($model, 'login', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
			
		</div>
		<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'login'); ?></div></div>
	</div>
	
	<div class="form-group">
		<?php echo $form->labelEx($model, 'first_name', array('class' => 'col-sm-3 control-label')); ?>
		<div class="col-sm-6">
			<?php echo $form->textField($model, 'first_name', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
			
		</div>
		<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'first_name'); ?></div></div>
	</div>
	
	<div class="form-group">
		<?php echo $form->labelEx($model, 'last_name', array('class' => 'col-sm-3 control-label')); ?>
		<div class="col-sm-6">
			<?php echo $form->textField($model, 'last_name', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
			
		</div>
		<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'last_name'); ?></div></div>
	</div>
	
	<!--<div class="form-group">
		<?php echo $form->labelEx($model->profile, 'name', array('class' => 'col-sm-3 control-label')); ?>
		<div class="col-sm-6">
			<?php echo $form->textField($model->profile, 'name', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
			
		</div>
		<div class="col-md-3"><?php echo $form->error($model->profile, 'name'); ?></div>
	</div>

    <div class="form-group">
		<?php echo $form->labelEx($model->profile, 'surname', array('class' => 'col-sm-3 control-label')); ?>
		<div class="col-sm-6">
			<?php echo $form->textField($model->profile, 'surname', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
			
		</div>
		<div class="col-md-3"><?php echo $form->error($model->profile, 'surname'); ?></div>
	</div>

    <div class="form-group">
		<?php echo $form->labelEx($model->profile, 'sex', array('class' => 'col-sm-3 control-label')); ?>
		<div class="col-sm-6">
			<?php echo $form->dropDownList($model->profile, 'sex', Users_Profile::$sexs, array('class' => 'form-control')); ?>
		</div>
		<div class="col-md-3"><?php echo $form->error($model->profile, 'sex'); ?></div>
	</div>-->

	<div class="form-group">
		<?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-3 control-label')); ?>
		<div class="col-sm-6">
			<?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
			
		</div>
		<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'email'); ?></div></div>
	</div>
	
	<div class="form-group">
		<?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-3 control-label')); ?>
		<div class="col-sm-6">
			<?php echo $form->textField($model, 'phone', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control mask', 'data-inputmask' => '"mask": "+999999999[9][9][9][9][9][9][9][9]"')); ?>
		</div>
		<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'phone'); ?></div></div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model, 'created_at', array('class' => 'col-sm-3 control-label')); ?>
		<div class="col-sm-6">
			<?php echo $form->textField($model, 'created_at', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control', 'readonly' => 'readonly')); ?>
		</div>
	</div>
	
	<div class="form-group">
		<?php echo $form->labelEx($model, 'updated_at', array('class' => 'col-sm-3 control-label')); ?>
		<div class="col-sm-6">
			<?php echo $form->textField($model, 'updated_at', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control', 'readonly' => 'readonly')); ?>
		</div>
	</div>
	
	<div class="panel-footer">
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3">
				<div class="btn-toolbar">
					<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('Admin', 'Create') : Yii::t('Admin', 'Save'), array('class' => 'btn-primary btn')); ?>
				</div>
			</div>
		</div>
	</div>

<?php $this->endWidget(); ?>