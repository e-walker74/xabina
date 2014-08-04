<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 28.07.14
 * Time: 19:39
 */ ?>
<div class="xabina-form-normal">

<table class="table xabina-table-personal">
<tbody>
<tr class="table-header">
    <th style="width: 42%"><?= Yii::t('Front', 'Address'); ?></th>
    <th style="width: 25%"><?= Yii::t('Front', 'Type'); ?></th>
    <th style="width: 25%"><?= Yii::t('Front', 'Status'); ?></th>
    <th style="width: 8%"></th>
</tr>
<?php foreach($user->addresses as $addr):?>
    <tr class="data-row">
        <td class="address">
            <?= $addr->address ?><br>
            <?php if($addr->address_optional):?>
                <?= $addr->address_optional ?><br>
            <?php endif; ?>
            <?= $addr->indx?>
            <?= $addr->city?><?php if($addr->country): ?> (<?= $addr->country->code?>)<?php endif; ?>
        </td>
        <td>
            <div class="relative">
                <?= $addr->category->value ?>
            </div>
        </td>
        <td>
            <a <?php if($addr->is_master == 1):?>style="display:none;"<?php endif; ?> class="make-primary" href="javaScript:void(0)" onclick="js:Personal.makePrimary('<?= Yii::app()->createUrl('/personal/makePrimary', array('type' => 'address', 'id' => $addr->id)) ?>', this)"><?= Yii::t('Front', 'Make primary'); ?></a>
            <span <?php if($addr->is_master == 0):?>style="display:none;"<?php endif; ?> class="primary"><?= Yii::t('Front', 'Primary'); ?></span>
        </td>
        <td class="actions-td" style="overflow: visible!important">
            <div class="contact-actions transaction-buttons-cont">
                <div class="btn-group with-delete-confirm">
                    <a class="button menu" title="<?= Yii::t('Front', 'Options') ?>" data-toggle="dropdown" href="#"></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="javaScript:void(0)" title="<?= Yii::t('Front', 'Edit') ?>" class="button edit"></a>
                        </li>
                        <?php if(!$addr->is_master): ?>
                        <li>
                            <?= Html::link('', 'javaScript:void(0)', array(
                                'class' => 'button delete',
                                'onclick' => '$(this).addClass(\'opened\')',
                                'data-url' => Yii::app()->createUrl('/personal/delete', array('type' => 'address', 'id' => $addr->id)),
                            )) ?>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </td>
    </tr>
    <tr class="edit-row" style="display:none;">
        <td colspan="4">
            <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'adress_form_'.$addr->id,
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'action' => $this->createUrl('personal/editaddress'),
                'errorMessageCssClass' => 'error-message',
                'htmlOptions' => array(
                    'class' => 'form-validable',
                    'style' => 'position: relative;',
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
            <?= $form->hiddenField($addr, 'id'); ?>
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-5">
                    <div class="form-cell">
                        <div class="form-lbl">
                            <?= Yii::t('Personal', 'Address Line 1') ?>
                            <span class="tooltip-icon" title="<?= Yii::t('Personal', 'personal_address_line_tooltip') ?>"></span>
                        </div>
                        <div class="form-input">
                            <?= $form->textField($addr, 'address', array('class' => 'input-text')); ?>
                            <?= $form->error($addr, 'address'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5">
                    <div class="form-cell">
                        <div class="form-lbl">
                            <?= Yii::t('Personal', 'Address Line 2 (optional)') ?>
                            <span class="tooltip-icon" title="<?= Yii::t('Personal', 'personal_address_line2_tooltip') ?>"></span>
                        </div>
                        <div class="form-input">
                            <?= $form->textField($addr, 'address_optional', array('class' => 'input-text')); ?>
                            <?= $form->error($addr, 'address_optional'); ?>
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
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-5">
                    <div class="form-cell">
                        <div class="form-lbl">
                            <?= Yii::t('Personal', 'Index') ?>
                            <span class="tooltip-icon" title="<?= Yii::t('Personal', 'personal_address_index_tooltip') ?>"></span>
                        </div>
                        <div class="form-input">
                            <?= $form->textField($addr, 'indx', array('class' => 'input-text')); ?>
                            <?= $form->error($addr, 'indx'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5">
                    <div class="form-cell">
                        <div class="form-lbl">
                            <?= Yii::t('Personal', 'City') ?>
                            <span class="tooltip-icon" title="<?= Yii::t('Personal', 'personal_address_city_tooltip') ?>"></span>
                        </div>
                        <div class="form-input">
                            <?= $form->textField($addr, 'city', array('class' => 'input-text')); ?>
                            <?= $form->error($addr, 'city'); ?>
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
                            <?= Yii::t('Personal', 'Country') ?>
                            <span class="tooltip-icon" title="<?= Yii::t('Personal', 'personal_address_country_tooltip') ?>"></span>
                        </div>
                        <div class="form-input">
                            <div class="select-custom">
                                <span class="select-custom-label"></span>
                                <?=
                                $form->dropDownList(
                                    $addr,
                                    'country_id',
                                    CHtml::listData($countries, 'id', 'name'),
                                    array(
                                        'class' => 'country-select select-invisible',
                                        'options' => array(
                                            '' => array('disabled' => true),
                                        ),
                                        'empty' => Yii::t('Profile', 'Select'),

                                    )); ?>
                            </div>
                            <?= $form->error($addr, 'country_id'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5">
                    <div class="form-cell">
                        <div class="form-lbl">
                            <?= Yii::t('Personal', 'Category') ?>
                            <span class="tooltip-icon" title="<?= Yii::t('Personal', 'personal_address_category_tooltip') ?>"></span>
                        </div>
                        <div class="form-input">
                            <div class="form-input category-select">
                                <div class="select-custom">

                                    <span class="select-custom-label"></span>
                                    <?= $form->dropDownList(
                                        $addr,
                                        'category_id',
                                        Html::listDataWithFilter(
                                            $data_categories,
                                            'id',
                                            'value',
                                            'data_type',
                                            $addr->tableName()
                                        ) + array('add' => Yii::t('Front', 'Other')),
                                        array(
                                            'class' => 'select-invisible',
                                            'onchange' => 'Personal.showAddNewCategory(this)',
                                            'empty' => Yii::t('Front', 'Select'),
                                            'options' => array($addr->category_id => array('selected' => true)),
                                        )
                                    ) ?>
                                </div>
                                <?= $form->error($addr, 'category_id'); ?>
                            </div>
                            <div class="form-input add-new-category" style="display: none;">
                            <span class="clear-input-cont full-with">
                                <input type="text" name="Data_Category" maxlength="25" class="input-text" disabled="disabled">
                                <span class="clear-input-but" onclick="Personal.hideCategoryTextField(this)"></span>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 ">

                </div>
            </div>
            <?php $this->endWidget(); ?>
        </td>
    </tr>
<?php endforeach; ?>
<?php if(!$user->addresses): ?>
    <tr class="comment-tr">
        <td colspan="4" style="line-height: 1.43!important">
					<span class="rejected">
						<?= Yii::t('Front', 'You have not added any address yet. You can add new address by clicking "Add new" button.') ?>
					</span>
        </td>
    </tr>
<?php endif; ?>

<tr class="data-row">
    <td colspan="4">
        <a class="rounded-buttons add-more upload" onclick="resetPage(); $(this).closest('tr').hide().closest('tr').next().slideDown('slow')" href="javaScript:void(0)"><?= Yii::t('Front', 'Add new'); ?></a>
    </td>
</tr>

<tr class="edit-row">
    <td colspan="4">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'adress_form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'action' => $this->createUrl('personal/editaddress'),
            'errorMessageCssClass' => 'error-message',
            'htmlOptions' => array(
                'class' => 'form-validable',
                'style' => 'position: relative;',
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
        <div class="table-subheader"><?= Yii::t('Personal', 'Add address') ?></div>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5">
                <div class="form-cell">
                    <div class="form-lbl">
                        <?= Yii::t('Personal', 'Address Line 1') ?>
                        <span class="tooltip-icon" title="<?= Yii::t('Personal', 'personal_address_line_tooltip') ?>"></span>
                    </div>
                    <div class="form-input">
                        <?= $form->textField($model, 'address', array('class' => 'input-text')); ?>
                        <?= $form->error($model, 'address'); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5">
                <div class="form-cell">
                    <div class="form-lbl">
                        <?= Yii::t('Personal', 'Address Line 2 (optional)') ?>
                        <span class="tooltip-icon" title="<?= Yii::t('Personal', 'personal_address_line2_tooltip') ?>"></span>
                    </div>
                    <div class="form-input">
                        <?= $form->textField($model, 'address_optional', array('class' => 'input-text')); ?>
                        <?= $form->error($model, 'address_optional'); ?>
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
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5">
                <div class="form-cell">
                    <div class="form-lbl">
                        <?= Yii::t('Personal', 'Index') ?>
                        <span class="tooltip-icon" title="<?= Yii::t('Personal', 'personal_address_index_tooltip') ?>"></span>
                    </div>
                    <div class="form-input">
                        <?= $form->textField($model, 'indx', array('class' => 'input-text')); ?>
                        <?= $form->error($model, 'indx'); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5">
                <div class="form-cell">
                    <div class="form-lbl">
                        <?= Yii::t('Personal', 'City') ?>
                        <span class="tooltip-icon" title="<?= Yii::t('Personal', 'personal_address_city_tooltip') ?>"></span>
                    </div>
                    <div class="form-input">
                        <?= $form->textField($model, 'city', array('class' => 'input-text')); ?>
                        <?= $form->error($model, 'city'); ?>
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
                        <?= Yii::t('Personal', 'Country') ?>
                        <span class="tooltip-icon" title="<?= Yii::t('Personal', 'personal_address_country_tooltip') ?>"></span>
                    </div>
                    <div class="form-input">
                        <div class="select-custom">
                            <span class="select-custom-label"></span>
                            <?=
                            $form->dropDownList(
                                $model,
                                'country_id',
                                CHtml::listData($countries, 'id', 'name'),
                                array(
                                    'class' => 'country-select select-invisible',
                                    'options' => array(
                                        '' => array('disabled' => true),
                                    ),
                                    'empty' => Yii::t('Profile', 'Select'),

                                )); ?>
                        </div>
                        <?= $form->error($model, 'country_id'); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5">
                <div class="form-cell">
                    <div class="form-lbl">
                        <?= Yii::t('Personal', 'Category') ?>
                        <span class="tooltip-icon" title="<?= Yii::t('Personal', 'personal_address_category_tooltip') ?>"></span>
                    </div>
                    <div class="form-input">
                        <div class="form-input category-select">
                            <div class="select-custom">

                                <span class="select-custom-label"></span>
                                <?= $form->dropDownList(
                                    $model,
                                    'category_id',
                                    Html::listDataWithFilter(
                                        $data_categories,
                                        'id',
                                        'value',
                                        'data_type',
                                        $model->tableName()
                                    ) + array('add' => Yii::t('Front', 'Other')),
                                    array(
                                        'class' => 'select-invisible',
                                        'onchange' => 'Personal.showAddNewCategory(this)',
                                        'empty' => Yii::t('Front', 'Select'),
                                        'options' => array($model->category_id => array('selected' => true)),
                                    )
                                ) ?>
                            </div>
                            <?= $form->error($model, 'category_id'); ?>
                        </div>
                        <div class="form-input add-new-category" style="display: none;">
                            <span class="clear-input-cont full-with">
                                <input type="text" name="Data_Category" maxlength="25" class="input-text" disabled="disabled">
                                <span class="clear-input-but" onclick="Personal.hideCategoryTextField(this)"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 ">

            </div>
        </div>
        <?php $this->endWidget(); ?>
    </td>
</tr>
</tbody>
</table>
</div>