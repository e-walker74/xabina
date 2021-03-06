<div class="col-lg-9 col-md-9 col-sm-9 accordions-container" >
<div class="new-transfer xabina-form-container">
<div class="h1-header"><?= Yii::t('Front', 'Upload money') ?></div>
<div class="transfer-accordion xabina-accordion xabina-transfer-accordion" >
<?php if (count($favorites)) {?>
<div class="accordion-header"><a href="#" class="search-acc"><?= Yii::t('Front', 'Quick Upload') ?></a><span class="arr"></span></div>
<div class="upload-table accordion-content quick-transfer-content quick-transfer-form">
    <div class="transaction-table-header">
        <table class="transaction-header">
            <tr>
                <td width="24%"><?= Yii::t('Front', 'Method') ?></td>
                <td width="27%"><?= Yii::t('Front', 'Receiver') ?></td>
                <td width="49%"><?= Yii::t('Front', 'Value') ?></td>
            </tr>
        </table>
    </div>
    <div class="new-transfer-table">
        <ul class="list-unstyled list-quick">
            <?php foreach ($favorites as $favorite) {?>
			<li class="quick-row">
                <div class="">
                    <div class="update-img-payment pull-left">
                        <?php if($favorite->card_type): ?>
                            <img height="25" src="/images/<?= isset(Transfers_Incoming::$card_types[$favorite->card_type]) ? Transfers_Incoming::$card_types[$favorite->card_type] : "" ?>.png" alt=""/>
                        <?php endif; ?>
                    </div>
                    <div class="transaction-buttons-cont pull-right">
                        <a href="javaScript:void(0)" onclick="quick_edit(this)" class="button edit"></a>
                    </div>
                    <div class="update-name pull-right">
                        <strong class="holder"><?= $favorite->account->user->fullName ?></strong>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="">
                    <div class="grey acc-num pull-left">xxxx xxxx xxxx <?= substr($favorite->from_account_number, -4); ?></div>
                    <div class="grey acc-to-num pull-left"><?= chunk_split($favorite->to_account_number, 4); ?></div>
                    <a href="javaScript:void(0)" onclick="send_quick_transfer('<?= $favorite->id ?>')" class="rounded-buttons upload pull-right select-pay"><?= Yii::t('Front', 'SELECT AND PAY') ?></a>
                    <div class="upload-price pull-right"><span class="amount"><?= number_format($favorite->amount, 2, ".", " ") ?></span>  <span class="currency"><?= $favorite->currency->code ?></span></div>
                    <div class="clearfix"></div>
                </div>
            </li>
            <li class="row-edit">
				<?php $form = $this->beginWidget('CActiveForm', array(
					'id'=>"quick-form{$favorite->id}",
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
								if ($("#"+attribute.id).hasClass("input-error")){
									$("#"+attribute.id+"_em_").show().slideUp();
								}
								$("#"+attribute.id).removeClass("input-error").parent().next("error-message").slideUp().removeClass("input-error");
								$("#"+attribute.id).next(".validation-icon").fadeIn();
								$("#"+attribute.id).addClass("valid");
							}
						}'
					),
				)); ?>
                <div class="quick-row">
                    <div class="update-img-payment pull-left">
                        <?php if ($favorite->card_type): ?>
                            <img height="25" src="/images/<?= isset(Transfers_Incoming::$card_types[$favorite->card_type]) ? Transfers_Incoming::$card_types[$favorite->card_type] : "" ?>.png" alt=""/>
                        <?php endif; ?>
                    </div>
                    <div class="transaction-buttons-cont pull-right">
                        <a href="javaScript:void(0)" onclick="resetPage(this)" class="button remove"></a>
						<input type="submit" class="button ok" value=""/>
                    </div>
                    <!--<div class="update-name pull-right">
                        <input class="holder-name-input" type="text" value="Viktor Kupets"/>
                        <div class="error-message" id="Form_Incoming_Request_transmitter_em_" style="display: block; overflow: hidden;">error</div>
                    </div>-->
                    <div class="clearfix"></div>
                </div>
                <div class="quick-row">
					<?php $quickForm->attributes = $favorite->attributes?>
                    <div class="grey acc-num pull-left">xxxx xxxx xxxx <?= substr($favorite->from_account_number, -4); ?></div>
                    <div class="grey acc-to-num pull-left">
						<div class="select-custom select-narrow currency-select">
							<span class="select-custom-label"><?= chunk_split($favorite->to_account_number, 4) ?></span>
							<?= $form->dropDownList(
								$quickForm,
								'to_account_number',
								CHtml::listData(
									$user->accounts,
									'number',
									function($data){
										return chunk_split($data->number, 4);
									}
								),
								array('encode' => false, 'class' => 'select-invisible')
							) ?>
						</div>
                        <!--<div class="error-message" id="Form_Incoming_Request_transmitter_em_" style="display: block; overflow: hidden;">error</div>-->
                    </div>
                    <a href="javaScript:void(0)" onclick="send_quick_transfer('<?= $favorite->id ?>')" class="rounded-buttons upload pull-right select-pay"><?= Yii::t('Front', 'SELECT AND PAY') ?></a>
                    <div class="upload-price pull-right">
						<?php 
							$Aamount = explode('.', $favorite->amount);
							$quickForm->amount = $Aamount[0]; 
							if(isset($Aamount[1])){
								$quickForm->amount_cent = $Aamount[1];
							}
						?>
						<?= $form->textField($quickForm, 'amount', array('class' => 'amount-input', 'maxlength' => 9)) ?>
						<span class="delimitter">.</span>
						<?= $form->textField($quickForm, 'amount_cent', array('class' => 'cent-input')) ?>
						
                        <div class="select-custom select-narrow currency-select">
                            <span class="select-custom-label"><?= $favorite->currency->code ?></span>
							<?= $form->dropDownList(
								$quickForm,
								'currency_id',
								CHtml::listData($currencies, 'id', 'title'),
								array('class' => 'select-invisible', 'options' => array($favorite->currency_id => array('selected' => true)))
							); ?>
                        </div>
                        <?= $form->error($quickForm, 'amount') ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
				<?php $quickForm->tid = $favorite->id ?>
				<?= $form->hiddenField($quickForm, 'tid') ?>
				<?php $this->endWidget(); ?>
            </li>
			<?php } ?>
