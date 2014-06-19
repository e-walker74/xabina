<div class="accordion-header"><a href="#" class="search-acc label-external-form"><?= Yii::t('Front', 'Bank Transfer') ?></a><span class="arr"></span></div>
<div class="accordion-content">
<div class="own-account-form xabina-form-container">
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'external-form',
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
                    <?= $form->textField($externalForm, 'amount', array('class' => 'amount-sum', 'maxlength' => 9)) ?>
                    <span class="delimitter">.</span>
                    <?= $form->textField($externalForm, 'amount_cent', array('class' => 'amount-cent')) ?>
                    <?= $form->error($externalForm, 'amount') ?>
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
                            $externalForm,
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
                            $externalForm,
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
	<div class="form-line">
		<div class="form-cell" style="width: 54%">
			<div class="account-number ">
				<div class="lbl"><?= Yii::t('Front', 'Account Number') ?><span class="tooltip-icon" title="tooltip text"></span></div>
				<div class="input">
					<?= $form->textField($externalForm, 'to_account_number', array('class' => 'account-num pull-left', 'style' => 'width: 81%;')); ?>
					<a href="#" class="account-search button-search pull-right"></a>
					<div class="clearfix"></div>
					<?= $form->error($externalForm, 'to_account_number'); ?>
				</div>
			</div>
		</div>
		<div class="form-cell pull-right" style="width:42%">
            <div class="account-holder">
                <div class="lbl"><?= Yii::t('Front', 'Account Holder') ?>
					<span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_new_transfer_account_holder') ?>"></span>
				</div>
                <div class="input">
                    <?= $form->textField($externalForm, 'to_account_holder'); ?>
                    <?= $form->error($externalForm, 'to_account_holder'); ?>
                </div>
            </div>
        </div>
	</div>
    <div class="clearfix"></div>
	<?php Widget::get('searchWidget')->html() ?>
	<?php Widget::get('searchTransfers')->html() ?>
	<script>
		$(document).ready(function(){
			
			$('.account-search.button-search').searchContactButton({
				url: '<?= Yii::app()->createUrl('/contact/searchholders') ?>'
			})
			
			clientListSearchTransfers({
				url: '<?= Yii::app()->createUrl('/contact/searchtransfers') ?>',
				qholder: '#Form_Outgoingtransf_External_to_account_holder',
				qnumber: '#Form_Outgoingtransf_External_to_account_number'
			})
		})
	</script>
    <div class="form-line">
        <div class="form-cell" style="width: 42%">
            <div class="swift">
                <div class="lbl"><?= Yii::t('Front', 'BIC (SWIFT Address)') ?><span class="tooltip-icon" title="<?= Yii::t('Front', 'new_transfer_externa_bic'); ?>"></span></div>
                <div class="input">
                    <?= $form->textField($externalForm, 'bic', array('data-url' => Yii::app()->createUrl('/transfers/GetBankName'), 'class' => 'bank-swift')); ?>
                    <?= $form->error($externalForm, 'bic'); ?>
                </div>
            </div>

        </div>
        <div class="form-cell pull-right" style="width:54%">
            <div class="bank-name">
                <div class="lbl"><?= Yii::t('Front', 'Bank Name'); ?> <span class="tooltip-icon" title="<?= Yii::t('Front', 'new_transfer_externa_bank_name'); ?>"></span></div>
                <div class="input">
                    <?= $form->textField($externalForm, 'bank_name', array('disabled' => 'disabled', 'class' => 'bankinfo-name')); ?>
                    <?= $form->error($externalForm, 'bank_name'); ?>
                </div>
            </div>

        </div>
    </div>
	<div class="form-line">
		<div class="form-cell" style="width: 100%">
			<div class="description">
				<div class="lbl"><?= Yii::t('Front', 'Description'); ?><span class="qtity">(<span class="len2-num">0</span>/140)</span><span class="tooltip-icon" title="" data-original-title="tooltip_description_own_new_transfer"></span></div>
				<div class="input">
					<?= $form->textArea($externalForm, 'description', array('class' => 'len2')); ?>
				</div>
			</div>
		</div>
	</div>
    <div class="clearfix"></div>
</div>


    <?php $this->renderPartial('_outgoing_details', array('model' => $externalForm, 'form' => $form, 'categories' => $categories)); ?>

    <div class="transfer-controls-cont">

        <input type="submit" onclick="change_click_button(this)" class="button-left save pull-left" value="<?= Yii::t('Front', 'SAVE AND NEW TRANSFER') ?>">
        <input type="submit" onclick="change_click_button(this)" class="button-right send pull-left" value="<?= Yii::t('Front', 'Sign and send') ?>">
        <label class="star-button  pull-right" onclick="$(this).toggleClass('active')">
            <?= $form->checkbox($externalForm, 'favorite', array('style' => 'display:none;', 'class' => 'favorite-check')); ?>
        </label>
        <div class="clearfix"></div>
    </div>
    <?php $this->endWidget(); ?>
</div>
</div>