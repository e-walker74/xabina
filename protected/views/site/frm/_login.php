<div class="popup-register-cont">


                    <div class="popup-register-block auth">

					<div class="popup-language-menu"  style="background-color: rgba(237, 239, 238, 1)">
                        <div class="language-current"><a class="<?= Yii::app()->language ?>" href="#"><?= Yii::app()->params->translatedLanguages[Yii::app()->language] ?></a></div>
                        <ul class="language-list">
							<?php foreach(Yii::app()->params->translatedLanguages as $label => $translate): ?>
								<?php if($label == Yii::app()->language) continue; ?>
								<li class="<?= $label ?>" >
									<?= CHtml::link($translate, array(Yii::app()->request->url, 'language' => $label)); ?>
								</li>
							<?php endforeach; ?>
                        </ul>
                    </div>
					<div class="shadow_blocker"></div>

                        <div class="popup-register-header"><?= Yii::t('Front', 'Account login') ?></div>
							<?php $form=$this->beginWidget('CActiveForm', array(
										'id'=>'login-from',
										//'action' => Yii::app()->request->url,
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
                                        <div class="register-forgot-row">
                                            <a href="<?= Yii::app()->createUrl('/site/registration') ?>"><?= Yii::t('Front', 'Open an account'); ?></a>
                                            /
                                            <a href="<?= Yii::app()->createUrl('/site/remind') ?>"><?= Yii::t('Front', 'Lost Password?'); ?></a>
                                        </div>
									</div>
							<?php $this->endWidget(); ?>
                    </div>

                </div>