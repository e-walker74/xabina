<div class="col-lg-9 col-md-9 col-sm-9" >
    <div class="h1-header"><?= Yii::t('Front', 'Аdding a new user') ?></div>
    <form action="<?=Yii::app()->createUrl('rbac/addUser'); ?>" method="post">
    <div class="role-form xabina-form-container">
        <div class="account-selection" >
            <span class="select-lbl pull-left"><?= Yii::t('Front', 'Account'); ?></span>
            <div class="select-custom account-select pull-right" style="width: 92%!important">
                <span class="select-custom-label">
                    <?php $this->widget('AccountInfo', array('account' => $selectedAcc));?>
                </span>
                <select name="data[account]" class=" select-invisible">
                    <?php foreach($accounts as $acc): ?>
                    <option <?php if($acc->number == $selectedAcc->number): ?>selected<?php endif; ?> 
                            value="<?= $acc->number ?>">
                        <?php $this->widget('AccountInfo', array('account' => $acc));?>
                    </option>
                    <?php endforeach; ?>                    
                </select>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5">
                <div class="field-lbl">
                    <?= Yii::t('Front', 'User (ID)'); ?>
                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'user_id_tooltip'); ?>"></span>
                </div>
                <div class="field-input">
                    <input  name="data[user]" class="input-text jquery-live-validation-on <?php /*input-error" */?> type="text">
                    <?php /*<span class="validation-icon" style="display: inline;"></span>*/?>
                    <?php /*<div class="error-message" style="display: block;">
                        User Id is incorrect
                        <div class="error-message-arr"></div>
                    </div>*/?>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-7">
                <div class="field-lbl">
                    <?= Yii::t('Front', 'Role') ?>
                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'Role: (Choose the role from the drop-down menu)'); ?>"></span>
                </div>
                <div class="field-input">
                    <div class="select-custom">
                        <span class="select-custom-label"><?= Yii::t('Front', 'Select') ?></span>
                        <?= CHtml::dropDownList(
                            'data[role]',
                            '',
                            CHtml::listData($roles, 'id', 'name'),
                            array(
                                'empty' =>Yii::t('Front', 'Select'),
                                'class' => 'country-select select-role-type select-invisible',
                                'data-url' => Yii::app()->createUrl('ajax/getRoleRights'),
                            )
                        )?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="details-accordion role-details">
            <div class="accordion-header"><a href="#"><?= Yii::t('Front', 'Details') ?></a></div>
            <div class="accordion-content">
                <?php $this->widget('AccessRightsTree', array('rightsTree' => $rightsTree));?>
            </div>            
        </div>
        
        <div class="form-submit">
            <input class="rounded-buttons save" type="submit" value="Save"/>
        </div>
    </div>
    </form>
</div>

<script>
    RBACK.addRolePage()
</script>