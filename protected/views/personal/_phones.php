<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'user_datas',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'action' => $this->createUrl('personal/editphones'),
    'errorMessageCssClass' => 'error-message',
    'htmlOptions' => array(
        'class' => 'form-validable',
    ),
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'errorCssClass' => 'input-error',
        'successCssClass' => 'valid'
    ),
)); ?>

<table class="table xabina-table-personal">
    <tr class="table-header">
        <th width="34%"><?= Yii::t('Front', 'Phone'); ?></th>
        <th width="25%"><?= Yii::t('Front', 'Type'); ?></th>
        <th width="33%"><?= Yii::t('Front', 'Status'); ?></th>
        <th width="8%" class="edit-th">
            
        </th>
    </tr>
    <? foreach ($users_phones as $users_phone): ?>
		<?php if($users_phone->hash): ?>
		<tr class="email-comment-tr sms-comment-tr">
			<td colspan="4">
				<div class="comment-bg">
					<?= Yii::t('Front', 'We have send an SMS with the verification code on the phone number') ?> 
					+<?= $users_phone->phone ?>
					<a href="javaScript:void($.post('<?= $this->createUrl('/personal/resendsms', array('id' => $users_phone->id)) ?>', function(data){if(jQuery.parseJSON(data).success){alert('<?= Yii::t('Front', 'Sms sended') ?>')}}))"><?= Yii::t('Front', 'Send verification code once again'); ?></a>
				</div>
				<div class="comment-arr"></div>
			</td>
		</tr>
		<?php endif; ?>
        <tr class="form-sms-tr">
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
					<div class="field-row">
						<div class="field-lbl">SMS code<span class="tooltip-icon" title="tooltip text"></span>
						</div>
						<div class="field-input">
							<input type="text" name="code_activation" class="status-check-input input-text-sms" />
						</div>
						<div class="violet-button-slim-square" onclick="activatePhone('<?= $this->createUrl('/personal/activate', array('type' => 'phones', 'hash' => "" )) ?>', this)"><?= Yii::t('Front', 'Add') ?></div>
					</div>
					<div class="error-message"></div>
                <? elseif ($users_phone->status == 1 && $users_phone->is_master == 0):?>
					<?php if($users_phone->hash): ?>
					<div class="field-row">
						<div class="field-lbl">SMS code<span class="tooltip-icon" title="tooltip text"></span>
						</div>
						<div class="field-input">
							<input class="status-check-input input-text-sms" type="text" name="code_activation" />
						</div>
						<div class="violet-button-slim-square" onclick="js:activatePhone('<?= $this->createUrl('/personal/activate', array('type' => 'phones', 'hash' => "" )) ?>', this)"><?= Yii::t('Front', 'Add') ?></div>
					</div>
					<div class="error-message"></div>
					<?php else: ?>
					<a href="javaScript:void(0)" onclick="js:makePrimary('<?= Yii::app()->createUrl('/personal/makePrimary', array('type' => 'phones', 'id' => $users_phone->id)) ?>')"><?= Yii::t('Front', 'Make primary'); ?></a>
					<?php endif; ?>
                <? elseif ($users_phone->status == 1 && $users_phone->is_master == 1):?>
                <span class="primary"><?= Yii::t('Front', 'Primary'); ?></span>
                <? endif;?>
            </td>
			<?php if(!$users_phone->is_master): ?>
            <td class="remove-td actions-td">
				<div class="transaction-buttons-cont">
					<a class="button delete" href="javaScript:void(0)" onclick="js:confirm('<?= Yii::t('Front', 'Are you sure you want to delete this phone from profile?') ?>') ? deleteRow('<?= Yii::app()->createUrl('/personal/delete', array('type' => 'phones', 'id' => $users_phone->id)) ?>', this) : false;" ></a>
				</div>
            </td>
			<?php else: ?>
			<td></td>
			<?php endif; ?>
            <input type="hidden" name="delete[<?= $users_phone->id ?>]" class="delete" value="0"/>
            <input type="hidden" name="type_edit[<?= $users_phone->id ?>]" class="type_edit" value="0"/>
        </tr>
    <? endforeach; ?>
	<tr>
			<td class="add-new-td" colspan="4">
				<a class="table-btn" onclick="$(this).parents('tr').hide()" href="javaScript:void($('.prof-form').toggle('slow'))"><?= Yii::t('Front', 'Add new'); ?></a>
			</td>
		</tr>
		<tr class="prof-form" style="overflow: hidden;">
			<td colspan="4" class="table-form-subheader">
				<div class="table-subheader"><?= Yii::t('Front', 'Add phone number'); ?></div>
			</td>
		</tr>
    <tr class="prof-form emails-form-tr">
        <td colspan="4">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="field-row">
                        <div class="field-lbl">
                            <?= Yii::t('Front', 'Phone'); ?>
                            <span class="tooltip-icon" title="tooltip text"></span></div>
                        <div class="field-input">
                            <?= $form->textField($model_phones, 'phone', array('class' => 'input-text item0', 'data-v' => 'phone')); ?>
                            <?= $form->error($model_phones, 'phone'); ?>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="field-row">
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
            <!--<div class="edit-add-button"
                 onclick="js:add_temp_user_datas('<?= $this->createUrl('personal/editphones', array('ajax' => 'user_datas')) ?>', this)">
                <?= Yii::t('Front', 'Add'); ?>
            </div>-->
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2">
                    <div class="field-row">
                        <div class="field-lbl">&nbsp;</div>
                        <div class="field-input">
			                <input type="submit" class="violet-button-slim-square" value="<?= Yii::t('Front', 'Add'); ?>" />
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
</table>
<div class="form-submit">
	<a href="<?= Yii::app()->createUrl('/banking/personal') . '/' ?>"><div class="submit-button button-back"><?= Yii::t('Front', 'Back')?></div></a> 
    <!--<div class="submit-button button-next save"
         onclick="js:save_datas('<?= Yii::app()->createUrl('/banking/personal/savephones') . '/' ?>', this)">
        <?= Yii::t('Front', 'Save'); ?>
    </div>-->
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
