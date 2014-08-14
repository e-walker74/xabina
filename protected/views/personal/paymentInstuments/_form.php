<?php
/**
 * @param Users_Paymentinstruments $model
 * @param CActiveForm $form
 */
?>

<?php $form = $this->beginWidget('CActiveForm', array(
    'action'=>"/personal/paymentinstuments?method=$method",
    'id'=>'electronic-form-' . Text::rand_str(),
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    'errorMessageCssClass' => 'error-message',
    'htmlOptions' => array(
        'class' => 'form-validable form-payment',
    ),
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
        'validateOnChange'=>true,
        'errorCssClass'=>'input-error',
        'successCssClass'=>'valid',
        'afterValidate' => 'js:Personal.afterValidate',
        'afterValidateAttribute' => 'js:Personal.afterValidateAttribute'
    ),
));?>

<div class="row">
    <div class="col-lg-10 col-md-10 col-sm-10">
        <div class="form-cell">
            <div class="form-lbl">
                <?= Yii::t('Front', 'Method') ?>
                <span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_electronic_methods') ?>"></span>
            </div>
            <div class="form-input">
                <div class="select-custom">
                    <span class="select-custom-label"></span>
                    <?=
                    $form->dropDownList(
                        $model,
                        'electronic_method',
                        Users_Paymentinstruments::$methods,
                        array(
                            'class' => 'select-invisible payment_select',
                            'id' => get_class($model) . "_electronic_method",
                            'options' => array($model->electronic_method => array('selected' => true)),
                            'empty' => Yii::t('Front', 'Select a method'),
                            'disabled' => ($model->isNewRecord) ? false : true,
                        )
                    ); ?>

                </div>
                <?= $form->error($model, 'electronic_method'); ?>
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

