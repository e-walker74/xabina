<div class="col-lg-9 col-md-9 col-sm-9" >
  <div class="h1-header">
    <?= Yii::t('Front', 'My personal cabinet'); ?>
  </div>
  <div id="emails_edit">
    <div class="xabina-form-container">
		<table class="table  xabina-table-edit">
			<tbody><tr class="table-header">
				<th><?= Yii::t('Front', 'Personal details'); ?></th>
				<th class="edit-th">
					
				</th>
			</tr>
			<tr>
				<td colspan="2">
					<div class="xabina-alert">
						<?= Yii::t('Front', 'In order to change Your Personal Details, please upload the new copy of Your ID (passport, driving licence, etc.)'); ?>
					</div>
					<div class="form-validable xabina-form-container">
						<?php $form=$this->beginWidget('CActiveForm', array(
							'id'=>'editname-from-1',
							//'action' => Yii::app()->createUrl('/banking/savefiles').'/',
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
										<div class="field-row file-upload-row">
										<div class="field-lbl">
											<?= Yii::t('Front', 'File Upload') ?>
											<span class="tooltip-icon" title="<?= Yii::t('Front', 'You can upload up to 3 files in the following formats: PDF, JPG, PNG, GIF') ?>"></span>
										</div>
										<?php $template = '<div class="upload-list passport">';?>
										<?php foreach($files1 as $file): ?>
											<?php $template .= '<div class="file-row doc1 qq-upload-success">'.Yii::t('Front','Uploaded').': <span class="file-name qq-upload-file">'.$file->user_file_name.'.'.$file->ext.'</span>
														<span class="remove-file on-success"></span>
														<input type="hidden" name="Form_Editname_File[files][]" value="'.$file->name.'" />
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
													'action'=>Yii::app()->createUrl('/personal/uploadfile').'/?doc=1',
													'allowedExtensions'=>array("jpg","jpeg","gif","png","pdf"),
													'sizeLimit'=> 20 *1024 * 1024,
													'onSubmit' => 'js:function(){ 
														$("#"+this.element.id).parent().find("#Form_Editname_File_files_em_").slideUp()
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
														<input type="hidden" name="Form_Editname_File[files][]" value="" />
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
														$("#"+this.element.id).parent().find("#Form_Editname_File_files_em_").html(message).slideDown().delay(5000).slideUp()
													}',
													)
										)); 
										?>
										<div class="error-message" id="Form_Editname_File_files_em_" style="overflow: hidden;"></div>
										<div class="field-row">
											<div style="display:none;" class="violet-button-slim" onclick="js:uploadFile(this)"><?= Yii::t('Front', 'Upload selected files')?></div>
										</div>
										<input type="hidden" name="Form_Editname_File[document]" value="1" />
									</div>
								</td>
							</tr>
							</tbody>
						</table>
						<?php $this->endWidget(); ?>
					</div>
					<div class="form-validable xabina-form-container">
						<?php $form=$this->beginWidget('CActiveForm', array(
							'id'=>'editname-from-2',
							//'action' => Yii::app()->createUrl('/banking/savefiles').'/',
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
										<div class="field-row file-upload-row">
										<div class="field-lbl">
											<?= Yii::t('Front', 'File Upload') ?>
											<span class="tooltip-icon" title="<?= Yii::t('Front', 'You can upload up to 3 files in the following formats: PDF, JPG, PNG, GIF') ?>"></span>
										</div>
										<?php $template = '<div class="upload-list passport">';?>
										<?php foreach($files2 as $file): ?>
											<?php $template .= '<div class="file-row doc2 qq-upload-success">'.Yii::t('Front','Uploaded').': <span class="file-name qq-upload-file">'.$file->user_file_name.'.'.$file->ext.'</span>
														<span class="remove-file on-success"></span>
														<input type="hidden" name="Form_Editname_File[files][]" value="'.$file->name.'" />
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
												'action'=>Yii::app()->createUrl('/personal/uploadfile').'/?doc=2',
												'allowedExtensions'=>array("jpg","jpeg","gif","png","pdf"),
												'sizeLimit'=> 20 *1024 * 1024,
												'onSubmit' => 'js:function(){ 
													$("#"+this.element.id).parent().find("#Form_Editname_File_files_em_").slideUp()
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
													<input type="hidden" name="Form_Editname_File[files][]" value="" />
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
													$("#"+this.element.id).parent().find("#Form_Editname_File_files_em_").html(message).slideDown().delay(5000).slideUp()
												}',
												)
										)); 
										?>
										<div class="error-message" id="Form_Editname_File_files_em_" style="overflow: hidden;"></div>
										<div class="field-row">
											<div style="display:none;" class="violet-button-slim" onclick="js:uploadFile(this)"><?= Yii::t('Front', 'Upload selected files')?></div>
										</div>
										<input type="hidden" name="Form_Editname_File[document]" value="2" />
									</div>
								</td>
							</tr>
							</tbody>
						</table>
						<?php $this->endWidget(); ?>
					</div>
					<div class="xabina-alert-success" style="display:none;"><?= Yii::t('Front', 'Data received and will soon be reviewed by our staff'); ?></div>
				</td>
			</tr>

		</tbody></table>
		<div class="form-submit">
			<a href="<?= Yii::app()->createUrl('/banking/personal') . '/' ?>"><div class="submit-button button-back"><?= Yii::t('Front', 'Back')?></div></a> 
			<div class="submit-button button-next" onclick="js:saveEditName('<?= Yii::app()->createUrl('/personal/editname'); ?>', this)"><?= Yii::t('Front', 'Save'); ?></div>
		</div>
		</div>
    <div class="clearfix"></div>
  </div>
</div>
