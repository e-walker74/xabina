<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 29.07.14
 * Time: 15:03
 */ ?>
<div class=" xabina-form-normal">
<table class="table  xabina-table-contacts">
<tr class="table-header">
    <th style="width: 40%"><?= Yii::t('Personal', 'Password') ?></th>
    <th style="width: 25%"><?= Yii::t('Personal', 'Current password') ?></th>
    <th style="width: 26%"><?= Yii::t('Personal', 'Expiry date') ?></th>
    <th style="width: 9%"></th>
</tr>
<?php if($model->pin1_exp < time()): ?>
    <tr class="note-arr-tr">
        <td colspan="4">
            <div class="note-arr">
                <div class="note-bg">
                    <?php if($model->pin1_exp): ?>
                        <span class="rejected"> <?= Yii::t('Front', 'Your password has been expired. Please, change Your password below') ?></span>
                    <?php else: ?>
                        <span> <?= Yii::t('Front', 'add_password') ?></span>
                    <?php endif; ?>
                </div>
                <div class="arr"></div>
            </div>
        </td>
    </tr>
<?php else: ?>
<tr class="note-arr-tr">
    <td colspan="4">
        <div class="note-arr">
            <div class="note-bg">
                <?= Yii::t('Personal', 'description_for_pass_1') ?>
            </div>
            <div class="arr"></div>
        </div>
    </td>
</tr>
<?php endif; ?>
<tr class="data-row">
    <td><?= Yii::t('Personal', 'Password 1') ?></td>
    <td>**********</td>
    <td>
        <?php if($model->pin1_exp): ?>
            <?php if($model->pin1_exp < time()): ?>
                <span class="rejected"><?= date('d.m.Y', $model->pin1_exp) ?></span>
            <?php else: ?>
                <span class="approved"><?= date('d.m.Y', $model->pin1_exp) ?></span>
            <?php endif; ?>
        <?php endif; ?>
    </td>
    <td>
        <div class="transaction-buttons-cont ">
            <a href="javaScript:void(0)" class="button edit"></a>
        </div>
    </td>
</tr>
<tr class="edit-row">
    <td colspan="4" style="border-top: none!important;">
        <div class="table-subheader">
            <?php if(!$model->pin1): ?>
                <?= Yii::t('Personal', 'Add Password 1') ?>
            <?php else: ?>
                <?= Yii::t('Personal', 'Edit Password 1') ?>
            <?php endif; ?>
        </div>
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
                'successCssClass' => 'valid',
                'afterValidate' => 'js:Personal.afterValidate',
                'afterValidateAttribute' => 'js:Personal.afterValidateAttribute',
            ),
        )); ?>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5">
                <div class="form-cell">
                    <div class="form-lbl">
                        <?= Yii::t('Front', 'Old password') ?>
                        <span class="tooltip-icon" title="<?= Yii::t('Front', 'password_pin1_tooltip') ?>"></span>
                    </div>
                    <div class="form-input">
                        <?= $form->passwordField($model, 'old_pass', array('class' => 'input-text', 'disabled' => (empty($model->pin1)))) ?>
                        <?= $form->error($model, 'old_pass'); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5">
                <div class="form-cell">
                    <div class="form-lbl">
                        <?= Yii::t('Front', 'Password lifetime'); ?>
                        <span class="tooltip-icon" title="<?= Yii::t('Front', 'password_lifetime_tooltip') ?>"></span>
                    </div>
                    <div class="form-input">
                        <div class="select-custom ">
                            <span class="select-custom-label"></span>
                            <?=
                            $form->dropDownList($model, 'pin1_exp', array(time()+3600*24*30 => 'month', time()+3600*24*30*6 => '6 month', time()+3600*24*30*12 => 'year'), array(
                                'class' => 'country-select select-invisible',
                                'empty' => Yii::t('Personal', 'Select'),
                            ));
                            ?>
                        </div>
                        <?= $form->error($model, 'pin1_exp'); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 ">
                <div class="transaction-buttons-cont edit-submit-cont">
                    <input type="submit" class="button ok" value=""/>
                    <a href="javaScript:void(0)" class="button cancel"></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5">
                <div class="form-cell">
                    <div class="form-lbl">
                        <?= Yii::t('Front', 'New password') ?>
                        <span class="tooltip-icon" title="<?= Yii::t('Front', 'password_newpassword_tooltip') ?>"></span>
                    </div>
                    <div class="form-input">
                        <?= $model->pin1 = ''; ?>
                        <?= $form->passwordField($model, 'pin1', array('class' => 'input-text')) ?>
                        <span class="icon"></span>
                        <?= $form->error($model, 'pin1'); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5">
                <div class="form-cell">
                    <div class="form-lbl">
                        <?= Yii::t('Front', 'Confirm new password') ?>
                        <span class="tooltip-icon" title="<?= Yii::t('Front', 'password_confirm_pass_tooltip') ?>"></span>
                    </div>
                    <div class="form-input">
                        <?= $form->passwordField($model, 'confirm_pass', array('class' => 'input-text')) ?>
                        <span class="icon"></span>
                        <?= $form->error($model, 'confirm_pass'); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 ">
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </td>
</tr>

