<div class="col-lg-9 col-md-9 col-sm-9" >
	<div class="h1-header"><?= Yii::t('Front', 'Edit contact'); ?></div>
	<div class="edit-contact-cont ">
		<div class="edit-tabs ">
			<ul class="list-unstyled">
				<li style="width:20%;"><a href="#tab1"><?= Yii::t('Front', 'Personal Info'); ?></a></li>
				<li style="width:20%;"><a href="#tab2"><?= Yii::t('Front', 'Accounts'); ?></a></li>
				<li style="width:20%;"><a href="#tab3"><?= Yii::t('Front', 'E-Mail'); ?></a></li>
				<li style="width:20%;"><a href="#tab4"><?= Yii::t('Front', 'Phone'); ?></a></li>
				<li style="width:19%;border-right: 1px solid #9a9aa1;"><a href="#tab5"><?= Yii::t('Front', 'Address'); ?></a></li>
				<li style="clear: both; width:0;" class="clearfix"></li>
				<li style="width:16%;"><a href="#tab6"><?= Yii::t('Front', 'Default'); ?></a></li>
				<li style="width:18%;"><a href="#tab7"><?= Yii::t('Front', 'Social Networks'); ?></a></li>
				<li style="width:16%;"><a href="#tab8"><?= Yii::t('Front', 'Linking'); ?></a></li>
				<li style="width:19%;"><a href="#tab9"><?= Yii::t('Front', 'Instant Messaging'); ?></a></li>
				<li style="width:15%;"><a href="#tab10"><?= Yii::t('Front', 'URLs'); ?></a></li>
				<li style="width:15%;"><a href="#tab11"><?= Yii::t('Front', 'Date'); ?></a></li>
			</ul>
			<div id="tab1">
				<div class=" xabina-form-narrow">
				<table class="table xabina-table-contacts">
					<tr class="table-header">
						<th style="width: 20%"><?= Yii::t('Front', 'Photo'); ?></th>
						<th style="width: 49%"><?= Yii::t('Front', 'Contact Name'); ?></th>
						<th style="width: 31%"><?= Yii::t('Front', 'Xabina User ID'); ?></th>
						<th style="width: 0"></th>
					</tr>
					<tr class="data-row">
						<td>
							<?php if($model->photo): ?>
								<img width="40" src="<?= $model->getAvatarUrl() ?>" alt=""/>
							<?php else: ?>
								<img width="40" src="/images/contact_no_foto.png" alt="">
							<?php endif; ?>
						</td>
						<td><?= $model->fullname ?></td>
						<td><?= $model->xabina_id ?></td>
						<td>
							<div class="transaction-buttons-cont">
								<a href="#" class="button edit"></a>
							</div>
						</td>
					</tr>
					<tr class="edit-row">
						<td colspan="4">
							<?php $form=$this->beginWidget('CActiveForm', array(
								'id'=>'contact-form',
								'enableAjaxValidation'=>true,
								'enableClientValidation'=>true,
								'errorMessageCssClass' => 'error-message',
								'htmlOptions' => array(
									'class' => 'form-validable',
									'enctype' => 'multipart/form-data',
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
										for(var i in data.notify) {
											$(form).find("."+i).html(data.notify[i]).slideDown().delay(3000).slideUp();
										}
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
									'afterValidateAttribute' => 'js:afterValidateAttribute'
								),
							)); ?>
							<div class=" xabina-form-narrow">
								<div class="row">
									<div class="col-lg-5 col-md-5 col-sm-5">
										<div class="form-cell">
											<div class="form-lbl">
												<?= Yii::t('Front', 'First Name') ?>
												<span class="tooltip-icon" title="<?= Yii::t('Front', 'first_name_contact') ?>"></span>
											</div>
											<div class="form-input">
												<?= $form->textField($model, 'first_name', array('class' => 'input-text')) ?>
												<?= $form->error($model, 'first_name') ?>
											</div>
										</div>
									</div>
									<div class="col-lg-5 col-md-5 col-sm-5">
										<div class="form-cell">
											<div class="form-lbl">
												<?= Yii::t('Front', 'Last Name') ?>
												<span class="tooltip-icon" title="<?= Yii::t('Front', 'last_name_contact') ?>"></span>
											</div>
											<div class="form-input">
												<?= $form->textField($model, 'last_name', array('class' => 'input-text')) ?>
												<?= $form->error($model, 'last_name') ?>
											</div>
										</div>
									</div>
									<div class="col-lg-2 col-md-2 col-sm-2 ">
										<div class="transaction-buttons-cont edit-submit-cont">
											<input type="submit" class="button ok" value="" />
											<a href="javaScript:void(0)" class="button cancel"></a>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-5 col-md-5 col-sm-5">
										<div class="form-cell">
											<div class="form-lbl">
												<?= Yii::t('Front', 'Company') ?>
												<span class="tooltip-icon" title="<?= Yii::t('Front', 'company_name_contact') ?>"></span>
											</div>
											<div class="form-input">
												<?= $form->textField($model, 'company', array('class' => 'input-text')) ?>
												<?= $form->error($model, 'company') ?>
											</div>
										</div>
									</div>
									<div class="col-lg-5 col-md-5 col-sm-5">
										<div class="form-cell">
											<div class="form-lbl">
												<?= Yii::t('Front', 'Nickname') ?>
												<span class="tooltip-icon" title="<?= Yii::t('Front', 'nickname_name_contact') ?>"></span>
											</div>
											<div class="form-input">
												<?= $form->textField($model, 'nickname', array('class' => 'input-text')) ?>
												<?= $form->error($model, 'nickname') ?>
											</div>
										</div>
									</div>
									<div class="col-lg-2 col-md-2 col-sm-2 ">

									</div>
								</div>
								<div class="row">
									<div class="col-lg-5 col-md-5 col-sm-5">
										<div class="form-cell">
											<div class="form-lbl">
												<?= Yii::t('Front', 'Xabina User ID') ?>
												<span class="tooltip-icon" title="<?= Yii::t('Front', 'xabina_id_name_contact') ?>"></span>
											</div>
											<div class="form-input">
												<?= $form->textField($model, 'xabina_id', array('class' => 'input-text')) ?>
												<?= $form->error($model, 'xabina_id') ?>
											</div>
										</div>
									</div>
									<div class="col-lg-5 col-md-5 col-sm-5">
										<div class="form-cell">
											<div class="form-lbl">
												<?= Yii::t('Front', 'User Photo') ?>
												<span class="tooltip-icon" title="<?= Yii::t('Front', 'user_photo_name_contact') ?>"></span>
											</div>
											<div class="form-input">
												<label class="file-label <?= ($model->photo) ? 'uploaded' : '' ?>">
													<?php if($model->photo): ?>
														<img width="22" src="<?= $model->getAvatarUrl() ?>" alt=""/>
													<?php endif; ?>
													<span class="file-button"><?= Yii::t('Front', 'Select') ?></span>
													<?= Yii::t('Front', 'Upload user photo') ?>
													<?= $form->fileField($model, 'photo', array('class' => 'file-input')) ?>
													<?php if($model->photo): ?>
														<img src="/images/uploded_remove.png" style="float: right; cursor:pointer" alt=""/>
													<?php endif; ?>
												</label>
											</div>
										</div>
									</div>
									<div class="col-lg-2 col-md-2 col-sm-2 ">

									</div>
								</div>
							</div>
							<?php $this->endWidget(); ?>
						</td>
					</tr>
				</table>
				</div>
			</div>
			<div id="tab2" class="account tab">
				<?php $this->renderPartial('update/_account', array('model' => $model)); ?>
			</div>
			<div id="tab3" class="email tab">
				<?php $this->renderPartial('update/_email', array('model' => $model)); ?>
			</div>
			<div id="tab4" class="phone tab">
				<?php $this->renderPartial('update/_phone', array('model' => $model)); ?>
			</div>
			<div id="tab5" class="address tab">
				<?php $this->renderPartial('update/_address', array('model' => $model)); ?>
			</div>
			<div id="tab6" class="default tab">
				<?php $this->renderPartial('update/_default', array('model' => $model)); ?>
			</div>
			<div id="tab7" class="social tab">
				<?php $this->renderPartial('update/_social', array('model' => $model)); ?>
			</div>
			<div id="tab8" class="linking tab">
				<?php $this->renderPartial('update/_contact', array('model' => $model)); ?>
			</div>
			<div id="tab9" class="instmessaging tab">
				<?php $this->renderPartial('update/_instmessaging', array('model' => $model)); ?>
			</div>
			<div id="tab10" class="urls tab">
				<?php $this->renderPartial('update/_urls', array('model' => $model)); ?>
			</div>
			<div id="tab11" class="dates tab">
				<?php $this->renderPartial('update/_dates', array('model' => $model)); ?>
			</div>
		</div>
		<div class="form-narrow-submit clearfix">
			<a href="<?= Yii::app()->createUrl('/contact/index') ?>" class="xabina-submit left back">Back</a>
		</div>
	</div>
</div>
