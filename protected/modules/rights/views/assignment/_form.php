<?php $form=$this->beginWidget('CActiveForm', array(
    'htmlOptions' => array('class' => 'form-horizontal row-border'),
)); ?>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'itemname', array('class' => 'col-sm-3 control-label')); ?>
        <div class="col-sm-6">
            <?php echo $form->dropDownList($model, 'itemname', $itemnameSelectOptions, array('class' => 'form-control')); ?>
        </div>
        <div class="col-md-3">
            <?php echo $form->error($model, 'itemname'); ?>
        </div>
    </div>

    <div class="panel-footer">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="btn-toolbar">
                    <?php echo CHtml::submitButton(Yii::t('Admin', 'Assign'), array('class' => 'btn btn-success')); ?>
                </div>
                <div class="btn-toolbar">
                    <?php //echo CHtml::submitButton(Yii::t('Admin', 'Block'), array('class' => 'btn-primary btn')); ?>
                </div>
            </div>
        </div>
    </div>

<?php $this->endWidget(); ?>