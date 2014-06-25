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
        <div class="popup-register-form" id="popup-auth-form">
            <div class="form-line">
                <div class="form-block">
                    <div class="form-lbl">
                        <?= $model->getAttributeLabel('email') ?>
                        <span class="tooltip-icon " title="[Enter your Username or E-Mail]"></span>
                    </div>
                    <div class="form-input">
                        <?= $form->textField($model, 'email', array('autocomplete' => 'off')); ?>
                        <span class="validation-icon"></span>
                    </div>
                    <div class="form-alert">
                        <?= $form->error($model, 'email'); ?>
                    </div>
                </div>
                <div class="form-block">
                    <div class="form-lbl">
                        <?= $model->getAttributeLabel('phone') ?>
                        <span class="tooltip-icon " title="[Enter password from your account]"></span>
                    </div>
                    <div class="form-input">
                        <?= $form->textField($model, 'phone', array('autocomplete' => 'off')); ?>
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
                        <?= $model->getAttributeLabel('login') ?>
                        <span class="tooltip-icon " title="[Enter your Username or E-Mail]"></span>
                    </div>
                    <div class="form-input">
                        <?= $form->textField($model, 'login', array('autocomplete' => 'off')); ?>
                        <span class="validation-icon"></span>
                    </div>
                    <div class="form-alert">
                        <?= $form->error($model, 'login'); ?>
                    </div>
                </div>
                <div class="form-block">
                    <div class="form-lbl">
                        <?= $model->getAttributeLabel('role') ?>
                        <span class="tooltip-icon " title="[Enter password from your account]"></span>
                    </div>
                    <div class="form-input">
                        <div class="select-custom select-type">
                            <span><?=Yii::t('Front', 'Private Individual')?></span>
                            <?= $form->dropDownList($model,'role',array('1'=>Yii::t('Front', 'Private Individual'),'2'=>Yii::t('Front', 'Company')), array('class'=>'select-invisible')); ?>

                        </div>
                    </div>
                    <div class="form-alert">
                        <?= $form->error($model, 'role'); ?>
                    </div>
                </div>
                <div class="form-block"></div>
            </div>
            <div class="clear"></div>
            <div class="form-line-submit">
                <input type="submit" class="popup-register-submit" value="<?= Yii::t('Front', 'Open an account'); ?>"/>
            </div>
            <div class="register-forgot-row">
                <div class="terms-check">
                    <input type="checkbox"/> <?= CHtml::link(Yii::t('Front', 'I read and agree to the terms & conditions'), array('/terms', 'language' => Yii::app()->language)); ?>
                </div>

                <div class="change-phone-cont login-cont">
                    <?= Yii::t('Front', 'Already have an account?'); ?> <?= CHtml::link(Yii::t('Front', 'Log in'), array('/login', 'language' => Yii::app()->language)); ?>
                </div>
            </div>
        </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>

</div>