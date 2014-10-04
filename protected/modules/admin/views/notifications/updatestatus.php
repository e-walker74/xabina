<div id="wrap">
	<div id="page-heading">
		<h1><?= Yii::t('Notifications', 'Notifications') ?></h1>
	</div>

	<div class="container">
		<div class="panel panel-midnightblue">
			<div class="panel-heading ">
				<h4><?= Yii::t('Notifications', 'Update') ?></h4>
				<div class="options">
					<!--<a href="javascript:;"><i class="fa fa-cog"></i></a>
					<a href="javascript:;"><i class="fa fa-wrench"></i></a>-->
					<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
				</div>
			</div>
			<div class="panel-body collapse in">
				<?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'notifications-form',
        'htmlOptions' => array('class' => 'form-horizontal row-border','enctype'=>'multipart/form-data'),
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
	<?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-3 control-label')); ?>
	<div class="col-sm-6">
		<?php echo $form->dropDownList($model, 'status', $model->statuses, array('class' => 'form-control')); ?>
	</div>
	<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'status'); ?></div></div>
</div>

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
			</div>
		</div>
	</div>
</div>
