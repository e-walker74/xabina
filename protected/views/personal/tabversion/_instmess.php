<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 29.07.14
 * Time: 9:33
 */ ?>

<div class=" xabina-form-normal">
    <table class="table xabina-table-contacts">
        <tr class="table-header">
            <th style="width: 28%"><?= Yii::t('Personal', 'Instant Messaging'); ?></th>
            <th style="width: 25%"><?= Yii::t('Personal', 'Username'); ?></th>
            <th style="width: 18%"><?= Yii::t('Personal', 'Category'); ?></th>
            <th style="width: 21%"><?= Yii::t('Personal', 'Status'); ?></th>
            <th style="width: 8%"></th>
        </tr>
        <?php foreach($user->messagers as $mes): ?>
            <tr class="data-row" style="overflow: visible!important">
                <td>
                    <div class="messenger-ico <?= $mes->messager_system->code ?>"></div> <?= $mes->messager_system->name ?>
                </td>
                <td><?= $mes->messager_login ?></td>
                <td><?= $mes->category->value ?></td>
                <td>
                    <?php if($mes->is_master): ?>
                        <span class="bold"><?= Yii::t('Front', 'Primary'); ?></span>
                    <?php else: ?>
                        <a href="javaScript:void(0)" class="make-primary" onclick="js:Personal.makePrimary('<?= Yii::app()->createUrl('/personal/makePrimary', array('type' => 'instmessagers', 'id' => $mes->id)) ?>', this)"><?= Yii::t('Front', 'Make primary'); ?></a>
                    <?php endif; ?>

                </td>
                <td style="overflow: visible!important">
                    <div class="contact-actions transaction-buttons-cont">
                        <div class="btn-group with-delete-confirm">
                            <a class="button menu" title="<?= Yii::t('Front', 'Options') ?>" data-toggle="dropdown" href="#"></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="javaScript:void(0)" title="<?= Yii::t('Front', 'Edit') ?>" class="button edit"></a>
                                </li>
                                <?php if(!$mes->is_master): ?>
                                    <li>
                                        <?= Html::link('', 'javaScript:void(0)', array(
                                            'class' => 'button delete',
                                            'onclick' => '$(this).addClass(\'opened\')',
                                            'data-url' => Yii::app()->createUrl('/personal/delete', array('type' => 'messager', 'id' => $mes->id)),
                                        )) ?>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="edit-row">
                <td colspan="5">
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'users_instmessagers'.$mes->id,
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
                            'afterValidate' => 'js:Personal.afterValidate',
                            'afterValidateAttribute' => 'js:Personal.afterValidateAttribute',
                        ),
                    )); ?>
                    <?= $form->hiddenField($mes, 'id') ?>
                    <div class="table-subheader"><?= Yii::t('Personal', 'Add instant messenger') ?></div>
                    <div class="row">
                        <div class="col-lg-3 col-md-3  col-sm-3">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Personal', 'Instant Messenger') ?>
                                    <span class="tooltip-icon" title="<?= Yii::t('Personal', 'instmess_messenger_tooltip') ?>"></span>
                                </div>
                                <div class="form-input">
                                    <div class="select-custom">
                                        <span class="select-custom-label"></span>
                                        <?= $form->dropDownList(
                                            $mes,
                                            'messager_type',
                                            CHtml::listData($messengers, 'id', 'name'),
                                            array(
                                                'class' => 'country-select select-invisible',
                                                'empty' => Yii::t('Personal', 'Select'),
                                            )
                                        ); ?>
                                    </div>
                                    <?= $form->error($mes, 'messager_type'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Personal', 'Username') ?>
                                    <span class="tooltip-icon" title="<?= Yii::t('Personal', 'instmess_username_tooltip') ?>"></span>
                                </div>
                                <div class="form-input">
                                    <?= $form->textField($mes, 'messager_login', array('class' => 'input-text')); ?>
                                    <?= $form->error($mes, 'messager_login'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Personal', 'Category') ?>
                                    <span class="tooltip-icon" title="<?= Yii::t('Personal', 'instmess_category_tooltip') ?>"></span>
                                </div>
                                <div class="form-input category-select">
                                    <div class="select-custom">

                                        <span class="select-custom-label"></span>
                                        <?= $form->dropDownList(
                                            $mes,
                                            'category_id',
                                            Html::listDataWithFilter(
                                                $data_categories,
                                                'id',
                                                'value',
                                                'data_type',
                                                $mes->tableName()
                                            ) + array('add' => Yii::t('Front', 'Other')),
                                            array(
                                                'class' => 'select-invisible',
                                                'onchange' => 'Personal.showAddNewCategory(this)',
                                                'empty' => Yii::t('Front', 'Select'),
                                                'options' => array($mes->category_id => array('selected' => true)),
                                            )
                                        ) ?>
                                    </div>
                                    <?= $form->error($mes, 'category_id'); ?>
                                </div>
                                <div class="form-input add-new-category" style="display: none;">
                                    <span class="clear-input-cont full-with">
                                        <input type="text" name="Data_Category" maxlength="25" class="input-text" disabled="disabled">
                                        <span class="clear-input-but" onclick="Personal.hideCategoryTextField(this)"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <div class="transaction-buttons-cont edit-submit-cont">
                                <input type="submit" class="button ok" value=""/>
                                <a href="javaScript:void(0)" class="button cancel"></a>
                            </div>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </td>
            </tr>
        <?php endforeach ?>

        <tr class="data-row">
            <td colspan="5">
                <a href="javaScript:void(0)" class="rounded-buttons upload add-more"><?= Yii::t('Personal', 'Add NEW') ?></a>
            </td>
        </tr>
        <tr class="edit-row">
            <td colspan="5">
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'users_instmessagers',
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
                        'afterValidate' => 'js:Personal.afterValidate',
                        'afterValidateAttribute' => 'js:Personal.afterValidateAttribute',
                    ),
                )); ?>
                <?php $model = new Users_Instmessagers(); ?>
                <div class="table-subheader"><?= Yii::t('Personal', 'Add instant messenger') ?></div>
                <div class="row">
                    <div class="col-lg-3 col-md-3  col-sm-3">
                        <div class="form-cell">
                            <div class="form-lbl">
                                <?= Yii::t('Personal', 'Instant Messenger') ?>
                                <span class="tooltip-icon" title="<?= Yii::t('Personal', 'instmess_messenger_tooltip') ?>"></span>
                            </div>
                            <div class="form-input">
                                <div class="select-custom">
                                    <span class="select-custom-label"></span>
                                    <?= $form->dropDownList(
                                        $model,
                                        'messager_type',
                                        CHtml::listData($messengers, 'id', 'name'),
                                        array(
                                            'class' => 'country-select select-invisible',
                                            'empty' => Yii::t('Personal', 'Select'),
                                        )
                                    ); ?>
                                </div>
                                <?= $form->error($model, 'messager_type'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <div class="form-cell">
                            <div class="form-lbl">
                                <?= Yii::t('Personal', 'Username') ?>
                                <span class="tooltip-icon" title="<?= Yii::t('Personal', 'instmess_username_tooltip') ?>"></span>
                            </div>
                            <div class="form-input">
                                <?= $form->textField($model, 'messager_login', array('class' => 'input-text')); ?>
                                <?= $form->error($model, 'messager_login'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="form-cell">
                            <div class="form-lbl">
                                <?= Yii::t('Personal', 'Category') ?>
                                <span class="tooltip-icon" title="<?= Yii::t('Personal', 'instmess_category_tooltip') ?>"></span>
                            </div>
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
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <div class="transaction-buttons-cont edit-submit-cont">
                            <input type="submit" class="button ok" value=""/>
                            <a href="javaScript:void(0)" class="button cancel"></a>
                        </div>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </td>
        </tr>
    </table>
</div>