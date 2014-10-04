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
<?php echo $form->hiddenField($model, 'code', array('value' => 'from_panel')); ?>
<?$model_users = new Users();?>
				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'dataProvider'=>$model_users->search(),
					'ajaxUpdate' => true,
					//'htmlOptions' => array('class' => 'table table-striped table-bordered datatables'),
					'itemsCssClass' => 'table table-striped table-bordered datatables',
					'filter'=>$model_users,
					'id'=>'userList',
					'summaryCssClass' => 'dataTables_info',
					'template' => '{items}
									<div class="row">
										<div class="col-xs-6">
											{summary}
										</div>
										<div class="col-xs-6">
											{pager}
										</div>
									</div>',
					'pagerCssClass' => 'dataTables_paginate paging_bootstrap',
					'cssFile'=>$this->module->assetsUrl.'/css/styles-admin.css',
					'pager' => 'BootstrapPager',
					'columns'=>array(
						array(
							'class'=>'CCheckBoxColumn',
							'selectableRows' => 2,
							'checkBoxHtmlOptions'=>array('onClick' => '$.ajax("?checked_id="+$(this).val()+"&checked_status="+$(this).attr("checked"))'),
							'checked'=>'($st=Yii::app()->user->getState("notif_user_id"))&&isset($st[$data->id])&&$st[$data->id]'
						),
								array(
									'header' => 'Дата',
									'value' => 'date("Y-m-d h:m", $data->created_at)',
								),
								'login',
								'email',

					),
				)); ?>

<div class="form-group">
	<?php echo $form->labelEx($model, 'type', array('class' => 'col-sm-3 control-label')); ?>
	<div class="col-sm-6">
		<?php echo $form->dropDownList($model, 'type', $model->types, array('class' => 'form-control')); ?>
	</div>
	<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'type'); ?></div></div>
</div>


<div class="form-group">
	<?php echo $form->labelEx($model, 'manager_id', array('class' => 'col-sm-3 control-label')); ?>
	<div class="col-sm-6">
		<?php echo $form->dropDownList($model, 'manager_id', CHtml::listData(PersonalManagers::model()->findAll(), 'id', 'manager_name'), array('class' => 'form-control')); ?>
	</div>
	<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'type'); ?></div></div>
</div>

<div class="form-group">
	<?php echo $form->labelEx($model, 'title', array('class' => 'col-sm-3 control-label')); ?>
	<div class="col-sm-6">
		<?php echo $form->textField($model, 'title', array('class' => 'form-control')); ?>

	</div>
	<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'title'); ?></div></div>
</div>

<div class="form-group">
	<?php echo $form->labelEx($model, 'announce', array('class' => 'col-sm-3 control-label')); ?>
	<div class="col-sm-6">
		<?php $this->widget('ImperaviRedactorWidget', array(
    'model' => $model,
    'attribute' => 'announce',
	'options' => array(
        'lang' => 'ru',
        'iframe' => true,
		'height' => '200px'
    ),
	'htmlOptions' => array('style' => 'height:200px')
));?>
	</div>
	<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'announce'); ?></div></div>
</div>

<div class="form-group">
	<?php echo $form->labelEx($model, 'text', array('class' => 'col-sm-3 control-label')); ?>
	<div class="col-sm-6">
	<?php $this->widget('ImperaviRedactorWidget', array(
    'model' => $model,
    'attribute' => 'text',
	'options' => array(
        'lang' => 'ru',
        'iframe' => true,
		'height' => '200px'
    ),
	'htmlOptions' => array('style' => 'height:200px')
));?>

	</div>
	<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'text'); ?></div></div>
</div>


<div class="form-group">
	<?php echo $form->labelEx($model, 'section', array('class' => 'col-sm-3 control-label')); ?>
	<div class="col-sm-6">
		<?php echo $form->dropDownList($model, 'section', $model->sections, array('class' => 'form-control')); ?>
	</div>
	<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'section'); ?></div></div>
</div>

<div class="form-group">
	<?php echo $form->labelEx($model, 'section_link', array('class' => 'col-sm-3 control-label')); ?>
	<div class="col-sm-6">
		<?php echo $form->textField($model, 'section_link', array('class' => 'form-control')); ?>

	</div>
	<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'section_link'); ?></div></div>
</div>

<div class="form-group">
	<?php echo $form->labelEx($model, 'button', array('class' => 'col-sm-3 control-label')); ?>
	<div class="col-sm-6">
		<?php echo $form->textField($model, 'button', array('class' => 'form-control')); ?>

	</div>
	<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'button'); ?></div></div>
</div>

<div class="form-group">
	<?php echo $form->labelEx($model, 'button_link', array('class' => 'col-sm-3 control-label')); ?>
	<div class="col-sm-6">
		<?php echo $form->textField($model, 'button_link', array('class' => 'form-control')); ?>

	</div>
	<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'button_link'); ?></div></div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label"><?= Yii::t("Notifications", "Attachments")?></label>
	<div class="col-sm-6">
		<?php echo CHtml::fileField('files[]') ?>
		<a href="javascript;" onclick="$(this).prev().clone().insertBefore($(this).prev());return false;">Add</a>
	</div>
</div>
<div class="form-group">
	<?php echo $form->labelEx($model, 'published_at', array('class' => 'col-sm-3 control-label')); ?>
	<div class="col-sm-6">
		<?php

    $this->widget('CJuiDateTimePicker',array(
        'model'=>$model, //Model object
        'attribute'=>'published_at', //attribute name
		'options'=>array(
			'showAnim'=>'slideDown',
			'hideIfNoPrevNext' => true,
			'timeFormat'=>'hh:mm:ss',
			'dateFormat' => 'yy-mm-dd'
		),
         'mode'=>'datetime', //use "time","date" or "datetime" (default)
        'htmlOptions'=>array('class'=>'form-control') // jquery plugin options
    ));

?>
	</div>
	<div class="col-md-3"><div class="help-block"><?php echo $form->error($model, 'published_at'); ?></div></div>
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