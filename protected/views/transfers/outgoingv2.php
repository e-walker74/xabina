<div class="col-lg-9 col-md-9 col-sm-9">
<div class="h1-header"><?= Yii::t('Front', 'New transfer') ?></div>
<div class="transfer-accordion xabina-accordion xabina-transfer-accordion">
<?php if(!empty($quickTransfers)): ?>
<div class="accordion-header"><a href="#" class="search-acc label-quick-form"><?= Yii::t('Front', 'Quick Transfer') ?></a><span class="arr"></span></div>
<div class="accordion-content quick-transfer-content">
<div class="quick-transfer-form">
<table class="quick-header">
    <tr>
        <th style="width: 31%"><?= Yii::t('Front', 'Recipient') ?></th>
        <th style="width: 34%"><?= Yii::t('Front', 'Value') ?></th>
        <th style="width: 35%"><?= Yii::t('Front', 'Sender') ?></th>
    </tr>
</table>
<ul class="quick-transferts-list list-unstyled">
<?php foreach($quickTransfers as $qtr): ?>
    <li class="quick-row">
        <div class="quick-row">
            <div class="receiver">
                <div class="receiver-name"><?= $qtr->to_account_holder ?></div>
                <div class="receiver-num"><?= chunk_split($qtr->to_account_number, 4) ?></div>
            </div>
            <div class="sum">
                <div class="amount"><?= $qtr->amount ?></div>
            </div>
            <div class="currency">
                <div class="curr"><?= $qtr->currency->code ?></div>
            </div>
            <div class="quick-submit">
                <div class="transaction-buttons-cont">
                    <a href="javaScript:void(0)" onclick="edit_quick_transfer(this)" class="button edit"></a>
                </div>
            </div>
            <div class="account-num">
                <div class="acc-num"><?= chunk_split($qtr->account_number, 4) ?></div>
            </div>

        </div>
        <div class="quick-row">
            <div class="comment">
                <div class="comm-txt">
                    <?= $qtr->description ?>
                </div>

            </div>
            <div class="sign-cont">
                <a href="javaScript:void(0)" onclick="send_quick_transfer('<?= $qtr->id ?>')" class="sign-send-button"><?= Yii::t('Front', 'SIGN AND SEND') ?></a>
            </div>
        </div>

    </li>
    <li class="quick-row-edit" style="display: none;">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'quick-form-'.$qtr->id,
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
						    var li = $(form).parents(".quick-row-edit").prev("li")
						    li.find(".comm-txt").html($(form).find("#Transfers_Outgoing_Favorite_description").val())
						    li.find(".amount").html($(form).find("#Transfers_Outgoing_Favorite_amount").val())
						    li.find(".curr").html($(form).find("#Transfers_Outgoing_Favorite_currency_id option:selected").text())
							li.find(".acc-num").html($(form).find("#Transfers_Outgoing_Favorite_account_number option:selected").text())
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
        <div class="quick-row">
            <div class="receiver">
                <div class="receiver-name"><?= $qtr->to_account_holder ?></div>
                <div class="receiver-num"><?= chunk_split($qtr->to_account_number, 4) ?></div>
                <?= $form->hiddenField($qtr, 'to_account_number') ?>
                <?= $form->hiddenField($qtr, 'id') ?>
            </div>
            <div class="sum">
                <?= $form->textField($qtr, 'amount', array('class' => 'sum-input')); ?>
                <?= $form->error($qtr, 'amount'); ?>
            </div>

            <div class="currency">
                <div class="select-custom select-narrow currency-select">
                    <span class="select-custom-label"><?= $qtr->currency->code ?></span>
                    <?= $form->dropDownList(
                        $quickForm,
                        'currency_id',
                        CHtml::listData($currencies, 'id', 'title'),
                        array('class' => 'select-invisible country-select', 'options' => array($qtr->currency_id => array('selected' => true)))
                    ); ?>
                </div>
            </div>
            <div class="quick-submit">
                <div class="transaction-buttons-cont">
                    <input type="submit" class="button ok" value="" />
                </div>
            </div>
            <div class="account-num">
                <div class="select-custom select-narrow account-select">
                    <span class="select-custom-label"><?= chunk_split($selectedAcc->number, 4); ?></span>
                    <?= $form->dropDownList(
                        $qtr,
                        'account_number',
                        CHtml::listData(
                            $user->accounts,
                            'number',
                            function($data){
                                return chunk_split($data->number, 4);
                            }
                        ),
                        array('class' => 'select-invisible', 'options' => array(
                            $selectedAcc->number => array(
                                'selected' => true,
                            ),
                            $qtr->to_account_number => array(
                                'style' => 'display:none;'
                            ),
                        ))
                    ) ?>
                    <?= $form->error($qtr, 'account_number') ?>
                </div>
            </div>

        </div>
        <div class="quick-row">
            <div class="comment">
                <?= $form->textarea($qtr, 'description') ?>
            </div>
            <div class="sign-cont">
                <div class="transaction-buttons-cont quick-remove">
                    <a href="javaScript:void(0)" onclick="resetPage()" class="button remove"></a>
                </div>
                <a href="javaScript:void(0)" onclick="send_quick_transfer('<?= $qtr->id ?>')" class="sign-send-button" >SIGN AND SEND</a>
            </div>

        </div>
        <?php $this->endWidget(); ?>
    </li>
