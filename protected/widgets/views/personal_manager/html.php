<? if($manager): ?>
<script type="text/javascript" src="/js/manager_widget.js"></script>
<div class="personal-manager-widget">
    <div class="transfer-accordion xabina-accordion xabina-transfer-accordion" id="manager-accordion" >
        <div class="accordion-header"><a href="#" class="search-acc"><b><?= Yii::t('Front', 'Your own manager') ?></b></a></div>
        <div class="accordion-content">
            <div class="manager-top-content">
                <img src="/images/manager.png" alt=""/>
                <b><?=$manager->manager_name?></b>
                <i><?= Yii::t('Front', 'Recruiter Accountancy') ?></i>
            </div>
            <div class="manager-bottom-content">
                <div class="manager-mobile"><?=$manager->phone?></div>
                <div class="manager-email"><a href="mailto:<?=$manager->email?>"><?=$manager->email?></a></div>
                <div class="manager-social"><a href="#">connect met Madelon <br>
                        op Twitter</a></div>
                <div class="form-submit"><a href="#" class="rounded-buttons upload comments"><?= Yii::t('Front', 'Send a Message') ?></a></div>
            </div>

        </div>
    </div>
</div>
<? endif ?>