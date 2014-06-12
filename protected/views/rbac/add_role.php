<form action="<?php echo Yii::app()->createUrl('rbac/addRole'); ?>" method="post">
<div class="col-lg-9 col-md-9 col-sm-9" >
    <div class="h1-header">Add a new role</div>
    <div class="role-form xabina-form-container">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5">
                <div class="field-lbl">
                    Role Name
                    <span class="tooltip-icon" title="Add Your mobile phone in an international format (e.g. +3100000000)"></span>
                </div>
                <div class="field-input">
                    <input name="RbacRoles[name]" class="input-text jquery-live-validation-on input-error" type="text">
                    <?php /*<span class="validation-icon" style="display: inline;"></span>
                    <div class="error-message" style="display: block;">
                        Mobile Phone is incorrect
                        <div class="error-message-arr"></div>
                    </div>*/?>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-7">
                <div class="field-lbl">
                    Base role
                    <span class="tooltip-icon" title="Country: (Choose the country from the drop-down menu)"></span>
                </div>
                <div class="field-input">
                    <div class="select-custom">
                        <span class="select-custom-label"><?= Yii::t('Front', 'Select') ?></span>
                        <?= CHtml::dropDownList(
                            'country',
                            '',
                            CHtml::listData($roles, 'id', 'name'),
                            array(
                                'empty' =>Yii::t('Front', 'Select'),
                                'class' => 'country-select select-role-type select-invisible',
                                'data-url' => Yii::app()->createUrl('ajax/getRoleRights'),
                            )
                        )?>
                    </div>
                    <?php /*
                    <div class="error-message" style="display: block;">error  <div class="error-message-arr"></div></div>
                     * 
                     */?>
                </div>
            </div>
        </div>
        <?php $this->widget('AccessRightsTree', array('rightsTree' => $rightsTree));?>
        <div class="form-submit">
            <input class="rounded-buttons save" type="submit" value="Save"/>
        </div>
    </div>
</div>
</form>

<script>
    RBACK.addRolePage()
</script>