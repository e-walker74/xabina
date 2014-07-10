<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 29.06.14
 * Time: 16:49
 */
?>

<div class=" xabina-form-narrow">
    <table class="table xabina-table-contacts">
        <tr class="table-header">
            <th style="width: 16%"><?= Yii::t('Front', 'Photo'); ?></th>
            <th style="width: 45%"><?= Yii::t('Front', 'Contact Name'); ?></th>
            <th style="width: 31%"><?= Yii::t('Front', 'Xabina User ID'); ?></th>
            <th style="width: 8%"></th>
        </tr>
        <tr class="data-row">
            <td>
                <?php if ($model->photo): ?>
                    <img width="40" src="<?= $model->getAvatarUrl() ?>" alt=""/>
                <?php else: ?>
                    <img width="40" src="/images/contact_no_foto.png" alt="">
                <?php endif; ?>
            </td>
            <td><?= $model->fullname ?></td>
            <td><?= $model->xabina_id ?></td>
            <td>
                <div class="transaction-buttons-cont">
                    <a href="#" title="<?= Yii::t('Front', 'Edit') ?>" class="button edit"></a>
                </div>
            </td>
        </tr>
        <tr class="edit-row">
            <td colspan="4">
                <?php $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'contact-form',
                    'action' => array('/contact/update', 'url' => $model->url),
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'errorMessageCssClass' => 'error-message',
                    'htmlOptions' => array(
                        'class' => 'form-validable',
                        'enctype' => 'multipart/form-data',
                    ),
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnChange' => true,
                        'errorCssClass' => 'input-error',
                        'successCssClass' => 'valid',
                        'afterValidate' => 'js:afterValidate',
                        'afterValidateAttribute' => 'js:afterValidateAttribute'
                    ),
                )); ?>
                <div class=" xabina-form-narrow">
                    <?php if(!$model->isNewRecord): ?>
                        <input type="hidden" name="update" value="1" />
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-5">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Front', 'First Name') ?>
                                    <span class="tooltip-icon"
                                          title="<?= Yii::t('Front', 'first_name_contact') ?>"></span>
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
                                    <span class="tooltip-icon"
                                          title="<?= Yii::t('Front', 'last_name_contact') ?>"></span>
                                </div>
                                <div class="form-input">
                                    <?= $form->textField($model, 'last_name', array('class' => 'input-text')) ?>
                                    <?= $form->error($model, 'last_name') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 ">
                            <div class="transaction-buttons-cont edit-submit-cont">
                                <input type="submit" title="<?= Yii::t('Front', 'Save') ?>" class="button ok" value=""/>
                                <a href="javaScript:void(0)" title="<?= Yii::t('Front', 'Cancel') ?>" class="button cancel"></a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-5">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Front', 'Company') ?>
                                    <span class="tooltip-icon"
                                          title="<?= Yii::t('Front', 'company_name_contact') ?>"></span>
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
                                    <span class="tooltip-icon"
                                          title="<?= Yii::t('Front', 'nickname_name_contact') ?>"></span>
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
                                    <span class="tooltip-icon"
                                          title="<?= Yii::t('Front', 'xabina_id_name_contact') ?>"></span>
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
                                    <span class="tooltip-icon"
                                          title="<?= Yii::t('Front', 'user_photo_name_contact') ?>"></span>
                                </div>
                                <div class="form-input">
                                    <label class="file-label <?= ($model->photo) ? 'uploaded' : '' ?>">
                                            <span id="image-mini"
                                                  <?php if (!$model->photo): ?>style="display:none"<?php endif; ?>>
                                                <img width="22" src="<?= $model->getAvatarUrl() ?>" alt=""/>
                                            </span>
                                        <span class="file-button"><?= Yii::t('Front', 'Select') ?></span>
                                        <span class="filename"><?= Yii::t('Front', 'Upload user photo') ?></span>
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