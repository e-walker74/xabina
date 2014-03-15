<div class="popup-register-cont">
			

                    <div class="popup-register-block auth">

					<div class="popup-language-menu"  style="background-color: rgba(237, 239, 238, 1)">
                        <div class="language-current"><a class="en" href="#">English</a></div>
                        <ul class="language-list">
                            <li class="ch" ><a href="#">Chinese</a></li>
                            <li class="du" ><a href="#">Dutch</a></li>
                            <li class="ge" ><a href="#">German</a></li>
                            <li class="fr" ><a href="#">French</a></li>
                            <li class="ru" ><a href="#">Russian</a></li>
                        </ul>
                    </div>
					<div class="shadow_blocker"></div>

                        <div class="popup-register-header"><?= Yii::t('Front', 'Account login') ?></div>
							<?php $form=$this->beginWidget('CActiveForm', array(
										'id'=>'login-from',
										'enableAjaxValidation'=>false,
										'enableClientValidation'=>false,
										'focus'=>array($model,'first_name'),
										'enableAjaxValidation'=>true,
										'enableClientValidation'=>true,
										'focus'=>array($model,'first_name'),
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

									<div class="popup-register-form" id="popup-auth-form">
										<div class="form-line">
											<div class="form-block">
												<div class="form-lbl"><?= $model->getAttributeLabel('login') ?> <span class="tooltip-icon " title="<?= Yii::t('Front', '[login form LOGIN OR EMAIL]'); ?>"></span></div>
												<div class="form-input">
													<?= $form->textField($model, 'login'); ?>
													<span class="validation-icon"></span>
												</div>
												<div class="form-alert">
													<?= $form->error($model, 'login'); ?>
												</div>
											</div>
											<div class="form-block">
												<div class="form-lbl"><?= $model->getAttributeLabel('password') ?> <span class="tooltip-icon " title="<?= Yii::t('Front', '[login form PASSWORD]'); ?>"></span></div>
												<div class="form-input">
													<?= $form->passwordField($model, 'password', array('autocomplete' => 'off')); ?>
													<span class="validation-icon"></span>
												</div>
												<div class="form-alert">
													<?= $form->error($model, 'password'); ?>
												</div>
											</div>
											<div class="form-block"></div>
										</div>
										<div class="clear"></div>
										<div class="form-line-submit">
											<input type="submit" class="popup-register-submit" value="<?= Yii::t('Front', 'Login'); ?>"/>
										</div>
									</div>
							<?php $this->endWidget(); ?>
                    </div>

                </div>