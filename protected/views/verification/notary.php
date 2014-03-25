<div class="col-lg-9 col-md-9 col-sm-9" id="steps">
	<div class="h1-header"><?= Yii::t('Front', 'Verification'); ?></div>
	<div class="xabina-progress-bar verification-page">
		<div class="step step1  previous">
			<div class="step-name"><?= Yii::t('Front', 'Verification Method') ?></div>
			<div class="step-arr"></div>
		</div>
		<div class="step step2 current">
			<div class="step-name"><?= Yii::t('Front', 'Verification Steps') ?></div>
			<div class="step-arr"></div>
		</div>
		<div class="step step3 ">
			<div class="step-name"><?= Yii::t('Front', 'Verification') ?></div>
			<div class="step-arr"></div>
		</div>
	</div>

	<ul class="list-unstyled list-with-icos">
		<li><?= Yii::t('Front', 'We are required to verify your identity before you can send or receive over EUR 2500/00 or equivalent.') ?></li>
		<li><?= Yii::t('Front', 'Verifying your identity increases transactin limits and gives you access to the full wallet functionality.') ?></li>
		<li><?= Yii::t('Front', 'Verification is quick, easy and free.') ?></li>
	</ul>

	<div class="subheader"><?= Yii::t('Front', 'Verification steps') ?></div>

	<div class="verification-step">
		<div class="step-header"><?= Yii::t('Front', 'Step1') ?></div>

		<table class="xabina-validation-form">
			<tbody><tr class="header-tr">
				<td><?= Yii::t('Front', 'Validation form') ?></td>
			</tr>
			<tr class="comment-tr">
				<td><?= Yii::t('Front', 'Download the form, visit the notary, fill out the form and reassure her by a notary. Next, download the form at the site in step number 2.') ?></td>
			</tr>
			<tr class="submit-tr">
				<td>
					<div class="validation-form-download">
						<a onclick="$('.ste2-notary').slideDown()" href="<?= Yii::app()->createUrl('/banking/verification/getnotaryfile') ?>" class="violet-button" ><?= Yii::t('Front', 'download valide form') ?></a>
					</div>
				</td>
			</tr>
		</tbody></table>
	</div>
	<div class="ste2-notary" <?php if(!$verification): ?>style="display:none;"<?php endif; ?>>
		<div class="xabina-alert-success">
			<?= Yii::t('Front', 'You have successfully passed the first stage. Fill the form and notarized and go to step 2.') ?>
		</div>

		<div class="verification-step">
			<div class="step-header"><?= Yii::t('Front', 'Step 2') ?></div>
			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'verification-notary',
				'action' => Yii::app()->createUrl('/verification/notary').'/',
				'enableAjaxValidation'=>false,
				'enableClientValidation'=>true,
				'errorMessageCssClass' => 'error-message',
				'htmlOptions' => array(
					'class' => 'xabina-form-container',
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
				)
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
										<span class="select-custom-label"><?= Yii::t('Front', 'Notary form'); ?> </span>
										<?= $form->dropDownList($model, 'file_type', array('notary_form' => Yii::t('Front', 'Notary form')), array('class' => 'country-select select-invisible')); ?>
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
										<label class="file-label upload-button">
											<span class="file-button">Select</span>
											File is not selected
											<input class="file-input" type="file">
										</label>'; ?>
							<?php $this->widget('application.ext.EAjaxUpload.EAjaxUpload',
							array(
									'id'=>'uploadFile',
									'config'=>array(
										'action'=>Yii::app()->createUrl('/verification/uploadfile').'/',
										'allowedExtensions'=>array("jpg","jpeg","gif","png","pdf"),
										'sizeLimit'=> 20 *1024 * 1024,
										'onSubmit' => 'js:function(){ 
											$("#"+this.element.id).parent().find("#Form_Activation_File_files_em_").slideUp()
										}',
										'onComplete'=>"js:function(id, fileName, responseJSON){ 
											if(responseJSON.success){
												$('.uploaded'+id).find('input').val(responseJSON.filename)
											}
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
											$("#"+this.element.id).parent().find("#Form_Activation_File_files_em_").html(message).slideDown().delay(5000).slideUp()
										}',
										)
							)); 
							?>
							<div class="error-message" id="Form_Activation_File_files_em_" style="overflow: hidden;"></div>
							<input type="hidden" name="Form_Activation_File[document]" value="2" />
						</div>
					</td>
				</tr>
				</tbody>
			</table>
			<div class="form-submit">
				<a class="submit-button button-back" href="<?= $this->createUrl('/verification/index') ?>"><?= Yii::t('Front', 'Back'); ?></a>
				<div class="submit-button button-next" onclick="js:next(this)"><?= Yii::t('Front', 'Next'); ?></div>
			</div>
			<?php $this->endWidget(); ?>
		</div>
	</div>
</div>
<?php Yii::app()->clientScript->registerScriptFile('/js/verification.js'); ?>