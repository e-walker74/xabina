<div id="wrap">
	<div id="page-heading">
		<h1><?= Yii::t('Users', 'Update transfer') ?></h1>
	</div>

	<div class="container">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><?= Yii::t('Users', 'Update Transfer') ?></h4>
				<div class="options">   
					<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
				</div>
			</div>
			<div class="panel-body collapse in">
				<?php
					$form = $this->beginWidget('CActiveForm', array(
						'id' => 'transfer-form',
						'action' => array('/admin/transfers/authorise', 'id' => $model->id),
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
                    <?php echo $form->labelEx($model, 'form_type', array('class' => 'col-sm-3 control-label ')); ?>
                    <div class="col-sm-6">
                        <?php echo $form->textField($model, 'form_type', array('disabled' => 'disabled', 'maxlength' => 12, 'class' => 'form-control')); ?>
                    </div>
                </div>

				<div class="form-group">
					<?php echo $form->labelEx($model->user, 'email', array('class' => 'col-sm-3 control-label ')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model->user, 'email', array('disabled' => 'disabled', 'maxlength' => 12, 'class' => 'form-control')); ?>
					</div>
				</div>
				
				<div class="form-group">
					<?php echo $form->labelEx($model->user, 'phone', array('class' => 'col-sm-3 control-label ')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model->user, 'phone', array('disabled' => 'disabled', 'maxlength' => 12, 'class' => 'form-control')); ?>
					</div>
				</div>
				
				<div class="form-group">
					<?php echo $form->labelEx($model->account, 'number', array('class' => 'col-sm-3 control-label ')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model->account, 'number', array('disabled' => 'disabled', 'maxlength' => 12, 'class' => 'form-control')); ?>
					</div>
				</div>
				
				<div class="form-group">
					<?php echo $form->labelEx($model, 'amount', array('class' => 'col-sm-3 control-label ')); ?>
					<div class="col-sm-6">
						<div class="input-group">
						<span class="input-group-addon"><?= $model->currency->code ?></span>
							<?php echo $form->textField($model, 'amount', array('disabled' => 'disabled', 'maxlength' => 12, 'class' => 'form-control')); ?>
						</div>
					</div>
				</div>
				
				<?php if($model->form_type == "own"): ?>
				<div class="form-group">
					<?php echo $form->labelEx($model, 'to_account_number', array('class' => 'col-sm-3 control-label ')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model, 'to_account_number', array('disabled' => 'disabled', 'maxlength' => 12, 'class' => 'form-control')); ?>
					</div>
				</div>
				<?php elseif($model->form_type == "xabina"): ?>
				<div class="form-group">
					<?php echo $form->labelEx($model, 'account_number', array('class' => 'col-sm-3 control-label ')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model, 'account_number', array('disabled' => 'disabled', 'maxlength' => 12, 'class' => 'form-control')); ?>
					</div>
				</div>
				<?php elseif($model->form_type == "external"): ?>
				<div class="form-group">
					<?php echo $form->labelEx($model, 'account_holder', array('class' => 'col-sm-3 control-label ')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model, 'account_holder', array('disabled' => 'disabled', 'maxlength' => 12, 'class' => 'form-control')); ?>
					</div>
				</div>
				<div class="form-group">
					<?php echo $form->labelEx($model, 'bank_beneficiary', array('class' => 'col-sm-3 control-label ')); ?>
					<div class="col-sm-6">
						<div class="input-group">
							<span class="input-group-addon"><?= $model->country->code ?></span>
							<?php echo $form->textField($model, 'bank_beneficiary', array('disabled' => 'disabled', 'maxlength' => 12, 'class' => 'form-control')); ?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<?php echo $form->labelEx($model, 'swift', array('class' => 'col-sm-3 control-label ')); ?>
					<div class="col-sm-6">
						 <?php echo $form->textField($model, 'swift', array('disabled' => 'disabled', 'class' => 'form-control')); ?>
					</div>
				</div>
				<div class="form-group">
					<?php echo $form->labelEx($model, 'external_account_number', array('class' => 'col-sm-3 control-label ')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model, 'external_account_number', array('disabled' => 'disabled', 'class' => 'form-control')); ?>
					</div>
				</div>
				<div class="form-group">
					<?php echo $form->labelEx($model, 'postcode', array('class' => 'col-sm-3 control-label ')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model, 'postcode', array('disabled' => 'disabled', 'class' => 'form-control')); ?>
					</div>
				</div>
				<div class="form-group">
					<?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-3 control-label ')); ?>
					<div class="col-sm-6">
						<?php echo $form->textArea($model, 'description', array('disabled' => 'disabled', 'class' => 'form-control')); ?>
					</div>
				</div>
				<?php endif; ?>
				
				<?php if($model->frequency_type == 1): ?>
				<div class="form-group">
					<?php echo $form->labelEx($model, 'execution_date', array('class' => 'col-sm-3 control-label ')); ?>
					<div class="col-sm-6">
						<?php $model->execution_date = date('m.d.Y', $model->execution_date); ?>
						<?php echo $form->textField($model, 'execution_date', array('disabled' => 'disabled', 'class' => 'form-control')); ?>
					</div>
				</div>
				<?php else: ?>
				<?php if($model->each_period): ?>
				<div class="form-group">
					<?php echo $form->labelEx($model, 'each_transfer', array('class' => 'col-sm-3 control-label ')); ?>
					<div class="col-sm-6">
						<div class="input-group">
							<span class="input-group-addon"><?= $model->each_transfer ?></span>
							<?php $model->each_period = Transfers_Outgoing::$periods[$model->each_period] ?>
							<?php echo $form->textField($model, 'each_period', array('disabled' => 'disabled', 'class' => 'form-control')); ?>
						</div>
					</div>
				</div>
				<?php endif; ?>
				<div class="form-group">
					<?php echo $form->labelEx($model, 'start_time', array('class' => 'col-sm-3 control-label ')); ?>
					<div class="col-sm-6">
						<?php $model->start_time = date('m.d.Y', $model->start_time); ?>
						<?php echo $form->textField($model, 'start_time', array('disabled' => 'disabled', 'class' => 'form-control')); ?>
					</div>
				</div>
				<div class="form-group">
					<?php echo $form->labelEx($model, 'end_time', array('class' => 'col-sm-3 control-label ')); ?>
					<div class="col-sm-6">
						<?php $model->end_time = date('m.d.Y', $model->end_time); ?>
						<?php echo $form->textField($model, 'end_time', array('disabled' => 'disabled', 'class' => 'form-control')); ?>
					</div>
				</div>
				<?php endif; ?>
				
				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-6 col-sm-offset-3">
							<div class="btn-toolbar">
								<?php echo CHtml::submitButton(Yii::t('Admin', 'Authorise'), array('class' => 'btn-primary btn')); ?>
                                <?php echo CHtml::submitButton(Yii::t('Admin', 'Reject'), array('class' => 'btn-danger btn')); ?>

							</div>
						</div>
					</div>
				</div>

				<?php $this->endWidget(); ?>
			</div>
		</div>
	</div>
</div>
