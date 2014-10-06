<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 01.08.14
 * Time: 13:58
 * @param Users_Other[] $model
 */ ?>

<div class=" xabina-form-normal">
    <table class="table xabina-table-contacts">
        <tr class="table-header">
            <th style="width: 50%"><?= Yii::t('Front', 'Note'); ?></th>
            <th style="width: 42%"><?= Yii::t('Front', 'Description'); ?></th>
            <th style="width: 8%"></th>
        </tr>
        <?php if(empty($others)): ?>
            <tr class="comment-tr empty-table">
                <td colspan="3" style="line-height: 1.43!important">
                    <span class=""><?= Yii::t('Front', 'You do not added a note yet. You can add new note by clicking “Add new” button') ?></span>
                </td>
            </tr>
        <?php endif; ?>

        <?php foreach($others as $other): ?>
            <tr class="data-row">
                <td><?= $other->note ?></td>
                <td><?= $other->description ?></td>
                <td style="overflow: visible!important;">
                    <div class="contact-actions transaction-buttons-cont">
                        <div class="btn-group with-delete-confirm">
                            <a class="button menu" title="<?= Yii::t('Front', 'Options') ?>" data-toggle="dropdown" href="#"></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="button edit" title="<?= Yii::t('Front', 'Edit') ?>" href="javascript:void(0)"></a>
                                </li>
                                <li>
                                    <?= Html::link('', 'javaScript:void(0)', array(
                                        'class' => 'button delete',
                                        'title' =>   Yii::t('Front', 'Remove'),
                                        'onclick' => '$(this).addClass(\'opened\')',
                                        'data-url' => Yii::app()->createUrl('/personal/delete', array('type' => 'other', 'id' => $other->id)),
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
                        'id'=>'dataform-form-others'.$other->id,
                        'action' => array('/personal/other'),
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
                            'afterValidateAttribute' => 'js:Personal.afterValidateAttribute'
                        ),
                    )); ?>
                    <?= $form->hiddenField($other, 'id') ?>
                    <div class="row">
                        <div class="col-lg-6 col-md-6  col-sm-6">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Front', 'Type a note') ?>
                                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'type_a_note_tooltip') ?>"></span>
                                </div>
                                <div class="form-input">
                                    <?= $form->textField($other, 'note', array('class' => 'input-text')) ?>
                                    <?= $form->error($other, 'note') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Front', 'Description') ?>
                                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'type_a_note_description_tooltip') ?>"></span>
                                </div>
                                <div class="form-input">
                                    <?= $form->textField($other, 'description', array('class' => 'input-text')) ?>
                                    <?= $form->error($other, 'description') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <div class="transaction-buttons-cont edit-submit-cont">
                                <input type="submit" title="<?= Yii::t('Front', 'Save') ?>" class="button ok" value=""/>
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
                <a href="javaScript:void(0)" class="rounded-buttons upload add-more"><?= Yii::t('Front', 'Add NEW'); ?></a>
            </td>
        </tr>
        <tr class="edit-row">
            <td colspan="3">
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'dataform-form-others',
                    'action' => array('/personal/other'),
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
                        'afterValidateAttribute' => 'js:Personal.afterValidateAttribute'
                    ),
                )); ?>
                <?php $m = new Users_Contacts_Data_Others; ?>
                <div class="table-subheader"><?= Yii::t('Front', 'Add new note'); ?></div>
                <div class="row">
                    <div class="col-lg-6 col-md-6  col-sm-6">
                        <div class="form-cell">
                            <div class="form-lbl">
                                <?= Yii::t('Front', 'Type a note') ?>
                                <span class="tooltip-icon" title="<?= Yii::t('Front', 'type_a_note_tooltip') ?>"></span>
                            </div>
                            <div class="form-input">
                                <?= $form->textField($model, 'note', array('class' => 'input-text')) ?>
                                <?= $form->error($model, 'note') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <div class="form-cell">
                            <div class="form-lbl">
                                <?= Yii::t('Front', 'Description') ?>
                                <span class="tooltip-icon" title="<?= Yii::t('Front', 'type_a_note_description_tooltip') ?>"></span>
                            </div>
                            <div class="form-input">
                                <?= $form->textField($model, 'description', array('class' => 'input-text')) ?>
                                <?= $form->error($model, 'description') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <div class="transaction-buttons-cont edit-submit-cont">
                            <input type="submit" title="<?= Yii::t('Front', 'Save') ?>" class="button ok" value=""/>
                            <a href="javaScript:void(0)" title="<?= Yii::t('Front', 'Cancel') ?>" class="button cancel"></a>
                        </div>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </td>
        </tr>
    </table>
</div>
