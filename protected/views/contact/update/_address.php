<div class=" xabina-form-narrow">
	<table class="table xabina-table-contacts">
		<tr class="table-header">
			<th style="width: 48%"><?= Yii::t('Front', 'Address'); ?></th>
			<th style="width: 21%"><?= Yii::t('Front', 'Category'); ?></th>
			<th style="width: 23%"><?= Yii::t('Front', 'Status'); ?></th>
			<th style="width: 8%"></th>
		</tr>
        <tr class="comment-tr empty-table <?php if (count($model->getDataByType('address'))): ?>hidden<?php endif; ?>">
            <td colspan="4" style="line-height: 1.43!important">
                <span class="rejected "><?= Yii::t('Front', 'You do not added a address yet. You can add new address by clicking “Add new” button') ?></span>
            </td>
        </tr>
		<?php foreach($model->getDataByType('address') as $m): ?>
		<tr class="data-row <?= (isset($new_model_id) && $new_model_id == $m->id) ? 'flash_notify_here' : '' ?>">
			<td>
				<?= $m->getAddressHtml() ?>
			</td>
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
                        <a class="button menu" title="<?= Yii::t('Front', 'Options') ?>" data-toggle="dropdown" href="#"></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="javaScript:void(0)" title="<?= Yii::t('Front', 'Edit') ?>" class="button edit"></a>
                            </li>
                            <li>
                                <?= Html::link('', 'javaScript:void(0)', array(
                                    'class' => 'button delete',
                                    'onclick' => '$(this).addClass(\'opened\')',
                                    'data-url' => Yii::app()->createUrl('/contact/deleteData', array('type' => 'address', 'id' => $m->id)),
                                )) ?>
                            </li>
                        </ul>
                    </div>

                </div>
            </td>
		</tr>
		<tr class="edit-row">
			<td colspan="4">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'dataform-form-address'.$m->id,
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
				<div class="xabina-form-narrow">
					<div class="row">
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Address') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'address_name_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($m, 'address', array('class' => 'input-text')) ?>
									<?= $form->error($m, 'address') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Address Line 2') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'address_name_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($m, 'address_line_2', array('class' => 'input-text')) ?>
									<?= $form->error($m, 'address_line_2') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 ">
							<div class="transaction-buttons-cont edit-submit-cont">
								<input type="submit" title="<?= Yii::t('Front', 'Save') ?>" class="button ok" value=""/>
								<a href="javaScript:void(0)" title="<?= Yii::t('Front', 'Cancel') ?>" class="button cancel"></a>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Index') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'index_address_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($m, 'index', array('class' => 'input-text')) ?>
									<?= $form->error($m, 'index') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'City') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'city_address_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($m, 'city', array('class' => 'input-text')) ?>
									<?= $form->error($m, 'city') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 ">

						</div>
					</div>
					<div class="row">
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Country') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'country_name_contact') ?>"></span>
								</div>
								<div class="form-input">
									<div class="select-custom select-narrow ">
										<span class="select-custom-label"></span>
										<?= $form->dropDownList(
											$m,
											'country_id',
											CHtml::listData(Countries::model()->findAll(array('order' => 'name asc')), 'id', 'name'),
											array(
												'class' => 'select-invisible country-select',
												'options' => array($m->country_id => array('selected' => true)),
												'empty' => Yii::t('Front', 'Select')
											)
										); ?>
									</div>
									<?= $form->error($m, 'country_id'); ?>
								</div>
							</div>
						</div>
                        <div class="col-lg-5 col-md-5 col-sm-5">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Front', 'Category') ?>
                                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'country_name_contact') ?>"></span>
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
                                                'address'
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
                                        <input type="text" name="Data_Category" maxlength="25" class="input-text" disabled="disabled">
                                        <span class="clear-input-but" onclick="hideCategoryTextField(this)"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
						<div class="col-lg-2 col-md-2 col-sm-2 ">

						</div>
					</div>
				</div>
				<?php $this->endWidget(); ?>
			</td>
		</tr>
		<?php endforeach; ?>
		<tr class="data-row">
			<td colspan="4">
				<a href="javaScript:void(0)" class="rounded-buttons upload add-more"><?= Yii::t('Front', 'Add NEW'); ?></a>
			</td>
		</tr>
		<tr class="edit-row">
			<td colspan="4">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'dataform-form-address',
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
				<?php $m = new Users_Contacts_Data_Address; ?>
                <div class="table-subheader"><?= Yii::t('Front', 'Add new address'); ?></div>
				<div class="xabina-form-narrow">
					<div class="row">
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Address Line 1') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'address_name_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($m, 'address', array('class' => 'input-text')) ?>
									<?= $form->error($m, 'address') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Address Line 2') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'address_name_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($m, 'address_line_2', array('class' => 'input-text')) ?>
									<?= $form->error($m, 'address_line_2') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 ">
							<div class="transaction-buttons-cont edit-submit-cont">
								<input type="submit" title="<?= Yii::t('Front', 'Save') ?>" class="button ok" value=""/>
								<a href="javaScript:void(0)" title="<?= Yii::t('Front', 'Cancel') ?>" class="button cancel"></a>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Index') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'index_address_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($m, 'index', array('class' => 'input-text')) ?>
									<?= $form->error($m, 'index') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'City') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'city_address_contact') ?>"></span>
								</div>
								<div class="form-input">
									<?= $form->textField($m, 'city', array('class' => 'input-text')) ?>
									<?= $form->error($m, 'city') ?>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 ">

						</div>
					</div>
					<div class="row">
						<div class="col-lg-5 col-md-5 col-sm-5">
							<div class="form-cell">
								<div class="form-lbl">
									<?= Yii::t('Front', 'Country') ?>
									<span class="tooltip-icon" title="<?= Yii::t('Front', 'country_name_contact') ?>"></span>
								</div>
								<div class="form-input">
									<div class="select-custom select-narrow ">
										<span class="select-custom-label"></span>
										<?= $form->dropDownList(
											$m,
											'country_id',
											CHtml::listData(Countries::model()->findAll(array('order' => 'name asc')), 'id', 'name'),
											array(
												'class' => 'select-invisible country-select',
												'options' => array($m->country_id => array('selected' => true)),
												'empty' => Yii::t('Front', 'Select')
											)
										); ?>
									</div>
									<?= $form->error($m, 'country_id'); ?>
								</div>
							</div>
						</div>
                        <div class="col-lg-5 col-md-5 col-sm-5">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Front', 'Category') ?>
                                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'country_name_contact') ?>"></span>
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
                                                'address'
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
                                        <input type="text" name="Data_Category" maxlength="25" class="input-text" disabled="disabled">
                                        <span class="clear-input-but" onclick="hideCategoryTextField(this)"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
						<div class="col-lg-2 col-md-2 col-sm-2 ">

						</div>
					</div>
				</div>
				<?php $this->endWidget(); ?>
			</td>
		</tr>
	</table>
</div>