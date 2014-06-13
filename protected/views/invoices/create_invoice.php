<div class="col-lg-9 col-md-9 col-sm-9" >
<div class="h1-header"><?= Yii::t('Front', 'Create an Invoice') ?></div>
<?php $form = $this->beginWidget('CActiveForm', array(
    'id'=>'invoice-form',
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
        'afterValidate' => 'js:afterValidate', 
        'afterValidateAttribute' => 'js:afterValidateAttribute'
    ),
)); ?>
<div class="xabina-form-container">
<div class="row">
    <div class="col-lg-7 col-md-7 col-sm-7">
        <div class="invoice-block">
            <table class="table xabina-table-personal">
                <tr>
                    <td>
                        <b><?=Yii::t('Front', 'Your business information') ?></b><br>
                        <div class="invoice-logo" id="invoice-logo">
                            <img src="" style="display: none;" />
                            <div>Your logo <br />
                            (JPG, GIF, PNG, BMP)</div>
                        </div>
                        <div class="clearfix"></div>
                        <?=$form->fileField($file, 'name', array('style'=>'visibility:hidden;height:0')); ?>
                        <?=$form->hiddenField($file, 'user_file_name'); ?>
                        <a href="#" id="add_logo">Add logo</a>
                        <script language="JavaScript"><!--
                        $('#add_logo').click(function() {
                            $('#Users_Files_name').click();
                            return false;
                        });
                        var logoSpanText = $('#invoice-logo div').html();
                        $('#Users_Files_name').on('change', function() {
                            var name = $(this).val().split(/(\\|\/)/g).pop()
                            $('#invoice-logo div').html(name);
                            $('#Users_Files_user_file_name').html(name);
                            var input = $(this)[0];
                            if (input.files && input.files[0]) {
                                if (input.files[0].type.match('image.*')) {
                                    var reader = new FileReader();
                                    reader.onload = function(e) {
                                        $('#invoice-logo img').attr('src', e.target.result);
                                    }
                                    reader.readAsDataURL(input.files[0]);
                                    $('#invoice-logo img').show();
                                } else {
                                    $('#invoice-logo img').hide();
                                    $('#invoice-logo div').html(logoSpanText);
                                    console.log('is not image mime type');
                                }
                            } else
                                console.log('not isset files data or files API not suport');
                        })
                        //--></script>
                        <div class="field-lbl">
                            <?=($user->primary_address) ? $user->primary_address->getAddressHtml() : "" ?>
                        </div>
						<?php if($user->primary_phone): ?>
                        <div class="field-lbl"><?= Yii::t('Front', 'Phone'); ?>: +
						<?=$user->primary_phone->phone ?>
						</div>
						<?php endif; ?>
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
                                <?= $form->error($model, 'email'); ?>
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
                            <?= $model->getAttributeLabel('number') ?>
                            <span class="tooltip-icon" title="<?= Yii::t('Front', 'Add Your invoice number') ?>"></span>
                        </div>
                        <div class="field-input">
                            <div class="relative">
                                <?= $form->textField($model, 'number', array('autocomplete' => 'off','class'=>'input-text')); ?>
                                <?= $form->error($model, 'number'); ?>
                            </div>
                        </div>
                        <div class="field-lbl">
                            <?= $model->getAttributeLabel('invoice_date') ?>
                            <span class="tooltip-icon" title="<?= Yii::t('Front', 'Add date') ?>"></span>
                        </div>
                        <div class="field-input">
                            <div class="relative">
                                <?= $form->textField($model, 'invoice_date', array('autocomplete' => 'off','class'=>'input-text datepicker')); ?>
                                <?= $form->error($model, 'invoice_date'); ?>
                                <span class="icon"></span>
                            </div>
                        </div>
                        <div class="field-lbl">
                            <?= $model->getAttributeLabel('due_date') ?>
                            <span class="tooltip-icon" title="<?= Yii::t('Front', 'Add Your due data') ?>"></span>
                        </div>
                        <div class="field-input">
                            <div class="relative">
                                <?= $form->textField($model, 'due_date', array('autocomplete' => 'off','class'=>'input-text datepicker')); ?>
                                <?= $form->error($model, 'due_date'); ?>
                                <span class="icon"></span>
                            </div>
                        </div>
                        <div class="field-lbl">
                            <?= $model->getAttributeLabel('reference') ?>
                            <span class="tooltip-icon" title="<?= Yii::t('Front', 'Add Your Reference') ?>"></span>
                        </div>
                        <div class="field-input">
                            <div class="relative">
                                <?= $form->textField($model, 'reference', array('autocomplete' => 'off','class'=>'input-text')); ?>
                                <?= $form->error($model, 'reference'); ?>
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

    <?=CHtml::link('', array('/invoices/createoption', 'language' => Yii::app()->language), array('id' => 'add-invoice-option', 'class' => 'button add')); ?>
