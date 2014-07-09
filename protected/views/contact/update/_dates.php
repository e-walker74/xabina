<div class=" xabina-form-narrow">
<table class="table xabina-table-contacts">
<tr class="table-header">
    <th style="width: 50%"><?= Yii::t('Front', 'Date') ?></th>
    <th style="width: 42%"><?= Yii::t('Front', 'Category') ?></th>
    <th style="width: 8%"></th>
</tr>
<?php foreach ($model->getDataByType('dates') as $m): ?>
    <tr class="data-row">
        <td><?= $m->date ?></td>
        <td><?= ($m->getDbModel()->category) ? $m->getDbModel()->category->value : ''  ?>
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
                            <?=
                            Html::link('', 'javaScript:void(0)', array(
                                'class' => 'button delete',
                                'onclick' => '$(this).addClass(\'opened\')',
                                'data-url' => Yii::app()->createUrl('/contact/deleteData', array('type' => 'dates', 'id' => $m->id)),
                            )) ?>
                        </li>
                    </ul>
                </div>
            </div>
        </td>
    </tr>
    <tr class="edit-row">
        <td colspan="3">
            <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'dataform-form-dates' . $m->id,
                'action' => array('/contact/update', 'url' => $model->url),
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'errorMessageCssClass' => 'error-message',
                'htmlOptions' => array(
                    'class' => 'form-validable',
                    'enctype' => 'multipart/form-data',
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
            <div class="xabina-form-narrow">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <?= $form->hiddenField($m, 'id') ?>
                        <div class="form-cell">
                            <div class="form-lbl">
                                <?= Yii::t('Front', 'Choose Day') ?>
                                <span class="tooltip-icon" title="<?= Yii::t('Front', 'date_contact') ?>"></span>
                            </div>
                            <div class="form-input">
                                <?= $form->textField($m, 'date', array('class' => 'date-input input-text with_datepicker', 'id' => '')) ?>
                                <?= $form->error($m, 'date') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <div class="form-cell">
                            <div class="form-lbl">
                                <?= Yii::t('Front', 'Category') ?>
                                <span class="tooltip-icon"
                                      title="<?= Yii::t('Front', 'country_name_contact') ?>"></span>
                            </div>
                            <div class="form-input category-select">
                                <div class="select-custom select-narrow ">
                                    <span class="select-custom-label"></span>
                                    <?=
                                    $form->dropDownList(
                                        $m,
                                        'category_id',
                                        Html::listDataWithFilter(
                                            $data_categories,
                                            'id',
                                            'value',
                                            'data_type',
                                            'dates'
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
                    <div class="col-lg-2 col-md-2 col-sm-2 ">
                        <div class="transaction-buttons-cont edit-submit-cont">
                            <input type="submit" class="button ok" value=""/>
                            <a href="javaScript:void(0)" class="button cancel"></a>
                        </div>
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
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'dataform-form-dates',
            'action' => array('/contact/update', 'url' => $model->url),
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'errorMessageCssClass' => 'error-message',
            'htmlOptions' => array(
                'class' => 'form-validable',
                'enctype' => 'multipart/form-data',
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
        <?php $m = new Users_Contacts_Data_Dates; ?>
        <div class="table-subheader"><?= Yii::t('Front', 'Add new date'); ?></div>
        <div class="xabina-form-narrow">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="form-cell">
                        <div class="form-lbl">
                            <?= Yii::t('Front', 'Choose Day') ?>
                            <span class="tooltip-icon" title="<?= Yii::t('Front', 'date_contact') ?>"></span>
                        </div>
                        <div class="form-input">
                            <?= $form->textField($m, 'date', array('class' => 'date-input input-text with_datepicker', 'id' => '')) ?>
                            <?= $form->error($m, 'date') ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="form-cell">
                        <div class="form-lbl">
                            <?= Yii::t('Front', 'Category') ?>
                            <span class="tooltip-icon" title="<?= Yii::t('Front', 'country_name_contact') ?>"></span>
                        </div>
                        <div class="form-input category-select">
                            <div class="select-custom select-narrow ">
                                <span class="select-custom-label"></span>
                                <?=
                                $form->dropDownList(
                                    $m,
                                    'category_id',
                                    Html::listDataWithFilter(
                                        $data_categories,
                                        'id',
                                        'value',
                                        'data_type',
                                        'dates'
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
                <div class="col-lg-2 col-md-2 col-sm-2 ">
                    <div class="transaction-buttons-cont edit-submit-cont">
                        <input type="submit" class="button ok" value=""/>
                        <a href="javaScript:void(0)" class="button cancel"></a>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </td>
</tr>
</table>
</div>
<script>
    $("form .with_datepicker, .calendar-input").datepicker({
        showOn: "both",
        buttonImage: '/images/calendar_ico.png',
        buttonImageOnly: true,
        dateFormat: 'dd.mm.yy'
    }).inputmask("d.m.y");
    ;
</script>
<script>
    $(document).ready(function () {
        $('.xabina-form-narrow .transaction-buttons-cont .delete').confirmation({
            title: '<?= Yii::t('Front', 'Are you sure?') ?>',
            singleton: true,
            popout: true,
            onConfirm: function () {
                deleteRow($(this).parents('.popover').prev('a'));
                return false;
            }
        })
    })
</script>