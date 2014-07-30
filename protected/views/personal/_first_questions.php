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
        'action' => array('/personal/editqustions'),
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
            'afterValidate' => 'js:Personal.afterValidate',
            'afterValidateAttribute' => 'js:Personal.afterValidateAttribute',
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
        'action' => array('/personal/editqustions'),
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
            'afterValidate' => 'js:Personal.afterValidate',
            'afterValidateAttribute' => 'js:Personal.afterValidateAttribute',
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