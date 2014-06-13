<div class="accordion-header"><a href="#" class="search-acc label-own-form"><?= Yii::t('Front', 'Own Account') ?></a><span class="arr"></span></div>
<div class="accordion-content">
<div class="own-account-form xabina-form-container">
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'own-form',
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
<div class="form-header"><span><?= Yii::t('Front', 'From') ?></span></div>
<div class="from-form">

    <div class="form-cell">
        <div class="amount">
            <div class="lbl"><?= Yii::t('Front', 'Amount') ?><span class="tooltip-icon"
                 title="<?= Yii::t('Front', 'tool_tip_amount_new_transfer') ?>"></span>
            </div>
            <div class="input">
                <?= $form->textField($ownForm, 'amount', array('class' => 'amount-sum', 'maxlength' => 9)) ?>
                <span class="delimitter">.</span>
                <?= $form->textField($ownForm, 'amount_cent', array('class' => 'amount-cent')) ?>
                <?= $form->error($ownForm, 'amount') ?>
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
                        $ownForm,
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
                        $ownForm,
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
        <div class="account-number">
            <div class="lbl"><?= Yii::t('Front', 'Account') ?><span class="tooltip-icon" title="to_account_own_new_transfer"></span></div>
            <div class="input">
                <div class="select-custom currency-select">
                    <span class="select-custom-label"><?= ($ownForm->to_account_number) ? chunk_split($ownForm->to_account_number, 4) : Yii::t('Front', 'Choose') ?></span>
                    <?= $form->dropDownList(
                        $ownForm,
                        'to_account_number',
                        array('' => Yii::t('Front', 'Choose')) +
                        CHtml::listData(
                            $user->accounts,
                            'number',
                            function($data){
                                return chunk_split($data->number, 4);
                            }
                        ),
                        array('class' => 'select-invisible', 'options' => array('' => array('selected' => true, 'disabled' => true)))
                    ) ?>
                </div>
                <div class="clearfix"></div>
                <?= $form->error($ownForm, 'to_account_number'); ?>
            </div>
        </div>
    </div>
    <div class="form-cell" style="width: 100%">
        <div class="description">
            <div class="lbl"><?= Yii::t('Front', 'Description'); ?><span class="qtity">(<span class="len1-num">0</span>/140)</span><span class="tooltip-icon"
                                                                                 title="<?= Yii::t('Front', 'tooltip_description_own_new_transfer'); ?>"></span></div>
            <div class="input">
                <?= $form->textArea($ownForm, 'description', array('class' => 'len1')); ?>
            </div>
        </div>

    </div>
</div>

    <?php $this->renderPartial('_outgoing_details', array('model' => $ownForm, 'form' => $form, 'categories' => $categories)); ?>

<div class="transfer-controls-cont">

    <input type="submit" onclick="change_click_button(this)" class="button-left save pull-left" value="<?= Yii::t('Front', 'SAVE AND NEW TRANSFER') ?>">
    <input type="submit" onclick="change_click_button(this)" class="button-right send pull-left" value="<?= Yii::t('Front', 'Sign and send') ?>">
    <label class="star-button  pull-right" onclick="$(this).toggleClass('active')">
        <?= $form->checkbox($ownForm, 'favorite', array('style' => 'display:none;', 'class' => 'favorite-check')); ?>
    </label>
    <div class="clearfix"></div>
</div>
<?php $this->endWidget(); ?>
</div>
</div>