<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 31.07.14
 * Time: 18:03
 * @param Users $model
 * @param Users_Ids $lastXabinaId
 */ ?>

<div class=" xabina-form-normal" style="margin-top: 19px">
    <table class="table xabina-table-contacts">
        <tr class="table-header">
            <th style="width: 18%"><?= Yii::t('Personal', 'Photo') ?></th>
            <th style="width: 25%"><?= Yii::t('Personal', 'Name') ?></th>
            <th style="width: 20%"><?= Yii::t('Personal', 'Gender') ?></th>
            <th style="width: 29%"><?= Yii::t('Personal', 'Birth Date') ?></th>
            <th style="width: 8%"></th>
        </tr>
        <tr class="note-tr">
            <td colspan="5" style="width: 100%">
                <div class="note">
                    <?= Yii::t('Personal', 'If you want to change Your First and/or Last Name, You need to upload the new copy of Your Passport or ID') ?>
                    <a href="#tab5"><?= Yii::t('Personal', 'Drive section') ?></a>
                </div>
            </td>
        </tr>
        <tr class="data-row">
            <td>
                <img width="40" src="<?= $model->getPhotoUrl() ?>" alt="">
            </td>
            <td><?= $model->first_name ?> <?= $model->last_name ?></td>
            <td><?= ($model->gender == 'male') ? Yii::t('Personal', 'Male') : (($model->gender == 'female') ? Yii::t('Personal', 'Female') : "" ) ?></td>
            <td><?= $model->birthday ?></td>
            <td>
                <div class="contact-actions transaction-buttons-cont">
                    <a class="button edit" href="javascript:void(0)" title="<?= Yii::t('Front', 'Edit') ?>"></a>
                </div>

            </td>
        </tr>
        <tr class="edit-row">
            <td colspan="5">
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'user-personal-photo-form',
                    'enableAjaxValidation'=>true,
                    'action' => array('/personal/uploaduserphoto'),
                    'enableClientValidation'=>false,
                    'errorMessageCssClass' => 'error-message',
                    'htmlOptions' => array(
                        'class' => 'form-validable',
                        'enctype' => 'multipart/form-data',
                    ),
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                        'validateOnChange'=>false,
                        'errorCssClass'=>'input-error',
                        'successCssClass'=>'valid',
                        'afterValidate' => 'js:Personal.uploadUserPhoto',
