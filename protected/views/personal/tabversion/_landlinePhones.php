<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 28.07.14
 * Time: 17:05
 */ ?>

<div class="subheader"><?= Yii::t('Personal', 'Landline Phone') ?></div>
<div class=" xabina-form-normal">
    <table class="table xabina-table-contacts">
        <tr class="table-header">
            <th style="width: 33%"><?= Yii::t('Personal', 'Phone') ?></th>
            <th style="width: 39%"><?= Yii::t('Personal', 'Category') ?></th>
            <th style="width: 28%"></th>
        </tr>
        <?php foreach ($user->telephones as $users_phone): ?>
            <tr class="data-row">
                <td>+<?= $users_phone->number ?></td>
                <td><?= $users_phone->category->value ?></td>
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
                                        'data-url' => Yii::app()->createUrl('/personal/delete', array('type' => 'telephones', 'id' => $users_phone->id)),
                                    )) ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="add-new-row edit-row">
                <td colspan="3">
                    <?php $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'personal-landlinephones-phone-' . $users_phone->id,
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
                            'successCssClass' => 'valid',
                            'afterValidate' => 'js:Personal.afterValidate',
                            'afterValidateAttribute' => 'js:Personal.afterValidateAttribute',
                        ),
                    )); ?>
                    <?= $form->hiddenField($users_phone, 'id') ?>
                    <div class=" xabina-form-normal">
                        <div class="table-subheader"><?= Yii::t('Personal', 'Add landline phone number') ?></div>
                        <div class="row">
                            <div class="col-lg-5 col-md-5 col-sm-5">
                                <div class="form-cell">
                                    <div class="form-lbl">
                                        <?= Yii::t('Front', 'Phone') ?>
                                        <span class="tooltip-icon" title="<?= Yii::t('Personal', 'landline_phone_tooltip') ?>"></span>
                                    </div>
                                    <div class="form-input">
                                        <?php $users_phone->number = '+'.$users_phone->number ?>
                                        <?= $form->textField($users_phone, 'number', array('class' => 'input-text item0 numeric phone')); ?>
                                        <?= $form->error($users_phone, 'number'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-5">
                                <div class="form-cell">
                                    <div class="form-lbl">
                                        <?= Yii::t('Personal', 'Category') ?>
                                        <span class="tooltip-icon" title="<?= Yii::t('Personal', 'landline_phone_category_tooltip') ?>"></span>
                                    </div>
                                    <div class="form-input category-select">
                                        <div class="select-custom">

                                            <span class="select-custom-label"></span>
                                            <?= $form->dropDownList(
                                                $users_phone,
                                                'category_id',
                                                Html::listDataWithFilter(
                                                    $data_categories,
                                                    'id',
                                                    'value',
                                                    'data_type',
                                                    $users_phone->tableName()
                                                ) + array('add' => Yii::t('Front', 'Other')),
                                                array(
                                                    'class' => 'select-invisible',
                                                    'onchange' => 'Personal.showAddNewCategory(this)',
                                                    'empty' => Yii::t('Front', 'Select'),
                                                    'options' => array($users_phone->category_id => array('selected' => true)),
                                                )
                                            ) ?>
                                        </div>
                                        <?= $form->error($users_phone, 'category_id'); ?>
                                    </div>
                                    <div class="form-input add-new-category" style="display: none;">
                                    <span class="clear-input-cont full-with">
                                        <input type="text" name="Data_Category" maxlength="25" class="input-text" disabled="disabled">
                                        <span class="clear-input-but" onclick="Personal.hideCategoryTextField(this)"></span>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 ">
                                <div class="transaction-buttons-cont edit-submit-cont">
                                    <input type="submit" class="button ok" value="" />
                                    <a class="button cancel" href="javaScript:void(0)"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr class="data-row">
            <td colspan="3" class="add-new-td">
                <a class="rounded-buttons add-more upload" onclick="$(this).closest('tr').hide().closest('tr').next().toggle('slow')" href="javaScript:void(0)"><?= Yii::t('Front', 'Add new'); ?></a>
            </td>
        </tr>
        <tr class="add-new-row prof-form edit-row">
            <td colspan="3">
                <?php $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'personal-landlinephones',
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
                        'successCssClass' => 'valid',
                        'afterValidate' => 'js:Personal.afterValidate',
                        'afterValidateAttribute' => 'js:Personal.afterValidateAttribute',
                    ),
                )); ?>
                <?php $model_telephones = new Users_Telephones(); ?>
                <div class=" xabina-form-normal">
                    <div class="table-subheader"><?= Yii::t('Personal', 'Add landline phone number') ?></div>
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-5">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Front', 'Phone') ?>
                                    <span class="tooltip-icon" title="<?= Yii::t('Personal', 'landline_phone_tooltip') ?>"></span>
                                </div>
                                <div class="form-input">
                                    <?= $form->textField($model_telephones, 'number', array('class' => 'input-text item0 numeric phone')); ?>
                                    <?= $form->error($model_telephones, 'number'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Personal', 'Category') ?>
                                    <span class="tooltip-icon" title="<?= Yii::t('Personal', 'landline_phone_category_tooltip') ?>"></span>
                                </div>
                                <div class="form-input category-select">
                                    <div class="select-custom">

                                        <span class="select-custom-label"></span>
                                        <?= $form->dropDownList(
                                            $model_telephones,
                                            'category_id',
                                            Html::listDataWithFilter(
                                                $data_categories,
                                                'id',
                                                'value',
                                                'data_type',
                                                $model_telephones->tableName()
                                            ) + array('add' => Yii::t('Front', 'Other')),
                                            array(
                                                'class' => 'select-invisible',
                                                'onchange' => 'Personal.showAddNewCategory(this)',
                                                'empty' => Yii::t('Front', 'Select'),
                                                'options' => array($model_telephones->category_id => array('selected' => true)),
                                            )
                                        ) ?>
                                    </div>
                                    <?= $form->error($model_telephones, 'category_id'); ?>
                                </div>
                                <div class="form-input add-new-category" style="display: none;">
                                    <span class="clear-input-cont full-with">
                                        <input type="text" name="Data_Category" maxlength="25" class="input-text" disabled="disabled">
                                        <span class="clear-input-but" onclick="Personal.hideCategoryTextField(this)"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 ">
                            <div class="transaction-buttons-cont edit-submit-cont">
                                <input type="submit" class="button ok" value="" />
                                <a class="button cancel" href="javaScript:void(0)"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </td>
        </tr>
    </table>
</div>