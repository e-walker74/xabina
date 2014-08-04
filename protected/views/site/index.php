<div class="popup-login">
    <a href="<?= Yii::app()->createUrl('site/registration') ?>" class="popup-btn-wrapper open-account">
        <div class="popup-btn">
            <div class="img"></div>
            <div class="text"><?= Yii::t('Front', 'Open Account'); ?></div>
        </div>
    </a>
    <a href="<?= Yii::app()->createUrl('/site/login') ?>" class="popup-btn-wrapper account-login">
        <div class="popup-btn">
            <div class="img"></div>
            <div class="text"><?= Yii::t('Front', 'Account Login'); ?></div>
        </div>
    </a>
</div>