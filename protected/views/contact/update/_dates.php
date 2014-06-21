<div class=" xabina-form-narrow">
	<table class="table xabina-table-contacts">
		<tr class="table-header">
			<th style="width: 44%"><?= Yii::t('Front', 'Date') ?></th>
			<th style="width: 36%"><?= Yii::t('Front', 'Category') ?></th>
			<th style="width: 20%"></th>
		</tr>
		<?php foreach($model->getDataByType('dates') as $model): ?>
		<tr class="data-row">
			<td><?= $model->date ?></td>
			<td>
				<?php if(isset(Users_Contacts_Data_Dates::$categories[$model->category])):?>
				<?= Yii::t('Front', Users_Contacts_Data_Dates::$categories[$model->category]) ?>
				<?php else: ?>
				<?= $model->category ?>
				<?php endif; ?>
			</td>
			<td>
				<div class="transaction-buttons-cont">
					<a href="javaScript:void(0)" class="button edit"></a>
					<a class="button delete" data-url="<?= Yii::app()->createUrl('/contact/deleteData', array('type' => 'dates', 'id' => $model->id)) ?>" ></a>
				</div>
			</td>
		</tr>
		<tr class="edit-row">
			<td colspan="3">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'dataform-form-dates'.$model->id,
					'enableAjaxValidation'=>true,
					'enableClientValidation'=>true,
					'errorMessageCssClass' => 'error-message',
					'htmlOptions' => array(
						'class' => 'form-validable',
						'enctype' => 'multipart/form-data',
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
				<div class="xabina-form-narrow">
					<div class="row">
						<div class="col-lg-5 col-md-5 col-sm-5">
							<?= $form->hiddenField($model, 'id') ?>
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Choose Day') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'date_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($model, 'date', array('class' => 'date-input with_datepicker', 'id' => '')) ?>
									<?= $form->error($model, 'date') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Category') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'country_name_contact') ?>"></span>
								</div>
								<div class="form-input">
								<span class="select-custom-label"></span>
								<div class="select-custom select-narrow ">
									<span class="select-custom-label"></span>
									<?= $form->dropDownList(
										$model,
										'category',
										Users_Contacts_Data_Dates::$categories,
										array(
											'class' => 'select-invisible country-select', 
											'options' => array($model->category => array('selected' => true)),
											'empty' => Yii::t('Front', 'Select')
										)
									); ?>
								</div>
							</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 ">
							<div class="transaction-buttons-cont edit-submit-cont">
								<input type="submit" class="button ok" value=""/>
								<a href="javaScript:void(0)" class="button cancel"></a>
							</div>
						</div>
					</div>
				</div>
				<?php $this->endWidget(); ?>
			</td>
		</tr>
		<?php endforeach; ?>
		<tr class="data-row">
			<td colspan="3">
				<a href="#" class="rounded-buttons upload add-more"><?= Yii::t('Front', 'Add NEW'); ?></a>
			</td>
		</tr>
		<tr class="edit-row">
			<td colspan="3">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'dataform-form-dates',
					'enableAjaxValidation'=>true,
					'enableClientValidation'=>true,
					'errorMessageCssClass' => 'error-message',
					'htmlOptions' => array(
						'class' => 'form-validable',
						'enctype' => 'multipart/form-data',
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
				<?php $model = new Users_Contacts_Data_Dates; ?>
				<div class="xabina-form-narrow">
					<div class="row">
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Choose Day') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'date_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($model, 'date', array('class' => 'date-input with_datepicker', 'id' => '')) ?>
									<?= $form->error($model, 'date') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Category') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'country_name_contact') ?>"></span>
								</div>
								<div class="form-input">
									<span class="select-custom-label"></span>
									<div class="select-custom select-narrow ">
										<span class="select-custom-label"></span>
										<?= $form->dropDownList(
											$model,
											'category',
											Users_Contacts_Data_Dates::$categories,
											array(
												'class' => 'select-invisible country-select', 
												'options' => array($model->category => array('selected' => true)),
												'empty' => Yii::t('Front', 'Select')
											)
										); ?>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 ">
							<div class="transaction-buttons-cont edit-submit-cont">
								<input type="submit" class="button ok" value=""/>
								<a href="javaScript:void(0)" class="button cancel"></a>
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
    $("form .with_datepicker, .calendar-input").datepicker({
        showOn:"both",
        buttonImage: '/images/calendar_ico.png',
        buttonImageOnly:true,
        dateFormat: 'dd.mm.yy'
    }).inputmask("d.m.y");;
</script>
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