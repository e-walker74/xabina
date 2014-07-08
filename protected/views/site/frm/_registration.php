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
                    'validationDelay'=>0,
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
                        <span class="tooltip-icon " title="<?= Yii::t('Front', 'Enter your E-mail'); ?>"></span>
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
                        <span class="tooltip-icon " title="<?= Yii::t('Front', 'Enter your phone'); ?>"></span>
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
                        <?= $model->getAttributeLabel('login') ?>
                        <span class="tooltip-icon " title="<?= Yii::t('Front', 'Enter your User ID'); ?>"></span>
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
                        <span class="tooltip-icon " title="<?= Yii::t('Front', 'Enter your role'); ?>"></span>
                    </div>
                    <div class="form-input">
                        <div class="dropdown select-type-dropdown">
                            <?=$form->hiddenField($model, 'role', array('value' => $model->role?$model->role:'1'))?>
                            <a data-toggle="dropdown" class="select-type" href="#"><?=Yii::t('Front', 'Private Individual')?></a>
                            <ul class="dropdown-menu" role="menu">
                                <li data-id="1"><?=Yii::t('Front', 'Private Individual')?></li>
                                <li data-id="2"><?=Yii::t('Front', 'Company')?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-alert">
                        <?= $form->error($model, 'role'); ?>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="form-block" style="margin: 0; float: none">
                    <div class="terms-check">
                        <div class="checkbox-custom">
                            <label class="checked">
                                <?= $form->checkbox($model, 'terms', array('checked' => 'checked')); ?>
                            </label>
                        </div>
                        <?=Yii::t('Front', 'I read and agree to')?>  <?= CHtml::link(Yii::t('Front', 'the terms & conditions'), array('/terms', 'language' => Yii::app()->language), array('target'=>'_blank')); ?>
                        <div class="form-alert">
                            <div class="errorMessage"><?= $form->error($model, 'terms'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="form-line-submit">
                <input type="submit" class="popup-register-submit" value="<?= Yii::t('Front', 'Open an account'); ?>"/>
            </div>
             <div class="register-forgot-row" style="margin: 0">
                <div class="change-phone-cont login-cont">
                    <?=Yii::t('Front', 'Already have an account?')?> <?= CHtml::link(Yii::t('Front', 'Log in'), array('/site/SMSLogin'), array('class'=>'login-link')); ?>
                </div>
            </div>
        </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>

</div>