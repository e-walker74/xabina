<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 08.07.14
 * Time: 22:51
 */
?>

<div class=" xabina-form-narrow">
    <table class="table xabina-table-contacts">
        <tr class="table-header">
            <th style="width: 50%"><?= Yii::t('Front', 'Note'); ?></th>
            <th style="width: 42%"><?= Yii::t('Front', 'Description'); ?></th>
            <th style="width: 8%"></th>
        </tr>
        <?php foreach($model->getDataByType('others') as $m): ?>
            <tr class="data-row">
                <td><?= $m->note ?></td>
                <td><?= $m->description ?></td>
                <td style="overflow: visible!important;">
                    <div class="contact-actions transaction-buttons-cont">
                        <div class="btn-group with-delete-confirm">
                            <a class="button menu" data-toggle="dropdown" href="#"></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="button edit" href="edit_contact.html"></a>
                                </li>
                                <li>
                                    <?= Html::link('', 'javaScript:void(0)', array(
                                        'class' => 'button delete',
                                        'onclick' => '$(this).addClass(\'opened\')',
                                        'data-url' => Yii::app()->createUrl('/contact/deleteData', array('type' => 'others', 'id' => $m->id)),
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
                        'id'=>'dataform-form-others'.$m->id,
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
                                    <?= Yii::t('Front', 'Type a note') ?>
                                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'type_a_note_tooltip') ?>"></span>
                                </div>
                                <div class="form-input">
                                    <?= $form->textField($m, 'note', array('class' => 'input-text')) ?>
                                    <?= $form->error($m, 'note') ?>
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
                                    <?= $form->textField($m, 'description', array('class' => 'input-text')) ?>
                                    <?= $form->error($m, 'description') ?>
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
        <?php endforeach; ?>
        <tr class="data-row">
            <td colspan="3">
                <a href="#" class="rounded-buttons upload add-more"><?= Yii::t('Front', 'Add NEW'); ?></a>
            </td>
        </tr>
        <tr class="edit-row">
            <td colspan="3">
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'dataform-form-others',
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
                                <?= $form->textField($m, 'note', array('class' => 'input-text')) ?>
                                <?= $form->error($m, 'note') ?>
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
                                <?= $form->textField($m, 'description', array('class' => 'input-text')) ?>
                                <?= $form->error($m, 'description') ?>
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