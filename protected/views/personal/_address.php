<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'user_datas',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'action' => $this->createUrl('personal/editaddress'),
    'errorMessageCssClass' => 'error-message',
    'htmlOptions' => array(
        'class' => 'form-validable',
        //'onsubmit'=>"return false;",/* Disable normal form submit */
        //'onkeypress'=>" if(event.keyCode == 13){ send(); } "
    ),
    //'focus'=>array($model,'first_name'),
    'clientOptions' => array(
        'validateOnSubmit' => false,
        'validateOnChange' => true,
        'errorCssClass' => 'input-error',
        'successCssClass' => 'valid'
    ),
)); ?>

<table class="table  xabina-table-edit">
    <tr class="table-header">
        <th width="39%"><?= Yii::t('Front', 'Address'); ?></th>
        <th width="25%"><?= Yii::t('Front', 'Type'); ?></th>
        <th width="28%"><?= Yii::t('Front', 'Status'); ?></th>
        <th width="8%" class="edit-th">
            <div class="table-close-btn"></div>
        </th>
    </tr>
    <? foreach ($users_address as $users_addr): ?>
        <tr>
            <td>
			<?= $users_addr->address ?><br>
            <?= $users_addr->address_optional ?><br>
            <?= $users_addr->indx?><br>
            <?= $users_addr->city?><br>
            <?= $users_addr->country->name?>
            </td>
            <td>
                <div class="relative">
                    <span class="dropdown_button types_dropdown">
                        <?= $users_addr->emailType->type_name ?>
                    </span>
               </div>
            </td>
            <td>
            	<span class="primary">
                <? if($users_addr->status == 0 && $users_addr->is_master == 0):?>
                	<?= Yii::t('Front', 'Recent address'); ?>
                <? elseif ($users_addr->status == 1 && $users_addr->is_master == 0):?>
                	<?= Yii::t('Front', 'Make primary'); ?>
                <? elseif ($users_addr->status == 1 && $users_addr->is_master == 1):?>
                	<?= Yii::t('Front', 'Primary'); ?>
                <? endif;?></span>
            </td>
            <td class="remove-td">
                <div class="remove-btn"></div>
            </td>
            <input type="hidden" name="delete[<?= $users_addr->id ?>]" class="delete" value="0"/>
            <input type="hidden" name="type_edit[<?= $users_addr->id ?>]" class="type_edit" value="0"/>
        </tr>
    <? endforeach; ?>
    <tr style="display:none; background:#CEFFCE" class="line-template">
        <td class="item">address,address_optional,indx,city,country_id</td>
        <td class="item">type_id</td>
        <td><?= Yii::t('Front', 'Pending activation'); ?></td>
        <td class="remove-td">
            <div class="remove-btn"></div>
        </td>
        <input type="hidden" name="address[]" class ="address item" data-v="address" value=""/>
        <input type="hidden" name="address_optional[]" class ="address_optional item" data-v="address_optional" value=""/>
        <input type="hidden" name="indx[]" class ="indx item" data-v="indx" value=""/>
        <input type="hidden" name="city[]" class ="city item" data-v="city" value=""/>
        <input type="hidden" name="country_id[]" class ="country_id item" data-v="country_id" value=""/>      
        <input type="hidden" name="type[]" class="type item" data-v="type_id" value=""/>     
	    <input type="hidden" name="delete[]" class="delete" value="0"/>
    </tr>
    <tr>
        <td>
            <div class="field-row">
                <div class="field-lbl">
                    <?= Yii::t('Front', 'Address Line 1'); ?>
                    <span class="tooltip-icon" title="tooltip text"></span></div>
                <div class="field-input">
                    <?= $form->textField($model_address, 'address', array('class' => 'input-text', 'data-v' => 'address')); ?>
                    <?= $form->error($model_address, 'address'); ?>
                </div>
            </div>
            
            <div class="field-row">
                <div class="field-lbl">
                    <?= Yii::t('Front', 'Index'); ?>
                    <span class="tooltip-icon" title="tooltip text"></span></div>
                <div class="field-input">
                    <?= $form->textField($model_address, 'indx', array('class' => 'input-text','data-v' => 'indx')); ?>
                    <?= $form->error($model_address, 'indx'); ?>
                </div>
            </div>
            
            <div class="field-lbl"> <?= Yii::t('Front', 'Сountry'); ?><span class="tooltip-icon" title="You can upload a file to one of the formats: PDF, JPG, PNG, GIF"></span> </div>
            <div class="field-input ">
              <div class="select-custom"> <span class="select-custom-label"><?= Yii::t('Front', 'Choose'); ?> </span>
                <?=
				$form->dropDownList($model_address, 'country_id', Countries::all(), array(
					'class' => 'country-select select-invisible', 'data-v' => 'country_id'

				)); ?>
				<?= $form->error($model_address, 'country_id'); ?>
                <span class="validation-icon"></span> </div>
            </div>
          </div>
        </td>
        <td colspan="3">
        
        	<div class="field-row">
                <div class="field-lbl">
                    <?= Yii::t('Front', 'Address Line 2 (optional)'); ?>
                    <span class="tooltip-icon" title="tooltip text"></span></div>
                <div class="field-input">
                    <?= $form->textField($model_address, 'address_optional', array('class' => 'input-text','data-v' => 'address_optional')); ?>
                    <?= $form->error($model_address, 'address_optional'); ?>
                </div>
            </div>
            
            <div class="field-row">
                <div class="field-lbl">
                    <?= Yii::t('Front', 'City'); ?>
                    <span class="tooltip-icon" title="tooltip text"></span></div>
                <div class="field-input">
                    <?= $form->textField($model_address, 'city', array('class' => 'input-text',  'data-v' => 'city')); ?>
                    <?= $form->error($model_address, 'city'); ?>
                </div>
            </div>
        
            <div class="field-row edit-select">
                <div class="field-lbl">
                    <?= Yii::t('Front', 'Address Type'); ?>
                    <span class="tooltip-icon"
                          title="<?= Yii::t('Front', 'You can upload a file to one of the formats: PDF, JPG, PNG, GIF'); ?>"></span>
                </div>
                <div class="field-input ">
                    <div class="select-custom"> <span class="select-custom-label">
            <?= Yii::t('Front', 'Choose'); ?>
            </span>
                        <?=
                        $form->dropDownList($model_address, 'email_type_id', Users_EmailTypes::all(), array(
                            'class' => 'country-select select-invisible item1', 'data-v' => 'type_id'

                        )); ?>
                        <?= $form->error($model_address, 'email_type_id'); ?>
                        <span class="validation-icon"></span></div>
                </div>
            </div>
            <div class="edit-add-button"
                 onclick="js:add_temp_user_datas('<?= $this->createUrl('personal/editaddress', array('ajax' => 'user_datas')) ?>', this)">
                <?= Yii::t('Front', 'Add'); ?>
            </div>
        </td>
    </tr>
</table>
<div class="form-submit">
	<a href="<?= Yii::app()->createUrl('/banking/personal') . '/' ?>"><div class="submit-button button-back"><?= Yii::t('Front', 'Back')?></div></a> 
    <div class="submit-button button-next save"
         onclick="js:save_datas('<?= Yii::app()->createUrl('/banking/personal/saveaddress') . '/' ?>', this)">
        <?= Yii::t('Front', 'Save'); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<script>
$('.types_dropdown').dropDown({
	list: {
		<? foreach(Users_EmailTypes::all() as $k => $v):?>
		<? if(!empty($k) && !empty($v)):?>
	    '<?=$k?>': {id:<?=$k?>, name:'<?=$v?>'},
		<? endif; ?>
		<? endforeach;?>
	},
	listClass: 'type_dropdown',
});
</script>