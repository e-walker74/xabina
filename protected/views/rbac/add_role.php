<?php $form = $this->beginWidget('CActiveForm', array(
    'id'=>'add-role-form',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    'action' => Yii::app()->createUrl('rbac/addRole'),
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
<?= $form->hiddenField($role, 'id'); ?>
<div class="col-lg-9 col-md-9 col-sm-9" >
    <div class="h1-header">
        <?= ($role->isNewRecord) ? Yii::t('Front', 'Add a new role') : Yii::t('Front', 'Update Role') ?>
    </div>
    <div class="role-form xabina-form-container">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5">
                <div class="field-lbl">
                    <?= Yii::t('Front', 'Role Name') ?>
                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'role_name_tooltip') ?>"></span>
                </div>
                <div class="field-input">
                    <?= $form->textField($role, 'name', array('autocomplete' => 'off','class'=>'input-text')); ?>
                    <span class="validation-icon" style="display: none;"></span>
                    <?= $form->error($role, 'name'); ?>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-7">
                <div class="field-lbl">
                    <?= Yii::t('Front', 'Base role') ?>
                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'base_role_tooltip') ?>"></span>
                </div>
                <div class="field-input">
                    <div class="select-custom">
                        <span class="select-custom-label"></span>
                        <?= $form->dropDownList(
                            $role,
                            'parent_id',
                            CHtml::listData($roles, 'id', 'name'),
                            array(
                                'class' => 'country-select select-role-type select-invisible',
                                'empty' =>Yii::t('Front', 'Select'),
                                'data-url' => Yii::app()->createUrl('ajax/getRoleRights'),
                            )
                        ); ?>
                    </div>
                    <?php /*
                    <div class="error-message" style="display: block;">error  <div class="error-message-arr"></div></div>
                     * 
                     */?>
                </div>
            </div>
        </div>
        <?php $this->widget('AccessRightsTree', array('rightsTree' => $rightsTree));?>
        <?= $form->hiddenField($role, 'rightsArr'); ?>
        <?= $form->error($role, 'rightsArr'); ?>
        <?php if(isset($rightsError)):?>
            <div class="error-message" style="display: block;"> <?php echo $rightsError ?><div class="error-message-arr"></div></div>
        <?php endif;?>
        <div class="form-submit">
            <input class="rounded-buttons save" type="submit" value="Save"/>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<script>
    RBAC.addRolePage().bindCheckRoleRights()
    <?php if(!$role->isNewRecord): ?>
        RBAC.getRoleRigths(<?= $role->id ?>)
    <?php endif; ?>
</script>