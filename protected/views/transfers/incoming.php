<div class="col-lg-9 col-md-9 col-sm-9" >
<div class="new-transfer xabina-form-container">
<div class="h1-header"><?= Yii::t('Front', 'Upload money') ?></div>
<div class="transfer-accordion xabina-accordion xabina-transfer-accordion" >
<div class="accordion-header"><a href="#" class="search-acc"><?= Yii::t('Front', 'Quick Upload') ?></a><span class="arr"></span></div>
<div class="upload-table accordion-content quick-transfer-content">
    <div class="transaction-table-header">
        <table class="transaction-header">
            <tr>
                <td width="24%"<?= Yii::t('Front', 'Method') ?></td>
                <td width="27%"><?= Yii::t('Front', 'Receiver') ?></td>
                <td width="49%"><?= Yii::t('Front', 'Value') ?></td>
            </tr>
        </table>
    </div>
    <div class="new-transfer-table">
        <table class="table">
            <tr>
                <td width="24%">
                    <div class="update-img-payment"><img src="/images/payment.jpg" alt=""/></div>
                    <div class="grey">xxxx xxxx xxxx 01541</div>
                </td>
                <td width="27%">
                    <div class="update-name"><strong class="holder">Viktor Kupets</strong></div>
                    <div class="grey">0121 0101 2585 01541</div>
                </td>
                <td width="49%">
                    <div class="transaction-buttons-cont">
                        <a href="#" class="button edit"></a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="clearfix"><div class="upload-price pull-left">1 000 000.00 EUR</div><a href="#" class="rounded-buttons upload pull-right select-pay">SELECT AND PAY</a></div>
                </td>
            </tr>
            <tr>
                <td width="23%">
                    <div class="update-img-payment"><img src="img/payment.jpg" alt=""/></div>
                    <div class="grey">xxxx xxxx xxxx 01541</div>
                </td>
                <td width="25%">
                    <div class="update-name"><strong class="holder">Viktor Kupets</strong></div>
                    <div class="grey">0121 0101 2585 01541</div>
                </td>
                <td width="50%">
                    <div class="transaction-buttons-cont">
                        <a href="#" class="button edit"></a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="clearfix"><div class="upload-price pull-left">1 000 000.00 EUR</div><a href="#" class="rounded-buttons upload pull-right select-pay">SELECT AND PAY</a></div>
                </td>
            </tr>
            <tr>
                <td width="23%">
                    <div class="update-img-payment"><img src="img/payment.jpg" alt=""/></div>
                    <div class="grey">xxxx xxxx xxxx 01541</div>
                </td>
                <td width="25%">
                    <div class="update-name"><strong class="holder">Viktor Kupets</strong></div>
                    <div class="grey">0121 0101 2585 01541</div>
                </td>
                <td width="50%">
                    <div class="transaction-buttons-cont">
                        <a href="#" class="button edit"></a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="clearfix"><div class="upload-price pull-left">1 000 000.00 EUR</div><a href="#" class="rounded-buttons upload pull-right select-pay">SELECT AND PAY</a></div>
                </td>
            </tr>
            <tr>
                <td width="23%">
                    <div class="update-img-payment"><img src="img/payment.jpg" alt=""/></div>
                    <div class="grey">xxxx xxxx xxxx 01541</div>
                </td>
                <td width="25%">
                    <div class="update-name"><strong class="holder">Viktor Kupets</strong></div>
                    <div class="grey">0121 0101 2585 01541</div>
                </td>
                <td width="50%">
                    <div class="transaction-buttons-cont">
                        <a href="#" class="button edit"></a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="clearfix"><div class="upload-price pull-left">1 000 000.00 EUR</div><a href="#" class="rounded-buttons upload pull-right select-pay">SELECT AND PAY</a></div>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="accordion-header"><a href="#" class="search-acc">Electronic methods</a><span class="arr"></span></div>
