<div class="col-lg-9 col-md-9 col-sm-9" >
  <div class="h1-header">
    <?= Yii::t('Front', 'My personal cabinet'); ?>
  </div>
  <?php $this->widget('XabinaAlert'); ?>
	<div id="addresses_view" class="xabina-form-container">
		<div class="subheader"><?= Yii::t('Front', 'Change addresses'); ?></div>
		<table class="table xabina-table-personal">
			<tbody>
			<tr class="table-header">
				<th style="width: 38%"><?= Yii::t('Front', 'Address'); ?></th>
				<th style="width: 24%"><?= Yii::t('Front', 'Type'); ?></th>
				<th style="width: 24%"><?= Yii::t('Front', 'Status'); ?></th>
				<th style="width: 14%"></th>
			</tr>
			<?php foreach($user->addresses as $addr):?>
			<tr class="address-tr">
				<td class="address">
					<?= $addr->address ?><br>
					<?php if($addr->address_optional):?>
						<?= $addr->address_optional ?><br>
					<?php endif; ?>
					<?= $addr->indx?><br>
					<?= $addr->city?><br>
					<?= $addr->country->name?>
				</td>
				<td>
					<div class="relative">
						<?= $addr->emailType->type_name ?>
				   </div>
				</td>
				<td>
					<? if($addr->is_master == 0):?>
						<a class="make-primary" href="javaScript:void(0)" onclick="js:makePrimary('<?= Yii::app()->createUrl('/personal/makePrimary', array('type' => 'address', 'id' => $addr->id)) ?>')"><?= Yii::t('Front', 'Make primary'); ?></a>
					<? elseif ($addr->is_master == 1):?>
						<span class="primary"><?= Yii::t('Front', 'Primary'); ?></span>
					<? endif;?>
				</td>
				<td class="actions-td">
					<a href="javaScript:void(0)" onclick="$(this).parents('tr').next('tr').toggle('slow')" class="edit-btn"></a>
					<?php if(!$addr->is_master): ?>
						<a href="javaScript:void(0)" onclick="js:confirm('<?= Yii::t('Front', 'Are you sure you want to delete this address from profile?') ?>') ? deleteRow('<?= Yii::app()->createUrl('/personal/delete', array('type' => 'address', 'id' => $addr->id)) ?>', this) : false;" class="remove-btn"></a>
					<?php endif; ?>
				</td>
			</tr>
			<tr class="edit-address-tr" style="display:none;">
				<td colspan="4">
					<?php $form = $this->beginWidget('CActiveForm', array(
						'id' => 'adress_form_'.$addr->id,
						'enableAjaxValidation' => true,
						'enableClientValidation' => true,
						'action' => $this->createUrl('personal/editaddress'),
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
					<?= $form->hiddenField($addr, 'id'); ?>
					<div class="field-row">
						<div class="field-lbl">
							<?= Yii::t('Front', 'Address Line 1'); ?>
							<span class="tooltip-icon" title="tooltip text"></span>
						</div>
						<div class="field-input">
							<?= $form->textField($addr, 'address', array('class' => 'input-text')); ?>
							<?= $form->error($addr, 'address'); ?>
						</div>
						<div class="field-lbl">
							<?= Yii::t('Front', 'Index'); ?>
							<span class="tooltip-icon" title="tooltip text"></span>
						</div>
						<div class="field-input">
							<?= $form->textField($addr, 'indx', array('class' => 'input-text')); ?>
							<?= $form->error($addr, 'indx'); ?>
						</div>
						<div class="field-lbl">
							<?= Yii::t('Front', 'Сountry'); ?>
							<span class="tooltip-icon" title="<?= Yii::t('Front', 'Choose country'); ?>"></span>
						</div>
						<div class="field-input ">
							<div class="select-custom">
							<span class="select-custom-label"><?= $addr->country->name; ?> </span>
								<?=
								$form->dropDownList($addr, 'country_id', CHtml::listData(Countries::model()->findAll(array('order' => 'name asc')), 'id', 'name'), array(
									'class' => 'country-select select-invisible'

								)); ?>
							</div>
							<?= $form->error($addr, 'country_id'); ?>
						</div>
					</div>
					
					<div class="field-row edit-select">
						<div class="field-lbl">
							<?= Yii::t('Front', 'Address Line 2 (optional)'); ?>
							<span class="tooltip-icon" title="tooltip text"></span>
						</div>
						<div class="field-input">
							<?= $form->textField($addr, 'address_optional', array('class' => 'input-text')); ?>
							<?= $form->error($addr, 'address_optional'); ?>
						</div>
						<div class="field-lbl">
							<?= Yii::t('Front', 'City'); ?>
							<span class="tooltip-icon" title="tooltip text"></span>
						</div>
						<div class="field-input">
							<?= $form->textField($addr, 'city', array('class' => 'input-text')); ?>
							<?= $form->error($addr, 'city'); ?>
						</div>
						<div class="field-lbl">
							<?= Yii::t('Front', 'Address Type'); ?>
							<span class="tooltip-icon"
								title="<?= Yii::t('Front', 'Address type tooltip'); ?>"></span>
						</div>
						<div class="field-input ">
							<div class="select-custom">
								<span class="select-custom-label">
									<?= $addr->emailType->type_name; ?>
								</span>
								<?=
								$form->dropDownList($addr, 'email_type_id', Users_EmailTypes::all(), array(
									'class' => 'country-select select-invisible item1'
								)); ?>
							</div>
							<?= $form->error($addr, 'email_type_id'); ?>
						</div>
					</div>

					<input type="submit" class="violet-button-slim-square" href="#" value="<?= Yii::t('Front', 'Save'); ?>" />

					<?php $this->endWidget(); ?>
				</td>
			</tr>
			<?php endforeach; ?>
			
			<tr>
				<td class="add-new-td" colspan="5">
					<a class="table-btn" href="javaScript:void($('.prof-form').toggle('slow'))"><?= Yii::t('Front', 'Add new'); ?></a>
				</td>
			</tr>
			<tr class="prof-form">
				<td colspan="5" class="table-form-subheader">
					<div class="table-subheader"><?= Yii::t('Front', 'Add address'); ?></div>
				</td>
			</tr>
			<tr class="new-address-tr prof-form">
				<td colspan="4" >
					<?php $form = $this->beginWidget('CActiveForm', array(
						'id' => 'adress_form',
						'enableAjaxValidation' => true,
						'enableClientValidation' => true,
						'action' => $this->createUrl('personal/editaddress'),
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
					<?= $form->hiddenField($model, 'id'); ?>
					<div class="field-row">
						<div class="field-lbl">
							<?= Yii::t('Front', 'Address Line 1'); ?>
							<span class="tooltip-icon" title="tooltip text"></span>
						</div>
						<div class="field-input">
							<?= $form->textField($model, 'address', array('class' => 'input-text')); ?>
							<?= $form->error($model, 'address'); ?>
						</div>
						<div class="field-lbl">
							<?= Yii::t('Front', 'Index'); ?>
							<span class="tooltip-icon" title="tooltip text"></span>
						</div>
						<div class="field-input">
							<?= $form->textField($model, 'indx', array('class' => 'input-text')); ?>
							<?= $form->error($model, 'indx'); ?>
						</div>
						<div class="field-lbl">
							<?= Yii::t('Front', 'Сountry'); ?>
							<span class="tooltip-icon" title="<?= Yii::t('Front', 'Choose country'); ?>"></span>
						</div>
						<div class="field-input ">
							<div class="select-custom">
							<span class="select-custom-label"><?= Yii::t('Front', 'Choose'); ?> </span>
								<?=
								$form->dropDownList($model, 'country_id', array_merge(array('' => Yii::t('Front', 'Choose')), CHtml::listData(Countries::model()->findAll(array('order' => 'name asc')), 'id', 'name')), array(
									'class' => 'country-select select-invisible'

								)); ?>
							</div>
							<?= $form->error($model, 'country_id'); ?>
						</div>
					</div>
					
					<div class="field-row edit-select">
						<div class="field-lbl">
							<?= Yii::t('Front', 'Address Line 2 (optional)'); ?>
							<span class="tooltip-icon" title="tooltip text"></span>
						</div>
						<div class="field-input">
							<?= $form->textField($model, 'address_optional', array('class' => 'input-text')); ?>
							<?= $form->error($model, 'address_optional'); ?>
						</div>
						<div class="field-lbl">
							<?= Yii::t('Front', 'City'); ?>
							<span class="tooltip-icon" title="tooltip text"></span>
						</div>
						<div class="field-input">
							<?= $form->textField($model, 'city', array('class' => 'input-text')); ?>
							<?= $form->error($model, 'city'); ?>
						</div>
						<div class="field-lbl">
							<?= Yii::t('Front', 'Address Type'); ?>
							<span class="tooltip-icon"
								title="<?= Yii::t('Front', 'Address type tooltip'); ?>"></span>
						</div>
						<div class="field-input ">
							<div class="select-custom">
								<span class="select-custom-label">
									<?= Yii::t('Front', 'Choose'); ?>
								</span>
								<?=
								$form->dropDownList($model, 'email_type_id', array_merge(array('' => Yii::t('Front', 'Choose')), CHtml::listData(Users_EmailTypes::model()->findAll(array('order' => 'type_name asc')), 'id', 'type_name')), array(
									'class' => 'country-select select-invisible item1'
								)); ?>
							</div>
							<?= $form->error($model, 'email_type_id'); ?>
						</div>
					</div>

					<input type="submit" class="violet-button-slim-square" href="#" value="<?= Yii::t('Front', 'Add'); ?>" />

					<?php $this->endWidget(); ?>
				</td>

			</tr>
			</tbody>
		</table>
		<div class="form-submit">
			<a href="<?= Yii::app()->createUrl('/personal/index') ?>" class="submit-button button-back">Back</a>
		</div>
		<div class="clearfix"></div>
	</div>
</div>