
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
<div class="xabina-form-container">

	<div class="xabina-alert">
		<?= Yii::t('Front', 'Please upload a scanned version of your identity document. 
			This can be a passport, residence permit, driving license or any other 
			official document that identifies you personally. You can upload up to 3 
			files in the following formats: PDF, JPG, PNG, GIFF.'); ?>
	</div>
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'activation-from-two-1',
		'action' => Yii::app()->createUrl('/banking/savefiles').'/',
		'enableAjaxValidation'=>true,
		'enableClientValidation'=>false,
		'errorMessageCssClass' => 'error-message',
		'htmlOptions' => array(
			'class' => 'form-validable',
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
	<table class="xabina-table-upload">
		<tbody>
		<tr class="header-tr">
			<td colspan="2">
				<?= Yii::t('Front', 'Document 1'); ?>
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
								<?= $form->dropDownList($model, 'file_type', array('' => Yii::t('Front', 'Select'), 'passport' => Yii::t('Front', 'Passport'), 'residence permit' => Yii::t('Front', 'Residence permit'), 'driving license' => Yii::t('Front', 'Driving license'), 'other official document' => Yii::t('Front', 'Other official document')), array('class' => 'country-select select-invisible')); ?>
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
					<div class="field-row  file-upload-row">
					<div class="field-lbl">
						<?= Yii::t('Front', 'File Upload') ?>
						<span class="tooltip-icon" title="<?= Yii::t('Front', 'You can upload up to 3 files in the following formats: PDF, JPG, PNG, GIF') ?>"></span>
					</div>
					<?php $template = '<div class="upload-list passport">';?>
					<?php foreach($files1 as $file): ?>
						<?php $template .= '<div class="file-row doc1 qq-upload-success">'.Yii::t('Front','Uploaded').': <span class="file-name qq-upload-file">'.$file->user_file_name.'.'.$file->ext.'</span>
									<span class="remove-file on-success"></span>
									<input type="hidden" name="Form_Activation_File[files][]" value="'.$file->name.'" />
									</div>'; ?>
					<?php endforeach; ?>
					<?php $template .= '</div>
								<label class="file-label upload-button">
									<span class="file-button">Select</span>
									File is not selected
									<input class="file-input" type="file">
								</label>'; ?>
					<?php $this->widget('application.ext.EAjaxUpload.EAjaxUpload',
					array(
							'id'=>'uploadFile1',
							'config'=>array(
								'action'=>Yii::app()->createUrl('/banking/uploadactivationfile').'/?doc=1',
								'allowedExtensions'=>array("jpg","jpeg","gif","png","pdf"),
								'sizeLimit'=> 20 *1024 * 1024,
								'onSubmit' => 'js:function(){ 
									$("#"+this.element.id).parent().find("#Form_Activation_File_files_em_").slideUp()
								}',
								'onComplete'=>"js:function(id, fileName, responseJSON){ 
									if(responseJSON.success){
										$('.doc1.uploaded'+id).find('input').val(responseJSON.filename)
									}
								}",
								'template' => $template,
								'fileTemplate' => '<div class="file-row doc1">
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
									$("#"+this.element.id).parent().find("#Form_Activation_File_files_em_").html(message).slideDown().delay(5000).slideUp()
								}',
								)
					)); 
					?>
					<div class="error-message" id="Form_Activation_File_files_em_" style="overflow: hidden;"></div>
					<div class="field-row">
						<div class="violet-button-slim" style="display:none" onclick="js:uploadFile(this)"><?= Yii::t('Front', 'Upload selected files')?></div>
					</div>
					<input type="hidden" name="Form_Activation_File[document]" value="1" />
				</div>
			</td>
		</tr>
		</tbody>
	</table>
	<?php $this->endWidget(); ?>
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'activation-from-two-2',
		'action' => Yii::app()->createUrl('/banking/savefiles').'/',
		'enableAjaxValidation'=>true,
		'enableClientValidation'=>false,
		'errorMessageCssClass' => 'error-message',
		'htmlOptions' => array(
			'class' => 'form-validable',
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
	<table class="xabina-table-upload">
		<tbody>
		<tr class="header-tr">
			<td colspan="2">
				<?= Yii::t('Front', 'Document 2'); ?>
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
								<?= $form->dropDownList($model, 'file_type', array('' => Yii::t('Front', 'Select'), 'passport' => Yii::t('Front', 'Passport'), 'residence permit' => Yii::t('Front', 'Residence permit'), 'driving license' => Yii::t('Front', 'Driving license'), 'other official document' => Yii::t('Front', 'Other official document')), array('class' => 'country-select select-invisible')); ?>
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
					<?php foreach($files2 as $file): ?>
						<?php $template .= '<div class="file-row doc2 qq-upload-success">'.Yii::t('Front','Uploaded').': <span class="file-name qq-upload-file">'.$file->user_file_name.'.'.$file->ext.'</span>
									<span class="remove-file on-success"></span>
									<input type="hidden" name="Form_Activation_File[files][]" value="'.$file->name.'" />
									</div>'; ?>
					<?php endforeach; ?>
					<?php $template .= '</div>
								<label class="file-label upload-button">
									<span class="file-button">Select</span>
									File is not selected
									<input class="file-input" type="file">
								</label>'; ?>
					<?php $this->widget('application.ext.EAjaxUpload.EAjaxUpload',
					array(
							'id'=>'uploadFile2',
							'config'=>array(
								'action'=>Yii::app()->createUrl('/banking/uploadactivationfile').'/?doc=2',
								'allowedExtensions'=>array("jpg","jpeg","gif","png","pdf"),
								'sizeLimit'=> 20 *1024 * 1024,
								'onSubmit' => 'js:function(){ 
									$("#"+this.element.id).parent().find("#Form_Activation_File_files_em_").slideUp()
								}',
								'onComplete'=>"js:function(id, fileName, responseJSON){ 
									if(responseJSON.success){
										$('.doc2.uploaded'+id).find('input').val(responseJSON.filename)
									}
								}",
								'template' => $template,
								'fileTemplate' => '<div class="file-row doc2">
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
									$("#"+this.element.id).parent().find("#Form_Activation_File_files_em_").html(message).slideDown().delay(5000).slideUp()
								}',
								)
					)); 
					?>
					<div class="error-message" id="Form_Activation_File_files_em_" style="overflow: hidden;"></div>
					<div class="field-row">
						<div class="violet-button-slim" style="display:none" onclick="js:uploadFile(this)"><?= Yii::t('Front', 'Upload selected files')?></div>
					</div>
					<input type="hidden" name="Form_Activation_File[document]" value="2" />
				</div>
			</td>
		</tr>
		</tbody>
	</table>
	<?php $this->endWidget(); ?>
	<div class="form-submit">
		<div class="submit-button button-back" onclick="js:back('<?= Yii::app()->createUrl('/banking/accountsactivationback').'/' ?>')">Back</div>
		<div class="submit-button button-next" onclick="js:last('<?= Yii::app()->createUrl('/banking/accountsactivation').'/' ?>', this)">Далее</div>
	</div>
</div>
