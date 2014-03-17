
<div class="h1-header"><?= Yii::t('Front', 'Account activation'); ?></div>
<div class="xabina-progress-bar">
	<div class="step step1  previous">
		<div class="step-name"><?= Yii::t('Front', 'Personal information'); ?></div>
		<div class="step-arr"></div>
	</div>
	<div class="step step2 current">
		<div class="step-name"><?= Yii::t('Front', 'File upload'); ?></div>
		<div class="step-arr"></div>
	</div>
	<div class="step step3">
		<div class="step-name"><?= Yii::t('Front', 'Activation'); ?></div>
		<div class="step-arr"></div>
	</div>
</div>
<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'activation-from-two',
		'enableAjaxValidation'=>true,
		'enableClientValidation'=>false,
		'errorMessageCssClass' => 'error-message',
		'htmlOptions' => array(
			'class' => 'form-validable xabina-form-container',
			'enctype' => 'multipart/form-data'
			//'onsubmit'=>"return false;",/* Disable normal form submit */
			//'onkeypress'=>" if(event.keyCode == 13){ send(); } "
		),
		//'focus'=>array($model,'first_name'),
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
	<div class="xabina-alert">
		<?= Yii::t('Front', 'Please upload a scanned version of your identity document. 
			This can be a passport, residence permit, driving license or any other 
			official document that identifies you personally. You can upload up to 3 
			files in the following formats: PDF, JPG, PNG, GIFF.'); ?>
	</div>

	<table class="xabina-table-upload">
		<tbody>
		<tr class="header-tr">
			<td colspan="2">
				<?= Yii::t('Front', 'Passport'); ?>
			</td>
		</tr>
		<tr class="form-tr">
			<td style="width: 45%;">
				<div class="td-cont field-input">
					<div class="field-row">
						<div class="field-lbl">
							<?= $model->getAttributeLabel('file_type') ?> 
							<span class="tooltip-icon " title="<?= Yii::t('Front', 'File type'); ?>"></span>
						</div>
						<div class="field-input">
							<div class="select-custom">
								<span class="select-custom-label"><?= Yii::t('Front', 'Select'); ?> </span>
								<?= $form->dropDownList($model, 'file_type', array('' => Yii::t('Front', 'Select'), 1 => Yii::t('Front', 'PDF'), 2 => Yii::t('Front', 'JPG'), 3 => Yii::t('Front', 'PNG'), 4 => Yii::t('Front', 'GIF')), array('class' => 'country-select select-invisible')); ?>
								<span class="validation-icon"></span>
							</div>
							<?= $form->error($model, 'file_type', array()); ?>
						</div>
					</div>
					<div class="field-row">
						<div class="field-lbl">
							<?= $model->getAttributeLabel('description') ?> 
							<span class="tooltip-icon " title="<?= Yii::t('Front', 'Insert description'); ?>"></span>
						</div>
						<div class="field-input">
							<?= $form->textArea($model, 'description', array('autocomplete' => 'off', 'cols' => 30, 'row' => 10, 'class' => 'textarea file-comments-textarea')); ?>
						</div>
					</div>
				</div>
			</td>
			<td style="width: 65%;">
				<div class="td-cont ">
					<div class="field-row">
					<div class="field-lbl">
						<?= Yii::t('Front', 'File Upload') ?>
						<span class="tooltip-icon" title="<?= Yii::t('Front', 'You can upload up to 3 files in the following formats: PDF, JPG, PNG, GIF') ?>"></span>
					</div>
					<?php $template = '<div class="upload-list passport">';?>
					<?php foreach($files as $file): ?>
						<?php $template .= '<div class="file-row qq-upload-success">'.Yii::t('Front','Uploaded').': <span class="file-name qq-upload-file">'.$file->user_file_name.'.'.$file->ext.'</span>
									<span class="remove-file on-success"></span>
									<input type="hidden" name="Form_Activation_File[files][]" value="'.$file->name.'" />
									</div>'; ?>
					<?php endforeach; ?>
					<?php $template .= '</div>
								<div class="field-row">
									<div class="violet-button-slim">'.Yii::t('Front', 'Upload files').'</div>
								</div>'; ?>
					<?php $this->widget('application.ext.EAjaxUpload.EAjaxUpload',
					array(
							'id'=>'uploadPassportFile',
							'config'=>array(
								'action'=>Yii::app()->createUrl('/banking/uploadactivationfile').'/',
								'allowedExtensions'=>array("jpg","jpeg","gif","png","pdf"),
								'sizeLimit'=> 20 *1024 * 1024,
								'onSubmit' => 'js:function(){$("#Form_Activation_File_files_em_").slideUp()}',
								'onComplete'=>"js:function(id, fileName, responseJSON){ 
									$('.passport.upload-list')
										.find('.file-row:last')
										.find('input')
										.val(responseJSON.filename)
								}",
								'template' => $template,
								'fileTemplate' => '<div class="file-row">
									<span class="qq-upload-spinner"></span>
									'.Yii::t('Front','Uploaded').': <span class="file-name qq-upload-file"></span>
									<span class="qq-upload-size"></span>
									<span class="remove-file qq-upload-cancel"></span>
									<span class="remove-file on-success"></span>
									<span class="qq-upload-failed-text"></span>
									<input type="hidden" name="Form_Activation_File[files][]" value="" />
									</div>',
								'multiple' => true,
								'messages'=>array(
									'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
									'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
									'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
									'emptyError'=>"{file} is empty, please select files again without it.",
									'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled.",
									'countError' => "Limit upload files is {maxFiles}.",
									),
								'showMessage' => 'js:function(message){
									$("#Form_Activation_File_files_em_").html(message).slideDown().delay(5000).slideUp()
								}',
								)
					)); 
					?>
					<div class="error-message" id="Form_Activation_File_files_em_" style="overflow: hidden;"></div>
				</div>
			</td>
		</tr>
		</tbody>
	</table>
	<div class="form-submit">
		<div class="submit-button button-back" onclick="js:back('<?= Yii::app()->createUrl('/banking/accountsactivationback').'/' ?>')">Back</div>
		<div class="submit-button button-next" onclick="next('<?= Yii::app()->createUrl('/banking/accountsactivation').'/' ?>', this)">Далее</div>
	</div>
<?php $this->endWidget(); ?>