<?php if($model->pin2_exp < time()): ?>
    <tr class="note-arr-tr">
        <td colspan="4">
            <div class="note-arr">
                <div class="note-bg">
                    <?php if($model->pin2_exp): ?>
                        <span class="rejected"> <?= Yii::t('Front', 'Your password has been expired. Please, change Your password below') ?></span>
                    <?php else: ?>
                        <span> <?= Yii::t('Front', 'add_password') ?></span>
                    <?php endif; ?>
                </div>
                <div class="arr"></div>
            </div>
        </td>
    </tr>
<?php else: ?>
    <tr class="note-arr-tr">
        <td colspan="4">
            <div class="note-arr">
                <div class="note-bg">
                    <?= Yii::t('Personal', 'description_for_pass_2') ?>
                </div>
                <div class="arr"></div>
            </div>
        </td>
    </tr>
<?php endif; ?>
<tr class="data-row">
    <td><?= Yii::t('Personal', 'Password 2') ?></td>
    <td>**********</td>
    <td>
        <?php if($model->pin2_exp): ?>
            <?php if($model->pin2_exp < time()): ?>
                <span class="rejected"><?= date('d.m.Y', $model->pin2_exp) ?></span>
            <?php else: ?>
                <span class="approved"><?= date('d.m.Y', $model->pin2_exp) ?></span>
            <?php endif; ?>
        <?php endif; ?>
    </td>
    <td>
        <div class="transaction-buttons-cont ">
            <a href="javaScript:void(0)" class="button edit"></a>
        </div>
    </td>
</tr>
<tr class="edit-row">
    <td colspan="4" style="border-top: none!important;">
        <div class="table-subheader">
            <?php if(!$model->pin2): ?>
                <?= Yii::t('Personal', 'Add Password 2') ?>
            <?php else: ?>
                <?= Yii::t('Personal', 'Edit Password 2') ?>
            <?php endif; ?>
        </div>
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
                'successCssClass' => 'valid',
                'afterValidate' => 'js:Personal.afterValidate',
                'afterValidateAttribute' => 'js:Personal.afterValidateAttribute',
            ),
        )); ?>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5">
                <div class="form-cell">
                    <div class="form-lbl">
                        <?= Yii::t('Front', 'Old password') ?>
                        <span class="tooltip-icon" title="<?= Yii::t('Front', 'password_pin2_tooltip') ?>"></span>
                    </div>
                    <div class="form-input">
                        <?= $form->passwordField($model, 'old_pass', array('class' => 'input-text', 'disabled' => (empty($model->pin2)))) ?>
                        <?= $form->error($model, 'old_pass'); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5">
                <div class="form-cell">
                    <div class="form-lbl">
                        <?= Yii::t('Front', 'Password lifetime'); ?>
                        <span class="tooltip-icon" title="<?= Yii::t('Front', 'password_lifetime_tooltip') ?>"></span>
                    </div>
                    <div class="form-input">
                        <div class="select-custom ">
                            <span class="select-custom-label"></span>
                            <?=
                            $form->dropDownList($model, 'pin2_exp', array(time()+3600*24*30 => 'month', time()+3600*24*30*6 => '6 month', time()+3600*24*30*12 => 'year'), array(
                                'class' => 'country-select select-invisible',
                                'empty' => Yii::t('Personal', 'Select'),
                            ));
                            ?>
                        </div>
                        <?= $form->error($model, 'pin2_exp'); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 ">
                <div class="transaction-buttons-cont edit-submit-cont">
                    <input type="submit" class="button ok" value=""/>
                    <a href="javaScript:void(0)" class="button cancel"></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5">
                <div class="form-cell">
                    <div class="form-lbl">
                        <?= Yii::t('Front', 'New password') ?>
                        <span class="tooltip-icon" title="<?= Yii::t('Front', 'password_newpassword_tooltip') ?>"></span>
                    </div>
                    <div class="form-input">
                        <?= $model->pin2 = ''; ?>
                        <?= $form->passwordField($model, 'pin2', array('class' => 'input-text')) ?>
                        <span class="icon"></span>
                        <?= $form->error($model, 'pin2'); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5">
                <div class="form-cell">
                    <div class="form-lbl">
                        <?= Yii::t('Front', 'Confirm new password') ?>
                        <span class="tooltip-icon" title="<?= Yii::t('Front', 'password_confirm_pass_tooltip') ?>"></span>
                    </div>
                    <div class="form-input">
                        <?= $form->passwordField($model, 'confirm_pass', array('class' => 'input-text')) ?>
                        <span class="icon"></span>
                        <?= $form->error($model, 'confirm_pass'); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 ">
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </td>
</tr>
<?php if($model->pin3_exp < time()): ?>
    <tr class="note-arr-tr">
        <td colspan="4">
            <div class="note-arr">
                <div class="note-bg">
                    <?php if($model->pin3_exp): ?>
                        <span class="rejected"> <?= Yii::t('Front', 'Your password has been expired. Please, change Your password below') ?></span>
                    <?php else: ?>
                        <span> <?= Yii::t('Front', 'add_password') ?></span>
                    <?php endif; ?>
                </div>
                <div class="arr"></div>
            </div>
        </td>
    </tr>
