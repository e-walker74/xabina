
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'users_instmessager',
			'enableAjaxValidation'=>true,
			'enableClientValidation'=>true,
			'errorMessageCssClass' => 'error-message',
			'htmlOptions' => array(
				'class' => 'form-validable',
				'enctype' => 'multipart/form-data'
			),
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
				'validateOnChange'=>true,
				'errorCssClass'=>'input-error',
				'successCssClass'=>'valid',
                'afterValidate' => 'js:Personal.afterValidate',
                'afterValidateAttribute' => 'js:Personal.afterValidateAttribute',
			),
		)); ?>
		<table class="table xabina-table-personal">
			<tbody>
			<tr class="table-header">
				<th style="width: 26%"><?= Yii::t('Front', 'Instant Messaging'); ?></th>
				<th style="width: 25%"><?= Yii::t('Front', 'Username'); ?></th>
				<th style="width: 21%"><?= Yii::t('Front', 'Type'); ?></th>
				<th style="width: 20%"><?= Yii::t('Front', 'Status'); ?></th>
				<th style="width: 8%"></th>
			</tr>
			<?php foreach($user->messagers as $mes): ?>
				<tr>
					<td>
						<div class="messenger-ico <?= $mes->messager_system->code ?>"></div> <?= $mes->messager_system->name ?>
					</td>
					<td><?= $mes->messager_login ?></td>
					<td>
						<div class="relative">
							<!--<span class="dropdown_button types_dropdown" row-id="<?= $mes->id ?>">-->
								<?= $mes->type->type_name ?>
							<!--</span>-->
					   </div>
					</td>
					<td>
						<?php if($mes->is_master): ?>
							<span class="primary"><?= Yii::t('Front', 'Primary'); ?></span>
						<?php else: ?>
							<a href="javaScript:void(0)" onclick="js:Personal.makePrimary('<?= Yii::app()->createUrl('/personal/makePrimary', array('type' => 'instmessagers', 'id' => $mes->id)) ?>', this)"><?= Yii::t('Front', 'Make primary'); ?></a>
						<?php endif; ?>
					</td>
					<td class="actions-td">
						<div class="transaction-buttons-cont">
                            <?php if(!$mes->is_master): ?>
							<a class="button delete" data-url="<?= Yii::app()->createUrl('/personal/delete', array('type' => 'messager', 'id' => $mes->id)) ?>" ></a>
                            <?php endif; ?>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
			<?php if(!$user->messagers): ?>
			<tr class="comment-tr">
				<td colspan="6" style="line-height: 1.43!important">
					<span class="rejected">
						<?= Yii::t('Front', 'You have not added any instant messenger yet. You can add new instant messenger by clicking "Add new" button.') ?>
					</span>
				</td>
			</tr>
			<?php endif; ?>
			<tr>
				<td class="add-new-td" colspan="5">
					<a class="table-btn" onclick="$(this).parents('tr').hide()" href="javaScript:void($('.prof-form').toggle('slow'))"><?= Yii::t('Front', 'Add new'); ?></a>
				</td>
			</tr>

			<tr class="prof-form">
				<td colspan="5" class="table-form-subheader">
					<div class="table-subheader"><?= Yii::t('Front', 'Add instant messenger'); ?></div>
				</td>
			</tr>
			<tr class="prof-form messenger-form-tr">
				<td colspan="5">
				   <table class="messanger-table">
					   <tbody><tr>
						   <td colspan="2">
								<div class="transaction-buttons-cont">
									<input type="submit" class="button ok submit" value="" />
									<a class="button cancel" href="javaScript:void(0)"></a>
								</div>
								<div class="field-row left-coll">
								   <div class="field-lbl">

									   <?= Yii::t('Front', 'Instant Messenger'); ?>

									   <span class="tooltip-icon" title="<?= Yii::t('Front', 'Select one of instant messengers'); ?>"></span>
								   </div>
								   <div class="field-input ">
									   <div class="select-custom">
										   <span class="select-custom-label"><?= Yii::t('Front', 'Skype'); ?> </span>
										   <?= $form->dropDownList($model, 'messager_type', CHtml::listData(InstmessagerSystems::model()->findAll('status = 1'), 'id', 'name'), array('class' => 'country-select select-invisible')); ?>
										   <?= $form->error($model, 'messager_type'); ?>
									   </div>
								   </div>
							   </div>
							   <div class="field-row right-coll">
								   <div class="field-lbl ">

										<?= Yii::t('Front', 'Username'); ?>

									   <span class="tooltip-icon" title="tooltip text"></span>
								   </div>
								   <div class="field-input">
										<?= $form->textField($model, 'messager_login', array('class' => 'input-text')); ?>
										<?= $form->error($model, 'messager_login'); ?>
								   </div>
							   </div>
						   </td>
					   </tr>
				   </tbody>
				   </table>
				</td>
			</tr>
			</tbody>
		</table>
		<?php $this->endWidget(); ?>