<!--
            <li>
                <td >
                    <div class="update-img-payment"><img height="25" src="/images/payment.jpg" alt=""/></div>
                    <input class="method-input" type="text" value="xxxx xxxx xxxx 01541"/>
                    <div class="error-message" id="Form_Incoming_Request_transmitter_em_" style="display: block; overflow: hidden;">error</div>
                </td>
                <td>
                    <input class="holder-name-input" type="text" value="Viktor Kupets"/>
                    <div class="error-message" id="Form_Incoming_Request_transmitter_em_" style="display: block; overflow: hidden;">error</div>
                    <input class="holder-account-input" type="text" value="0121 0101 2585 01541"/>
                    <div class="error-message" id="Form_Incoming_Request_transmitter_em_" style="display: block; overflow: hidden;">error</div>
                </td>
                <td>
                    <div class="transaction-buttons-cont">
                        <a href="#" class="button remove"></a>
                        <a href="#" class="button ok"></a>
                    </div>
                    <div class="clearfix"></div>
                    <div>
                    <div class="pull-left">
                        <input class="amount-input" type="text" value="1 000 000 "/>
                        <span class="delimitter">.</span>
                        <input class="cent-input" type="00"/>
                        <div class="select-custom select-narrow currency-select">
                            <span class="select-custom-label">EUR</span>
                            <select class="select-invisible" name="Form_Incoming_Electronic[currency_id]" id="Form_Incoming_Electronic_currency_id">
                                <option value="1">USD</option>
                                <option value="2" selected="selected">RUB</option>
                            </select>

                        </div>
                        <div class="error-message" id="Form_Incoming_Request_transmitter_em_" style="display: block; overflow: hidden;">error</div>
                    </div>
                        <a href="#" class="rounded-buttons upload pull-right select-pay">SELECT AND PAY</a>

                    </div>
                </td>
            </li>-->
        </ul>
    </div>
</div>
<?php }?>
<div class="accordion-header">
    <a href="#" class="search-acc">Electronic methods</a><span class="arr"></span>
</div>
<div class="electronic-methods accordion-content">
	<?php $form = $this->beginWidget('CActiveForm', array(
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
						<?= $form->textField($electronic_request, 'amount', array('class' => 'amount-sum', 'maxlength' => 9)) ?>
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
        
        <div class="form-header">
            <span><?= Yii::t('Front', 'From') ?></span>
        </div>
        
        <?php
        $this->widget('Payment', array(
            'form' => $form,
            'model' => $electronic_request,
        )); 
        $this->renderPartial('_outgoing_details', array(
            'form' => $form,
            'model' => $electronic_request,
            'categories' => $categories
        ));
        ?>
		
        <div class="form-submit transfer-controls-cont col-lg-12 col-md-12 col-sm-12 none-padding-left none-padding-right">
            <input type="submit" class="submit-button button-next pull-left" value="<?= Yii::t('Front', 'Sign and send') ?>" />
			<label class="star-button in-star pull-left" onclick="$(this).toggleClass('active')">
				<?= $form->checkbox($electronic_request, 'favorite', array('style' => 'display:none;', 'class' => 'favorite-check')); ?>
			</label>
        </div>
    </div>
	<?php $this->endWidget(); ?>
</div>
<div class="accordion-header"><a href="#" class="search-acc"><?= Yii::t('Front', 'Payment Request') ?></a><span class="arr"></span></div>
<div class="payment-request accordion-content">
    <?php $form = $this->beginWidget('CActiveForm', array(
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
                            <?= $form->textField($incoming_request, 'amount', array('class' => 'amount-sum', 'maxlength' => 9)) ?>
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

            <div class="form-submit transfer-controls-cont ">
                <input type="submit" class="submit-button button-next" value="<?= Yii::t('Front', 'Sign and send') ?>"/>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
</div>
</div>
</div>

<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile('/js/incoming.js');
$cs->registerScriptFile('/js/submitTransaction.js');
$cs->registerScriptFile('/js/jquery.creditCardValidator.js');
$cs->registerCssFile('http://silviomoreto.github.io/bootstrap-select/stylesheets/bootstrap-select.css');
$cs->registerScriptFile('http://silviomoreto.github.io/bootstrap-select/javascripts/bootstrap-select.js', CClientScript::POS_END);