<?php else: ?>
    <tr class="note-arr-tr">
        <td colspan="4">
            <div class="note-arr">
                <div class="note-bg">
                    <?= Yii::t('Personal', 'description_for_pass_3') ?>
                </div>
                <div class="arr"></div>
            </div>
        </td>
    </tr>
<?php endif; ?>
<tr class="data-row">
    <td><?= Yii::t('Personal', 'Password 3') ?></td>
    <td>**********</td>
    <td>
        <?php if($model->pin3_exp): ?>
            <?php if($model->pin3_exp < time()): ?>
                <span class="rejected"><?= date('d.m.Y', $model->pin3_exp) ?></span>
            <?php else: ?>
                <span class="approved"><?= date('d.m.Y', $model->pin3_exp) ?></span>
            <?php endif; ?>
        <?php endif; ?>
    </td>
    <td>
        <div class="transaction-buttons-cont ">
            <a href="javaScript:void(0)" class="button edit"></a>
        </div>
    </td>
</tr>
<tr class="edit-row">
    <td colspan="4" style="border-top: none!important;">
        <div class="table-subheader">
            <?php if(!$model->pin3): ?>
                <?= Yii::t('Personal', 'Add Password 3') ?>
            <?php else: ?>
                <?= Yii::t('Personal', 'Edit Password 3') ?>
            <?php endif; ?>
        </div>
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
                'successCssClass' => 'valid',
                'afterValidate' => 'js:Personal.afterValidate',
                'afterValidateAttribute' => 'js:Personal.afterValidateAttribute',
            ),
        )); ?>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5">
                <div class="form-cell">
                    <div class="form-lbl">
                        <?= Yii::t('Front', 'Old password') ?>
                        <span class="tooltip-icon" title="<?= Yii::t('Front', 'password_pin3_tooltip') ?>"></span>
                    </div>
                    <div class="form-input">
                        <?= $form->passwordField($model, 'old_pass', array('class' => 'input-text', 'disabled' => (empty($model->pin3)))) ?>
                        <?= $form->error($model, 'old_pass'); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5">
                <div class="form-cell">
                    <div class="form-lbl">
                        <?= Yii::t('Front', 'Password lifetime'); ?>
                        <span class="tooltip-icon" title="<?= Yii::t('Front', 'password_lifetime_tooltip') ?>"></span>
                    </div>
                    <div class="form-input">
                        <div class="select-custom ">
                            <span class="select-custom-label"></span>
                            <?=
                            $form->dropDownList($model, 'pin3_exp', array(time()+3600*24*30 => 'month', time()+3600*24*30*6 => '6 month', time()+3600*24*30*12 => 'year'), array(
                                'class' => 'country-select select-invisible',
                                'empty' => Yii::t('Personal', 'Select'),
                            ));
                            ?>
                        </div>
                        <?= $form->error($model, 'pin3_exp'); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 ">
                <div class="transaction-buttons-cont edit-submit-cont">
                    <input type="submit" class="button ok" value=""/>
                    <a href="javaScript:void(0)" class="button cancel"></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5">
                <div class="form-cell">
                    <div class="form-lbl">
                        <?= Yii::t('Front', 'New password') ?>
                        <span class="tooltip-icon" title="<?= Yii::t('Front', 'password_newpassword_tooltip') ?>"></span>
                    </div>
                    <div class="form-input">
                        <?= $model->pin3 = ''; ?>
                        <?= $form->passwordField($model, 'pin3', array('class' => 'input-text')) ?>
                        <span class="icon"></span>
                        <?= $form->error($model, 'pin3'); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5">
                <div class="form-cell">
                    <div class="form-lbl">
                        <?= Yii::t('Front', 'Confirm new password') ?>
                        <span class="tooltip-icon" title="<?= Yii::t('Front', 'password_confirm_pass_tooltip') ?>"></span>
                    </div>
                    <div class="form-input">
                        <?= $form->passwordField($model, 'confirm_pass', array('class' => 'input-text')) ?>
                        <span class="icon"></span>
                        <?= $form->error($model, 'confirm_pass'); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 ">
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </td>
</tr>
</table>
</div>