<?php endforeach; ?>
</ul>
</div>
</div>
<?php endif; ?>
<div class="accordion-header"><a href="#" class="search-acc label-own-form">Own account</a><span class="arr"></span></div>
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
<div class="form-header"><span><?= Yii::t('Front', 'From') ?></span></div>
<div class="from-form">

    <div class="form-cell">
        <div class="amount">
            <div class="lbl"><?= Yii::t('Front', 'Amount') ?><span class="tooltip-icon"
                 title="<?= Yii::t('Front', 'tool_tip_amount_new_transfer') ?>"></span>
            </div>
            <div class="input">
                <?= $form->textField($ownForm, 'amount', array('class' => 'amount-sum')) ?>
                <span class="delimitter">.</span>
                <?= $form->textField($ownForm, 'amount_cent', array('class' => 'amount-cent')) ?>
                <?= $form->error($ownForm, 'amount') ?>
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
                    <span class="select-custom-label"><?= chunk_split($selectedAcc->number, 4); ?></span>
                    <?= $form->dropDownList(
                        $ownForm,
                        'account_number',
                        CHtml::listData(
                            $user->accounts,
                            'number',
                            function($data){
                                return chunk_split($data->number, 4);
                            }
                        ),
                        array('class' => 'select-invisible', 'options' => array($selectedAcc->number => array('selected' => true)))
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
<div class="accordion-header"><a href="#" class="search-acc label-another-form"><?= Yii::t('Front', 'Another Xabina account'); ?></a><span class="arr"></span></div>
<div class="accordion-content">
<div class="own-account-form xabina-form-container">
<div class="form-header"><span><?= Yii::t('Front', 'From'); ?></span></div>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'another-form',
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
<div class="from-form">
    <div class="form-cell">
        <div class="amount">
            <div class="lbl"><?= Yii::t('Front', 'Amount') ?><span class="tooltip-icon"
                                                                   title="<?= Yii::t('Front', 'tool_tip_amount_new_transfer') ?>"></span>
            </div>
            <div class="input">
                <?= $form->textField($anotherForm, 'amount', array('class' => 'amount-sum')) ?>
                <span class="delimitter">.</span>
                <?= $form->textField($anotherForm, 'amount_cent', array('class' => 'amount-cent')) ?>
                <?= $form->error($anotherForm, 'amount') ?>
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
                        $anotherForm,
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
                    <span class="select-custom-label"><?= chunk_split($selectedAcc->number, 4); ?></span>
                    <?= $form->dropDownList(
                        $anotherForm,
                        'account_number',
                        CHtml::listData(
                            $user->accounts,
                            'number',
                            function($data){
                                return chunk_split($data->number, 4);
                            }
                        ),
                        array('class' => 'select-invisible', 'options' => array($selectedAcc->number => array('selected' => true)))
                    ) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-header"><span>To</span></div>
<div class="from-form">
    <div class="form-cell" style="width: 100%">
        <div class="account-number">
            <div class="lbl"><?= Yii::t('Front', 'Account') ?><span class="tooltip-icon" title="<?= Yii::t('Front', 'tootltip_new_transfer_another_xabina_account') ?>"></span></div>
            <div class="input" style="min-height: 40px">
                <?= $form->textField($anotherForm, 'to_account_number', array('class' => 'account-num pull-left')); ?>
                <a href="#" class="account-search pull-right"></a>
            </div>
            <?= $form->error($anotherForm, 'to_account_number'); ?>
        </div>
    </div>
    <div class="form-cell" style="width: 100%">
        <div class="description">
            <div class="lbl"><?= Yii::t('Front', 'Description'); ?><span class="qtity">(<span class="len2-num">0</span>/140)</span><span class="tooltip-icon"
                                                                                                                                         title="<?= Yii::t('Front', 'tooltip_description_own_new_transfer'); ?>"></span></div>
            <div class="input">
                <?= $form->textArea($anotherForm, 'description', array('class' => 'len2')); ?>
            </div>
        </div>

    </div>
</div>

    <?php $this->renderPartial('_outgoing_details', array('model' => $anotherForm, 'form' => $form, 'categories' => $categories)); ?>

    <div class="transfer-controls-cont">

        <input type="submit" onclick="change_click_button(this)" class="button-left save pull-left" value="<?= Yii::t('Front', 'SAVE AND NEW TRANSFER') ?>">
        <input type="submit" onclick="change_click_button(this)" class="button-right send pull-left" value="<?= Yii::t('Front', 'Sign and send') ?>">
        <label class="star-button  pull-right" onclick="$(this).toggleClass('active')">
            <?= $form->checkbox($anotherForm, 'favorite', array('style' => 'display:none;', 'class' => 'favorite-check')); ?>
        </label>
        <div class="clearfix"></div>
    </div>
<?php $this->endWidget(); ?>
</div>
</div>
<div class="accordion-header"><a href="#" class="search-acc label-external-form">External bank transfer</a><span class="arr"></span></div>
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
<div class="form-header"><span><?= Yii::t('Front', 'From') ?></span></div>
    <div class="from-form">
        <div class="form-cell">
            <div class="amount">
                <div class="lbl"><?= Yii::t('Front', 'Amount') ?><span class="tooltip-icon"
                                                                       title="<?= Yii::t('Front', 'tool_tip_amount_new_transfer') ?>"></span>
                </div>
                <div class="input">
                    <?= $form->textField($externalForm, 'amount', array('class' => 'amount-sum')) ?>
                    <span class="delimitter">.</span>
                    <?= $form->textField($externalForm, 'amount_cent', array('class' => 'amount-cent')) ?>
                    <?= $form->error($externalForm, 'amount') ?>
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
                        <span class="select-custom-label"><?= chunk_split($selectedAcc->number, 4); ?></span>
                        <?= $form->dropDownList(
                            $externalForm,
                            'account_number',
                            CHtml::listData(
                                $user->accounts,
                                'number',
                                function($data){
                                    return chunk_split($data->number, 4);
                                }
                            ),
                            array('class' => 'select-invisible', 'options' => array($selectedAcc->number => array('selected' => true)))
                        ) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="form-header"><span><?= Yii::t('Front', 'To') ?></span></div>
<div class="from-form">
    <div class="form-line">
        <div class="form-cell" style="width:42%">
            <div class="account-holder">
                <div class="lbl"><?= Yii::t('Front', 'Account Holder') ?><span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_new_transfer_account_holder') ?>"></span></div>
                <div class="input">
                    <?= $form->textField($externalForm, 'to_account_holder'); ?>
                    <?= $form->error($externalForm, 'to_account_holder'); ?>
                </div>
            </div>
        </div>
        <div class="form-cell pull-right" style="width: 54%">
            <div class="account-number ">
                <div class="lbl"><?= Yii::t('Front', 'Account Number') ?><span class="tooltip-icon" title="<?= Yii::t('Front', 'new_transfer_account_number_external') ?>"></span></div>
                <div class="input">
                    <?= $form->textField($externalForm, 'to_account_number', array('class' => 'account-num pull-left', 'style' => 'width: 81%; min-height: 40px;')); ?>
                    <a href="#" class="account-search pull-right"></a>
                </div>
                <?= $form->error($externalForm, 'to_account_number'); ?>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="form-line">
        <div class="form-cell" style="width: 42%">
            <div class="swift">
                <div class="lbl"><?= Yii::t('Front', 'BIC (SWIFT Address)') ?><span class="tooltip-icon" title="<?= Yii::t('Front', 'new_transfer_externa_bic'); ?>"></span></div>
                <div class="input">
                    <?= $form->textField($externalForm, 'bic', array('data-url' => Yii::app()->createUrl('/transfers/GetBankName'))); ?>
                    <?= $form->error($externalForm, 'bic'); ?>
                </div>
            </div>

        </div>
        <div class="form-cell pull-right" style="width:54%">
            <div class="bank-name">
                <div class="lbl"><?= Yii::t('Front', 'Bank Name'); ?> <span class="tooltip-icon" title="<?= Yii::t('Front', 'new_transfer_externa_bank_name'); ?>"></span></div>
                <div class="input">
                    <?= $form->textField($externalForm, 'bank_name', array('disabled' => 'disabled')); ?>
                    <?= $form->error($externalForm, 'bank_name'); ?>
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
<div class="accordion-header"><a href="#" class="search-acc label-ewallet-form">E-wallet</a><span class="arr"></span></div>
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
<div class="form-header"><span>From</span></div>
    <div class="from-form">
        <div class="form-cell">
            <div class="amount">
                <div class="lbl"><?= Yii::t('Front', 'Amount') ?><span class="tooltip-icon"
                                                                       title="<?= Yii::t('Front', 'tool_tip_amount_new_transfer') ?>"></span>
                </div>
                <div class="input">
                    <?= $form->textField($ewalletForm, 'amount', array('class' => 'amount-sum')) ?>
                    <span class="delimitter">.</span>
                    <?= $form->textField($ewalletForm, 'amount_cent', array('class' => 'amount-cent')) ?>
                    <?= $form->error($ewalletForm, 'amount') ?>
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
                        <span class="select-custom-label"><?= chunk_split($selectedAcc->number, 4); ?></span>
                        <?= $form->dropDownList(
                            $ewalletForm,
                            'account_number',
                            CHtml::listData(
                                $user->accounts,
                                'number',
                                function($data){
                                    return chunk_split($data->number, 4);
                                }
                            ),
                            array('class' => 'select-invisible', 'options' => array($selectedAcc->number => array('selected' => true)))
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
                    <div class="lbl"><?= Yii::t('Front', 'Scrill Account Number') ?><span class="tooltip-icon" title="<?= Yii::t('Front', 'new-transfer-receiver-email-for-paypal'); ?>"></span></div>
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
</div>
</div>

<?php Yii::app()->clientScript->registerScriptFile('/js/transfersv2.js'); ?>

<?php if($transfer): ?>
    <script>
        $(document).ready(function(){
            $('.label-<?= $transfer->form_type ?>-form').click()
        })
    </script>
<?php endif; ?>