<div class=" xabina-form-narrow">
	<table class="table xabina-table-contacts">
		<tr class="table-header">
			<th style="width: 31%"><?= Yii::t('Front', 'Instant Messaging') ?></th>
			<th style="width: 26%"><?= Yii::t('Front', 'Username') ?></th>
			<th style="width: 16%"><?= Yii::t('Front', 'Category') ?></th>
			<th style="width: 19%"><?= Yii::t('Front', 'Status') ?></th>
			<th style="width: 8%"></th>
		</tr>
		<?php foreach($model->getDataByType('instmessaging') as $m): ?>
		<tr class="data-row">
			<td>
				<div class="messenger-ico <?= $m->messanger ?>"></div>
				<?= $m->messanger ?>
			</td>
			<td><?= $m->name ?></td>
			<td><?= ($m->getDbModel()->category) ? $m->getDbModel()->category->value : ''  ?></td>
            <td>
                <?php if($m->getDbModel()->is_primary): ?>
                    <span class="primary">
                        <?= Yii::t('Front', 'Primary') ?>
                    </span>
                <?php else: ?>
                    <a class="make-primary" href="javaScript:void(0)" data-url="<?= Yii::app()->createUrl('/contact/makePrimary', array('entity' => $m->getDbModel()->data_type, 'id' => $m->getDbModel()->id)) ?>" onclick="makePrimary(this)"><?= Yii::t('Front', 'Make primary') ?></a>
                <?php endif; ?>
            </td>
            <td style="overflow: visible!important;">
                <div class="contact-actions transaction-buttons-cont">
                    <div class="btn-group with-delete-confirm">
                        <a class="button menu" data-toggle="dropdown" href="#"></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="javaScript:void(0)" class="button edit"></a>
                            </li>
                            <li>
                                <?= Html::link('', 'javaScript:void(0)', array(
                                    'class' => 'button delete',
                                    'onclick' => '$(this).addClass(\'opened\')',
                                    'data-url' => Yii::app()->createUrl('/contact/deleteData', array('type' => 'instmessaging', 'id' => $m->id)),
                                )) ?>
                            </li>
                        </ul>
                    </div>

                </div>
            </td>
		</tr>
            <tr class="edit-row">
                <td colspan="5">
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'dataform-form-instmess'.$m->id,
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
                        <div class="col-lg-3 col-md-3  col-sm-3">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Front', 'Inst. Messenger'); ?>
                                    <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                                </div>
                                <div class="form-input">
                                    <span class="select-custom-label"></span>
                                    <div class="select-custom select-narrow ">
                                        <span class="select-custom-label"></span>
                                        <?= $form->dropDownList(
                                            $m,
                                            'messanger',
                                            CHtml::listData(InstmessagerSystems::model()->findAll(), 'code', 'name'),
                                            array(
                                                'class' => 'select-invisible country-select',
                                                'options' => array($m->messanger => array('selected' => true)),
                                                'empty' => Yii::t('Front', 'Select')
                                            )
                                        ); ?>
                                    </div>
                                    <?= $form->error($m, 'messanger') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Front', 'Username'); ?>
                                    <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                                </div>
                                <div class="form-input">
                                    <div class="form-input">
                                        <?= $form->textField($m, 'name', array('class' => 'input-text')) ?>
                                        <?= $form->error($m, 'name') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Front', 'Type'); ?>
                                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'type_inst_mess_contact'); ?>"></span>
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
                                                'instmessaging'
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
                                <input type="submit" class="button ok" value="" />
                                <a href="javaScript:void(0)" class="button cancel"></a>
                            </div>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </td>
            </tr>
		<?php endforeach; ?>
		<tr class="data-row">
			<td colspan="5">
				<a href="javaScript:void(0)" class="rounded-buttons upload add-more"><?= Yii::t('Front', 'Add NEW') ?></a>
			</td>
		</tr>
		<tr class="edit-row">
			<td colspan="5">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'dataform-form-instmess',
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
				<?php $m = new Users_Contacts_Data_Instmessaging; ?>
                <div class="table-subheader"><?= Yii::t('Front', 'Add new instant messaging'); ?></div>
				<div class="row">
					<div class="col-lg-3 col-md-3  col-sm-3">
						<div class="form-cell">
							<div class="form-lbl">
								<?= Yii::t('Front', 'Inst. Messenger'); ?>
								<span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
							</div>
							<div class="form-input">
								<span class="select-custom-label"></span>
								<div class="select-custom select-narrow ">
									<span class="select-custom-label"></span>
									<?= $form->dropDownList(
										$m,
										'messanger',
										CHtml::listData(InstmessagerSystems::model()->findAll(), 'code', 'name'),
										array(
											'class' => 'select-invisible country-select', 
											'options' => array($m->messanger => array('selected' => true)),
											'empty' => Yii::t('Front', 'Select')
										)
									); ?>
								</div>
                                <?= $form->error($m, 'messanger') ?>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4">
						<div class="form-cell">
							<div class="form-lbl">
								<?= Yii::t('Front', 'Username'); ?>
								<span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
							</div>
							<div class="form-input">
								<div class="form-input">
									<?= $form->textField($m, 'name', array('class' => 'input-text')) ?>
									<?= $form->error($m, 'name') ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3">
						<div class="form-cell">
							<div class="form-lbl">
								<?= Yii::t('Front', 'Type'); ?>
								<span class="tooltip-icon" title="<?= Yii::t('Front', 'type_inst_mess_contact'); ?>"></span>
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
                                            'instmessaging'
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
							<input type="submit" class="button ok" value="" />
							<a href="javaScript:void(0)" class="button cancel"></a>
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