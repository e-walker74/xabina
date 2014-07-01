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
    <div class="popup-register-header"><?= Yii::t('Front', 'Change lost phone'); ?></div>
    <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'registration-from',

            )); ?>
        <div class="popup-register-form" id="popup-auth-form">
            <div class="form-line">
                <div class="form-block">
                    <div class="form-lbl">
                        <?= $model->getAttributeLabel('email') ?>
                        <span class="tooltip-icon " title="<?= Yii::t('Front', 'Enter your E-Mail'); ?>"></span>
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
                        <span class="tooltip-icon " title="<?= Yii::t('Front', 'Enter your password'); ?>"></span>
                    </div>
                    <div class="form-input">
                        <?= $form->textField($model, 'phone', array('autocomplete' => 'off')); ?>
                        <span class="validation-icon"></span>
                    </div>
                    <div class="form-alert">
                       <?= $form->error($model, 'phone'); ?>
                    </div>
                </div>
            </div>

            <div class="clear"></div>
            <div class="form-line-submit">
                <input type="submit" class="popup-register-submit" value="<?= Yii::t('Front', 'Confirm'); ?>"/>
            </div>
            <div class="register-forgot-row">
                <div class="form-alert">
                    <?= $form->error($model, 'userId'); ?>
                </div>
            </div>
        </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>

</div>