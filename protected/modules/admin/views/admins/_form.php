<?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'admins-form',
        'htmlOptions' => array('class' => 'form-horizontal row-border'),
        'enableAjaxValidation' => true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
            'validateOnChange'=>true,
            'errorCssClass'=>'has-error',
            'afterValidate' => 'js:function(form, data, hasError) {
                form.find("input").parents(".form-group").removeClass("has-error");
                form.find(".validation-icon").show();
                if(hasError) {
                    for(var i in data) {
                        $("#"+i).parents(".form-group").addClass("has-error");
                        $("#"+i).next(".validation-icon").show();
                    }
                    return false;
                }
                else {
                    return true;
                }
            }',
            'afterValidateAttribute' => 'js:function(form, attribute, data, hasError) {
                if(hasError){
                    $("#"+attribute.id).parents(".form-group").addClass("has-error");
                    $("#"+attribute.id).next(".validation-icon").show();
                } else {
                    $("#"+attribute.id).parents(".form-group").removeClass("has-error");
                    $("#"+attribute.id).next(".validation-icon").show();
                }
            }'
        ),
    ));
?>

<div class="form-group">
    <?php echo $form->labelEx($model, 'login', array('class' => 'col-sm-3 control-label')); ?>
    <div class="col-sm-6">
        <?= $form->textField($model, 'login', array('class' => 'form-control')) ?>
    </div>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'password', array('class' => 'col-sm-3 control-label')); ?>
    <div class="col-sm-6">
        <div class="input-group">
            <?php $model->password = ''; ?>
            <?= $form->textField($model, 'password', array('class' => 'form-control', 'readonly' => 'readonly')) ?>
            <div class="input-group-btn">
                <button type="button" id="genNewPass" class="btn btn-info">Generate</button>
            </div>
        </div>
    </div>
</div>

<script>

</script>

<div class="form-group">
    <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-3 control-label')); ?>
    <div class="col-sm-3 control-label">
        <div class="toggle toggle-success"></div>
        <?php echo $form->checkBox($model, 'status', array('style' => 'display:none;')); ?>
    </div>
</div>

<script>
$(document).ready(function(){
     <?php if($model->status): ?>
        $('.toggle').toggles({on:true, checkbox:$('#Admins_status')});
    <?php else: ?>
        $('.toggle').toggles({on:false, checkbox:$('#Admins_status')});
    <?php endif; ?>
})
</script>

<div class="panel-footer">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="btn-toolbar">
                <?php echo CHtml::submitButton(Yii::t('Admin', 'Save'), array('class' => 'btn btn-success')); ?>
            </div>
            <div class="btn-toolbar">
                <?php //echo CHtml::submitButton(Yii::t('Admin', 'Block'), array('class' => 'btn-primary btn')); ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>