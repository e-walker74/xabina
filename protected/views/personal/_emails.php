<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'user_datas',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
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

<table class="table  xabina-table-personal">
    <tr class="table-header">
        <th width="39%"><?= Yii::t('Front', 'E-Mail'); ?></th>
        <th width="25%"><?= Yii::t('Front', 'Type'); ?></th>
        <th width="28%"><?= Yii::t('Front', 'Status'); ?></th>
        <th width="8%" class="edit-th">
            
        </th>
    </tr>
    <? foreach ($users_emails as $users_email): ?>
		<? if($users_email->status == 0 && $users_email->is_master == 0):?>
		<tr class="email-comment-tr">
			<td colspan="4">
				<div class="comment-bg">
				<?= Yii::t('Front', 'We have sent a message to this E-Mail address with an activation link. Please, click on an activation link to verify the E-Mail address'); ?>
				<br>
					<a href="javaScript:void($.post('<?= $this->createUrl('/personal/resendemail', array('id' => $users_email->id)) ?>', function(data){if(jQuery.parseJSON(data).success){alert('<?= Yii::t('Front', 'Email with activation link was sent') ?>')}}))"><?= Yii::t('Front', 'Send new activation link'); ?></a>
				</div>
				<div class="comment-arr"></div>
			</td>
		</tr>
		<? elseif ($users_email->status == 1 && $users_email->is_master == 0 && $users_email->hash):?>
		<tr class="email-comment-tr">
			<td colspan="4">
				<div class="comment-bg">
				<?= Yii::t('Front', 'We have sent a message to this E-Mail address with an activation link. Please, click on an activation link to verify the E-Mail address'); ?>
				<br>
					<a href="javaScript:void($.post('<?= $this->createUrl('/personal/resendemail', array('id' => $users_email->id)) ?>', function(data){if(jQuery.parseJSON(data).success){alert('<?= Yii::t('Front', 'Email with activation link was sent') ?>')}}))"><?= Yii::t('Front', 'Send new activation link'); ?></a>
				</div>
				<div class="comment-arr"></div>
			</td>
		</tr>
		<?php endif; ?>
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
            	
                <? if($users_email->status == 0 && $users_email->is_master == 0):?>
                	<a href="javaScript:void($.post('<?= $this->createUrl('/personal/resendemail', array('id' => $users_email->id)) ?>', function(data){if(jQuery.parseJSON(data).success){alert('<?= Yii::t('Front', 'Email with activation link was sent') ?>')}}))" class="verify"><?= Yii::t('Front', 'Verify') ?></a>
                <? elseif ($users_email->status == 1 && $users_email->is_master == 0):?>
					<a class="make-primary" href="javaScript:void(0)" onclick="js:makePrimary('<?= Yii::app()->createUrl('/personal/makePrimary', array('type' => 'emails', 'id' => $users_email->id)) ?>')"><?= Yii::t('Front', 'Make primary'); ?></a>
                <? elseif ($users_email->status == 1 && $users_email->is_master == 1):?>
                <span class="primary">
					<b><?= Yii::t('Front', 'Primary'); ?></b>
				</span>
                <? endif;?>
            </td>
			<?php if(!$users_email->is_master): ?>
            <td class="remove-td actions-td">
                <a href="javaScript:void(0)" onclick="js:confirm('<?= Yii::t('Front', 'Are you sure you want to delete this email from profile?') ?>') ? deleteRow('<?= Yii::app()->createUrl('/personal/delete', array('type' => 'emails', 'id' => $users_email->id)) ?>', this) : false;" class="remove-btn"></a>
            </td>
			<?php else: ?>
			<td></td>
			<?php endif; ?>
            <input type="hidden" name="delete[<?= $users_email->id ?>]" class="delete" value="0"/>
            <input type="hidden" name="type_edit[<?= $users_email->id ?>]" class="type_edit" value="0"/>
        </tr>
    <? endforeach; ?>
	<tr>
			<td class="add-new-td" colspan="5">
				<a class="table-btn" href="javaScript:void($('.prof-form').toggle('slow'))"><?= Yii::t('Front', 'Add new'); ?></a>
			</td>
		</tr>
		<tr class="prof-form" style="overflow: hidden;">
			<td colspan="5" class="table-form-subheader">
				<div class="table-subheader"><?= Yii::t('Front', 'Add E-Mail'); ?></div>
			</td>
		</tr>
	<tr class="prof-form emails-form-tr">
        <td>
            <div class="field-row">
                <div class="field-lbl">
                    <?= Yii::t('Front', 'E-mail'); ?>
                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'Insert youre email address'); ?>"></span></div>
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
                          title="<?= Yii::t('Front', 'This type just for you'); ?>"></span>
                </div>
                <div class="field-input ">
                    <div class="select-custom">
                        <span class="select-custom-label">
						    <?= Yii::t('Front', 'Choose'); ?>
                        </span>
                        <?=
                        $form->dropDownList($model_emails, 'email_type_id', Users_EmailTypes::all(), array(
                            'class' => 'country-select select-invisible item1', 'data-v' => 'type_id',
                        )); ?>

                    </div>
                    <?= $form->error($model_emails, 'email_type_id'); ?>
                </div>
            </div>
            <input type="submit" class="violet-button-slim-square" value="<?= Yii::t('Front', 'Add'); ?>" />
        </td>
    </tr>
</table>
<div class="form-submit">
	<a href="<?= Yii::app()->createUrl('/banking/personal') . '/' ?>"><div class="submit-button button-back"><?= Yii::t('Front', 'Back')?></div></a>   
    <!--<div class="submit-button button-next save"
         onclick="js:save_datas('<?= Yii::app()->createUrl('/banking/personal/saveemails') . '/' ?>', this)">
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
