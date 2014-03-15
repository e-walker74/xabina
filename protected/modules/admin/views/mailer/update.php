<div id="wrap">
	<div id="page-heading">
		<h1><?= Yii::t('Mailer', 'Change template'); ?> <?php echo $model->code; ?></h1>
	</div>

	<div class="container">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><?= Yii::t('Mailer', 'Template setings') ?></h4>
				<div class="options">
					<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
				</div>
			</div>
			<div class="panel-body collapse in">
				<?php
					$form = $this->beginWidget('CActiveForm', array(
						'id' => 'template-mailer',
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
					<?php echo $form->labelEx($model, 'code', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model, 'code', array('readonly' => 'readonly', 'class' => 'form-control')); ?>
						
					</div>
				</div>

				<div class="form-group">
					<?php echo $form->labelEx($model, 'template', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?php echo $form->dropDownList($model, 'template', $templates, array('class' => 'form-control')); ?>
						
					</div>
					<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'template'); ?></div></div>
				</div>
				
				<div class="form-group">
					<?php echo $form->labelEx($model, 'sender', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model, 'sender', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
						
					</div>
					<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'sender'); ?></div></div>
				</div>

				<div class="form-group">
					<?php echo $form->labelEx($model, 'subject', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model, 'subject', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
						
					</div>
					<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'subject'); ?></div></div>
				</div>
				
				<div class="form-group">
					<?php echo $form->labelEx($model, 'fromName', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model, 'fromName', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
						
					</div>
					<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'fromName'); ?></div></div>
				</div>
				
				<div class="form-group">
					<?php echo $form->labelEx($model, 'params', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model, 'params', array('readonly' => 'readonly', 'class' => 'form-control')); ?>
						
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
			</div>
		</div>
	</div>
</div>