<div class="popup-register-cont">
			

                    <div class="popup-register-block">

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
					<div class="popup-register-header"><?= Yii::t('Front', 'Bank account application form'); ?></div>
<?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'registration-from',
            'enableAjaxValidation'=>true,
            'enableClientValidation'=>true,
            //'focus'=>array($model,'first_name'),
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
				'validateOnChange'=>true,
				'errorCssClass'=>'input-error',
				'afterValidate' => 'js:function(form, data, hasError) {
					form.find("input").removeClass("input-error");
					form.find(".validation-icon").show();
					if(hasError) {
						for(var i in data) {
							$("#"+i).addClass("input-error");
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
						$("#"+attribute.id).addClass("input-error");
						$("#"+attribute.id).next(".validation-icon").show();
					} else {
						$("#"+attribute.id).removeClass("input-error"); 
						$("#"+attribute.id).next(".validation-icon").show();
					}
				}'
			),
)); ?>

        <div class="popup-register-form" id="popup-register-form">
			<div class="form-line">
				<div class="form-block">
					<div class="form-lbl"><?= $model->getAttributeLabel('first_name') ?> <span class="tooltip-icon " title="<?= Yii::t('Front', 'Add Your first name using latin alphabet'); ?>"></span></div>
					<div class="form-input">
						<?= $form->textField($model, 'first_name', array('autocomplete' => 'off')); ?>
						<span class="validation-icon"></span>
					</div>
					<div class="form-alert">
						<?= $form->error($model, 'first_name'); ?>
					</div>
				</div>
				<div class="form-block">
					<div class="form-lbl"><?= $model->getAttributeLabel('last_name') ?> <span class="tooltip-icon " title="<?= Yii::t('Front', 'Add Your last name using latin alphabet'); ?>"></span></div>
					<div class="form-input">
						<?= $form->textField($model, 'last_name', array('autocomplete' => 'off')); ?>
						<span class="validation-icon"></span>
					</div>
					<div class="form-alert">
						<?= $form->error($model, 'last_name'); ?>
					</div>
				</div>
				<div class="form-block"></div>
			</div>
			<div class="clear"></div>
			<div class="form-line">
				<div class="form-block">
					<div class="form-lbl"><?= $model->getAttributeLabel('phone') ?> <span class="tooltip-icon" title="<?= Yii::t('Front', 'Add Your mobile phone in an international format (e.g. +3100000000)'); ?>"></span></div>
					<div class="form-input">
						<?= $form->textField($model, 'phone', array('autocomplete' => 'off')); ?>
						<span class="validation-icon"></span>
					</div>
					<div class="form-alert">
						<?= $form->error($model, 'phone'); ?>
					</div>
				</div>
				<div class="form-block">
					<div class="form-lbl"><?= $model->getAttributeLabel('email') ?> <span class="tooltip-icon" title="<?= Yii::t('Front', 'Add Your E-Mail that you will use to access online banking'); ?>"></span></div>
					<div class="form-input">
						<?= $form->textField($model, 'email', array('autocomplete' => 'off')); ?>
						<span class="validation-icon"></span>
					</div>
					<div class="form-alert">
						<?= $form->error($model, 'email'); ?>
					</div>
				</div>
				<div class="form-block"></div>
			</div>
			<div class="clear"></div>
			<div class="form-line-submit">
				<input type="submit" class="popup-register-submit" value="<?= Yii::t('Front', 'Open an account'); ?>"/>
			</div>
		</div>

<?php $this->endWidget(); ?>
		<div class="popup-register-agreement">
                            <a target="_blank" href="<?= Yii::app()->createUrl('site/terms') ?>"><?= Yii::t('Front', 'I read and agree to the terms & conditions'); ?></a>
                        </div>

                        <div class="popup-register-login"> 
                            <?= Yii::t('Front', 'Already have an account?'); ?>
                            <a href="<?= Yii::app()->createUrl('/site/login') ?>"><?= Yii::t('Front', 'Log in'); ?></a>
                        </div>
	</div>
</div>