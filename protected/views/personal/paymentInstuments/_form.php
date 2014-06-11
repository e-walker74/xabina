<?php $form = $this->beginWidget('CActiveForm', array(
    'action'=>"/personal/paymentinstuments?method=$method",
    'id'=>'electronic-form-' . Text::rand_str(),
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
            if (hasError) {
                for (var i in data) {
                    $("#"+i).addClass("input-error");
                    $("#"+i).parent().addClass("input-error");
                    $("#"+i).next(".validation-icon").fadeIn();
                }
                return false;
            } else {
                submitForm(form, "' . $method . '");
                return false;
            }
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
    <?php
    $this->widget('Payment', Array(
        'form'=>$form,
        'model'=>$model
    ));
    echo $form->hiddenField($model, 'id');
    ?>
</div>
<div class="transaction-buttons-cont">
    <input type="submit" class="button ok" value="">
    <a class="button cancel" href="javaScript:void(0)"></a>
</div>
<?php $this->endWidget();?>


