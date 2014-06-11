<div class="popup-register-cont">
    <div class="popup-register-block success">
        <div class="popup-register-header">
            <?= Yii::t('Front', 'disclaimer_head!'); ?>
        </div>
        <div class="success-ico"></div>
        <div class="congratulations-msg">
            <?= Yii::t('Front', 'disclaimer_text :url', array(
				':url' => '<a href="' . urldecode(Yii::app()->request->getParam('tourl')) . '">' . urldecode(Yii::app()->request->getParam('tourl')) . '</a>'
			)); ?>
        </div>
    </div>
</div>

