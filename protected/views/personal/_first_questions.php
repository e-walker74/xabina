<?php foreach($user->questions as $ques): ?>
<tr class="question-row" data-value="<?= $ques->question->id ?>">
	<td><?= $ques->question->question ?></td>
	<td>
		<div class="masked-value">**********</div>
		<input class="original-value" type="hidden" value="<?= $ques->answer ?>">
		<a href="javascript:void(0);" class="mask-toggle"></a>
	</td>
	<td class="actions-td">
		<div class="transaction-buttons-cont">
			<a class="button delete" href="javaScript:void(0)" data-url="<?= Yii::app()->createUrl('/personal/delete', array('type' => 'question', 'id' => $ques->id)) ?>" ></a>
		</div>
	</td>
</tr>
<?php endforeach; ?>
<?php if(!count($user->questions)): ?>
<tr class="messenger-form-tr">
<td colspan="3">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'users_securityquestions_1',
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
					form.removeClass("success");
					for(var i in data) {
						form.find("#"+i).addClass("input-error");
						form.find("#"+i).parent().addClass("input-error");
						form.find("#"+i).next(".validation-icon").fadeIn();
					}
					return false;
				}
				else {
					return true;
				}
				return false;
			}',
			'afterValidateAttribute' => 'js:function(form, attribute, data, hasError) {
				if(hasError){
					form.removeClass("success");
					if(!form.find("#"+attribute.id).hasClass("input-error")){
						form.find("#"+attribute.id+"_em_").hide().slideDown();
					}
					form.find("#"+attribute.id).removeClass("valid").parent().removeClass("valid");
					form.find("#"+attribute.id).addClass("input-error").parent().addClass("input-error");
					form.find("#"+attribute.id).next(".validation-icon").fadeIn();
				} else {
					if(form.find("#"+attribute.id).hasClass("input-error")){
						form.find("#"+attribute.id+"_em_").show().slideUp();
					}
					form.find("#"+attribute.id).removeClass("input-error").parent().next("error-message").slideUp().removeClass("input-error"); 
					form.find("#"+attribute.id).next(".validation-icon").fadeIn();
					form.find("#"+attribute.id).addClass("valid");
				}
			}'
		),
	)); ?>
   <table class="messanger-table">
	   <tbody><tr>
		   <td colspan="2">
				<div class="transaction-buttons-cont to-input-row">
					<input type="submit" class="button ok" value="" />
				</div>
			   <div class="field-row left-coll">
				   <div class="field-lbl">

					   <?= Yii::t('Front', 'Question'); ?>

					   <span class="tooltip-icon" title="<?= Yii::t('Front', 'Select one of questions'); ?>"></span>
				   </div>
				   <div class="field-input ">
					   <div class="select-custom">
							<?php 
								$questions = Securityquestions::model()->findAll('status = 1 AND lang = :lang', array(':lang' => Yii::app()->language));
								$firsm = current($questions);
							?>
							
						   <span class="select-custom-label"><?= $firsm->question; ?> </span>
						   <?= $form->dropDownList($model, 'question_id', CHtml::listData(Securityquestions::model()->findAll('status = 1 AND lang = :lang', array(':lang' => Yii::app()->language)), 'id', 'question'), array('class' => 'country-select select-invisible')); ?>
						   <?= $form->error($model, 'question_id'); ?>
					   </div>
				   </div>
			   </div>
			   <div class="field-row right-coll">
				   <div class="field-lbl ">

						<?= Yii::t('Front', 'Answer'); ?>

					   <span class="tooltip-icon" title="tooltip text"></span>
				   </div>
				   <div class="field-input">
						<?= $form->textField($model, 'answer', array('class' => 'input-text')); ?>
						<?= $form->error($model, 'answer'); ?>
				   </div>
			   </div>
		   </td>
	   </tr>
   </tbody>
   </table>
   <?php $this->endWidget(); ?>
</td>
</tr>
<?php endif; ?>
<?php if(count($user->questions) <= 1): ?>
<tr class="messenger-form-tr">
<td colspan="3">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'users_securityquestions_2',
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
		),
	)); ?>
   <table class="messanger-table">
	   <tbody><tr>
		   <td colspan="2">
				<div class="transaction-buttons-cont to-input-row">
					<input type="submit" class="button ok" value="" />
				</div>
				<div class="field-row left-coll">
				   <div class="field-lbl">

					   <?= Yii::t('Front', 'Question'); ?>

					   <span class="tooltip-icon" title="<?= Yii::t('Front', 'Select one of instant messengers'); ?>"></span>
				   </div>
				   <div class="field-input ">
					   <div class="select-custom">
							<?php 
								$questions = Securityquestions::model()->findAll('status = 1 AND lang = :lang', array(':lang' => Yii::app()->language));
								$firsm = current($questions);
							?>
							
						   <span class="select-custom-label"><?= $firsm->question; ?> </span>
						   <?= $form->dropDownList($model, 'question_id', CHtml::listData(Securityquestions::model()->findAll('status = 1 AND lang = :lang', array(':lang' => Yii::app()->language)), 'id', 'question'), array('class' => 'country-select select-invisible')); ?>
						   <?= $form->error($model, 'question_id'); ?>
					   </div>
				   </div>
				</div>
				   <div class="field-row right-coll">
					   <div class="field-lbl ">

						<?= Yii::t('Front', 'Answer'); ?>

					   <span class="tooltip-icon" title="tooltip text"></span>
				   </div>
				   <div class="field-input">
						<?= $form->textField($model, 'answer', array('class' => 'input-text')); ?>
						<?= $form->error($model, 'answer'); ?>
				   </div>
			   </div>
		   </td>
	   </tr>
   </tbody>
   </table>
   <?php $this->endWidget(); ?>
</td>
</tr>
<?php endif; ?>