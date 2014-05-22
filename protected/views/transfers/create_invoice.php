<link rel='stylesheet' type='text/css' href='/css/datepicker.css' />
<script type="text/javascript" src="/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="/js/invoice.js"></script>
<div class="col-lg-9 col-md-9 col-sm-9" >
<div class="h1-header">Create an Invoice</div>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'registration-from',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    //'focus'=>array($model,'first_name'),
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
        'validateOnChange'=>true,
        'errorCssClass'=>'input-error',
        'afterValidate' => 'js:function(form, data, hasError) {
                form.find("input").removeClass("input-error");
                form.find(".validation-icon").show();
                if(hasError) {
                    for(var i in data) {
                        $("#"+i).addClass("input-error");
                        $("#"+i).next(".validation-icon").show();
                    }
                    return false;
                }
                else {
                    return true;
                }
            }',
        'afterValidateAttribute' => 'js:function(form, attribute, data, hasError) {
                if(hasError){
                    $("#"+attribute.id).addClass("input-error");
                    $("#"+attribute.id).next(".validation-icon").show();
                } else {
                    $("#"+attribute.id).removeClass("input-error");
                    $("#"+attribute.id).next(".validation-icon").show();
                }
            }'
    ),
)); ?>
<div class="xabina-form-container">
<div class="row">
    <div class="col-lg-7 col-md-7 col-sm-7">
        <div class="invoice-block">
            <table class="table xabina-table-personal">
                <tr>
                    <td>
                        <b><?= Yii::t('Front', 'Your business information') ?></b><br>
                        <div class="invoice-logo">
                            Your logo <br>
                            (JPG, GIF, PNG, BMP)
                        </div>
                        <div class="clearfix"></div>
                        <a href="#">Add logo</a>
                        <div class="field-lbl">
                            TRUST Media B.V. <br>
                            Stadsring 99 <br>
                            3811HP Amersfoort Netherlands
                        </div>
                        <div class="field-lbl">Phone: +31 880200200</div>
                        <div class="field-lbl">
                            <a href="#">Edit business information</a> <span class="grey">(Includes tax ID)</span> <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="invoice-block">
            <table class="table xabina-table-personal">
                <tbody>
                <tr>
                    <td>
                        <b><?= Yii::t('Front', 'Sent to') ?></b><br>
                        <div class="field-lbl">
                            <?= Yii::t('Front', 'Recipient’s email address') ?>
                            <span class="tooltip-icon" title="<?= Yii::t('Front', 'Add Your first name using latin alphabet') ?>"></span>
                        </div>
                        <div class="field-input">
                            <div class="relative">
                                <?= $form->textField($model, 'email', array('autocomplete' => 'off','class'=>'input-text')); ?>
                            </div>
                        </div>
                        <div class="field-lbl">
                            <a href="#">Add recipient’s name, address, <br>
                                language</a> <span class="grey">(optional)</span> <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                        </div>
                        <div class="new-transfer">
                            <div class="subheader"></div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-5 col-md-5 col-sm-5">
        <div class="invoice-block">
            <table class="table xabina-table-personal">
                <tbody>
                <tr>
                    <td>
                        <b> <?= Yii::t('Front', 'Your information') ?></b><br>
                        <div class="field-lbl">
                            <?= Yii::t('Front', 'Invoice number') ?>
                            <span class="tooltip-icon" title="<?= Yii::t('Front', 'Add Your invoice number') ?>"></span>
                        </div>
                        <div class="field-input">
                            <div class="relative">
                                <?= $form->textField($model, 'number', array('autocomplete' => 'off','class'=>'input-text')); ?>
                            </div>
                        </div>
                        <div class="field-lbl">
                            <?= Yii::t('Front', 'Invoice date') ?>
                            <span class="tooltip-icon" title="<?= Yii::t('Front', 'Add date') ?>"></span>
                        </div>
                        <div class="field-input">
                            <div class="relative">
                                <?= $form->textField($model, 'date', array('autocomplete' => 'off','class'=>'input-text datepicker')); ?>
                                <span class="icon"></span>
                            </div>
                        </div>
                        <div class="field-lbl">
                            <?= Yii::t('Front', 'Due data') ?>
                            <span class="tooltip-icon" title="<?= Yii::t('Front', 'Add Your due data') ?>"></span>
                        </div>
                        <div class="field-input">
                            <div class="relative">
                                <?= $form->textField($model, 'due_date', array('autocomplete' => 'off','class'=>'input-text datepicker')); ?>
                                <span class="icon"></span>
                            </div>
                        </div>
                        <div class="field-lbl">
                            <?= Yii::t('Front', 'Reference') ?>
                            <span class="tooltip-icon" title="<?= Yii::t('Front', 'Add Your Reference') ?>"></span>
                        </div>
                        <div class="field-input">
                            <div class="relative">
                                <?= $form->textField($model, 'reference', array('autocomplete' => 'off','class'=>'input-text')); ?>
                            </div>
                        </div>
                        <br><br><br>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="invoice-block"></div>
