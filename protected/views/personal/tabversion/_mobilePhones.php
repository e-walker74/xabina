<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 28.07.14
 * Time: 17:01
 * @var Users_Phones $users_phones
 */ ?>

<div class="subheader" style="margin-top: 0"><?= Yii::t('Personal', 'Mobile Phones') ?></div>
<div class=" xabina-form-normal">
    <table class="table xabina-table-contacts">
        <tr class="table-header">
            <th style="width: 33%"><?= Yii::t('Personal', 'Phone')?></th>
            <th style="width: 29%"><?= Yii::t('Personal', 'Category')?></th>
            <th style="width: 29%"><?= Yii::t('Personal', 'Status')?></th>
            <th style="width: 9%"></th>
        </tr>
        <?php foreach ($users_phones as $users_phone): ?>
            <?php if($users_phone->hash && !$users_phone->is_master): ?>
                <tr>
                    <td colspan="4" class="form-border" style="overflow: visible!important;">

                        <div class="note-arr">
                            <div class="note-bg">
                                <?php if($users_phone->status == 1): ?>
                                    <?= Yii::t('Personal', 'varitication_code_to_primary_phone:phone.', array(':phone' => '+' . $users_phone->user->phone)) ?>
                                <?php else: ?>
                                    <?= Yii::t('Personal', 'varitication_code_activate_phone:phone.', array(':phone' => '+' . $users_phone->phone)) ?>
                                <?php endif; ?>
                                <a href="<?= $this->createUrl('/personal/resendsms', array('id' => $users_phone->id)) ?>" onclick='return Personal.resendSms(this)'><?= Yii::t('Front', 'Send verification code once again'); ?></a>
                            </div>
                            <div class="arr"></div>
                        </div>
                        <div class=" xabina-form-narrow">
                            <div class="container-form" style="margin: 0 0 10px">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <div class="form-cell">
                                            <div class="form-lbl">&nbsp;</div>
                                            <div class="form-input">
                                                +<?= $users_phone->phone ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                        <div class="form-cell">
                                            <div class="form-lbl">&nbsp;</div>
                                            <div class="form-input">
                                                <?php if($users_phone->category): ?>
                                                    <?= $users_phone->category->value ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <?php if($users_phone->is_master != 1):?>
                                            <div class="form-cell">
                                                <div class="form-lbl pull-left" style="margin: 18px 0 0">
                                                    <?= Yii::t('Personal', 'sms_code') ?>
                                                    <span class="tooltip-icon" title="<?= Yii::t('Personal', 'sms_code_tooltip') ?>"></span>
                                                </div>
                                                <div class="form-input pull-right" style="width: 50%">
                                                    <input type="text" name="code_activation" class="input-text" />
                                                    <div class="error-message"><?= Yii::t('Personal', 'Sms code is incorrect') ?></div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 ">
                                        <div class="transaction-buttons-cont" style="margin:10px 0 0;">
                                            <a href="javaScript:void(0)" title="<?= Yii::t('Front', 'OK') ?>" class="button ok pull-left" onclick="Personal.activatePhone('<?= $this->createUrl('/personal/activate', array('type' => 'phones', 'hash' => "" )) ?>', this)"></a>
                                            <?php if($users_phone->hash && !$users_phone->status): ?>
                                                <a class="button delete"  title="<?= Yii::t('Front', 'Remove') ?>" data-url="<?= Yii::app()->createUrl('/personal/delete', array('type' => 'phones', 'id' => $users_phone->id)) ?>" ></a>
                                            <?php elseif($users_phone->hash && $users_phone->status): ?>
                                                <a class="button remove" onclick="js:Personal.makePrimary('<?= Yii::app()->createUrl('/personal/cancelMakePrimary', array('type' => 'phones', 'id' => $users_phone->id)) ?>', this)"  title="<?= Yii::t('Front', 'Remove') ?>" ></a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php else: ?>
                <tr>
                    <td>+<?= $users_phone->phone ?></td>
                    <td><?= ($users_phone->category) ? $users_phone->category->value : "" ?></td>
                    <td class="status-td">
                        <?php if($users_phone->status == 0 && $users_phone->is_master == 0):?>
                            <div class="field-row">
                                <div class="field-lbl"><?= Yii::t('Personal', 'sms_code') ?><span class="tooltip-icon" title="<?= Yii::t('Personal', 'sms_code_tooltip') ?>"></span>
                                </div>
                                <div class="field-input">
                                    <input type="text" name="code_activation" class="status-check-input input-text-sms" />
                                    <div class="error-message"><?= Yii::t('Personal', 'Sms code is incorrect') ?></div>
                                </div>
                            </div>
                        <?php elseif ($users_phone->status == 1 && $users_phone->is_master == 0):?>
                            <?php if($users_phone->hash): ?>
                                <div class="field-row">
                                    <div class="field-lbl"><?= Yii::t('Personal', 'sms_code') ?><span class="tooltip-icon" title="<?= Yii::t('Personal', 'sms_code_tooltip') ?>"></span>
                                    </div>
                                    <div class="field-input">
                                        <input class="status-check-input input-text-sms" type="text" name="code_activation" />
                                        <div class="error-message"><?= Yii::t('Personal', 'Sms code is incorrect') ?></div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <a <?php if($users_phone->is_master == 1):?>style="display:none;"<?php endif; ?> title="<?= Yii::t('Personal', 'Make primary') ?>" class="tooltip-icon primary-button m-primary" href="javaScript:void(0)" onclick="js:Personal.makePrimary('<?= Yii::app()->createUrl('/personal/makePrimary', array('type' => 'phones', 'id' => $users_phone->id)) ?>', this)"></a>
                            <?php endif; ?>
                        <?php elseif ($users_phone->status == 1 && $users_phone->is_master == 1):?>
                            <span title="<?= Yii::t('Personal', 'Primary') ?>" class="tooltip-icon primary-button is-primary" alt="<?= Yii::t('Front', 'Primary') ?>"></span>
                        <?php endif;?>
                    </td>
                    <td>
                        <?php if(!$users_phone->is_master): ?>
                            <div class="transaction-buttons-cont" style="margin:10px 0 0;">
                                <a class="button delete"  title="<?= Yii::t('Front', 'Remove') ?>" data-url="<?= Yii::app()->createUrl('/personal/delete', array('type' => 'phones', 'id' => $users_phone->id)) ?>" ></a>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        <tr class="data-row">
            <td colspan="4" class="add-new-td">
                <a class="rounded-buttons add-more upload" onclick="$(this).closest('tr').hide().closest('tr').next().toggle('slow')" href="javaScript:void(0)"><?= Yii::t('Front', 'Add new'); ?></a>
            </td>
        </tr>
        <tr class="add-new-row prof-form edit-row">
            <td colspan="4">
                <?php $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'personal-mobilephones',
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
                <?php $model_phones = new Users_Phones(); ?>
                <div class=" xabina-form-normal">
                    <div class="table-subheader"><?= Yii::t('Personal', 'Add phone number') ?></div>
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-5">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Front', 'Phone') ?>
                                    <span class="tooltip-icon" title="<?= Yii::t('Personal', 'mobile_phone_tooltip') ?>"></span>
                                </div>
                                <div class="form-input">
                                    <?= $form->textField($model_phones, 'phone', array('class' => 'input-text item0 numeric phone', 'data-v' => 'phone')); ?>
                                    <?= $form->error($model_phones, 'phone'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Personal', 'Category') ?>
                                    <span class="tooltip-icon" title="<?= Yii::t('Personal', 'mobile_phone_category_tooltip') ?>"></span>
                                </div>
                                <div class="form-input category-select">
                                    <div class="select-custom">

                                        <span class="select-custom-label"></span>
                                        <?= $form->dropDownList(
                                            $model_phones,
                                            'category_id',
                                            Html::listDataWithFilter(
                                                $data_categories,
                                                'id',
                                                'value',
                                                'data_type',
                                                $model_phones->tableName()
                                            ) + array('add' => Yii::t('Front', 'Other')),
                                            array(
                                                'class' => 'select-invisible',
                                                'onchange' => 'Personal.showAddNewCategory(this)',
                                                'empty' => Yii::t('Front', 'Select'),
                                                'options' => array($model_phones->category_id => array('selected' => true)),
                                            )
                                        ) ?>
                                    </div>
                                    <?= $form->error($model_phones, 'category_id'); ?>
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
                                <input type="submit" class="button ok" value="" title="<?= Yii::t('Front', 'OK') ?>"/>
                                <a class="button cancel" href="javaScript:void(0)" title="<?= Yii::t('Front', 'Cancel') ?>"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </td>
        </tr>
    </table>
</div>