<div class="method-1 electronic-method-fields"
     style="<?php if (isset($model->electronic_method) && $model->electronic_method == Users_Paymentinstruments::METHOD_CREDITCARD) { ?>display:block;<?php } else { ?>display:none;<?php } ?>">
    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10">
            <div class="form-cell">
                <div class="form-lbl">
                    <?= Yii::t('Front', 'Creditcard holder') ?>
                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_creditcard_holder') ?>"></span>
                </div>
                <div class="form-input">
                    <?=
                    $form->textField($model, 'creditcard_holder', array(
                        'class' => 'input-text',
                        'value' => $model->from_account_holder,
                        'style' => 'width:100%'
                    ))?>
                    <?= $form->error($model, 'creditcard_holder') ?>
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
                    <?= Yii::t('Front', 'Credit Card Number') ?>
                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_creditcard_number') ?>"></span>
                </div>
                <div class="form-input">
                    <?=
                    $form->textField($model, 'creditcard_number', array(
                        'class' => 'input-text numeric creditcard',
                        'value' => $model->from_account_number,
                        'id' => get_class($model) . "_creditcard_number",
                    ))?>
                    <?= $form->error($model, 'creditcard_number') ?>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="form-cell">
                <div class="form-lbl">
                    <?= Yii::t('Front', 'Expiration Date') ?>
                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_creditcard_p_month') ?>"></span>
                </div>
                <div class="form-input">
                    <div class="select-custom currency-select exp-month">
                        <span class="select-custom-label"><?= Yii::t('Front', 'Month') ?></span>
                        <?=
                        $form->dropDownList(
                            $model,
                            'p_month',
                            array(
                                1 => '01',
                                2 => '02',
                                3 => '03',
                                4 => '04',
                                5 => '05',
                                6 => '06',
                                7 => '07',
                                8 => '08',
                                9 => '09',
                                10 => '10',
                                11 => '11',
                                12 => '12',
                            ),
                            array(
                                'options' => array($model->p_month => array('selected' => true)),
                                'class' => 'select-invisible',
                            )
                        ); ?>
                    </div>
                    <span class="exp-delimitter">/</span>

                    <div class="select-custom currency-select exp-year">
                        <span class="select-custom-label"><?= Yii::t('Front', 'Year') ?></span>
                        <?php
                        $year = array();
                        for ($i = 0, $y = date('y', time()); $i <= 20; $i++, $y++) {
                            $year[$y] = $y;
                        }
                        echo $form->dropDownList(
                            $model,
                            'p_year',
                            $year,
                            array(
                                'class' => 'select-invisible',
                                'options' => array($model->p_year => array('selected' => true)),
                            )
                        );
                        ?>
                    </div>
                    <?= $form->error($model, 'p_year'); ?>
                    <?= $form->error($model, 'p_month'); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 ">
            <div class="form-cell">
                <div class="form-lbl">
                    <?= Yii::t('Front', 'CSC') ?>
                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_creditcard_p_csc') ?>"></span>
                </div>
                <div class="form-input">
                    <?= $form->textField($model, 'p_csc', array('class' => 'input-text card-csc')) ?>
                    <?= $form->error($model, 'p_csc'); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 "></div>
    </div>
    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10">
            <div class="form-cell">
                <div class="form-lbl">
                    <?= Yii::t('Front', 'Payment Type') ?>
                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'Payment Type') ?>"></span>
                </div>
                <div class="form-input">
                    <ul class="list-inline payments-list">
                        <li>
                            <label>
                                <input type="radio" name="<?= get_class($model) ?>[card_type]" class="master-card"
                                       value="<?= array_search('master-card', Transfers_Incoming::$card_types) ?>">
                                <div class="logo master-card"></div>
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="radio" name="<?= get_class($model) ?>[card_type]" class="jcb"
                                       value="<?= array_search('jcb', Transfers_Incoming::$card_types) ?>">
                                <div class="logo jcb "></div>
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="radio" name="<?= get_class($model) ?>[card_type]" class="union-pay"
                                       value="<?= array_search('union-pay', Transfers_Incoming::$card_types) ?>">
                                <div class="logo union-pay "></div>
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="radio" name="<?= get_class($model) ?>[card_type]" class="maestro"
                                       value="<?= array_search('maestro', Transfers_Incoming::$card_types) ?>">
                                <div class="logo maestro"></div>
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="radio" name="<?= get_class($model) ?>[card_type]" class="visa"
                                       value="<?= array_search('visa', Transfers_Incoming::$card_types) ?>">
                                <div class="logo visa"></div>
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="radio" name="<?= get_class($model) ?>[card_type]" class="american-ecspress"
                                       value="<?= array_search('american-ecspress', Transfers_Incoming::$card_types) ?>">
                                <div class="logo american-ecspress"></div>
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="method-3 electronic-method-fields"
     style="<?php if (isset($model->electronic_method) && $model->electronic_method == Users_Paymentinstruments::METHOD_BANK_ACCOUNT) { ?>display:block;<?php } else { ?>display:none;<?php } ?>">
    <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-5">
            <div class="form-cell">
                <div class="form-lbl">
                    <?= Yii::t('Front', 'Account number') ?>
                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_bank_account_number') ?>"></span>
                </div>
                <div class="form-input">
                    <?=
                    $form->textField($model, 'from_account_number', array(
                        'class' => 'input-text',
                        'value' => $model->from_account_number,
                    ))?>
                    <?= $form->error($model, 'from_account_number'); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5">
            <div class="form-cell">
                <div class="form-lbl">
                    <?= Yii::t('Front', 'Account holder') ?>
                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_bank_account_holder') ?>"></span>
                </div>
                <div class="form-input">
                    <?=
                    $form->textField($model, 'from_account_holder', array(
                        'class' => 'input-text',
                        'value' => $model->from_account_holder,
                    ))?>
                    <?= $form->error($model, 'from_account_holder'); ?>
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
                    <?= Yii::t('Front', 'BIC (SWIFT Address)') ?>
                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_bank_account_bic') ?>"></span>
                </div>
                <div class="form-input">
                    <?=
                    $form->textField($model, 'bic', array(
                        'class' => 'input-text bank-swift',
                        'value' => $model->bic,
                        'data-url' => Yii::app()->createUrl('/transfers/GetBankName')
                    ))?>
                    <?= $form->error($model, 'bic'); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5">
            <div class="form-cell">
                <div class="form-lbl">
                    <?= Yii::t('Front', 'Bank name') ?>
                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_bank_account_bank_name') ?>"></span>
                </div>
                <div class="form-input">
                    <?=
                    $form->textField($model, 'from_account_holder', array(
                        'disabled' => 'disabled',
                        'class' => 'input-text bankinfo-name',
                        'value' => $model->from_account_holder,
                    ))?>
                    <?= $form->error($model, 'from_account_holder'); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 ">
        </div>
    </div>
