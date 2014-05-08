<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'user_telephones',
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
        <th width="8%" class="edit-th">
            
        </th>
    </tr>
	
	<tr class="comment-tr empty-row" <?php if(!empty($user->telephones)): ?>style="display:none"<?php endif; ?>>
		<td colspan="3" style="line-height: 1.43!important">
			<span class="rejected">
			<?= Yii::t('Front', 'You have not added any phones yet. You can add new phone by clicking "Add new" button.'); ?>
		</td>
	</tr>
	
    <? foreach ($user->telephones as $users_phone): ?>
        <tr class="form-sms-tr phone-row">
            <td><?= $users_phone->number ?></td>
            <td>
                <div class="relative">
                    <!--<span class="dropdown_button types_dropdown">-->
                        <?= $users_phone->emailType->type_name ?>
                    <!--</span>-->
               </div>
            </td>
            <td class="remove-td actions-td">
				<div class="transaction-buttons-cont">
					<a class="button delete" data-url="<?= Yii::app()->createUrl('/personal/delete', array('type' => 'telephones', 'id' => $users_phone->id)) ?>" ></a>
				</div>
            </td>
            <input type="hidden" name="delete[<?= $users_phone->id ?>]" class="delete" value="0"/>
            <input type="hidden" name="type_edit[<?= $users_phone->id ?>]" class="type_edit" value="0"/>
        </tr>
    <? endforeach; ?>
	<tr>
		<td class="add-new-td" colspan="3">
			<a class="table-btn" onclick="resetPage(); $(this).parents('tr').hide(); $(this).parents('form').find('.prof-form').toggle('slow')" href="javaScript:void(0)"><?= Yii::t('Front', 'Add new'); ?></a>
		</td>
	</tr>
	<tr class="prof-form" style="overflow: hidden;">
		<td colspan="3" class="table-form-subheader">
			<div class="table-subheader"><?= Yii::t('Front', 'Add phone number'); ?></div>
		</td>
	</tr>
    <tr class="prof-form emails-form-tr">
        <td colspan="3">
            <div class="field-row left-coll">
                <div class="field-lbl">
                    <?= Yii::t('Front', 'Phone'); ?>
                    <span class="tooltip-icon" title="tooltip text"></span></div>
                <div class="field-input">
                    <?= $form->textField($model_telephones, 'number', array('class' => 'input-text item0', 'data-v' => 'phone')); ?>
                    <?= $form->error($model_telephones, 'number'); ?>
                </div>
            </div>
			<div class="field-row right-coll edit-select">
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
                        $form->dropDownList($model_telephones, 'email_type_id', Users_EmailTypes::all(), array(
                            'class' => 'country-select select-invisible item1',
							'data-v' => 'type_id',
							'options' => array('' => array('disabled' => true)),
                        )); ?>
						<?= $form->error($model_telephones, 'email_type_id'); ?>
                    </div>
                    
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
<div class="form-submit">
	<a href="<?= Yii::app()->createUrl('/banking/personal') . '/' ?>"><div class="submit-button button-back"><?= Yii::t('Front', 'Back')?></div></a> 
</div>
<?php $this->endWidget(); ?>
<script>

$(document).ready(function(){

	$('#user_telephones .transaction-buttons-cont .delete').confirmation({
		title: '<?= Yii::t('Front', 'Are you sure?') ?>',
		singleton: true,
		popout: true,
		onConfirm: function(){
			link = $(this).parents('.popover').prev('a')
			deleteRow(link, function(){
				if($('.phone-row').length == 0){
					$('.empty-row').show()
				} else {
					$('.empty-row').hide()
				}
			});
			return false;
		}
	})

})



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
