<div id="wrap">
	<div id="page-heading">
		<h1><?= Yii::t('Users', 'Activation User: <b>' . $model->user->login . '</b>') ?></h1>
	</div>

	<div class="container">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><?= Yii::t('Users', 'Basic information') ?></h4>
				<div class="options">   
					<!--<a href="javascript:;"><i class="fa fa-cog"></i></a>
					<a href="javascript:;"><i class="fa fa-wrench"></i></a>-->
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
				
				<div class="form-group">
					<?php echo $form->labelEx($model, 'first_name', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model, 'first_name', array('disabled' => 'disabled', 'size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
					</div>
				</div>
				
				<div class="form-group">
					<?php echo $form->labelEx($model, 'last_name', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model, 'last_name', array('disabled' => 'disabled', 'size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
					</div>
				</div>
				
				<div class="form-group">
					<?php echo $form->labelEx($model, 'address_line_1', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model, 'address_line_1', array('disabled' => 'disabled', 'size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
					</div>
				</div>
				
				<div class="form-group">
					<?php echo $form->labelEx($model, 'address_line_2', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model, 'address_line_2', array('disabled' => 'disabled', 'size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
					</div>
				</div>
				
				<div class="form-group">
					<?php echo $form->labelEx($model, 'zip_code', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model, 'zip_code', array('disabled' => 'disabled', 'size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
					</div>
				</div>
				
				<div class="form-group">
					<?php echo $form->labelEx($model, 'town', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model, 'town', array('disabled' => 'disabled', 'size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
					</div>
				</div>
				
				<div class="form-group">
					<?php echo $form->labelEx($model, 'country', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model->country, 'name', array('disabled' => 'disabled', 'size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
					</div>
				</div>
				
				<?php foreach($model->files as $file): ?>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="Users_Files_user_file_name"><?= $file->getAttributeLabel('user_file_name') ?> (<?= $file->document_type ?>)</label>
						<div class="col-sm-6">
							<input disabled="disabled" size="60" maxlength="255" class="form-control" name="" id="" type="text" value="<?= $file->user_file_name . '.' . $file->ext ?>">
						</div>
						<div class="col-xs-3">
							<a href="<?= $this->createUrl('/admin/accounts/getFile', array('name' => $file->name, 'user_id' => $file->user_id)) ?>" class="btn btn-green"><?= Yii::t('Account', 'Download') ?></a>
						</div>
					</div>
				<?php endforeach; ?>
				<?php if(isset($file)): ?>
					<div class="form-group">
						<?php echo $form->labelEx($file, 'description', array('class' => 'col-sm-3 control-label')); ?>
						<div class="col-sm-6">
							<textarea name="txtarea1" disabled="desabled" id="txtarea1" cols="50" rows="4" class="form-control">
								<?= $file->description ?>
							</textarea>
						</div>
					</div>
				<?php endif; ?>
				
				<div class="form-group">
					<?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?= $form->textarea($model, 'description', array('cols' => 40, 'rows' => 4, 'class' => 'form-control')) ?>
					</div>
				</div>
				
				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-6 col-sm-offset-3">
							<div class="btn-toolbar">
								<?php echo CHtml::submitButton(Yii::t('Admin', 'Activate'), array('class' => 'btn btn-success')); ?>
							</div>
							<div class="btn-toolbar">
								<?php //echo CHtml::submitButton(Yii::t('Admin', 'Block'), array('class' => 'btn-primary btn')); ?>
							</div>
						</div>
					</div>
				</div>

			<?php $this->endWidget(); ?>
			</div>
		</div>
	</div>
</div>
