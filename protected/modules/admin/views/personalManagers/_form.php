<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'personal-managers-form',
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
    <?php echo $form->labelEx($model, 'manager_name', array('class' => 'col-sm-3 control-label')); ?>
    <div class="col-sm-6">
        <?php echo $form->textField($model, 'manager_name', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>

    </div>
    <div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'manager_name'); ?></div></div>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-3 control-label')); ?>
    <div class="col-sm-6">
        <?php echo $form->textField($model, 'phone', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>

    </div>
    <div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'phone'); ?></div></div>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-3 control-label')); ?>
    <div class="col-sm-6">
        <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>

    </div>
    <div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'email'); ?></div></div>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'manager_state', array('class' => 'col-sm-3 control-label')); ?>
    <div class="col-sm-3 control-label">
        <div class="toggle toggle-success"></div>
        <?php echo $form->checkBox($model, 'manager_state', array('style' => 'display:none;')); ?>
    </div>
</div>

<script>
    $(document).ready(function(){
        <?php if($model->manager_state): ?>
        $('.toggle').toggles({on:true, checkbox:$('#PersonalManagers_manager_state')});
        <?php else: ?>
        $('.toggle').toggles({on:false, checkbox:$('#PersonalManagers_manager_state')});
        <?php endif; ?>
    })
</script>

pers
    <div class="form-group">
        <?php echo $form->labelEx($model, 'language', array('class' => 'col-sm-3 control-label')); ?>
        <div class="col-sm-6">
            <?php echo $form->dropDownList($model, 'language', Languages::$languages, array('class' => 'form-control')); ?>

        </div>
        <div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'language'); ?></div></div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'is_default', array('class' => 'col-sm-3 control-label')); ?>
        <div class="col-sm-6">
            <?php echo $form->dropDownList($model, 'is_default', array(0 => 'no', 1 => 'yes'), array('class' => 'form-control')); ?>

        </div>
        <div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'is_default'); ?></div></div>
    </div>

<div class="panel-footer">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="btn-toolbar">
                   <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('PersonalManagers', 'Create') : Yii::t('PersonalManagers', 'Save'), array('class' => 'btn-primary btn')); ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>