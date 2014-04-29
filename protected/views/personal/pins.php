<div class="col-lg-9 col-md-9 col-sm-9">
            <div class="h1-header"><?= Yii::t('Front', 'My personal cabinet'); ?></div>
            <div id="addresses_view" class="xabina-form-container">
                <div class="subheader"><?= Yii::t('Front', 'PIN 1') ?></div>
                <table class="table xabina-table-personal">
                    <tbody>
                    <tr class="table-header">
                        <th style="width: 34%"><?= Yii::t('Front', 'Current password') ?></th>
                        <th style="width: 60%"><?= Yii::t('Front', 'Expiry date') ?></th>
                        <th style="width: 6% ">&nbsp;</th>
                    </tr>
                    <tr class="comment-tr">
                        <td colspan="3"><?= Yii::t('Front', 'Description for PIN 1') ?></td>
                    </tr>
					<?php if($model->pin1): ?>
                    <tr>
                        <td>
                            <span class="masked-value">**********</span>
                        </td>
                        <td>
							<?php if($model->pin1_exp < time()): ?>
							<span class="rejected"><?= date('d.m.Y', $model->pin1_exp) ?></span>
							<?php else: ?>
							<span class="expires-end"><?= date('d.m.Y', $model->pin1_exp) ?></span>
							<?php endif; ?>
                        </td>
                        <td class="actions-td">
                            <div class="transaction-buttons-cont">
								<?php if($model->pin1 && $model->pin1_exp > time()): ?>
									<a href="#" onclick="$(this).parents('tr').next('tr').show(); $(this).hide(); return false;" class="button edit"></a>
								<?php endif; ?>
                            </div>
                        </td>
                    </tr>
					<?php endif; ?>
					<?php if($model->pin1 && $model->pin1_exp > time()): ?>
					<tr style="display:none;">
					<?php else: ?>
                    <tr>
					<?php endif; ?>
                        <td colspan="3">
							<?php $model->scenario = 'pin1'; ?>
							<?php $form = $this->beginWidget('CActiveForm', array(
								'id' => 'user_pins',
								'enableAjaxValidation' => true,
								'enableClientValidation' => true,
								'errorMessageCssClass' => 'error-message',
								'htmlOptions' => array(
									'class' => 'form-validable',
								),
								'clientOptions' => array(
									'validateOnSubmit' => true,
									'validateOnChange' => true,
									'errorCssClass' => 'input-error',
									'successCssClass' => 'valid'
								),
							)); ?>
                            <div class="password-form">
                                <div class="row">
                                    <div class="col-lg-5 col-md-5 col-sm-5">
                                        <div class="field-lbl">
                                            <?= Yii::t('Front', 'Old password') ?>
                                            <span class="tooltip-icon" title="<?= Yii::t('Front', '[description for old pass]') ?>"></span>
                                        </div>
                                        <div class="field-input">
                                            <div class="relative">
												<?php if(!$model->pin1): ?>
													<?= $form->passwordField($model, 'old_pass', array('class' => 'input-text', 'disabled' => 'disabled')) ?>
												<?php else: ?>
													<?= $form->passwordField($model, 'old_pass', array('class' => 'input-text')) ?>
													<?= $form->error($model, 'old_pass'); ?>
												<?php endif; ?>
                                                <span class="icon"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-5">
                                        <div class="field-lbl">
                                            <?= Yii::t('Front', 'Password lifetime'); ?>
                                            <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                                        </div>
                                        <div class="field-input">
                                            <div class="select-custom">
                                                <span class="select-custom-label">
                                                  <?= Yii::t('Front', 'Choose'); ?>
                                                </span>
												<?= 
													$form->dropDownList($model, 'pin1_exp', array('' => 'Choose', time()+3600*24*30 => 'month', time()+3600*24*30*6 => '6 month', time()+3600*24*30*12 => 'year'), array(
													'class' => 'country-select select-invisible',
												)); ?>
                                            </div>
											<?= $form->error($model, 'pin1_exp'); ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                        <div class="transaction-buttons-cont">
                                            <input type="submit" value="" class="button ok" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-5 col-sm-5">
                                        <div class="field-lbl">
                                            <?= Yii::t('Front', 'New password') ?>
                                            <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                                        </div>
                                        <div class="field-input">
                                            <div class="relative">
												<?= $model->pin1 = ''; ?>
												<?= $form->passwordField($model, 'pin1', array('class' => 'input-text')) ?>
                                                <span class="icon"></span>
												<?= $form->error($model, 'pin1'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-5">
                                        <div class="field-lbl">
                                            <?= Yii::t('Front', 'Confirm new password') ?>
                                            <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                                        </div>
                                        <div class="field-input">
                                            <div class="relative">
												<?= $form->passwordField($model, 'confirm_pass', array('class' => 'input-text')) ?>
                                                <span class="icon"></span>
												<?= $form->error($model, 'confirm_pass'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<?php $this->endWidget(); ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="subheader"><?= Yii::t('Front', 'PIN 2') ?></div>
                <table class="table xabina-table-personal">
                    <tbody>
                    <tr class="table-header">
                        <th style="width: 34%"><?= Yii::t('Front', 'Current password') ?></th>
                        <th style="width: 60%"><?= Yii::t('Front', 'Expiry date') ?></th>
                        <th style="width: 6% ">&nbsp;</th>
                    </tr>
                    <tr class="comment-tr">
                        <td colspan="3"><?= Yii::t('Front', 'Description for PIN 2') ?></td>
                    </tr>
					<?php if($model->pin2): ?>
                    <tr>
                        <td>
                            <span class="masked-value">**********</span>
                        </td>
                        <td>
							<?php if($model->pin2_exp < time()): ?>
							<span class="rejected"><?= date('d.m.Y', $model->pin2_exp) ?></span>
							<?php else: ?>
							<span class="expires-end"><?= date('d.m.Y', $model->pin2_exp) ?></span>
							<?php endif; ?>
                            
                        </td>
                        <td class="actions-td">
                            <div class="transaction-buttons-cont">
								<?php if($model->pin2 && $model->pin2_exp > time()): ?>
									<a href="#" onclick="$(this).parents('tr').next('tr').show(); $(this).hide(); return false;" class="button edit"></a>
								<?php endif; ?>
                            </div>
                        </td>
                    </tr>
						<?php if($model->pin2_exp < time()): ?>
						<tr class="comment-tr">
							<td colspan="3"><span class="error-msg">
							<?= Yii::t('Front', 'Your password has been expired. Please, change Your password below') ?>
							</span></td>
						</tr>
						<?php endif; ?>
					<?php endif; ?>
					<?php if($model->pin2 && $model->pin2_exp > time()): ?>
					<tr style="display:none;">
					<?php else: ?>
                    <tr>
					<?php endif; ?>
                        <td colspan="3">
							<?php $model->scenario = 'pin2'; ?>
							<?php $form = $this->beginWidget('CActiveForm', array(
								'id' => 'user_pins_2',
								'enableAjaxValidation' => true,
								'enableClientValidation' => true,
								'errorMessageCssClass' => 'error-message',
								'htmlOptions' => array(
									'class' => 'form-validable',
								),
								'clientOptions' => array(
									'validateOnSubmit' => true,
									'validateOnChange' => true,
									'errorCssClass' => 'input-error',
									'successCssClass' => 'valid'
								),
							)); ?>
                            <div class="password-form">
                                <div class="row">
                                    <div class="col-lg-5 col-md-5 col-sm-5">
                                        <div class="field-lbl">
                                            <?= Yii::t('Front', 'Old password') ?>
                                            <span class="tooltip-icon" title="<?= Yii::t('Front', '[description for old pass]') ?>"></span>
                                        </div>
                                        <div class="field-input">
                                            <div class="relative">
												<?php if(!$model->pin2): ?>
													<?= $form->passwordField($model, 'old_pass', array('class' => 'input-text', 'disabled' => 'disabled')) ?>
												<?php else: ?>
													<?= $form->passwordField($model, 'old_pass', array('class' => 'input-text')) ?>
													<?= $form->error($model, 'old_pass'); ?>
												<?php endif; ?>
                                                <span class="icon"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-5">
                                        <div class="field-lbl">
                                            <?= Yii::t('Front', 'Password lifetime'); ?>
                                            <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                                        </div>
                                        <div class="field-input">
                                            <div class="select-custom">
                                                <span class="select-custom-label">
                                                  <?= Yii::t('Front', 'Choose'); ?>
                                                </span>
												<?= 
													$form->dropDownList($model, 'pin2_exp', array('' => 'Choose', time()+3600*24*30 => 'month', time()+3600*24*30*6 => '6 month', time()+3600*24*30*12 => 'year'), array(
													'class' => 'country-select select-invisible',
												)); ?>
												
                                            </div>
											<?= $form->error($model, 'pin2_exp'); ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                        <div class="transaction-buttons-cont">
                                            <input type="submit" value="" class="button ok" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-5 col-sm-5">
                                        <div class="field-lbl">
                                            <?= Yii::t('Front', 'New password') ?>
                                            <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                                        </div>
                                        <div class="field-input">
                                            <div class="relative">
												<?= $model->pin2 = ''; ?>
												<?= $form->passwordField($model, 'pin2', array('class' => 'input-text')) ?>
                                                <span class="icon"></span>
												<?= $form->error($model, 'pin2'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-5">
                                        <div class="field-lbl">
                                            <?= Yii::t('Front', 'Confirm new password') ?>
                                            <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                                        </div>
                                        <div class="field-input">
                                            <div class="relative">
												<?= $form->passwordField($model, 'confirm_pass', array('class' => 'input-text')) ?>
                                                <span class="icon"></span>
												<?= $form->error($model, 'confirm_pass'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<?php $this->endWidget(); ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="subheader"><?= Yii::t('Front', 'PIN 3') ?></div>
                <table class="table xabina-table-personal">
                    <tbody>
                    <tr class="table-header">
                        <th style="width: 34%"><?= Yii::t('Front', 'Current password') ?></th>
                        <th style="width: 60%"><?= Yii::t('Front', 'Expiry date') ?></th>
                        <th style="width: 6% ">&nbsp;</th>
                    </tr>
                    <tr class="comment-tr">
                        <td colspan="3"><?= Yii::t('Front', 'Description for PIN 3') ?></td>
                    </tr>
					<?php if($model->pin3): ?>
                    <tr>
                        <td>
                            <span class="masked-value">**********</span>
                        </td>
                        <td>
							<?php if($model->pin2_exp < time()): ?>
							<span class="rejected"><?= date('d.m.Y', $model->pin3_exp) ?></span>
							<?php else: ?>
							<span class="expires-end"><?= date('d.m.Y', $model->pin3_exp) ?></span>
							<?php endif; ?>
                        </td>
                        <td class="actions-td">
                            <div class="transaction-buttons-cont">
								<?php if($model->pin3 && $model->pin3_exp > time()): ?>
									<a href="#" onclick="$(this).parents('table').find('tr').show(); $(this).hide(); return false;" class="button edit"></a>
								<?php endif; ?>
                            </div>
                        </td>
                    </tr>
						<?php if($model->pin3_exp < time()): ?>
						<tr class="comment-tr">
							<td colspan="3"><span class="error-msg">
							<?= Yii::t('Front', 'Your password has been expired. Please, change Your password below') ?>
							</span></td>
						</tr>
						<?php endif; ?>
					<?php endif; ?>
					<?php if($model->pin3 && $model->pin3_exp > time()): ?>
					<tr style="display:none;">
					<?php else: ?>
                    <tr>
					<?php endif; ?>
                        <td colspan="3">
							<?php $model->scenario = 'pin3'; ?>
							<?php $form = $this->beginWidget('CActiveForm', array(
								'id' => 'user_pins_3',
								'enableAjaxValidation' => true,
								'enableClientValidation' => true,
								'errorMessageCssClass' => 'error-message',
								'htmlOptions' => array(
									'class' => 'form-validable',
								),
								'clientOptions' => array(
									'validateOnSubmit' => true,
									'validateOnChange' => true,
									'errorCssClass' => 'input-error',
									'successCssClass' => 'valid'
								),
							)); ?>
                            <div class="password-form">
                                <div class="row">
                                    <div class="col-lg-5 col-md-5 col-sm-5">
                                        <div class="field-lbl">
                                            <?= Yii::t('Front', 'Old password') ?>
                                            <span class="tooltip-icon" title="<?= Yii::t('Front', '[description for old pass]') ?>"></span>
                                        </div>
                                        <div class="field-input">
                                            <div class="relative">
												<?php if(!$model->pin3): ?>
													<?= $form->passwordField($model, 'old_pass', array('class' => 'input-text', 'disabled' => 'disabled')) ?>
												<?php else: ?>
													<?= $form->passwordField($model, 'old_pass', array('class' => 'input-text')) ?>
													<?= $form->error($model, 'old_pass'); ?>
												<?php endif; ?>
                                                <span class="icon"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-5">
                                        <div class="field-lbl">
                                            <?= Yii::t('Front', 'Password lifetime'); ?>
                                            <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                                        </div>
                                        <div class="field-input">
                                            <div class="select-custom">
                                                <span class="select-custom-label">
                                                  <?= Yii::t('Front', 'Choose'); ?>
                                                </span>
												<?= 
													$form->dropDownList($model, 'pin3_exp', array('' => 'Choose', time()+3600*24*30 => 'month', time()+3600*24*30*6 => '6 month', time()+3600*24*30*12 => 'year'), array(
													'class' => 'country-select select-invisible',
												)); ?>
                                            </div>
											<?= $form->error($model, 'pin3_exp'); ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                        <div class="transaction-buttons-cont">
                                            <input type="submit" value="" class="button ok" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5 col-md-5 col-sm-5">
                                        <div class="field-lbl">
                                            <?= Yii::t('Front', 'New password') ?>
                                            <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                                        </div>
                                        <div class="field-input">
                                            <div class="relative">
												<?= $model->pin3 = ''; ?>
												<?= $form->passwordField($model, 'pin3', array('class' => 'input-text')) ?>
                                                <span class="icon"></span>
												<?= $form->error($model, 'pin3'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-5">
                                        <div class="field-lbl">
                                            <?= Yii::t('Front', 'Confirm new password') ?>
                                            <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                                        </div>
                                        <div class="field-input">
                                            <div class="relative">
												<?= $form->passwordField($model, 'confirm_pass', array('class' => 'input-text')) ?>
                                                <span class="icon"></span>
												<?= $form->error($model, 'confirm_pass'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<?php $this->endWidget(); ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-submit">
                    <a href="<?= Yii::app()->createUrl('/banking/personal') . '/' ?>" class="submit-button button-back"><?= Yii::t('Front', 'Back')?></a> 
                </div>
                <div class="clearfix"></div>
            </div>
        </div>