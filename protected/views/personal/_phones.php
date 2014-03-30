<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'user_datas',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'action' => $this->createUrl('personal/editephones'),
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
        <th width="34%"><?= Yii::t('Front', 'Phone'); ?></th>
        <th width="25%"><?= Yii::t('Front', 'Type'); ?></th>
        <th width="33%"><?= Yii::t('Front', 'Status'); ?></th>
        <th width="8%" class="edit-th">
            <div class="table-close-btn"></div>
        </th>
    </tr>
    <? foreach ($users_phones as $users_phone): ?>
        <tr>
            <td>+<?= $users_phone->phone ?></td>
            <td>
                <div class="relative">
                    <span class="dropdown_button types_dropdown">
                        <?= $users_phone->emailType->type_name ?>
                    </span>
               </div>
            </td>
            <td>

                <? if($users_phone->status == 0 && $users_phone->is_master == 0):?>
					<a style="float:right" href="javaScript:void(0)" class="edit-add-button" onclick="js:activatePhone('<?= $this->createUrl('/personal/activate', array('type' => 'phones', 'hash' => "" )) ?>', this)" ><?= Yii::t('Front', 'Check'); ?></a>
					<input type="text" name="code_activation" class="status-check-input" placeholder="<?= Yii::t('Front', 'Activation code'); ?>" />
                <? elseif ($users_phone->status == 1 && $users_phone->is_master == 0):?>
					<?php if($users_phone->hash): ?>
					<a style="float:right" href="javaScript:void(0)" class="edit-add-button" onclick="js:activatePhone('<?= $this->createUrl('/personal/activate', array('type' => 'phones', 'hash' => "" )) ?>', this)" ><?= Yii::t('Front', 'Check'); ?></a>
					<input class="status-check-input" type="text" name="code_activation" placeholder="<?= Yii::t('Front', 'Make primary code'); ?>" />
					<?php else: ?>
					<a href="javaScript:void(0)" onclick="js:makePrimary('<?= Yii::app()->createUrl('/personal/makePrimary', array('type' => 'phones', 'id' => $users_phone->id)) ?>')"><?= Yii::t('Front', 'Make primary'); ?></a>
					<?php endif; ?>
                <? elseif ($users_phone->status == 1 && $users_phone->is_master == 1):?>
                <span class="primary"><?= Yii::t('Front', 'Primary'); ?></span>
                <? endif;?>

            </td>
            <td class="remove-td">
                <div class="remove-btn"></div>
            </td>
            <input type="hidden" name="delete[<?= $users_phone->id ?>]" class="delete" value="0"/>
            <input type="hidden" name="type_edit[<?= $users_phone->id ?>]" class="type_edit" value="0"/>
        </tr>
    <? endforeach; ?>
    <tr style="display:none; background:#CEFFCE" class="line-template">
        <td class="phone item">phone</td>
        <td class="type item">type_id</td>
        <td><?= Yii::t('Front', 'Pending activation'); ?></td>
        <td class="remove-td">
            <div class="remove-btn"></div>
        </td>
        <input type="hidden" name="phone[]" class ="phone hidden item" data-v="phone" value=""/>
        <input type="hidden" name="type[]" class="type hidden item" data-v="type_id" value=""/>
	    <input type="hidden" name="delete[]" class="delete" value="0"/>
    </tr>
    <tr>
        <td>
            <div class="field-row">
                <div class="field-lbl">
                    <?= Yii::t('Front', 'Phone'); ?>
                    <span class="tooltip-icon" title="tooltip text"></span></div>
                <div class="field-input">
                    <?= $form->textField($model_phones, 'phone', array('class' => 'input-text item0', 'data-v' => 'phone')); ?>
                    <?= $form->error($model_phones, 'phone'); ?>
                </div>
            </div>
        </td>
        <td colspan="3">
            <div class="field-row edit-select">
                <div class="field-lbl">
                    <?= Yii::t('Front', 'Phone Type'); ?>
                    <span class="tooltip-icon"
                          title="<?= Yii::t('Front', 'You can upload a file to one of the formats: PDF, JPG, PNG, GIF'); ?>"></span>
                </div>
                <div class="field-input ">
                    <div class="select-custom">
                        <span class="select-custom-label">
                            <?= Yii::t('Front', 'Choose'); ?>
                        </span>
                        <?=
                        $form->dropDownList($model_phones, 'email_type_id', Users_EmailTypes::all(), array(
                            'class' => 'country-select select-invisible item1','data-v' => 'type_id'

                        )); ?>
                    </div>
                    <?= $form->error($model_phones, 'email_type_id'); ?>
                    <span class="validation-icon"></span>
                </div>
            </div>
            <div class="edit-add-button"
                 onclick="js:add_temp_user_datas('<?= $this->createUrl('personal/editphones', array('ajax' => 'user_datas')) ?>', this)">
                <?= Yii::t('Front', 'Add'); ?>
            </div>
        </td>
    </tr>
</table>
<div class="form-submit">
	<a href="<?= Yii::app()->createUrl('/banking/personal') . '/' ?>"><div class="submit-button button-back"><?= Yii::t('Front', 'Back')?></div></a> 
    <div class="submit-button button-next save"
         onclick="js:save_datas('<?= Yii::app()->createUrl('/banking/personal/savephones') . '/' ?>', this)">
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
