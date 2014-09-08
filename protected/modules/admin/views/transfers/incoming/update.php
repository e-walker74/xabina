<div id="wrap">
	<div id="page-heading">
		<h1><?= Yii::t('Users', 'Update transfer') ?></h1>
	</div>

	<div class="container">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><?= Yii::t('Users', 'Update Incoming Transfer') ?></h4>
				<div class="options">   
					<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
				</div>
			</div>
			<div class="panel-body collapse in">
				<?php
					$form = $this->beginWidget('CActiveForm', array(
						'id' => 'transfer-form',
						'action' => array('/admin/transfers/authoriseinc', 'id' => $model->id),
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
				
				<?php if($model->electronic_method == 1): //creditcard ?>
				<div class="form-group">
					<?php echo $form->labelEx($model, 'from_account_number', array('class' => 'col-sm-3 control-label ')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model, 'from_account_number', array('disabled' => 'disabled', 'maxlength' => 12, 'class' => 'form-control')); ?>
					</div>
					<div class="col-sm-3">
						<img src="/images/<?= isset(Transfers_Incoming::$card_types[$model->card_type]) ? Transfers_Incoming::$card_types[$model->card_type] : "" ?>.png" alt=""/>
					</div>
				</div>
				<div class="form-group">
					<?php echo $form->labelEx($model, 'from_account_holder', array('class' => 'col-sm-3 control-label ')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model, 'from_account_holder', array('disabled' => 'disabled', 'maxlength' => 12, 'class' => 'form-control')); ?>
					</div>
				</div>
				<div class="form-group">
					<?php echo $form->labelEx($model, 'p_month', array('class' => 'col-sm-3 control-label ')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model, 'p_month', array('disabled' => 'disabled', 'maxlength' => 12, 'class' => 'form-control')); ?>
					</div>
				</div>
				<div class="form-group">
					<?php echo $form->labelEx($model, 'p_year', array('class' => 'col-sm-3 control-label ')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model, 'p_year', array('disabled' => 'disabled', 'maxlength' => 12, 'class' => 'form-control')); ?>
					</div>
				</div>
				<div class="form-group">
					<?php echo $form->labelEx($model, 'p_csc', array('class' => 'col-sm-3 control-label ')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model, 'p_csc', array('disabled' => 'disabled', 'maxlength' => 12, 'class' => 'form-control')); ?>
					</div>
				</div>
				<?php elseif($model->electronic_method == 2): //ideal ?>
				<div class="form-group">
					<?php echo $form->labelEx($model, 'from_account_number', array('class' => 'col-sm-3 control-label ')); ?>
					<div class="col-sm-6">
						<?php echo $form->textField($model, 'from_account_number', array('disabled' => 'disabled', 'maxlength' => 12, 'class' => 'form-control')); ?>
					</div>
				</div>
				<?php endif; ?>

                <div class="form-group">
                    <?php echo $form->labelEx($info, 'sender', array('class' => 'col-sm-3 control-label ')); ?>
                    <div class="col-sm-6">
                        <?php echo $form->textField($info, 'sender', array('class' => 'form-control')); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($info, 'recipient', array('class' => 'col-sm-3 control-label ')); ?>
                    <div class="col-sm-6">
                        <?php echo $form->textField($info, 'recipient', array('class' => 'form-control')); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-3 control-label ')); ?>
                    <div class="col-sm-6">
                        <?php echo $form->dropDownList($model, 'status', array(
                            Transfers_Outgoing::STATUS_PENDING => 'pending',
                            Transfers_Outgoing::STATUS_APPROVED => 'approved',
                            Transfers_Outgoing::STATUS_REJECTED => 'rejected',
                        ), array('class' => 'form-control')); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($info, 'status_comment', array('class' => 'col-sm-3 control-label ')); ?>
                    <div class="col-sm-6">
                        <?php echo $form->textField($info, 'status_comment', array('class' => 'form-control')); ?>
                    </div>
                </div>
				
				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-6 col-sm-offset-3">
							<div class="btn-toolbar">
								<?php echo CHtml::submitButton(Yii::t('Admin', 'Save'), array('class' => 'btn-primary btn')); ?>
							</div>
						</div>
					</div>
				</div>

				<?php $this->endWidget(); ?>
			</div>
		</div>
	</div>
</div>