</div>
<table class="custom-options-bottom">
    <tr>
        <td class="none-padding-left" width=43%>
            <div class="field-lbl">
                <?= $model->getAttributeLabel('terms') ?>
                <span class="tooltip-icon" title="<?= Yii::t('Front', 'Yuo can add terms and conditions') ?>"></span><br>
                <small class="grey"><?= Yii::t('Front', 'For example: you return or cancelation policy') ?></small>
            </div>
            <div class="field-input">
                <div class="relative">
                    <?= $form->textArea($model, 'terms', array('autocomplete' => 'off','cols'=>30, 'rows'=>1)); ?>
                    <?= $form->error($model, 'terms'); ?>
                </div>
                <small class="grey"><?= Yii::t('Front', 'Caracters:') ?> 4000</small>
            </div>
            <div>

            </div>
            <div class="field-lbl">
                <?= $model->getAttributeLabel('note') ?>
                <span class="tooltip-icon" title="<?= Yii::t('Front', 'Add some note to recipient') ?>"></span>
            </div>
            <div class="field-input">
                <div class="relative">
                    <?= $form->textField($model, 'note', array('autocomplete' => 'off','class'=>'input-text')); ?>
                    <?= $form->error($model, 'note'); ?>
                </div>
            </div>
            <small class="grey"><?= Yii::t('Front', 'Caracters:') ?> 4000</small>
        </td>
        <td width="32%">
            <div class="field-lbl">
                <?= Yii::t('Front', 'Subtotal') ?> <small class="grey">(<?= Yii::t('Front', 'pre-discount') ?>)</small>
                <span class="tooltip-icon" title="<?= Yii::t('Front', 'Subtotal, without discount') ?>"></span><br>
                <?= $model->getAttributeLabel('discount') ?>
                <span class="tooltip-icon" title="<?= Yii::t('Front', 'Discount for subtotal') ?>"></span>
            </div>
            <div class="field-input">
                <div class="relative">
                    <div class="col-lg-6 col-md-6 col-sm-6 none-padding-left none-padding-right">
                        <?= $form->textField($model, 'discount', array('autocomplete' => 'off','class'=>'input-text invoice-discount-input invoice-only-float', 'value' => 0)); ?>
                        <?= $form->error($model, 'discount'); ?>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 none-padding-right">
                        <div class="select-custom">
                            <span class="select-custom-label">
                                %
                            </span>
                            <?= CHtml::activeDropDownList($model, 'discount_type',
                                array(1 => '%', 2 => ''),
                                array('class' => 'country-select select-invisible invoice-discount-type-input')) ?>
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
        <td class="text-right"><b><?= Yii::t('Front', 'Total'); ?>:</b></td>
        <td class="text-right none-padding-left" width="23%" style="padding-right: 47px!important;"><b><span  class="invoice-total-block">0</span>
                <span class="invoice-current-currency-block"></span></b></td>
    </tr>
	<?= $form->hiddenField($model, 'subtotal'); ?>
	<?= $form->hiddenField($model, 'total'); ?>
    
</table>
</td>
</tr>
</tbody>
</table>
<div class="form-submit">
    <input type="submit" class="submit-button button-save-invoice" name="save" value="<?= Yii::t('Front', 'Save and new Invoice') ?>" />
    <input type="submit" onclick="change_click_button(this)" class="submit-button button-next" name="sing" value="<?= Yii::t('Front', 'Sign and send') ?>" />
</div>
<div class="clearfix"></div>
</div>
<?php $this->endWidget(); ?>
</div>