<table class="table xabina-table-personal show-custom-options">
<tbody>
<tr class="table-header invoice-block">
    <th style="width: 75%"><b><?= Yii::t('Front', 'Show customization options') ?></b></th>
    <th style="width: 5%">&nbsp;</th>
    <th style="width: 20% ">
        <div class="field-input">
            <div class="select-custom">
                <span class="select-custom-label"><?= $user->settings->currency->code ?></span>
                <?= CHtml::activeDropDownList($model, 'currency_id',
                    CHtml::listData(Currencies::model()->findAll(), 'id', 'title'),
                    array('class' => 'select-invisible invoice-current-currency-input')) ?>
            </div>
        </div>
    </th>
</tr>
<tr>
<td colspan="3">
<div class="col-lg-11 col-md-11 col-sm-11 none-padding-left none-padding-right invoice-options">

</div>
<div class="col-lg-1 col-md-1 col-sm-1">

    &nbsp;

    <?=CHtml::link('', array('/transfers/createinvoiceoption', 'language' => Yii::app()->language), array('id' => 'add-invoice-option', 'class' => 'button add')); ?>
</div>
<table class="custom-options-bottom">
    <tr>
        <td class="none-padding-left" width=43%>
            <div class="field-lbl">
                <?= Yii::t('Front', 'Terms and conditions') ?>
                <span class="tooltip-icon" title="<?= Yii::t('Front', 'Yuo can add terms and conditions') ?>"></span><br>
                <small class="grey"><?= Yii::t('Front', 'For example: you return or cancelation policy') ?></small>
            </div>
            <div class="field-input">
                <div class="relative">
                    <?= $form->textArea($model, 'terms', array('autocomplete' => 'off','cols'=>30, 'rows'=>1)); ?>
                </div>
                <small class="grey"><?= Yii::t('Front', 'Caracters:') ?> 4000</small>
            </div>
            <div>

            </div>
            <div class="field-lbl">
                <?= Yii::t('Front', 'Note to recipient') ?>
                <span class="tooltip-icon" title="<?= Yii::t('Front', 'Add some note to recipient') ?>"></span>
            </div>
            <div class="field-input">
                <div class="relative">
                    <?= $form->textField($model, 'note', array('autocomplete' => 'off','class'=>'input-text')); ?>
                </div>
            </div>
            <small class="grey"><?= Yii::t('Front', 'Caracters:') ?> 4000</small>
        </td>
        <td width="32%">
            <div class="field-lbl">
                <?= Yii::t('Front', 'Subtotal') ?> <small class="grey">(pre-discount)</small>
                <span class="tooltip-icon" title="<?= Yii::t('Front', 'Subtotal, without discount') ?>"></span><br>
                <?= Yii::t('Front', 'Discount') ?>
                <span class="tooltip-icon" title="<?= Yii::t('Front', 'Discount for subtotal') ?>"></span>
            </div>
            <div class="field-input">
                <div class="relative">
                    <div class="col-lg-6 col-md-6 col-sm-6 none-padding-left none-padding-right">
                        <?= $form->textField($model, 'discount', array('autocomplete' => 'off','class'=>'input-text invoice-discount-input invoice-only-float', 'value' => 0)); ?>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 none-padding-right">
                        <div class="select-custom">
                            <span class="select-custom-label">
                                %
                            </span>
                            <select name="country" class="country-select select-invisible invoice-discount-type-input">
                                <option value="1">%</option>
                                <option value="2"></option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="clearfix"></div>
        </td>
        <td class="text-right" width=23% style="vertical-align: top!important; padding-right: 47px!important;">
            <div class="field-lbl">
                <span class="invoice-subtotal-block">0</span><br>
                <span class="invoice-current-currency-block"></span>
            </div>
            <div class="field-lbl">
                <span class="invoice-discount-block">0</span><br>
                <span class="invoice-current-currency-block"></span>
            </div>
        </td>
    </tr>
    <tr>
        <td></td>
        <td class="text-right"><b>Total:</b></td>
        <td class="text-right none-padding-left" width="23%" style="padding-right: 47px!important;"><b><span  class="invoice-total-block">0</span><br>
                <span class="invoice-current-currency-block"></span></b></td>
    </tr>
</table>
</td>
</tr>
</tbody>
</table>
<div class="form-submit">
    <div class="submit-button button-save-invoice"><?= Yii::t('Front', 'Save and new Invoice') ?></div>
    <div class="submit-button button-next"><?= Yii::t('Front', 'Sign and send') ?></div>
</div>
<div class="clearfix"></div>
</div>
<?php $this->endWidget(); ?>
</div>