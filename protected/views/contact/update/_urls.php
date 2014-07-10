<div class=" xabina-form-narrow">
	<table class="table xabina-table-contacts">
		<tr class="table-header">
			<th style="width: 50%"><?= Yii::t('Front', 'URL') ?></th>
			<th style="width: 42%"><?= Yii::t('Front', 'Category') ?></th>
			<th style="width: 8%"></th>
		</tr>
		<?php foreach($model->getDataByType('urls') as $m): ?>
		<tr class="data-row">
			<td><?= $m->url ?></td>
			<td><?= ($m->getDbModel()->category) ? $m->getDbModel()->category->value : ''  ?></td>
            <td style="overflow: visible!important;">
                <div class="contact-actions transaction-buttons-cont">
                    <div class="btn-group with-delete-confirm">
                        <a class="button menu" title="<?= Yii::t('Front', 'Options') ?>" data-toggle="dropdown" href="#"></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="javaScript:void(0)" title="<?= Yii::t('Front', 'Edit') ?>" class="button edit"></a>
                            </li>
                            <li>
                                <?= Html::link('', 'javaScript:void(0)', array(
                                    'class' => 'button delete',
                                    'onclick' => '$(this).addClass(\'opened\')',
                                    'data-url' => Yii::app()->createUrl('/contact/deleteData', array('type' => 'urls', 'id' => $m->id)),
                                )) ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </td>
		</tr>
		<tr class="edit-row">
			<td colspan="3">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'dataform-form-urls'.$m->id,
                    'action' => array('/contact/update', 'url' => $model->url),
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
				<?= $form->hiddenField($m, 'id') ?>
				<div class="row">
					<div class="col-lg-6 col-md-6  col-sm-6">
						<div class="form-cell">
							<div class="form-lbl">
								<?= Yii::t('Front', 'Type URL Adress') ?>
								<span class="tooltip-icon" title="<?= Yii::t('Front', 'contact_url') ?>"></span>
							</div>
							<div class="form-input">
								<div class="form-input">
									<?= $form->textField($m, 'url', array('class' => 'input-text')) ?>
									<?= $form->error($m, 'url') ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4">
						<div class="form-cell">
							<div class="form-lbl">
								<?= Yii::t('Front', 'Category'); ?>
								<span class="tooltip-icon" title="<?= Yii::t('Front', 'category_tooltip'); ?>"></span>
							</div>
                            <div class="form-input category-select">
                                <div class="select-custom select-narrow ">
                                    <span class="select-custom-label"></span>
                                    <?= $form->dropDownList(
                                        $m,
                                        'category_id',
                                        Html::listDataWithFilter(
                                            $data_categories,
                                            'id',
                                            'value',
                                            'data_type',
                                            'urls'
                                        ) + array('add' => Yii::t('Front', 'Other')),
                                        array(
                                            'class' => 'select-invisible',
                                            'onchange' => 'showAddNewCategory(this)',
                                            'empty' => Yii::t('Front', 'Select'),
                                            'options' => array($m->getDbModel()->category_id => array('selected' => true)),
                                        )
                                    ) ?>
                                </div>
                            </div>
                            <div class="form-input add-new-category" style="display: none;">
                                <span class="clear-input-cont full-with">
                                    <input type="text" name="Data_Category" class="input-text" disabled="disabled">
                                    <span class="clear-input-but" onclick="hideCategoryTextField(this)"></span>
                                </span>
                            </div>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2">
						<div class="transaction-buttons-cont edit-submit-cont">
							<input type="submit" title="<?= Yii::t('Front', 'Save') ?>" class="button ok" value="" />
							<a href="javaScript:void(0)" title="<?= Yii::t('Front', 'Cancel') ?>" class="button cancel"></a>
						</div>
					</div>
				</div>
				<?php $this->endWidget(); ?>
			</td>
		</tr>
		<?php endforeach; ?>
		<tr class="data-row">
			<td colspan="3">
				<a href="javaScript:void(0)" class="rounded-buttons upload add-more"><?= Yii::t('Front', 'Add NEW') ?></a>
			</td>
		</tr>
		<tr class="edit-row">
			<td colspan="3">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'dataform-form-urls',
                    'action' => array('/contact/update', 'url' => $model->url),
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
				<?php $m = new Users_Contacts_Data_Urls; ?>
                <div class="table-subheader"><?= Yii::t('Front', 'Add new URL'); ?></div>
				<div class="row">
					<div class="col-lg-6 col-md-6  col-sm-6">
						<div class="form-cell">
							<div class="form-lbl">
								<?= Yii::t('Front', 'Type URL Adress') ?>
								<span class="tooltip-icon" title="<?= Yii::t('Front', 'contact_url') ?>"></span>
							</div>
							<div class="form-input">
								<div class="form-input">
									<?= $form->textField($m, 'url', array('class' => 'input-text')) ?>
									<?= $form->error($m, 'url') ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4">
						<div class="form-cell">
							<div class="form-lbl">
								<?= Yii::t('Front', 'Category'); ?>
								<span class="tooltip-icon" title="<?= Yii::t('Front', 'category_tooltip'); ?>"></span>
							</div>
                            <div class="form-input category-select">
                                <div class="select-custom select-narrow ">
                                    <span class="select-custom-label"></span>
                                    <?= $form->dropDownList(
                                        $m,
                                        'category_id',
                                        Html::listDataWithFilter(
                                            $data_categories,
                                            'id',
                                            'value',
                                            'data_type',
                                            'urls'
                                        ) + array('add' => Yii::t('Front', 'Other')),
                                        array(
                                            'class' => 'select-invisible',
                                            'onchange' => 'showAddNewCategory(this)',
                                            'empty' => Yii::t('Front', 'Select'),
                                        )
                                    ) ?>
                                </div>
                            </div>
                            <div class="form-input add-new-category" style="display: none;">
                                <span class="clear-input-cont full-with">
                                    <input type="text" name="Data_Category" class="input-text" disabled="disabled">
                                    <span class="clear-input-but" onclick="hideCategoryTextField(this)"></span>
                                </span>
                            </div>
						</div>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2">
						<div class="transaction-buttons-cont edit-submit-cont">
							<input type="submit" title="<?= Yii::t('Front', 'Save') ?>" class="button ok" value="" />
							<a href="javaScript:void(0)" title="<?= Yii::t('Front', 'Cancel') ?>" class="button cancel"></a>
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
	$('.xabina-form-narrow .transaction-buttons-cont .delete').confirmation({
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