<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'messages',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    //'action' => $this->createUrl('message/save'),
    'errorMessageCssClass' => 'error-message',
    'htmlOptions' => array(
        'class' => 'form-validable',
        //'onsubmit'=>"return false;",/* Disable normal form submit */
        //'onkeypress'=>" if(event.keyCode == 13){ send(); } "
    ),
    //'focus'=>array($model,'first_name'),
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'errorCssClass' => 'input-error',
        'successCssClass' => 'valid',
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
                        return true;
                    }
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
                            $("#"+attribute.id+"_em_").show().slideUp();
                        }
                        $("#"+attribute.id).removeClass("input-error").parent().next("error-message").slideUp().removeClass("input-error");
                        $("#"+attribute.id).next(".validation-icon").fadeIn();
                        $("#"+attribute.id).addClass("valid");
                    }
                }'
    ),
)); ?>
<div class="message-controls">
 <?=CHtml::link(Yii::t('Front', 'Send message'), "#", array(
				'submit' => array('/message/save/send/' . $model->id .'/'),
				'csrf' => true,
				'class' => 'button-violet'
			)
		); ?>
		
<!--<a class="button-violet" href="#" id="attachment_add">
	<?= Yii::t('Front', 'Add attachment'); ?>
</a>--> 

<?=CHtml::link(Yii::t('Front', 'Save message'), "#", array(
				'submit' => array('/message/save/save/' . $model->id .'/'),
				'csrf' => true,
				'class' => 'button-violet',
			)
		); ?>
<?=CHtml::link(Yii::t('Front', 'Cancel'), Yii::app()->createUrl('/message/cancel/' . $model->id), array(
				'class' => 'button-violet',
				'confirm' => Yii::t('Front', 'Are you sure?'),
			)
		); 
	  ?>
</div>
<table class="message-headers-table">
<tbody>
  <tr>
	<td><div style="height: 5px"></div></td>
	<td></td>
  </tr>
  <tr>
	<td width="12%"><?= Yii::t('Front', 'To:'); ?></td>
	<td width="88%">
		<?= $form->textField($model, 'to', array('disabled' => ($model->to) ? 'disabled' : '', 'class' => 'form-control', 'placeholder' => Yii::t('Front', 'Add User ID or contact from address book'))); ?>
		<?= $form->error($model, 'to'); ?>
	</td>
  </tr>
  <tr>
	<td><div style="height: 14px"></div></td>
	<td></td>
  </tr>
  <tr>
	<td><?= Yii::t('Front', 'Subject:'); ?></td>
	<td>
		<?= $form->textField($model, 'subject', array('disabled' => ($model->subject) ? 'disabled' : '', 'class' => 'form-control')); ?>
		<?= $form->error($model, 'subject'); ?>
	</td>
  </tr>
</tbody>
</table>
<?= $form->textArea($model, 'message', array('class' => 'message-reply-textarea')); ?>
<?= $form->error($model, 'message'); ?>



<?php $this->endWidget(); ?>