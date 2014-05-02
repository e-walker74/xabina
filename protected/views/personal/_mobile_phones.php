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
		<tr class="email-comment-tr sms-comment-tr  border-yellow">
			<td colspan="4">
				<div class="comment-bg">
					<?= Yii::t('Front', 'We have send an SMS with the verification code on the phone number') ?> 
					+<?= $users_phone->phone ?>
					<a href="<?= $this->createUrl('/personal/resendsms', array('id' => $users_phone->id)) ?>" onclick='return resendSms(this)'><?= Yii::t('Front', 'Send verification code once again'); ?></a>
				</div>
				<div class="comment-arr"></div>
			</td>
		</tr>
		<?php endif; ?>
        <tr class="form-sms-tr">
            <td>+<?= $users_phone->phone ?></td>
            <td>
                <div class="relative">
                    <!--<span class="dropdown_button types_dropdown">-->
                        <?= $users_phone->emailType->type_name ?>
                    <!--</span>-->
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
						<a href="javaScript:void(0)" class="button ok" onclick="activatePhone('<?= $this->createUrl('/personal/activate', array('type' => 'phones', 'hash' => "" )) ?>', this)"></a>
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
						<a href="javaScript:void(0)" class="button ok" onclick="activatePhone('<?= $this->createUrl('/personal/activate', array('type' => 'phones', 'hash' => "" )) ?>', this)"></a>
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
					<a class="button delete" data-url="<?= Yii::app()->createUrl('/personal/delete', array('type' => 'phones', 'id' => $users_phone->id)) ?>" ></a>
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
				<a class="table-btn" onclick="resetPage(); $(this).parents('tr').hide(); $(this).parents('form').find('.prof-form').toggle('slow')" href="javaScript:void(0)"><?= Yii::t('Front', 'Add new'); ?></a>
			</td>
		</tr>
		<tr class="prof-form" style="overflow: hidden;">
			<td colspan="4" class="table-form-subheader">
				<div class="table-subheader"><?= Yii::t('Front', 'Add phone number'); ?></div>
			</td>
		</tr>
    <tr class="prof-form emails-form-tr">
        <td colspan="4">
            <div class="field-row left-coll">
                <div class="field-lbl">
                    <?= Yii::t('Front', 'Phone'); ?>
                    <span class="tooltip-icon" title="tooltip text"></span></div>
                <div class="field-input">
                    <?= $form->textField($model_phones, 'phone', array('class' => 'input-text item0', 'data-v' => 'phone')); ?>
                    <?= $form->error($model_phones, 'phone'); ?>
                </div>
            </div>
			<div class="field-row right-coll">
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
                            'class' => 'country-select select-invisible item1',
							'data-v' => 'type_id',
							'options' => array('' => array('disabled' => true)),
                        )); ?>
                    </div>
                    <?= $form->error($model_phones, 'email_type_id'); ?>
                    <span class="validation-icon"></span>
                </div>
            </div>
			<div class="transaction-buttons-cont">
				<input type="submit" class="button ok" value="" />
				<a class="button cancel" href="javaScript:void(0)"></a>
			</div>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>
<script>

$(document).ready(function(){

	$('#user_datas .transaction-buttons-cont .delete').confirmation({
		title: '<?= Yii::t('Front', 'Are you sure?') ?>',
		singleton: true,
		popout: true,
		onConfirm: function(){
			deleteRow($(this).parents('.popover').prev('a'));
			return false;
		}
	})

})

var resendSms = function(link){
	link = $(link)
	$.post(
		link.attr('href'), 
		function(data){
			if(jQuery.parseJSON(data).success){
				successNotify('<?= Yii::t('Front', 'My phone numbers') ?>', '<?= Yii::t('Front', 'Sms was sent') ?>');
			}
		}
	)
	return false;
}

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
