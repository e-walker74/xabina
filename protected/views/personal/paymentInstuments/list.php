<div class="col-lg-9 col-md-9 col-sm-9">
    <div class="xabina-form-container">
        <div class="h1-header">
            <?= Yii::t('Front', 'Favorite Payment Instuments'); ?>
        </div>
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
                    } else {
                        submitForm(form)
                    }
                    return false;
                }',
                'afterValidateAttribute' => 'js:function(form, attribute, data, hasError) {
                    if (hasError) {
                        if (!$("#"+attribute.id).hasClass("input-error")) {
                            $("#"+attribute.id+"_em_").hide().slideDown();
                        }
                        $("#"+attribute.id).removeClass("valid").parent().removeClass("valid");
                        $("#"+attribute.id).addClass("input-error").parent().addClass("input-error");
                        $("#"+attribute.id).next(".validation-icon").fadeIn();
                    } else {
                        if ($("#"+attribute.id).hasClass("input-error")) {
                            $("#"+attribute.id+"_em_").show().slideUp();
                        }
                        $("#"+attribute.id).removeClass("input-error").parent().next("error-message").slideUp().removeClass("input-error");
                        $("#"+attribute.id).next(".validation-icon").fadeIn();
                        $("#"+attribute.id).addClass("valid");
                    }
                }'
            ),
        ));?>
        <table class="table xabina-table middle">
            <tr class="table-header">
                <th><?=Yii::t('Front', 'Method')?></th>
                <th><?=Yii::t('Front', 'Account')?></th>
                <th><?=Yii::t('Front', 'Status')?></th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach ($paymentInstruments as $paymentInstrument) {
                $this->renderPartial('paymentInstuments/row', compact('paymentInstrument'));
            }?>
            <tr class="add-more" id="add-more">
                <td colspan="4" class="table-form-subheader">
                    <a href="#" id="add-new-payment-instrument" class="rounded-buttons upload add-more">ADD NEW</a>
                </td>
            </tr>
            <tr class="prof-form" style="display: none;">
                <td colspan="4" class="table-form-subheader">
                    <div class="table-subheader">Add new favorite payment instument</div>
                </td>
            </tr>
            <tr class="prof-form" style="display: none;">
                <td colspan="4">
                    <div class="col-lg-10 col-md-10 col-sm-10 own-account-form xabina-form-container">
                        <?php $this->widget('Payment', compact('form', 'model'));?>
                    </div>
                    <div class="transaction-buttons-cont">
                        <input type="submit" class="button ok" value="">
                        <a class="button cancel" href="javaScript:void(0)"></a>
                    </div>
                </td>
            </tr>
        </table>
        <script language="JavaScript"><!--
            $('#add-new-payment-instrument').click(function() {
                $('.prof-form').css('display', 'table-row');
                $('.add-more').css('display', 'none');
                return false;
            });
            $('.button.cancel').click(function() {
                $('.prof-form').css('display', 'none');
                $('.add-more').css('display', 'table-row');
                return false;
            });
        //--></script>
        <?php $this->endWidget();?>
    </div>
</div>
<?php Yii::app()->clientScript->registerScriptFile('/js/paymentInstruments.js'); ?>