</div>

<div class="method-4 electronic-method-fields"
     style="<?php if (isset($model->electronic_method) && $model->electronic_method == Users_Paymentinstruments::METHOD_PAYPAL) { ?>display:block;<?php } else { ?>display:none;<?php } ?>">
    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10">
            <div class="form-cell">
                <div class="form-lbl">
                    <?= Yii::t('Front', 'Paypal account') ?>
                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_paypal_account') ?>"></span>
                </div>
                <div class="form-input">
                    <?=
                    $form->textField($model, 'paypal_account_number', array(
                        'class' => 'input-text',
                        'value' => $model->from_account_number,
                    ))?>
                    <?= $form->error($model, 'paypal_account_number'); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 ">
        </div>
    </div>
</div>

<div class="method-5 electronic-method-fields"
     style="<?php if (isset($model->electronic_method) && $model->electronic_method == Users_Paymentinstruments::METHOD_WEBMONEY) { ?>display:block;<?php } else { ?>display:none;<?php } ?>">
    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10">
            <div class="form-cell">
                <div class="form-lbl">
                    <?= Yii::t('Front', 'Webmoney account number') ?>
                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_webmoney_account_number') ?>"></span>
                </div>
                <div class="form-input">
                    <?=
                    $form->textField($model, 'webmoney_account_number', array(
                        'class' => 'input-text',
                        'value' => $model->from_account_number,
                    ))?>
                    <?= $form->error($model, 'webmoney_account_number'); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 ">
        </div>
    </div>
</div>

<div class="method-6 electronic-method-fields"
     style="<?php if (isset($model->electronic_method) && $model->electronic_method == Users_Paymentinstruments::METHOD_SKRILL) { ?>display:block;<?php } else { ?>display:none;<?php } ?>">
    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10">
            <div class="form-cell">
                <div class="form-lbl">
                    <?= Yii::t('Front', 'Skrill account') ?>
                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_skrill_account') ?>"></span>
                </div>
                <div class="form-input">
                    <?=
                    $form->textField($model, 'skrill_account_number', array(
                        'class' => 'input-text',
                        'value' => $model->from_account_number,
                    ))?>
                    <?= $form->error($model, 'skrill_account_number'); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 ">
        </div>
    </div>
</div>

<div class="method-<?= Users_Paymentinstruments::METHOD_QIWI ?> electronic-method-fields"
     style="<?php if (isset($model->electronic_method) && $model->electronic_method == Users_Paymentinstruments::METHOD_QIWI) { ?>display:block;<?php } else { ?>display:none;<?php } ?>">
    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10">
            <div class="form-cell">
                <div class="form-lbl">
                    <?= Yii::t('Front', 'QIWI account number') ?>
                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_qiwi_account_number') ?>"></span>
                </div>
                <div class="form-input">
                    <?=
                    $form->textField($model, 'qiwi_account_number', array(
                        'class' => 'input-text',
                        'value' => $model->from_account_number,
                    ))?>
                    <?= $form->error($model, 'qiwi_account_number'); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 ">
        </div>
    </div>
</div>

<div class="row category-row" <?php if($model->isNewRecord): ?>style="display: none"<?php endif; ?>>
    <div class="col-lg-10 col-md-10 col-sm-10">
        <div class="form-cell">
            <div class="form-lbl">
                <?= Yii::t('Front', 'Category') ?>
                <span class="tooltip-icon" title="<?= Yii::t('Front', 'payment_instrument_category_tooltip') ?>"></span>
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
    <div class="col-lg-2 col-md-2 col-sm-2 ">
    </div>
</div>

<?php echo $form->hiddenField($model, 'id'); ?>
<?php $this->endWidget();?>


