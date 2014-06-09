<div class=" xabina-form-narrow">
	<table class="table xabina-table-contacts">
		<tr class="table-header">
			<th style="width: 20%"><?= Yii::t('Front', 'Photo'); ?></th>
			<th style="width: 49%"><?= Yii::t('Front', 'Contact Name'); ?></th>
			<th style="width: 31%"><?= Yii::t('Front', 'Linkining Type'); ?></th>
			<th style="width: 0"></th>
		</tr>
		<?php foreach($model->getDataByType('contact') as $model): ?>
		<?php if(!$ci = $model->getContactInfo()) continue; ?>
		<tr>
			<td>
				<?php if($ci->photo): ?>
					<img width="40" src="<?= $ci->getAvatarUrl() ?>" alt=""/>
				<?php else: ?>
					<img width="40" src="/images/contact_no_foto.png" alt="">
				<?php endif; ?>
			</td>
			<td><?= $ci->fullname ?></td>
			<td><?= $model->category ?></td>
			<td>
				<div class="transaction-buttons-cont">
					<a class="button delete" data-url="<?= Yii::app()->createUrl('/contact/delete', array('type' => 'contact', 'id' => $model->id)) ?>" ></a>
				</div>
			</td>
		</tr>
		<?php endforeach; ?>
		<tr class="data-row">
			<td colspan="4">
				<a href="javaScript:void(0)" class="rounded-buttons upload add-more"><?= Yii::t('Front', 'Link new contact'); ?></a>
			</td>
		</tr>
		<tr class="edit-row">
			<td colspan="4">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'dataform-form-contact',
					'enableAjaxValidation'=>true,
					'enableClientValidation'=>true,
					'errorMessageCssClass' => 'error-message',
					'htmlOptions' => array(
						'class' => 'form-validable',
					),
					'clientOptions'=>array(
						'validateOnSubmit'=>true,
						'validateOnChange'=>true,
						'errorCssClass'=>'input-error',
						'successCssClass'=>'valid',
						'afterValidate' => 'js:afterValidate',
						'afterValidateAttribute' => 'js:afterValidateAttribute'
					),
				)); ?>
				<?php $model = new Users_Contacts_Data_Contact; ?>
				<div class="table-subheader"><?= Yii::t('Front', 'Link new contact'); ?></div>
				<div class="row">
					<div class="col-lg-10 col-md-10 col-sm-10">
						<div class="form-cell">
							<div class="form-lbl">
								<?= Yii::t('Front', 'Contact Name'); ?>
								<span class="tooltip-icon" title="<?= Yii::t('Front', 'add_contact_name_tooltip'); ?>"></span>
							</div>
							<div class="form-input">
								<input id="linkName" type="text" class="input-text account-search-input"/>
								<?= $form->hiddenField($model, 'contact_id'); ?>
								<div class="account-search pull-right"></div>
							</div>
						</div>
					</div>
					<div class="col-lg-2 col-md-2  col-sm-2 ">
						<div class="transaction-buttons-cont edit-submit-cont" style="margin-top: 30px">
							<input type="submit" class="button ok" value="" />
							<a href="javaScript:void(0)" class="button cancel"></a>
						</div>
					</div>
				</div>
				<div class="row">
					<?php Widget::create('ContactListWidget')->renderSeachContactByName() ?>
				</div>
				<script>
					$(document).ready(function(){
						$('.account-search').searchContactButtonByName({
							inputSelectorForName : '#linkName',
							inputSelectorForID : '#Users_Contacts_Data_Contact_contact_id'
						})
					})
				</script>
				<div class="row" style="margin-top: 15px">
					<div class="col-lg-12 col-md-12  col-sm-12 ">
						<div class="form-cell">
							<div class="form-lbl">
								<?= Yii::t('Front', 'Category') ?>
								<span class="tooltip-icon" title="<?= Yii::t('Front', 'category_contact') ?>"></span>
							</div>
							<div class="form-input">
								<?= $form->textField($model, 'category', array('class' => 'input-text')) ?>
								<?= $form->error($model, 'category') ?>
							</div>
						</div>
					</div>
				</div>
				<?php $this->endWidget(); ?>
			</td>
		</tr>
	</table>
</div>
<script>
$(document).ready(function(){
	$('.transaction-buttons-cont .delete').confirmation({
		title: '<?= Yii::t('Front', 'Are you sure?') ?>',
		singleton: true,
		popout: true,
		onConfirm: function(){
			deleteRow($(this).parents('.popover').prev('a'));
			return false;
		}
	})
})
</script>