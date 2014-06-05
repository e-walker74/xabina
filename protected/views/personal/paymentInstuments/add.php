<div class="col-lg-9 col-md-9 col-sm-9">
    <div class="h1-header">Add new Favorite Payment Instument</div>
    <div class="electronic-methods accordion-content row">
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
                        submitTransaction(form)
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

            <div class="col-lg-10 col-md-10 col-sm-10 own-account-form xabina-form-container">
                <?php $this->widget('Payment', compact('form', 'model'));?>
            </div>
            
            <div class="form-submit transfer-controls-cont col-lg-12 col-md-12 col-sm-12 none-padding-left none-padding-right">
                <input type="submit" class="submit-button button-next pull-left" value="<?= Yii::t('Front', 'Save')?>" />
            </div>
        <?php $this->endWidget();?>
    </div>
</div>
<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile('/js/submitTransaction.js');
