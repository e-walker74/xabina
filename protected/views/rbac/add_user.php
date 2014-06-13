<div class="col-lg-9 col-md-9 col-sm-9" >
    <div class="h1-header"><?= Yii::t('Front', 'Аdding a new user') ?></div>
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id'=>'add-user-form',
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'action' => Yii::app()->createUrl('rbac/addUser'),
        'method' => 'post',
        'errorMessageCssClass' => 'error-message',
        'htmlOptions' => array(
            'class' => 'form-validable',
        ),
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
            'validateOnChange'=>true,
            'errorCssClass'=>'input-error',
            'afterValidate' => 'js:RBAC.afterValidate',
            'afterValidateAttribute' => 'js:RBAC.afterValidateAttribute'
        ),
    )); ?>
    <?php if($addUserForm->role): ?>
        <?= $form->hiddenField($addUserForm, 'access_id'); ?>
    <?php endif; ?>
    <div class="role-form xabina-form-container">
        <div class="account-selection" >
            <span class="select-lbl pull-left"><?= Yii::t('Front', 'Account'); ?></span>
            <div class="select-custom account-select pull-right" style="width: 92%!important">
                <span class="select-custom-label"></span>
                <select name="RbacAddUserForm[account]" class=" select-invisible">
                    <?php foreach($accounts as $acc): ?>
                    <option <?php if($acc->id == $addUserForm->account): ?>selected<?php endif; ?>
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
                    <?= $form->textField($addUserForm, 'user', array('autocomplete' => 'off', 'class'=>'input-text')); ?>
                    <span class="validation-icon" style="display: none;"></span>
                    <?= $form->error($addUserForm, 'user'); ?>
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
                        <?= $form->dropDownList(
                            $addUserForm,
                            'role',
                            CHtml::listData($roles, 'id', 'name'),
                            array(
                                'class' => 'country-select select-role-type select-invisible',
                                'empty' =>Yii::t('Front', 'Select'),
                                'data-url' => Yii::app()->createUrl('ajax/getRoleRights'),
                            )
                        ); ?>
                    </div>
                    <?php  echo $form->error($addUserForm, 'role', array('style' => 'display:none;')); ?>
                </div>
            </div>
        </div>
        
        <div class="details-accordion role-details">
            <div class="accordion-header"><a href="#"><?= Yii::t('Front', 'Details') ?></a></div>
            <div class="accordion-content">
                <?php $this->widget('AccessRightsTree', array('rightsTree' => $rightsTree));?>
            </div>            
        </div>
        <?php if($addUserForm->hasErrors('rights')):?>
            <div class="error-message" style="display: block;"> <?php echo $addUserForm->getError('rights') ?><div class="error-message-arr"></div></div>
        <?php endif;?>
            
        <div class="form-submit">
            <input class="rounded-buttons save" type="submit" value="Save"/>
        </div>
    </div>
    <?php $this->endWidget(); ?></form>
</div>

<script>
    RBAC.addRolePage().bindCheckRoleRights()

    <?php if($addUserForm->role): ?>
    RBAC.getUserAccessRights('<?= Yii::app()->createUrl('ajax/getUserRights') ?>')
    <?php endif; ?>
</script>
