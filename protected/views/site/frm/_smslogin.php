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
						'id'=>'sms-login',
						'enableAjaxValidation'=>true,
						'enableClientValidation'=>true,
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

					<div class="popup-register-form sms-form" id="popup-auth-form">
						<div class="form-line">
							<div class="form-block">
								<div class="form-lbl"><?= $model->getAttributeLabel('userId') ?> <span class="tooltip-icon " title="<?= Yii::t('Front', 'Enter your UserID'); ?>"></span></div>
								<div class="form-input">
									<?= $form->textField($model, 'userId', array('class' => 'remind')); ?>
									<span class="validation-icon"></span>
								</div>
								<div class="form-alert">
									<?= $form->error($model, 'userId'); ?>
								</div>
							</div>
							<div class="form-block"></div>
						</div>
						<div class="clear"></div>
						<div class="form-line-submit">
							<input type="submit" class="popup-register-submit" value="<?= Yii::t('Front', 'Login'); ?>"/>
						</div>
                        <div class="register-forgot-row">
                            <a href="/remind" class="cant-access">I cannot access my account</a>

                            <div class="change-phone-cont">
                                <a href="/account"  class="dont-have">I do not have an account yet. Open an account</a>
                            </div>
                        </div>
					</div>
			<?php $this->endWidget(); ?>
	</div>

</div>