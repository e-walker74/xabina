<?php $form=$this->beginWidget('CActiveForm', array(
    'htmlOptions' => array('class' => 'form-horizontal row-border'),
)); ?>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-3 control-label')); ?>
        <div class="col-sm-6">
            <?php echo $form->textField($model, 'name', array('maxlength'=>255, 'class'=>'form-control')); ?>
        </div>
        <div class="col-md-3">
            <p class="hint"><?php echo Rights::t('core', 'Do not change the name </br>unless you know what you are doing.'); ?></p>
            <?php echo $form->error($model, 'name'); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-3 control-label')); ?>
        <div class="col-sm-6">
            <?php echo $form->textField($model, 'description', array('maxlength'=>255, 'class'=>'form-control')); ?>
        </div>
        <div class="col-md-3">
            <p class="hint"><?php echo Rights::t('core', 'A descriptive name for this item.'); ?></p>
            <?php echo $form->error($model, 'description'); ?>
        </div>
    </div>

	<?php if( Rights::module()->enableBizRule===true ): ?>

<!--		<div class="row">
			<?php echo $form->labelEx($model, 'bizRule'); ?>
			<?php echo $form->textField($model, 'bizRule', array('maxlength'=>255, 'class'=>'text-field')); ?>
			<?php echo $form->error($model, 'bizRule'); ?>
			<p class="hint"><?php echo Rights::t('core', 'Code that will be executed when performing access checking.'); ?></p>
		</div>-->

	<?php endif; ?>

	<?php if( Rights::module()->enableBizRule===true && Rights::module()->enableBizRuleData ): ?>

<!--		<div class="row">
			<?php echo $form->labelEx($model, 'data'); ?>
			<?php echo $form->textField($model, 'data', array('maxlength'=>255, 'class'=>'text-field')); ?>
			<?php echo $form->error($model, 'data'); ?>
			<p class="hint"><?php echo Rights::t('core', 'Additional data available when executing the business rule.'); ?></p>
		</div>-->

	<?php endif; ?>

    <div class="panel-footer">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="btn-toolbar">
                    <?php echo CHtml::submitButton(Yii::t('Admin', 'Save'), array('class' => 'btn btn-success')); ?>
                    <?php echo CHtml::link(Rights::t('core', 'Cancel'), Yii::app()->user->rightsReturnUrl, array('class' => 'btn')); ?>
                </div>
            </div>
        </div>
    </div>

<?php $this->endWidget(); ?>