//                        'afterValidateAttribute' => 'js:Personal.afterValidateAttribute',
                    ),
                )); ?>
                <div class=" xabina-form-normal">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-5">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Personal', 'First Name') ?>
                                    <span class="tooltip-icon" title="<?= Yii::t('Personal', 'personal_first_name_tooltip') ?>"></span>
                                </div>
                                <div class="form-input">
                                    <input type="text" disabled value="<?= $model->first_name ?>" class="input-text"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Personal', 'Last Name') ?>

                                    <span class="tooltip-icon" title="<?= Yii::t('Personal', 'personal_last_name_tooltip') ?>"></span>
                                </div>
                                <div class="form-input">
                                    <input type="text" disabled value="<?= $model->last_name ?>" class="input-text"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 ">
                            <div class="transaction-buttons-cont edit-submit-cont">
                                <input type="submit" class="button ok" value="" title="<?= Yii::t('Front', 'OK') ?>"/>
                                <a href="javaScript:void(0)" class="button cancel"  title="<?= Yii::t('Front', 'Remove') ?>"></a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-5">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-cell">
                                        <div class="form-lbl">
                                            <?= Yii::t('Personal', 'Gender') ?>
                                            <span class="tooltip-icon"
                                                  title="<?= Yii::t('Personal', 'personal_gender_tooltip') ?>"></span>
                                        </div>
                                        <div class="form-input">
                                            <div class="select-custom disabled">
                                                <span class="select-custom-label"></span>
                                                <select disabled name="country" class="country-select select-invisible gray">
                                                    <option value=""><?= Yii::t('Personal', 'Select') ?></option>
                                                    <option <?= ($model->gender == 'male') ? "selected" : "" ?> value="male"><?= Yii::t('Personal', 'Male') ?></option>
                                                    <option <?= ($model->gender == 'female') ? "selected" : "" ?> value="female"><?= Yii::t('Personal', 'Female') ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-cell">
                                        <div class="form-lbl">
                                            <?= Yii::t('Personal', 'Birth Date') ?>
                                            <span class="tooltip-icon"
                                                  title="<?= Yii::t('Personal', 'personal_birthdate_tooltip') ?>"></span>
                                        </div>
                                        <div class="form-input">
                                            <input disabled value="<?= $model->birthday ?>" type="text" class="input-text"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Personal', 'User Photo') ?>
                                    <span class="tooltip-icon" title="<?= Yii::t('Personal', 'personal_photo_tooltip') ?>"></span>
                                </div>
                                <div class="form-input">
                                    <label class="file-label <?= ($model->photo) ? 'uploaded' : '' ?>" for="Users_photo">
                                            <span id="image-mini"
                                                  <?php if (!$model->photo): ?>style="display:none"<?php endif; ?>>
                                                <img width="22" src="<?= $model->getPhotoUrl() ?>" alt=""/>
                                            </span>
                                        <span class="file-button"><?= Yii::t('Front', 'Select') ?></span>
                                        <span class="filename"><?= Yii::t('Front', 'Upload contact photo') ?></span>
                                        <?= $form->fileField($model, 'photo', array('class' => 'file-input')) ?>
                                        <?php if ($model->photo): ?>
                                            <span class="delete-photo">
                                                <img src="/images/uploded_remove.png"
                                                     style="float: right; cursor:pointer" alt=""/>
                                                <?= $form->hiddenField($model, 'delete') ?>
                                            </span>
                                        <?php endif; ?>
                                    </label>
                                    <?= $form->error($model, 'photo'); ?>
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
<?php if(!$lastXabinaId->isNewRecord): ?>
    <div class="xabina-form-normal">
        <table class="table xabina-table-contacts">
            <tr class="table-header">
                <th style="width: 25%"><?= Yii::t('Personal', 'Old User ID') ?></th>
                <th style="width: 66%"><?= Yii::t('Personal', 'New User ID') ?></th>
                <th style="width: 9%"></th>
            </tr>
            <tr>
                <td colspan="3" class="form-border">
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'user-change-id-form',
                        'enableAjaxValidation'=>true,
                        'enableClientValidation'=>false,
                        'errorMessageCssClass' => 'error-message',
                        'htmlOptions' => array(
                            'class' => 'form-validable',
                        ),
                        'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                            'validateOnChange'=>false,
                            'errorCssClass'=>'input-error',
                            'successCssClass'=>'valid',
                            'afterValidate' => 'js:Personal.afterValidate',
                            'afterValidateAttribute' => 'js:Personal.afterValidateAttribute',
                        ),
                    )); ?>
                    <div class="note-arr">
                        <div class="note-bg">
                            <?= Yii::t('Personal', 'We have send an SMS with the verification code on the phone number + *** *** :phone.',
                                array(':phone' => substr($model->phone, -3))); ?>
                            <a href="javaScript:void(0)" onclick="Personal.resendSmsForChangeId('<?= Yii::app()->createUrl('/personal/resendSmsForChangeId') ?>')"><?= Yii::t('Personal', 'Send verification code once again') ?></a>
                        </div>
                        <div class="arr"></div>
                    </div>
                    <div class=" xabina-form-narrow">
                        <div class="container-form" style="margin: 0 0 10px">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <div class="form-cell">
                                        <div class="form-lbl">&nbsp;</div>
                                        <div class="form-input">
                                            <?= $model->login ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <div class="form-cell">
                                        <div class="form-lbl">&nbsp;</div>
                                        <div class="form-input">
                                            <?= $lastXabinaId->new_user_id ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="form-cell">
                                        <div class="form-lbl pull-left" style="margin: 18px 0 0">
                                            <?= Yii::t('Personal', 'SMS code') ?>
                                        <span class="tooltip-icon"
                                              title="<?= Yii::t('Personal', 'personal_id_sms_confirm_code') ?>"></span>
                                        </div>
                                        <div class="form-input pull-right" style="width: 50%">
                                            <?= $form->textField($lastXabinaId, 'compare_confirm_code', array('class' => 'input-text')) ?>
                                            <?= $form->error($lastXabinaId, 'compare_confirm_code') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 ">
                                    <div class="transaction-buttons-cont " style="margin: 10px 0 0">
                                        <input type="submit" value="" class="button ok" title="<?= Yii::t('Front', 'OK') ?>"/>
                                        <input type="submit" name="delete" class="button remove"  title="<?= Yii::t('Front', 'Remove') ?>" value=""/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </td>
            </tr>
        </table>
    </div>
