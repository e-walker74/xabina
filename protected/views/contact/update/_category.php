<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 30.06.14
 * Time: 13:03
 */
?>

<!--<div class="subheader">--><?//= Yii::t('Front', 'Category') ?><!--</div>-->
<div class=" xabina-form-narrow">
    <table class="table xabina-table-contacts">
        <tr class="table-header">
            <th style="width: 38%"><?= Yii::t('Front', 'Section') ?></th>
            <th style="width: 54%"><?= Yii::t('Front', 'Description') ?></th>
            <th style="width: 8%"></th>
        </tr>
        <tr class="comment-tr">
            <td colspan="3" style="line-height: 1.43!important">
                <span><?= Yii::t('Front', 'go_to_the_category_page') ?> <?= Html::link(Yii::t('Front', 'Link'), array('/contact/category')) ?></span>
            </td>
        </tr>
        <tr class="comment-tr empty-table <?php if (!empty($model->categories)): ?>hidden<?php endif; ?>">
            <td colspan="3" style="line-height: 1.43!important">
                <span class="rejected "><?= Yii::t('Front', 'There is no category associated with this contact yet. You can add new category by clicking “Add new” button') ?></span>
            </td>
        </tr>
        <?php foreach($model->categories as $category): ?>
            <tr class="data-row <?= (isset($new_model_id) && $new_model_id == $category->id) ? 'flash_notify_here' : '' ?>" data-cat-id="<?= $category->id ?>">
                <td><?= $category->section ?></td>
                <td><?= $category->description ?></td>
                <td style="overflow: visible!important;">
                    <div class="contact-actions transaction-buttons-cont">
                        <?= Html::link('', array('/contact/unlinkContact'), array(
                            'data-url' => Yii::app()->createUrl('/contact/unlinkContact', array(
                                    'category' => $category->id,
                                    'contact' => $model->id,
                                )),
                            'class' => 'button delete',
                            'onclick' => '$(this).toggleClass("opened")',
                        )) ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr class="data-row">
            <td colspan="3">
                <a href="#" class="rounded-buttons upload add-more"><?= Yii::t('Front', 'add new') ?></a>
            </td>
        </tr>
        <tr class="edit-row">
            <td colspan="3">
                <?php $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'contacts-category-add',
                    'action' => array('/contact/addtocategory', 'id' => $model->id),
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,
                    'errorMessageCssClass' => 'error-message',
                    'htmlOptions' => array(
                        'class' => 'form-validable',
                    ),
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnChange' => true,
                        'errorCssClass' => 'input-error',
                        'successCssClass' => 'valid',
                        'afterValidate' => 'js:afterValidate',
                        'afterValidateAttribute' => 'js:afterValidateAttribute'
                    ),
                )); ?>
                <div class="table-subheader"><?= Yii::t('Front', 'Add new category'); ?></div>
                <div class="row">
                    <div class="col-lg-10 col-md-10  col-sm-10">
                        <div class="form-cell">
                            <div class="form-lbl">
                                <?= Yii::t('Front', 'Category'); ?>
                                <span class="tooltip-icon" title="<?= Yii::t('Front', 'contact_category_tooltip'); ?>"></span>
                            </div>
                            <div class="form-input">
                                <div class="select-custom select-narrow ">
                                    <span class="select-custom-label"></span>
                                    <?= $form->dropDownList(
                                        $link,
                                        'category_id',
                                        CHtml::listData($contact_categories, 'id', 'section'),
                                        array(
                                            'class' => 'select-invisible country-select',
                                            'empty' => Yii::t('Front', 'Select'),
                                        )
                                    ); ?>
                                </div>
                                <?= $form->error($link, 'category_id') ?>
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
    <script>

    </script>
</div>