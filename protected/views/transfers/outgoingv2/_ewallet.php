<div class="accordion-header"><a href="#" class="search-acc label-ewallet-form"><?= Yii::t('Front', 'E-wallet') ?></a><span class="arr"></span></div>
<div class="accordion-content">
<div class="own-account-form xabina-form-container">
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'ewallet-form',
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
        'afterValidate' => 'js:afterValidate',
        'afterValidateAttribute' => 'js:afterValidateAttribute'
    ),
)); ?>
<div class="form-header"><span><?= Yii::t('Front', 'From'); ?></span></div>
    <div class="from-form">
        <div class="form-cell">
            <div class="amount">
                <div class="lbl"><?= Yii::t('Front', 'Amount') ?><span class="tooltip-icon"
                                                                       title="<?= Yii::t('Front', 'tool_tip_amount_new_transfer') ?>"></span>
                </div>
                <div class="input">
                    <?= $form->textField($ewalletForm, 'amount', array('class' => 'amount-sum', 'maxlength' => 9)) ?>
                    <span class="delimitter">.</span>
                    <?= $form->textField($ewalletForm, 'amount_cent', array('class' => 'amount-cent')) ?>
                    <?= $form->error($ewalletForm, 'amount') ?>
					<div class="amount_notify error-message notify" style="display:none;"></div>
                </div>
            </div>
        </div>
        <div class="form-cell">
            <div class="currency">
                <div class="lbl"><?= Yii::t('Front', 'Currency'); ?><span class="tooltip-icon"
                                                                          title="<?= Yii::t('Front', 'tooltip_currecncy_new_transfer'); ?>">
    </span></div>
                <div class="input">
                    <div class="select-custom currency-select">
                        <span class="select-custom-label"><?= $user->settings->currency->title ?></span>
                        <?= $form->dropDownList(
                            $ewalletForm,
                            'currency_id',
                            CHtml::listData($currencies, 'id', 'title'),
                            array('class' => 'select-invisible', 'options' => array($user->settings->currency_id => array('selected' => true)))
                        ); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-cell" style="float: right">
            <div class="account">
                <div class="lbl"><?= Yii::t('Front', 'Account') ?><span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_account_new_transfer') ?>"></span></div>
                <div class="input">
                    <div class="select-custom currency-select">
                        <span class="select-custom-label"><?= chunk_split($selectedAcc->number, 4) . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . number_format($selectedAcc->balance, 2, ".", " ") . "&nbsp;" . $selectedAcc->currency->code ?></span>
                        <?= $form->dropDownList(
                            $ewalletForm,
                            'account_number',
                            CHtml::listData(
                                $user->accounts,
                                'number',
                                function($data){
                                    return chunk_split($data->number, 4) . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . number_format($data->balance, 2, ".", " ") . "&nbsp;" . $data->currency->code;
                                }
                            ),
                            array('encode' => false, 'class' => 'select-invisible', 'options' => array($selectedAcc->number => array('selected' => true)))
                        ) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-header"><span><?= Yii::t('Front', 'To') ?></span></div>
    <div class="from-form">
        <div class="form-cell" style="width: 100%">
            <div class="description">
                <div class="lbl"><?= Yii::t('Front', 'E-wallet') ?><span class="tooltip-icon" title="new_transfer_ewallet_tooltip"></span></div>
                <div class="input">
                    <div class="select-custom currency-select">
                        <span class="select-custom-label"><?= Yii::t('Front', 'Choose') ?></span>
                        <?= $form->dropDownList(
                            $ewalletForm,
                            'ewallet_type',
                            array('' => Yii::t('Front', 'Choose')) + Form_Outgoingtransf_Ewallet::$ewallet_types,
                            array(
                                'class' => 'select-invisible',
                                'options' => array('' => array('selected' => true, 'disabled' => true)),
                            )
                        ) ?>
                    </div>
                    <?= $form->error($ewalletForm, 'ewallet_type'); ?>
                </div>
            </div>
        </div>
        <div class="disabled e-wallet-type-1">
            <div class="form-cell" style="width: 100%">
                <div class="email">
                    <div class="lbl"><?= Yii::t('Front', 'Receiver E-Mail') ?><span class="tooltip-icon" title="<?= Yii::t('Front', 'new-transfer-receiver-email-for-paypal'); ?>"></span></div>
                    <div class="input">
                        <?= $form->textField($ewalletForm, 'paypall_email'); ?>
                        <?= $form->error($ewalletForm, 'paypall_email'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="disabled e-wallet-type-2">
            <div class="form-cell" style="width: 100%">
                <div class="email">
                    <div class="lbl"><?= Yii::t('Front', 'Web Money Account Number') ?><span class="tooltip-icon" title="<?= Yii::t('Front', 'new-transfer-receiver-email-for-paypal'); ?>"></span></div>
                    <div class="input">
                        <?= $form->textField($ewalletForm, 'webmoney_acc'); ?>
                        <?= $form->error($ewalletForm, 'webmoney_acc'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="disabled e-wallet-type-3">
            <div class="form-cell" style="width: 100%">
                <div class="email">
                    <div class="lbl"><?= Yii::t('Front', 'Receiver E-Mail') ?><span class="tooltip-icon" title="<?= Yii::t('Front', 'new-transfer-receiver-email-for-paypal'); ?>"></span></div>
                    <div class="input">
                        <?= $form->textField($ewalletForm, 'scrill_acc'); ?>
                        <?= $form->error($ewalletForm, 'scrill_acc'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-cell" style="width: 100%">
            <div class="description">
                <div class="lbl"><?= Yii::t('Front', 'Description'); ?><span class="qtity">(<span class="len3-num">0</span>/140)</span><span class="<?= Yii::t('Front', 'new_transfer_description') ?>"
                                                                                                                                             title="<?= Yii::t('Front', 'tooltip_description_own_new_transfer'); ?>"></span></div>
                <div class="input">
                    <?= $form->textArea($ewalletForm, 'description', array('class' => 'len3')); ?>
                </div>
            </div>
        </div>
    </div>

    <?php $this->renderPartial('_outgoing_details', array('model' => $ewalletForm, 'form' => $form, 'categories' => $categories)); ?>

    <div class="transfer-controls-cont">

        <input type="submit" onclick="change_click_button(this)" class="button-left save pull-left" value="<?= Yii::t('Front', 'SAVE AND NEW TRANSFER') ?>">
        <input type="submit" onclick="change_click_button(this)" class="button-right send pull-left" value="<?= Yii::t('Front', 'Sign and send') ?>">
        <label class="star-button  pull-right" onclick="$(this).toggleClass('active')">
            <?= $form->checkbox($ewalletForm, 'favorite', array('style' => 'display:none;', 'class' => 'favorite-check')); ?>
        </label>
        <div class="clearfix"></div>
    </div>
    <?php $this->endWidget(); ?>
</div>
</div>