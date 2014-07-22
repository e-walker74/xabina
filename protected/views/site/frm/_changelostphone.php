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
    <div class="popup-register-header"><?= Yii::t('Front', 'Bank account change phone form'); ?></div>
    <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'sms-change-phone',
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
        <div class="popup-register-form" id="popup-auth-form">
            <div class="form-line">
                <div class="form-block">
                    <div class="form-lbl">
                        <?= $user->getAttributeLabel('email') ?>
                        <span class="tooltip-icon " title="<?= Yii::t('Front', 'Enter your E-Mail'); ?>"></span>
                    </div>
                    <div class="form-input success">
                        <?= $form->passwordField($user, 'email', array('disabled' => 'disabled')); ?>
                        <span class="validation-icon" style="display: inline;"></span>
                    </div>
                    <div class="form-alert">
                        <?= $form->error($user, 'email'); ?>
                    </div>
                </div>
                <div class="form-block">
                    <div class="form-lbl">
                        <?= $model->getAttributeLabel('phone') ?>
                        <span class="tooltip-icon " title="<?= Yii::t('Front', 'Enter your password'); ?>"></span>
                    </div>
                    <div class="form-input">
                        <?= $form->textField($model, 'phone', array('autocomplete' => 'off', 'phonefield' => 'true')); ?>
                        <span class="validation-icon"></span>
                    </div>
                    <div class="form-alert">
                       <?= $form->error($model, 'phone'); ?>
                    </div>
                </div>
                <div class="form-block"></div>
            </div>
            <div class="clear"></div>
            <div class="form-line">
                <div class="form-block">
                    <div class="form-lbl">
                        <?= $user->getAttributeLabel('login') ?>
                        <span class="tooltip-icon " title="<?= Yii::t('Front', 'Enter your login'); ?>"></span>
                    </div>
                    <div class="form-input success">
                        <?= $form->passwordField($user, 'login', array('disabled' => 'disabled')); ?>
                        <span class="validation-icon" style="display: inline;"></span>
                    </div>
                    <div class="form-alert">
                        <?= $form->error($user, 'login'); ?>
                    </div>
                </div>
                <div class="form-block">
                    <div class="form-lbl">
                        <?= $user->getAttributeLabel('role') ?>
                        <span class="tooltip-icon " title="<?= Yii::t('Front', 'Change role for your account'); ?>"></span>
                    </div>
                    <div class="form-input success">
                        <div class="dropdown select-type-dropdown disabled">
                            <a  class="select-type" href="#"><?=Yii::t('Front', 'Private Individual')?></a>

                        </div>
                    </div>
                    <div class="form-alert">
                        <?= $form->error($user, 'role'); ?>
                    </div>
                </div>
                <div class="form-block"></div>
            </div>
            <div class="clear"></div>
            <div class="form-line-submit">
                <input type="submit" class="popup-register-submit" value="<?= Yii::t('Front', 'Change phone'); ?>"/>
            </div>
             <div class="register-forgot-row">
                <div class="change-phone-cont login-cont">
                    <?= CHtml::link(Yii::t('Front', 'Log in'), array('/site/SMSLogin'), array('class'=>'login-link')); ?>
                </div>
            </div>
        </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>

</div>