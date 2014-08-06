<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 25.07.14
 * Time: 19:23
 */ ?>

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'personal-emails',
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

<div class=" xabina-form-normal">
    <table class="table xabina-table-contacts">
        <tr class="table-header">
            <th style="width: 42%"><?= Yii::t('Personal', 'E-Mail') ?></th>
            <th style="width: 25%"><?= Yii::t('Personal', 'Category') ?></th>
            <th style="width: 25%"><?= Yii::t('Personal', 'Status') ?></th>
            <th style="width: 8%"></th>
        </tr>
        <?php foreach ($users_emails as $users_email): ?>
            <?php if($users_email->status == 0 && $users_email->is_master == 0): ?>
                <tr>
                    <td colspan="4" class="form-border" style="overflow: visible!important;">

                        <div class="note-arr">
                            <div class="note-bg">
                                <?= Yii::t('Personal', 'We have sent a message to this E-Mail address with an activation link. Please, click on an activation link to verify the E-Mail address'); ?>
                                <br>
                                <a href="javaScript:void(0)" onclick="resendActivationEmail('<?= $this->createUrl('/personal/resendemail', array('id' => $users_email->id)) ?>', this)"><?= Yii::t('Front', 'Send new activation link'); ?></a>
                            </div>
                            <div class="arr"></div>
                        </div>
                        <div class=" xabina-form-narrow">
                            <div class="container-form" style="margin: 0 0 10px">
                                <div class="row">
                                    <div class="col-lg-5 col-md-5 col-sm-5" style="overflow: hidden">
                                        <div class="form-cell">
                                            <div class="form-lbl">&nbsp;</div>
                                            <div class="form-input">
                                                <?= $users_email->email ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <div class="form-cell">
                                            <div class="form-lbl">&nbsp;</div>
                                            <div class="form-input">
                                                <?php if($users_email->category): ?>
                                                    <?= $users_email->category->value ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                        <div class="form-cell">
                                            <div class="form-lbl">&nbsp;</div>
                                            <div class="form-input">
                                                <?php if($users_email->status == 0 && $users_email->is_master == 0):?>
                                                    <span class="rejected"><?= Yii::t('Front', 'Unverified') ?></span>
                                                <?php elseif ($users_email->status == 1 && $users_email->is_master == 0):?>
                                                    <a class="make-primary" href="javaScript:void(0)" onclick="js:Personal.makePrimary('<?= Yii::app()->createUrl('/personal/makePrimary', array('type' => 'emails', 'id' => $users_email->id)) ?>', this)"><?= Yii::t('Front', 'Make primary'); ?></a>
                                                <?php elseif ($users_email->status == 1 && $users_email->is_master == 1):?>
                                                    <span class="primary">
					<b><?= Yii::t('Front', 'Primary'); ?></b>
				</span>
                                                <?php endif;?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 ">
                                        <?php if(!$users_email->is_master): ?>
                                        <div class="transaction-buttons-cont" style="margin:10px 0 0;">
                                            <a class="button delete" data-url="<?= Yii::app()->createUrl('/personal/delete', array('type' => 'emails', 'id' => $users_email->id)) ?>" ></a>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php elseif ($users_email->status == 1 && $users_email->is_master == 0 && $users_email->hash): ?>
                <tr>
                    <td colspan="4" class="form-border" style="overflow: visible!important;">
                        <div class="note-arr">
                            <div class="note-bg">
                                <?= Yii::t('Front', 'We have sent a message to primary E-Mail address with a confirmation link. Please, click on the link to confirm the E-Mail address'); ?>
                                <br>
                                <a href="javaScript:void(0)" onclick="resendActivationEmail('<?= $this->createUrl('/personal/resendemail', array('id' => $users_email->id)) ?>', this)"><?= Yii::t('Front', 'Send new confirmation link'); ?></a>
                            </div>
                            <div class="arr"></div>
                        </div>
                        <div class=" xabina-form-narrow">
                            <div class="container-form" style="margin: 0 0 10px">
                                <div class="row">
                                    <div class="col-lg-5 col-md-5 col-sm-5" style="overflow: hidden">
                                        <div class="form-cell">
                                            <div class="form-lbl">&nbsp;</div>
                                            <div class="form-input">
                                                <?= $users_email->email ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <div class="form-cell">
                                            <div class="form-lbl">&nbsp;</div>
                                            <div class="form-input">
                                                <?= $users_email->category->value ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                        <div class="form-cell">
                                            <div class="form-lbl">&nbsp;</div>
                                            <div class="form-input">
                                                <?php if($users_email->status == 0 && $users_email->is_master == 0):?>
                                                    <span class="rejected"><?= Yii::t('Front', 'Unverified') ?></span>
                                                <?php elseif ($users_email->status == 1 && $users_email->is_master == 0):?>
                                                    <a class="make-primary" href="javaScript:void(0)" onclick="js:Personal.makePrimary('<?= Yii::app()->createUrl('/personal/cancelMakePrimary', array('type' => 'emails', 'id' => $users_email->id)) ?>', this)"><?= Yii::t('Front', 'Cancel'); ?></a>
                                                <?php elseif ($users_email->status == 1 && $users_email->is_master == 1):?>
                                                    <span class="primary">
					<b><?= Yii::t('Front', 'Primary'); ?></b>
				</span>
                                                <?php endif;?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 ">
                                        <?php if(!$users_email->is_master): ?>
                                            <div class="transaction-buttons-cont" style="margin:10px 0 0;">
                                                <a class="button delete" data-url="<?= Yii::app()->createUrl('/personal/delete', array('type' => 'emails', 'id' => $users_email->id)) ?>" ></a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php else: ?>
                <tr>
                    <td><?= $users_email->email ?></td>
                    <td><?= $users_email->category->value ?></td>
                    <td>
                        <?php if($users_email->status == 0 && $users_email->is_master == 0):?>
                            <span class="rejected"><?= Yii::t('Front', 'Unverified') ?></span>
                        <?php elseif ($users_email->status == 1 && $users_email->is_master == 0):?>
                            <a class="make-primary" href="javaScript:void(0)" onclick="js:Personal.makePrimary('<?= Yii::app()->createUrl('/personal/makePrimary', array('type' => 'emails', 'id' => $users_email->id)) ?>', this)"><?= Yii::t('Front', 'Make primary'); ?></a>
                        <?php elseif ($users_email->status == 1 && $users_email->is_master == 1):?>
                            <span class="primary">
                                <b><?= Yii::t('Front', 'Primary'); ?></b>
                            </span>
                        <?php endif;?>
                    </td>
                    <td>
                        <?php if(!$users_email->is_master): ?>
                            <div class="transaction-buttons-cont" style="margin:10px 0 0;">
                                <a class="button delete" data-url="<?= Yii::app()->createUrl('/personal/delete', array('type' => 'emails', 'id' => $users_email->id)) ?>" ></a>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        <tr class="data-row">
            <td colspan="4" class="add-new-td">
                <a class="rounded-buttons add-more upload"><?= Yii::t('Front', 'Add new'); ?></a>
            </td>
        </tr>
        <?php $model_emails = new Users_Emails(); ?>
        <tr class="edit-row">
            <td colspan="4">
                <div class=" xabina-form-normal">
                    <div class="table-subheader"><?= Yii::t('Personal', 'Add E-Mail') ?></div>
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-5">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Personal', 'E-mail') ?>
                                        <span class="tooltip-icon"
                                              title="<?= Yii::t('Personal', 'email_tooltip') ?>"></span>
                                </div>
                                <div class="form-input">
                                    <?= $form->textField($model_emails, 'email', array('class' => 'input-text')); ?>
                                    <?= $form->error($model_emails, 'email'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Personal', 'Category') ?>
                                        <span class="tooltip-icon"
                                              title="<?= Yii::t('Personal', 'email_category_tooltip') ?>"></span>
                                </div>
                                <div class="form-input category-select">
                                    <div class="select-custom">

                                        <span class="select-custom-label"></span>
                                        <?= $form->dropDownList(
                                            $model_emails,
                                            'category_id',
                                            Html::listDataWithFilter(
                                                $data_categories,
                                                'id',
                                                'value',
                                                'data_type',
                                                $model_emails->tableName()
                                            ) + array('add' => Yii::t('Front', 'Other')),
                                            array(
                                                'class' => 'select-invisible',
                                                'onchange' => 'Personal.showAddNewCategory(this)',
                                                'empty' => Yii::t('Front', 'Select'),
                                                'options' => array($model_emails->category_id => array('selected' => true)),
                                            )
                                        ) ?>
                                    </div>
                                    <?= $form->error($model_emails, 'category_id'); ?>
                                </div>
                                <div class="form-input add-new-category" style="display: none;">
                                    <span class="clear-input-cont full-with">
                                        <input type="text" name="Data_Category" maxlength="25" class="input-text" disabled="disabled">
                                        <span class="clear-input-but" onclick="Personal.hideCategoryTextField(this)"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 ">
                            <div class="transaction-buttons-cont edit-submit-cont">
                                <input type="submit" class="button ok submit" value="" />
                                <a class="button cancel" href="javaScript:void(0)"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
<?php $this->endWidget(); ?>
