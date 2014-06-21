<div class="col-lg-9 col-md-9 col-sm-9" >
  <div class="h1-header">
    <?= Yii::t('Front', 'My personal cabinet'); ?>
  </div>
  <?php $this->widget('XabinaAlert'); ?>
  <div id="emails_view" class="xabina-form-container">
		<div class="subheader"><?= Yii::t('Front', 'My instant messengers'); ?></div>
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'users_instmessager',
			'enableAjaxValidation'=>true,
			'enableClientValidation'=>true,
			'errorMessageCssClass' => 'error-message',
			'htmlOptions' => array(
				'class' => 'form-validable',
				'enctype' => 'multipart/form-data'
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
		<table class="table xabina-table-personal">
			<tbody>
			<tr class="table-header">
				<th style="width: 29%"><?= Yii::t('Front', 'Instant Messaging'); ?></th>
				<th style="width: 25%"><?= Yii::t('Front', 'Username'); ?></th>
				<th style="width: 21%"><?= Yii::t('Front', 'Type'); ?></th>
				<th style="width: 20%"><?= Yii::t('Front', 'Status'); ?></th>
				<th style="width: 5%"></th>
			</tr>
			<?php foreach($user->messagers as $mes): ?>
				<tr>
					<td>
						<div class="messenger-ico <?= $mes->messager_system->code ?>"></div> <?= $mes->messager_system->name ?>
					</td>
					<td><?= $mes->messager_login ?></td>
					<td>
						<div class="relative">
							<!--<span class="dropdown_button types_dropdown" row-id="<?= $mes->id ?>">-->
								<?= $mes->type->type_name ?>
							<!--</span>-->
					   </div>
					</td>
					<td>
						<?php if($mes->is_master): ?>
							<span class="primary"><?= Yii::t('Front', 'Primary'); ?></span>
						<?php else: ?>
							<a href="javaScript:void(0)" onclick="js:makePrimary('<?= Yii::app()->createUrl('/personal/makePrimary', array('type' => 'instmessagers', 'id' => $mes->id)) ?>')"><?= Yii::t('Front', 'Make primary'); ?></a>
						<?php endif; ?>
					</td>
					<td class="actions-td">
						<div class="transaction-buttons-cont">
                            <?php if(!$mes->is_master): ?>
							<a class="button delete" data-url="<?= Yii::app()->createUrl('/personal/delete', array('type' => 'messager', 'id' => $mes->id)) ?>" ></a>
                            <?php endif; ?>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
			<?php if(!$user->messagers): ?>
			<tr class="comment-tr">
				<td colspan="6" style="line-height: 1.43!important">
					<span class="rejected">
						<?= Yii::t('Front', 'You have not added any instant messenger yet. You can add new instant messenger by clicking "Add new" button.') ?>
					</span>
				</td>
			</tr>
			<?php endif; ?>
			<tr>
				<td class="add-new-td" colspan="5">
					<a class="table-btn" onclick="$(this).parents('tr').hide()" href="javaScript:void($('.prof-form').toggle('slow'))"><?= Yii::t('Front', 'Add new'); ?></a>
				</td>
			</tr>

			<tr class="prof-form">
				<td colspan="5" class="table-form-subheader">
					<div class="table-subheader"><?= Yii::t('Front', 'Add instant messenger'); ?></div>
				</td>
			</tr>
			<tr class="prof-form messenger-form-tr">
				<td colspan="5">
				   <table class="messanger-table">
					   <tbody><tr>
						   <td colspan="2">
								<div class="transaction-buttons-cont">
									<input type="submit" class="button ok submit" value="" />
									<a class="button cancel" href="javaScript:void(0)"></a>
								</div>
								<div class="field-row left-coll">
								   <div class="field-lbl">

									   <?= Yii::t('Front', 'Instant Messenger'); ?>

									   <span class="tooltip-icon" title="<?= Yii::t('Front', 'Select one of instant messengers'); ?>"></span>
								   </div>
								   <div class="field-input ">
									   <div class="select-custom">
										   <span class="select-custom-label"><?= Yii::t('Front', 'Skype'); ?> </span>
										   <?= $form->dropDownList($model, 'messager_type', CHtml::listData(InstmessagerSystems::model()->findAll('status = 1'), 'id', 'name'), array('class' => 'country-select select-invisible')); ?>
										   <?= $form->error($model, 'messager_type'); ?>
									   </div>
								   </div>
							   </div>
							   <div class="field-row right-coll">
								   <div class="field-lbl ">

										<?= Yii::t('Front', 'Username'); ?>

									   <span class="tooltip-icon" title="tooltip text"></span>
								   </div>
								   <div class="field-input">
										<?= $form->textField($model, 'messager_login', array('class' => 'input-text')); ?>
										<?= $form->error($model, 'messager_login'); ?>
								   </div>
							   </div>
						   </td>
					   </tr>
				   </tbody>
				   </table>
				</td>
			</tr>
			</tbody>
		</table>
		<?php $this->endWidget(); ?>
		<div class="form-submit">
			<a href="<?= Yii::app()->createUrl('/personal/index') . '/' ?>" class="submit-button button-back"><?= Yii::t('Front', 'Back')?></a> 
		</div>
		<div class="clearfix"></div>
	</div>
</div>

<script>

$(document).ready(function(){

	$('.transaction-buttons-cont .delete').confirmation({
		title: '<?= Yii::t('Front', 'Are you sure?') ?>',
		singleton: true,
		popout: true,
		onConfirm: function(){
			deleteRow($(this).parents('.popover').prev('a'));
			return false;
		}
	})

})

</script>