<?php else: ?>
    <div class=" xabina-form-normal">
        <table class="table xabina-table-contacts">
            <tr class="table-header">
                <th style="width: 26%"><?= Yii::t('Personal', 'User ID') ?></th>
                <th style="width: 66%"><?= Yii::t('Personal', 'Status') ?></th>
                <th style="width: 8%"></th>
            </tr>
            <tr class="note-row">
                <td colspan="3" class="form-border" style="border: none!important;">
                    <div class="note-arr">
                        <div class="note-bg">
                            <?= Yii::t('Personal', 'You can change your ID once every week.'); ?>
                        </div>
                        <div class="arr"></div>
                    </div>
                </td>
            </tr>
            <tr class="data-row" style="border-top: none!important;">
                <td style="border-top: none!important;">
                    <?= $model->login ?>
                </td>
                <td style="border-top: none!important;">
                    <?php if($lastChange && !$lastChange->isCanChange): ?>
                        <?= Yii::t('Personal', 'You may change Xabina ID after: <span class="bold">:date</span>',
                            array(
                                ':date' => SiteService::timeRange((time() - $lastChange->confirm_at), Users_Ids::USER_ID_TIME)
                            ))  ?>
                    <?php endif; ?>
                </td>
                <td style="border-top: none!important;">
                    <?php if(!$lastChange || $lastChange->isCanChange): ?>
                        <div class="transaction-buttons-cont ">
                            <a href="javascript:void(0)" class="button edit"></a>
                        </div>
                    <?php endif; ?>
                </td>
            </tr>
            <tr class="edit-row">
                <td colspan="3" class="form-border" style="border: none!important">
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'user-change-id-form',
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
                    <div class="note-arr">
                        <div class="note-bg">
                            <?= Yii::t('Personal', 'You can change your ID once every week.'); ?>
                        </div>
                        <div class="arr"></div>
                    </div>
                    <div class=" xabina-form-narrow">
                        <div class="container-form">
                            <div class="row">
                                <div class="col-lg-5 col-md-5 col-sm-5">
                                    <div class="form-cell">
                                        <div class="form-lbl">
                                            <?= Yii::t('Personal', 'New User ID'); ?>
                                            <span class="tooltip-icon"
                                                  title="<?= Yii::t('Personal', 'new_user_id_tooltip'); ?>"></span>
                                        </div>
                                        <div class="form-input">
                                            <?= $form->textField($lastXabinaId, 'new_user_id', array('class' => 'input-text')) ?>
                                            <?= $form->error($lastXabinaId, 'new_user_id'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-5">
                                    <div class="form-cell">
                                        <div class="form-lbl">
                                            <?= Yii::t('Personal', 'Confirm New User ID'); ?>
                                            <span class="tooltip-icon"
                                                  title="<?= Yii::t('Personal', 'confirm_new_user_id_tooltip'); ?>"></span>
                                        </div>
                                        <div class="form-input">
                                            <?= $form->textField($lastXabinaId, 'confirm_new_user_id', array('class' => 'input-text')) ?>
                                            <?= $form->error($lastXabinaId, 'confirm_new_user_id'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 ">
                                    <div class="transaction-buttons-cont edit-submit-cont">
                                        <input type="submit" value="" class="button ok" title="<?= Yii::t('Front', 'OK') ?>"/>
                                        <a href="javaScript:void(0)" class="button cancel" title="<?= Yii::t('Front', 'Cancel') ?>"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </td>
            </tr>
        </table>
    </div>
<?php endif; ?>
<script>
    Personal.bindPhotoChange()
</script>
<?php Yii::app()->clientScript->registerScriptFile('/js/jquery.form.js')?>