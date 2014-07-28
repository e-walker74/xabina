<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'user_datas',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'errorMessageCssClass' => 'error-message',
    'htmlOptions' => array(
        'class' => 'form-validable',
    ),
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'errorCssClass' => 'input-error',
        'successCssClass' => 'valid',
        'afterValidate' => 'js:Personal.afterValidate',
        'afterValidateAttribute' => 'js:Personal.afterValidateAttribute',
    ),
)); ?>

<table class="table  xabina-table-personal">
    <tr class="table-header">
        <th width="39%"><?= Yii::t('Front', 'E-Mail'); ?></th>
        <th width="25%"><?= Yii::t('Front', 'Type'); ?></th>
        <th width="28%"><?= Yii::t('Front', 'Status'); ?></th>
        <th width="8%" class="edit-th"></th>
    </tr>
    <?php foreach ($users_emails as $users_email): ?>
		<?php if($users_email->status == 0 && $users_email->is_master == 0):?>
		<tr class="email-comment-tr border-yellow">
			<td colspan="4">
				<div class="comment-bg">
				<?= Yii::t('Front', 'We have sent a message to this E-Mail address with an activation link. Please, click on an activation link to verify the E-Mail address'); ?>
				<br>
					<a href="javaScript:void(0)" onclick="resendActivationEmail('<?= $this->createUrl('/personal/resendemail', array('id' => $users_email->id)) ?>', this)"><?= Yii::t('Front', 'Send new activation link'); ?></a>
				</div>
				<div class="comment-arr"></div>
			</td>
		</tr>
		<?php elseif ($users_email->status == 1 && $users_email->is_master == 0 && $users_email->hash):?>
		<tr class="email-comment-tr border-yellow">
			<td colspan="4">
				<div class="comment-bg">
				<?= Yii::t('Front', 'We have sent a message to primary E-Mail address with a confirmation link. Please, click on the link to confirm the E-Mail address'); ?>
				<br>
                    <a href="javaScript:void(0)" onclick="resendActivationEmail('<?= $this->createUrl('/personal/resendemail', array('id' => $users_email->id)) ?>', this)"><?= Yii::t('Front', 'Send new confirmation link'); ?></a>
				</div>
				<div class="comment-arr"></div>
			</td>
		</tr>
		<?php endif; ?>
        <tr>
            <td><?= $users_email->email ?></td>
            <td>
                <div class="relative">
					<?= $users_email->emailType->type_name ?>
               </div>
            </td>
            <td>
            	
                <?php if($users_email->status == 0 && $users_email->is_master == 0):?>
                	<span class="verify"><?= Yii::t('Front', 'Unverified') ?></span>
                <?php elseif ($users_email->status == 1 && $users_email->is_master == 0):?>
					<a class="make-primary" href="javaScript:void(0)" onclick="js:Personal.makePrimary('<?= Yii::app()->createUrl('/personal/makePrimary', array('type' => 'emails', 'id' => $users_email->id)) ?>', this)"><?= Yii::t('Front', 'Make primary'); ?></a>
                <?php elseif ($users_email->status == 1 && $users_email->is_master == 1):?>
                <span class="primary">
					<b><?= Yii::t('Front', 'Primary'); ?></b>
				</span>
                <?php endif;?>
            </td>
			<?php if(!$users_email->is_master): ?>
            <td class="remove-td actions-td">
				<div class="transaction-buttons-cont">
					<a class="button delete" data-url="<?= Yii::app()->createUrl('/personal/delete', array('type' => 'emails', 'id' => $users_email->id)) ?>" ></a>
				</div>
            </td>
			<?php else: ?>
			<td></td>
			<?php endif; ?>
            <input type="hidden" name="delete[<?= $users_email->id ?>]" class="delete" value="0"/>
            <input type="hidden" name="type_edit[<?= $users_email->id ?>]" class="type_edit" value="0"/>
        </tr>
    <?php endforeach; ?>
	<tr>
			<td class="add-new-td" colspan="4">
				<a class="table-btn" onclick="$(this).parents('tr').hide()" href="javaScript:void($('.prof-form').toggle('slow'))"><?= Yii::t('Front', 'Add new'); ?></a>
			</td>
		</tr>
		<tr class="prof-form" style="overflow: hidden;">
			<td colspan="4" class="table-form-subheader">
				<div class="table-subheader"><?= Yii::t('Front', 'Add E-Mail'); ?></div>
			</td>
		</tr>
	<tr class="prof-form emails-form-tr">
        <td colspan="4">
            <div class="field-row inline-form">
                <div class="field-lbl">
                    <?= Yii::t('Front', 'E-mail'); ?>
                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'Insert youre email address'); ?>"></span></div>
                <div class="field-input">
                    <?= $form->textField($model_emails, 'email', array('class' => 'input-text item0', 'data-v' => 'email')); ?>
                    <?= $form->error($model_emails, 'email'); ?>
                </div>
            </div>
			<div class="field-row edit-select inline-form">
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
                            'class' => 'country-select select-invisible item1', 
							'data-v' => 'type_id',
							'options' => array('' => array('disabled' => true)),
                        )); ?>

					</div>
                            <?= $form->error($model_emails, 'email_type_id'); ?>
				</div>
			</div>
			<div class="transaction-buttons-cont">
				<input type="submit" class="button ok submit" value="" />
				<a class="button cancel" href="javaScript:void(0)"></a>
			</div>
        </td>
    </tr>
</table>
<div class="form-submit">
	<a href="<?= Yii::app()->createUrl('/banking/personal') . '/' ?>"><div class="submit-button button-back"><?= Yii::t('Front', 'Back')?></div></a>   
</div>
<?php $this->endWidget(); ?>
