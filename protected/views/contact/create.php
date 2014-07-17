<div class="col-lg-9 col-md-9 col-sm-9" >
	<div class="h1-header"><?= Yii::t('Front', 'Add new contact'); ?></div>
	<div class="edit-contact-cont ">
		<div class="edit-tabs ">
			<div class=" xabina-form-narrow">
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
				<div class="contact-edit-form">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Front', 'Type') ?>
                                    <span class="tooltip-icon"
                                          title="<?= Yii::t('Front', 'type_of_contact_tooltip') ?>"></span>
                                </div>
                                <div class="form-input category-select">
                                    <div class="select-custom select-narrow ">
                                        <span class="select-custom-label"></span>
                                        <?= $form->dropDownList(
                                            $model,
                                            'type',
                                            array(
                                                'personal' => Yii::t('Front', 'Personal'),
                                                'company' => Yii::t('Front', 'Company')
                                            ),
                                            array(
                                                'class' => 'select-invisible',
                                                'onchange' => 'js:changeContactType(this)',
                                                'empty' => Yii::t('Front', 'Select'),
                                            )
                                        ) ?>
                                        <?= $form->error($model, 'type') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row type-personal hidden">
						<div class="col-lg-6 col-md-6 col-sm-6">
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
						<div class="col-lg-6 col-md-6 col-sm-6">
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
					</div>
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-cell type-personal hidden">
                                <div class="form-lbl">
                                    <?= Yii::t('Front', 'Xabina User ID') ?>
                                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'xabina_id_name_contact') ?>"></span>
                                </div>
                                <div class="form-input">
                                    <?= $form->textField($model, 'xabina_id', array('class' => 'input-text')) ?>
                                    <?= $form->error($model, 'xabina_id') ?>
                                </div>
                            </div>
                            <div class="form-cell type-company hidden type">
                                <div class="form-lbl">
                                    <?= Yii::t('Front', 'Company Name') ?>
                                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'company_name_contact') ?>"></span>
                                </div>
                                <div class="form-input">
                                    <?= $form->textField($model, 'company', array('class' => 'input-text')) ?>
                                    <?= $form->error($model, 'company') ?>
                                </div>
                            </div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 type hidden">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Front', 'Hint') ?>
                                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'hint_name_contact') ?>"></span>
                                </div>
                                <div class="form-input">
                                    <?= $form->textField($model, 'hint', array('class' => 'input-text')) ?>
                                    <?= $form->error($model, 'hint') ?>
                                </div>
                            </div>
						</div>
					</div>
					<div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 type hidden">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Front', 'Contact Photo') ?>
                                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'user_photo_name_contact') ?>"></span>
                                </div>
                                <div class="form-input">
                                    <label class="file-label">
										<span id="image-mini" style="display:none">
											<img width="22" src="" alt=""/>
										</span>
                                        <span class="file-button"><?= Yii::t('Front', 'Select') ?></span>
                                        <span class="filename"><?= Yii::t('Front', 'Upload contact photo') ?></span>
                                        <?= $form->fileField($model, 'photo', array('class' => 'file-input')) ?>
                                        <span class="delete-photo" style="display:none;">
											<img src="/images/uploded_remove.png" style="float: right; cursor:pointer" alt=""/>
                                            <?= $form->hiddenField($model, 'delete') ?>
										</span>
                                    </label>
                                </div>
                            </div>
                        </div>
						<div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-cell  type-personal hidden">
                                <div class="form-lbl">
                                    <?= Yii::t('Front', 'Sex') ?>
                                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'contact_sex') ?>"></span>
                                </div>
                                <div class="form-input category-select">
                                    <div class="select-custom select-narrow ">
                                        <span class="select-custom-label"></span>
                                        <?= $form->dropDownList(
                                            $model,
                                            'sex',
                                            array('male' => Yii::t('Front', 'Male'), 'female' => Yii::t('Front', 'Female')),
                                            array(
                                                'class' => 'select-invisible',
                                            )
                                        ) ?>
                                        <?= $form->error($model, 'sex') ?>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
				</div>
				<div class="form-narrow-submit">
					<a href="<?= Yii::app()->createUrl('/contact/index') ?>" class="xabina-submit left back"><?= Yii::t('Front', 'Back'); ?></a>
					<input class="xabina-submit left save" value="<?= Yii::t('Front', 'Save'); ?>" type="submit"/>
				</div>
				<?php $this->endWidget(); ?>
			</div>
		</div>
	</div>
</div>