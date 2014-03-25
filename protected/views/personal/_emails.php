<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'user_datas',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'action' => $this->createUrl('personal/editemails'),
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
        <th width="39%"><?= Yii::t('Front', 'E-Mail'); ?></th>
        <th width="25%"><?= Yii::t('Front', 'Type'); ?></th>
        <th width="28%"><?= Yii::t('Front', 'Status'); ?></th>
        <th width="8%" class="edit-th">
            <div class="table-close-btn"></div>
        </th>
    </tr>
    <? foreach ($users_emails as $users_email): ?>
        <tr>
            <td><?= $users_email->email ?></td>
            <td>
                <div class="relative">
                    <span class="dropdown_button types_dropdown">
                        <?= $users_email->emailType->type_name ?>
                    </span>
               </div>
            </td>
            <td>
            	<span class="primary">
                <? if($users_email->status == 0 && $users_email->is_master == 0):?>
                	<?= Yii::t('Front', 'Resend email'); ?>
                <? elseif ($users_email->status == 1 && $users_email->is_master == 0):?>
                	<?= Yii::t('Front', 'Make primary'); ?>
                <? elseif ($users_email->status == 1 && $users_email->is_master == 1):?>
                	<?= Yii::t('Front', 'Primary'); ?>
                <? endif;?></span>
            </td>
            <td class="remove-td">
                <div class="remove-btn"></div>
            </td>
            <input type="hidden" name="delete[<?= $users_email->id ?>]" class="delete" value="0"/>
            <input type="hidden" name="type_edit[<?= $users_email->id ?>]" class="type" value="0"/>
        </tr>
    <? endforeach; ?>
    <tr style="display:none; background:#CEFFCE" class="line-template">
        <td class="item">email</td>
        <td class="item">type_id</td>
        <td><?= Yii::t('Front', 'Resend email'); ?></td>
        <td class="remove-td">
            <div class="remove-btn"></div>
        </td>
        <input type="hidden" name="email[]" class ="email item" data-v="email" value=""/>
        <input type="hidden" name="type[]" class="type item" data-v="type_id"  value=""/>
	    <input type="hidden" name="delete[]" class="delete" value="0"/>
    </tr>
    <tr>
        <td>
            <div class="field-row">
                <div class="field-lbl">
                    <?= Yii::t('Front', 'E-mail'); ?>
                    <span class="tooltip-icon" title="tooltip text"></span></div>
                <div class="field-input">
                    <?= $form->textField($model_emails, 'email', array('class' => 'input-text item0', 'data-v' => 'email')); ?>
                    <?= $form->error($model_emails, 'email'); ?>
                </div>
            </div>
        </td>
        <td colspan="3">
            <div class="field-row edit-select">
                <div class="field-lbl">
                    <?= Yii::t('Front', 'E-mail Type'); ?>
                    <span class="tooltip-icon"
                          title="<?= Yii::t('Front', 'You can upload a file to one of the formats: PDF, JPG, PNG, GIF'); ?>"></span>
                </div>
                <div class="field-input ">
                    <div class="select-custom"> <span class="select-custom-label">
						<?= Yii::t('Front', 'Choose'); ?>
                        </span>
                        <?=
                        $form->dropDownList($model_emails, 'email_type_id', Users_EmailTypes::all(), array(
                            'class' => 'country-select select-invisible item1', 'data-v' => 'type_id',
                        )); ?>
                        <?= $form->error($model_emails, 'email_type_id'); ?>
                        <span class="validation-icon"></span></div>
                </div>
            </div>
            <div class="edit-add-button"
                 onclick="js:add_temp_user_datas('<?= $this->createUrl('personal/editemails', array('ajax' => 'user_datas')) ?>', this)">
                <?= Yii::t('Front', 'Add'); ?>
            </div>
        </td>
    </tr>
</table>
<div class="form-submit">
	<a href="<?= Yii::app()->createUrl('/banking/personal') . '/' ?>"><div class="submit-button button-back"><?= Yii::t('Front', 'Back')?></div></a>   
    <div class="submit-button button-next save"
         onclick="js:save_datas('<?= Yii::app()->createUrl('/banking/personal/saveemails') . '/' ?>', this)">
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
	bgEdit: '#FFCACA'
});
</script>
