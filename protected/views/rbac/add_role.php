<script>
    $(document).ready(function(){
        $('.xabina-accordion').accordion({
            heightStyle: "content",
            active: false,
            collapsible: true
        }); 
        $('.details-accordion').accordion({
            heightStyle: "content",
            active: 0,
            collapsible: true
        });
        $('.country-select').change(event, function(){
            $.ajax({url: "<?php echo Yii::app()->createUrl('ajax/getRoleRights'); ?>",
                data: {"roleId": this.value },
                type: 'get',
                success: function(response){
                    response = eval(response);
                    $('div.xabina-accordion').find('input:checkbox').each(function() {
                        $(this).attr('checked', false);
                        $(this).parent().removeClass('checked');
                    });
                    for(i=0; i<response.length; i++) {
                        $checkbox = $('.xabina-accordion').find('input:checkbox[name="RbacRoles[rights]['+response[i].acces_right_id+']"]');
                        $checkbox.attr('checked', true);
                        $checkbox.parent().addClass('checked');
                    }
                }
            });
        });
    });
</script>

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
        'afterValidate' => 'js:afterValidate',
        'afterValidateAttribute' => 'js:afterValidateAttribute'
    ),
)); ?>

<div class="col-lg-9 col-md-9 col-sm-9" >
    <div class="h1-header">Add a new role</div>
    <div class="role-form xabina-form-container">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5">
                <div class="field-lbl">
                    Role Name
                    <span class="tooltip-icon" title="Role"></span>
                </div>
                <div class="field-input">
                    <?= $form->textField($role, 'name', array('autocomplete' => 'off','class'=>'input-text')); ?>
                    <span class="validation-icon" style="display: none;"></span>
                    <?= $form->error($role, 'name', array('style' => 'display:none;')); ?>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-7">
                <div class="field-lbl">
                    Base role
                    <span class="tooltip-icon" title="Base role"></span>
                </div>
                <div class="field-input">
                    <div class="select-custom">
                        <span class="select-custom-label"><?= Yii::t('Front', 'Choose'); ?></span>
                        <select name="country" class="country-select select-invisible">
                            <option value="">Выберите</option>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?php echo $role->id; ?>"><?php echo $role->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>                    
                </div>
            </div>
        </div>
        <?php $this->widget('AccessRightsTree', array('rightsTree' => $rightsTree));?>
        <?php if(isset($rightsError)):?>
            <div class="error-message" style="display: block;"> <?php echo $rightsError ?><div class="error-message-arr"></div></div>
        <?php endif;?>
        <div class="form-submit">
            <input class="rounded-buttons save" type="submit" value="Save"/>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>