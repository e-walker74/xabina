<div id="wrap">
	<div id="page-heading">
		<h1><?= Yii::t('Messages', 'Messages') ?></h1>
	</div>

	<div class="container">
		<div class="panel panel-midnightblue">
			<div class="panel-heading ">
				<h4><?= Yii::t('Messages', 'Reply') ?></h4>
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
				<?php if(Yii::app()->request->getParam('user_id')): ?>
				<div class="form-group">
					<?php echo $form->labelEx($model, 'subject_id', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?php echo $form->dropDownList($model, 'subject_id', CHtml::listData(Messages_Subject::model()->findAll(), 'id', 'title'), array('class' => 'form-control')); ?>
					</div>
					<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'type'); ?></div></div>
				</div>
				
				<div class="form-group">
					<?php echo $form->labelEx($model, 'from', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?php echo $form->dropDownList($model, 'to_id', CHtml::listData(Messages_To::model()->findAll(), 'id', 'name'), array('class' => 'form-control')); ?>
					</div>
					<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'type'); ?></div></div>
				</div>
				
				<?php else: ?>
				
				<div class="form-group">
					<?php echo $form->labelEx($model, 'subject_id', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?php echo $form->dropDownList($model, 'subject_id', CHtml::listData(Messages_Subject::model()->findAll(), 'id', 'title'), array('class' => 'form-control', 'disabled' => 'disables')); ?>
					</div>
					<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'type'); ?></div></div>
				</div>
				
				<div class="form-group">
					<?php echo $form->labelEx($model, 'to_id', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?php echo $form->dropDownList($model, 'to_id', CHtml::listData(Messages_To::model()->findAll(), 'id', 'name'), array('class' => 'form-control', 'disabled' => 'disables')); ?>
					</div>
					<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'type'); ?></div></div>
				</div>
				
				<?php endif; ?>
				
				<div class="form-group">
					<?php echo $form->labelEx($model, 'message', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?= $form->textarea($model, 'message', array('cols' => 40, 'rows' => 4, 'class' => 'form-control')) ?>
					</div>
				</div>
				
				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-6 col-sm-offset-3">
							<div class="btn-toolbar">
								<?php echo CHtml::submitButton(Yii::t('Admin', 'Send'), array('class' => 'btn btn-success')); ?>
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
