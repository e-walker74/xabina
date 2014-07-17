<div class="popup-register-cont">
    <div class="popup-register-block success">
        <div class="popup-register-header">
            <?= Yii::t('Front', 'Dear client'); ?>
        </div>
        <div class="success-ico"></div>
        <div class="congratulations-msg">
            <?= Yii::t('Front', 'You have entered the wrong SMS-code 3 times. Your profile has been temporarily blocked for 1 hour. Please check Your E-Mail in order to restore access to Your account.<br/>'); ?>
            <a class="send-again" onclick="resendLoginEmail('<?= Yii::t('Front', 'SMS was sent') ?>', '<?= Yii::app()->createUrl('/site/resendBlockEmail') ?>')" href="javaScript:void(0)"><?= Yii::t('Front', 'Send E-mail again.') ?></a>

        </div>
    </div>
</div>

