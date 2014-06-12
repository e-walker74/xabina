<?php if(!empty($quickTransfers)): ?>
<div class="accordion-header"><a href="#" class="search-acc label-quick-form"><?= Yii::t('Front', 'Quick Transfer') ?></a><span class="arr"></span></div>
<div class="accordion-content quick-transfer-content">
<div class="quick-transfer-form">
<table class="quick-header">
    <tr>
        <th style="width: 45%"><?= Yii::t('Front', 'Recipient') ?></th>
        <th style="width: 25%"><?= Yii::t('Front', 'Value') ?></th>
        <th style="width: 30%"><?= Yii::t('Front', 'Sender') ?></th>
    </tr>
</table>
<ul class="quick-transferts-list list-unstyled">
<?php foreach($quickTransfers as $qtr): ?>
    <li class="quick-row">
        <div class="quick-row">
            <div class="receiver">
				<?php if($qtr->form_type == 'ewallet'):?>
					<div class="receiver-name"><?= $qtr->to_account_number ?> (<?= Form_Outgoingtransf_Ewallet::$ewallet_types[$qtr->ewallet_type] ?>)</div>
					<div class="receiver-num"></div>
				<?php else: ?>
					<div class="receiver-name"><?= $qtr->to_account_holder ?></div>
					<div class="receiver-num"><?= (is_numeric($qtr->to_account_number)) ? chunk_split($qtr->to_account_number, 4) : $qtr->to_account_number ?></div>
				<?php endif; ?>
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
                <div class="comm-txt"><?= $qtr->description ?></div>
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
                'errorCssClass'=>'',
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
							var amount = $(form).find("#Transfers_Outgoing_Favorite_amount").val()
							if($(form).find("#Transfers_Outgoing_Favorite_amount_cent").val()){
								amount = amount + "." + $(form).find("#Transfers_Outgoing_Favorite_amount_cent").val()
							}
							
						    li.find(".comm-txt").html($(form).find("#Transfers_Outgoing_Favorite_description").val())
						    li.find(".amount").html(amount)
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
								$("#"+attribute.id+"_em_").show().slideUp(400, function(){
								    form.find("input").parent().removeClass("input-error");
								});
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
                <?= $form->textField($qtr, 'amount', array('class' => 'sum-input', 'maxlength' => 9)); ?>
                <span class="delimitter">.</span>
				<?= $form->textField($qtr, 'amount_cent', array('class' => 'sum-input-cent', 'maxlength' => 2)); ?>
                <div class="clearfix"></div>
                <?= $form->error($qtr, 'amount'); ?>
				<div class="amount_notify error-message notify" style="display:none;"></div>
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
                    <input type="submit" onclick="change_click_button(this)" class="button ok" value="" />
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
                <?= $form->textarea($qtr, 'description', array('maxlength' => '140')) ?>
            </div>
            <div class="sign-cont">
                <div class="transaction-buttons-cont quick-remove">
                    <a href="javaScript:void(0)" onclick="resetPage()" class="button remove"></a>
                </div>
                <a href="javaScript:void(0)" onclick="send_quick_transfer('<?= $qtr->id ?>')" class="sign-send-button" ><?= Yii::t('Front', 'SIGN AND SEND'); ?></a>
            </div>

        </div>
        <?php $this->endWidget(); ?>
    </li>
<?php endforeach; ?>
</ul>
</div>
</div>
<?php endif; ?>