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
                        <div class="popup-register-header"><?= Yii::t('Front', 'Password reset') ?></div>
							<?php $form=$this->beginWidget('CActiveForm', array(
										'id'=>'remind-from',
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
                                    <div class="popup-register-form forgot-form" id="popup-auth-form">

                                        <ul class="form-list">
                                            <li>
                                                <a href="?type=email"><?= Yii::t('Front', 'I know my E-Mail') ?></a>
                                            </li>
                                            <li>
                                                <a href="?type=phone"><?= Yii::t('Front', 'I know my Phone') ?></a>
                                            </li>
                                            <li>
                                                <a href="?type=login"><?= Yii::t('Front', 'I know my User ID') ?></a>
                                            </li>
                                            <li>
                                                <a href="?"><?= Yii::t('Front', 'I forgot my User ID, E-mail and/or phone number, but I rember my name') ?></a>
                                            </li>
                                        </ul>
                                        <div class="form-line-submit">
                                            <input type="submit" class="popup-register-submit" value="<?= Yii::t('Front', 'Next'); ?>"/>
                                        </div>
                                    </div>
							<?php $this->endWidget(); ?>
                    </div>

                </div>