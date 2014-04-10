
	<a href="index.php"><img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/main_logo.png" alt="Logo" class="brand" /></a>
	<div class="panel panel-primary">
		<div class="panel-body">
			<h4 class="text-center" style="margin-bottom: 25px;">Log in to get started</h4>
				<?php $form=$this->beginWidget('CActiveForm', array(
                                'id'=>'login-from',
                                //'action' => Yii::app()->request->url,
                                'htmlOptions' => array('class' => 'form-horizontal'),
                                'enableAjaxValidation'=>true,
                                'enableClientValidation'=>true,
                                'focus'=>array($model,'login'),
                                'clientOptions'=>array(
                                      'validateOnSubmit'=>true,
                                      'afterValidate' => 'js:function(form, data, hasError) {
                                          if(hasError) {
                                              for(var i in data) {
                                                $("#"+i).addClass("input-error");
                                                $("#"+i).next(".validation-icon").show();
                                              }
                                              return false;
                                          }
                                          else {
                                              form.find("input").removeClass("input-error");
                                              return true;
                                          }
                                      }',
                                'afterValidateAttribute' => 'js:function(form, attribute, data, hasError) {
                                   if(hasError) {$("#"+attribute.id).addClass("input-error");$("#"+attribute.id).next(".validation-icon").show();}
                                   else {$("#"+attribute.id).removeClass("input-error"); $("#"+attribute.id).next(".validation-icon").show();}
                                  }'
                                ),
                    )); ?>
					<div class="form-group">
                        <label for="Admin_Form_Login_login" class="control-label col-sm-4" style="text-align: left;"><?= $model->getAttributeLabel('login') ?></label>
						<div class="col-sm-8">
                            <?= $form->textField($model, 'login', array('class' => 'form-control', 'placeholder' => 'Login')); ?>
                            <?= $form->error($model, 'login'); ?>
                        </div>
					</div>
					<div class="form-group">
						<label for="password" class="control-label col-sm-4" style="text-align: left;"><?= $model->getAttributeLabel('password') ?></label>
						<div class="col-sm-8">
                            <?= $form->passwordField($model, 'password', array('class' => 'form-control', 'placeholder' => 'Password')); ?>
                            <?= $form->error($model, 'password'); ?>
                        </div>
					</div>
					<div class="clearfix">
						<!--<div class="pull-right"><label><input type="checkbox" checked> Remember Me</label></div>-->
					</div>
                    <input type="submit" class="btn btn-primary btn-block" value="<?= Yii::t('Front', 'Login'); ?>"/>
				<?php $this->endWidget(); ?>
		</div>
		<div class="panel-footer">
			<!--<a href="extras-forgotpassword.php" class="pull-left btn btn-link" style="padding-left:0">Forgot password?</a>-->

			<div class="pull-right">
				<a href="javascript:document.r.reset();void(0);" class="btn btn-default">Reset</a>
			</div>
		</div>
	</div>
