<div id="wrap">
	<div id="page-heading">
		<h1><?= Yii::t('Users', 'Create new transfer') ?></h1>
	</div>

	<div class="container">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><?= Yii::t('Users', 'New transfer') ?></h4>
				<div class="options">   
					<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
				</div>
			</div>
			<div class="panel-body collapse in">
				<?php
					$form = $this->beginWidget('CActiveForm', array(
						'id' => 'transfer-form',
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
					<?php echo $form->labelEx($model, 'account_number', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model, 'account_number', array('maxlength' => 12, 'class' => 'form-control')); ?>
						
					</div>
					<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'account_number'); ?></div></div>
				</div>
				
				<div class="form-group">  
					<?php echo $form->labelEx($model, 'operation', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model, 'operation', array('class' => 'form-control')); ?>
						
					</div>
					<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'operation'); ?></div></div>
				</div>
				
				<div class="form-group">
					<?php echo $form->labelEx($model, 'type', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?php echo $form->dropDownList($model, 'type', array('positive' => 'positive', 'negative' => 'negative'), array('class' => 'form-control')); ?>
						
					</div>
					<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'type'); ?></div></div>
				</div>
				
				<div class="form-group">
					<?php echo $form->labelEx($model, 'sum', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<div class="input-group">
							<!--<span class="input-group-addon">$</span>-->
							<?php echo $form->textField($model, 'sum', array('class' => 'form-control')); ?>
							<span class="input-group-addon">.00</span>
						</div>
					</div>
					<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'sum'); ?></div></div>
				</div>
				
				<div class="form-group">
					<?php echo $form->labelEx($info, 'type', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($info, 'type', array('class' => 'form-control')); ?>
					</div>
					<div class="col-md-3"><div class="help-block"><?php echo $form->error($info, 'type'); ?><?= Yii::t('Transfers', 'Like: OV') ?></div></div>
				</div>
				
				<div class="form-group">
					<?php echo $form->labelEx($info, 'sender', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($info, 'sender', array('class' => 'form-control')); ?>
					</div>
					<div class="col-md-3"><div class="help-block"><?php echo $form->error($info, 'sender'); ?></div></div>
				</div>
				
				<div class="form-group">
					<?php echo $form->labelEx($info, 'bic', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($info, 'bic', array('class' => 'form-control')); ?>
					</div>
					<div class="col-md-3"><div class="help-block"><?php echo $form->error($info, 'bic'); ?></div></div>
				</div>

				<div class="form-group">
					<?php echo $form->labelEx($info, 'data_bank', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($info, 'data_bank', array('class' => 'form-control')); ?>
					</div>
					<div class="col-md-3"><div class="help-block"><?php echo $form->error($info, 'data_bank'); ?></div></div>
				</div>
				
				<div class="form-group">
					<?php echo $form->labelEx($info, 'costs', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($info, 'costs', array('class' => 'form-control')); ?>
					</div>
					<div class="col-md-3"><div class="help-block"><?php echo $form->error($info, 'costs'); ?></div></div>
				</div>
				
				<div class="form-group">
					<?php echo $form->labelEx($info, 'details_of_payment', array('class' => 'col-sm-3 control-label')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($info, 'details_of_payment', array('class' => 'form-control')); ?>
					</div>
					<div class="col-md-3"><div class="help-block"><?php echo $form->error($info, 'details_of_payment'); ?></div></div>
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