<div class="electronic-methods accordion-content">
	<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'electronic-form',
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
            'afterValidate' => 'js:function(form, data, hasError) {
						form.find("input").removeClass("input-error");
						form.find("input").parent().removeClass("input-error");
						form.find(".validation-icon").fadeIn();
						if(hasError) {
							for(var i in data) {
								$("#"+i).addClass("input-error");
								$("#"+i).parent().addClass("input-error");
								$("#"+i).next(".validation-icon").fadeIn();
							}
							return false;
						}
						else {
							submitTransaction(form)
						}
						return false;
					}',
            'afterValidateAttribute' => 'js:function(form, attribute, data, hasError) {
						if(hasError){
							if(!$("#"+attribute.id).hasClass("input-error")){
								$("#"+attribute.id+"_em_").hide().slideDown();
							}
							$("#"+attribute.id).removeClass("valid").parent().removeClass("valid");
							$("#"+attribute.id).addClass("input-error").parent().addClass("input-error");
							$("#"+attribute.id).next(".validation-icon").fadeIn();
						} else {
							if($("#"+attribute.id).hasClass("input-error")){
								$("#"+attribute.id+"_em_").show().slideUp();
							}
							$("#"+attribute.id).removeClass("input-error").parent().next("error-message").slideUp().removeClass("input-error");
							$("#"+attribute.id).next(".validation-icon").fadeIn();
							$("#"+attribute.id).addClass("valid");
						}
					}'
        ),
    )); ?>
    <div class="own-account-form xabina-form-container">
        <div class="form-header"><span><?= Yii::t('Front', 'To') ?></span></div>
        <div class="from-form">
            <div class="form-cell">
                <div class="amount">
					<div class="lbl"><?= Yii::t('Front', 'Amount') ?><span class="tooltip-icon" title="Add Your E-Mail that you will use to access online banking"></span></div>
					<div class="input">
						<?= $form->textField($electronic_request, 'amount', array('class' => 'amount-sum')) ?>
						<span class="delimitter">.</span>
						<?= $form->textField($electronic_request, 'amount_cent', array('class' => 'amount-cent')) ?>
						<?= $form->error($electronic_request, 'amount') ?>
					</div>
				</div>
            </div>
            <div class="form-cell">
                <div class="currency">
					<div class="lbl"><?= Yii::t('Front', 'Currency') ?>
						<span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_currecncy_new_transfer'); ?>"></span>
					</div>
					<div class="input">
						<div class="select-custom currency-select">
							<span class="select-custom-label"><?= $user->settings->currency->title ?></span>
							<?= $form->dropDownList(
								$electronic_request,
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
                                <span class="select-custom-label"><?= Yii::t('Front', 'Choose') ?></span>
                                <?= $form->dropDownList(
                                    $electronic_request,
                                    'to_account_number',
                                    CHtml::listData(
                                        $user->accounts,
                                        'number',
                                        function($data){
                                            return chunk_split($data->number, 4) . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . number_format($data->balance, 2, ".", " ") . "&nbsp;" . $data->currency->code;
                                        }
                                    ),
                                    array('empty' => Yii::t('Front', 'Choose'), 'encode' => false, 'class' => 'select-invisible')
                                ) ?>
                            </div>
                            <?= $form->error($electronic_request, 'to_account_number'); ?>
                        </div>
                    </div>
            </div>
        </div>
        <div class="form-header"><span><?= Yii::t('Front', 'From') ?></span></div>
        <div class="from-form">
            <div class="update-about">
                <div class="field-lbl">
                    <?= Yii::t('Front', 'Method') ?>
                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_electronic_methods') ?>"></span>
                </div>
            </div>
            <div class="field-input">
				
				<?= $form->dropDownList(
					$electronic_request,
					'electronic_method',
					Form_Incoming_Electronic::$methods,
					array(
						'class' => 'selectpicker',
						'empty' => Yii::t('Front', 'Select a method'),
					)
				); ?>
            </div>
		</div>
		
		<div class="method-1 electronic-method-fields">
			<div class="from-form">
				<div class="form-cell">
					<div class="lbl"><?= Yii::t('Front', 'creditcard_number') ?>
						<span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_creditcard_number') ?>"></span>
					</div>
					<div class="field-input">
						<?= $form->textField($electronic_request, 'creditcard_number', array('class' => 'input-text')) ?>
						<?= $form->error($electronic_request, 'creditcard_number'); ?>
					</div>
				</div>
			</div>
			
			<div class="from-form">
				<div class="form-cell">
					<div class="lbl"><?= Yii::t('Front', 'creditcard_holder') ?>
						<span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_creditcard_holder') ?>"></span>
					</div>
					<div class="field-input">
						<?= $form->textField($electronic_request, 'creditcard_holder', array('class' => 'input-text')) ?>
						<?= $form->error($electronic_request, 'creditcard_holder'); ?>
					</div>
				</div>
			</div>
			
			<div class="from-form">
				<div class="form-cell">
					<div class="lbl"><?= Yii::t('Front', 'from_creditcard_p_month') ?>
						<span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_creditcard_p_month') ?>"></span>
					</div>
					<div class="field-input">
						<?= $form->textField($electronic_request, 'p_month', array('class' => 'input-text')) ?>
						<?= $form->error($electronic_request, 'p_month'); ?>
					</div>
				</div>
			</div>
			
			<div class="from-form">
				<div class="form-cell">
					<div class="lbl"><?= Yii::t('Front', 'from_creditcard_p_year') ?>
						<span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_creditcard_p_year') ?>"></span>
					</div>
					<div class="field-input">
						<?= $form->textField($electronic_request, 'p_year', array('class' => 'input-text')) ?>
						<?= $form->error($electronic_request, 'p_year'); ?>
					</div>
				</div>
			</div>
			
			<div class="from-form">
				<div class="form-cell">
					<div class="lbl"><?= Yii::t('Front', 'from_creditcard_p_csc') ?>
						<span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_creditcard_p_csc') ?>"></span>
					</div>
					<div class="field-input">
						<?= $form->textField($electronic_request, 'p_csc', array('class' => 'input-text')) ?>
						<?= $form->error($electronic_request, 'p_csc'); ?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="method-2 electronic-method-fields">
			<div class="from-form">
				<div class="form-cell">
					<div class="lbl"><?= Yii::t('Front', 'ideal_account_number') ?>
						<span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_ideal_account_number') ?>"></span>
					</div>
					<div class="field-input">
						<?= $form->textField($electronic_request, 'ideal_account_number', array('class' => 'input-text')) ?>
						<?= $form->error($electronic_request, 'ideal_account_number'); ?>
					</div>
				</div>
			</div>
		</div>
		
		<?php $this->renderPartial('_outgoing_details', array('model' => $electronic_request, 'form' => $form, 'categories' => $categories)); ?>
		
        <div class="form-submit transfer-controls-cont col-lg-5 col-md-5 col-sm-5 none-padding-left none-padding-right">
            <input type="sbumit" class="submit-button button-next pull-left" value="<?= Yii::t('Front', 'Sign and send') ?>" />
            <div class="star-button pull-right">
            </div>
        </div>
    </div>
	<?php $this->endWidget(); ?>
</div>
<div class="accordion-header"><a href="#" class="search-acc"><?= Yii::t('Front', 'Payment Request') ?></a><span class="arr"></span></div>
<div class="payment-request accordion-content">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'request-form',
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
            'afterValidate' => 'js:function(form, data, hasError) {
						form.find("input").removeClass("input-error");
						form.find("input").parent().removeClass("input-error");
						form.find(".validation-icon").fadeIn();
						if(hasError) {
							for(var i in data) {
								$("#"+i).addClass("input-error");
								$("#"+i).parent().addClass("input-error");
								$("#"+i).next(".validation-icon").fadeIn();
							}
							return false;
						}
						else {
							submitTransaction(form)
						}
						return false;
					}',
            'afterValidateAttribute' => 'js:function(form, attribute, data, hasError) {
						if(hasError){
							if(!$("#"+attribute.id).hasClass("input-error")){
								$("#"+attribute.id+"_em_").hide().slideDown();
							}
							$("#"+attribute.id).removeClass("valid").parent().removeClass("valid");
							$("#"+attribute.id).addClass("input-error").parent().addClass("input-error");
							$("#"+attribute.id).next(".validation-icon").fadeIn();
						} else {
							if($("#"+attribute.id).hasClass("input-error")){
								$("#"+attribute.id+"_em_").show().slideUp();
							}
							$("#"+attribute.id).removeClass("input-error").parent().next("error-message").slideUp().removeClass("input-error");
							$("#"+attribute.id).next(".validation-icon").fadeIn();
							$("#"+attribute.id).addClass("valid");
						}
					}'
        ),
    )); ?>
    <div class="electronic-methods">
        <div class="new-transfer-table own-account-form xabina-form-container">
            <div class="from-form">
                <div class="form-cell">
                    <div class="amount">
                        <div class="lbl"><?= Yii::t('Front', 'Amount') ?><span class="tooltip-icon" title="Add Your E-Mail that you will use to access online banking"></span></div>
                        <div class="input">
                            <?= $form->textField($incoming_request, 'amount', array('class' => 'amount-sum')) ?>
                            <span class="delimitter">.</span>
                            <?= $form->textField($incoming_request, 'amount_cent', array('class' => 'amount-cent')) ?>
                            <?= $form->error($incoming_request, 'amount') ?>
                        </div>
                    </div>
                </div>
                <div class="form-cell">
                    <div class="currency">
                        <div class="lbl"><?= Yii::t('Front', 'Currency') ?>
                            <span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_currecncy_new_transfer'); ?>"></span>
                        </div>
                        <div class="input">
                            <div class="select-custom currency-select">
                                <span class="select-custom-label"><?= $user->settings->currency->title ?></span>
                                <?= $form->dropDownList(
                                    $incoming_request,
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
                                <span class="select-custom-label"><?= Yii::t('Front', 'Choose') ?></span>
                                <?= $form->dropDownList(
                                    $incoming_request,
                                    'to_account_number',
                                    CHtml::listData(
                                        $user->accounts,
                                        'number',
                                        function($data){
                                            return chunk_split($data->number, 4) . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . number_format($data->balance, 2, ".", " ") . "&nbsp;" . $data->currency->code;
                                        }
                                    ),
                                    array('empty' => Yii::t('Front', 'Choose'), 'encode' => false, 'class' => 'select-invisible')
                                ) ?>
                            </div>
                            <?= $form->error($incoming_request, 'to_account_number'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field-lbl">
                <?= Yii::t('Front', 'Comments') ?>
                <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
            </div>
            <div class="field-input">
                <?= $form->textArea($incoming_request, 'description', array('class' => 'len3 autosize')); ?>
            </div>
            <div class="field-lbl">
                <?= Yii::t('Front', 'Transmitter') ?>
                <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
            </div>
            <div class="col-lg-11 col-md-11 col-sm-11 none-padding-left">
                <div class="field-input">
                    <?= $form->textField($incoming_request, 'transmitter', array('class' => 'input-text')); ?>
                    <?= $form->error($incoming_request, 'transmitter'); ?>
                </div>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 none-padding-right">
                <div class="field-input">
                    <div type="submit" class="receiver-submit" ></div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-submit">
                <a href="#" class="rounded-buttons upload add-more "><?= Yii::t('Front', 'ADD INVOISE') ?></a><br><br>
                <div class="clearfix"></div>
            </div>

            <?php $this->renderPartial('_outgoing_details', array('model' => $incoming_request, 'form' => $form, 'categories' => $categories)); ?>

            <div class="form-submit">
                <input type="submit" class="submit-button button-next" value="<?= Yii::t('Front', 'Sign and send') ?>"/>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
</div>
</div>
</div>

<?php Yii::app()->clientScript->registerScriptFile('/js/incoming.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile('/js/jquery.creditCardValidator.js'); ?>
<?php Yii::app()->clientScript->registerCssFile('http://silviomoreto.github.io/bootstrap-select/stylesheets/bootstrap-select.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile('http://silviomoreto.github.io/bootstrap-select/javascripts/bootstrap-select.js', CClientScript::POS_END); ?>