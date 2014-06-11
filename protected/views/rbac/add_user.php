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
        
        $('.role-select').change(event, function(){
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
<div class="col-lg-9 col-md-9 col-sm-9" >
    <div class="h1-header">Аdding a new user</div>
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
            'afterValidate' => 'js:afterValidate',
            'afterValidateAttribute' => 'js:afterValidateAttribute'
        ),
    )); ?>    
    <div class="role-form xabina-form-container">
        <div class="account-selection" >
            <span class="select-lbl pull-left">Счет</span>
            <div class="select-custom account-select pull-right" style="width: 92%!important">
                <span class="select-custom-label">
                    <?php $this->widget('AccountInfo', array('account' => $selectedAcc));?>
                </span>
                <select name="RbacAddUserForm[account]" class=" select-invisible">
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
                    User (ID)
                    <span class="tooltip-icon" title="Add Your mobile phone in an international format (e.g. +3100000000)"></span>
                </div>
                <div class="field-input">
                    <?php echo $form->textField($addUserForm, 'user', array('autocomplete' => 'off','class'=>'input-text')); ?>
                    <span class="validation-icon" style="display: none;"></span>
                    <?php  echo $form->error($addUserForm, 'user', array('style' => 'display:none;')); ?>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-7">
                <div class="field-lbl">
                     Role
                    <span class="tooltip-icon" title="Role: (Choose the role from the drop-down menu)"></span>
                </div>
                <div class="field-input">
                    <div class="select-custom">
                        <span class="select-custom-label">Choose</span>
                        <select name="RbacAddUserForm[role]" class="role-select select-invisible" id="RbacAddUserForm_role">
                            <option value="">Choose</option>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?php echo $role->id; ?>"><?php echo $role->name; ?></option>
                            <?php endforeach; ?>
                        </select>                        
                    </div>
                    <?php  echo $form->error($addUserForm, 'role', array('style' => 'display:none;')); ?>
                </div>
            </div>
        </div>
        
        <div class="details-accordion role-details">
            <div class="accordion-header"><a href="#">Details</a></div>
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

