<div class="popup-register-cont">
    <div class="popup-register-block success">
        <div class="popup-register-header">
            <?= Yii::t('Front', 'Success'); ?>
        </div>
        <div class="success-ico"></div>
        <div class="congratulations-msg">
            <?= Yii::t('Front', 'Dear client, Your account unblocked. You can now'); ?><?= CHtml::link(Yii::t('Front', 'Log in'), array('/site/SMSLogin'), array('class'=>'login-link')); ?>
        </div>
    </div>
</div>

