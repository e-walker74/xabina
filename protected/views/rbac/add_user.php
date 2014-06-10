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
    <form action="<?=Yii::app()->createUrl('rbac/addUser'); ?>" method="post">
    <div class="role-form xabina-form-container">
        <div class="account-selection" >
            <span class="select-lbl pull-left">Счет</span>
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
                    User (ID)
                    <span class="tooltip-icon" title="Add Your mobile phone in an international format (e.g. +3100000000)"></span>
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
                     Role
                    <span class="tooltip-icon" title="Role: (Choose the role from the drop-down menu)"></span>
                </div>
                <div class="field-input">
                    <div class="select-custom">
                        <span class="select-custom-label">Выберите </span>
                        <select name="data[role]" class="role-select select-invisible">
                            <option value="">Выберите</option>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?php echo $role->id; ?>"><?php echo $role->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="details-accordion role-details">
            <div class="accordion-header"><a href="#">Details</a></div>
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

