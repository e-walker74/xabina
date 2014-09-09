<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 08.09.14
 * Time: 19:24
 * @var CActiveForm $form
 * @var Accounts $model
 */ ?>


<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog xabina-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><img src="img/close.png"></button>
                <div class="dialog-title">Terms</div>
            </div>
            <div class="modal-body">
                <div class="modal-terms-cont">
                    Вся информация, размещённая на данном сайте, является собственностью Xabina.
                    <br/><br/>
                    Xabina сохраняет за собой право изменять содержание и/или структуру сайта в любое время
                    и без предварительного уведомления.
                    <br/><br/>
                    Любая информация, когда-либо размещённая на данном сайте, не должна рассматриваться
                    как предложение продуктов и услуг в целом или банковских либо страховых продуктов
                    отдельно, сделанное CREDIT EUROPE BANK. Данный сайт не содержит никаких советов либо
                    рекомендаций касательно любой сферы деятельности. Никакие инвестиционные либо
                    коммерческие проекты не инициируются и не развиваются на страницах сайта, и никакие
                    решения любого другого характера не могут основываться на информации, содержащейся
                    на сайте. Следовательно, банк не может нести ответственность за ущерб, причинённый
                    посетителю сайта.
                    <br/><br/>
                    Эта парадигматическая страна, в которой жаренные члены предложения залетают прямо
                    в рот. Даже всемогущая пунктуация не имеет власти над рыбными текстами, ведущими
                    безорфографичный образ жизни. Однажды одна маленькая строчка рыбного текста по имени
                    Lorem ipsum решила выйти в большой мир грамматики. Великий Оксмокс предупреждал ее
                    <br/><br/>
                    Любая информация, когда-либо размещённая на данном сайте, не должна рассматриваться
                    как предложение продуктов и услуг в целом или банковских либо страховых продуктов
                    отдельно, сделанное CREDIT EUROPE BANK. Данный сайт не содержит никаких советов либо
                    рекомендаций касательно любой сферы деятельности. Никакие инвестиционные либо
                    коммерческие проекты не инициируются и не развиваются на страницах сайта, и никакие
                    решения любого другого характера не могут основываться на информации, содержащейся
                    на сайте. Следовательно, банк не может нести ответственность за ущерб, причинённый
                    посетителю сайта.
                    <br/><br/>
                    Эта парадигматическая страна, в которой жаренные члены предложения залетают прямо
                    в рот. Даже всемогущая пунктуация не имеет власти над рыбными текстами, ведущими
                    безорфографичный образ жизни. Однажды одна маленькая строчка рыбного текста по имени
                    Lorem ipsum решила выйти в большой мир грамматики. Великий Оксмокс предупреждал ее
                    <br/><br/>
                </div>
            </div>
            <div class="modal-footer">
                <input class="rounded-buttons submit pull-left" type="submit" value="Accept"/>
            </div>
        </div>
    </div>
</div>


<div class="col-lg-9 col-md-9 col-sm-9" >
<div class="h1-header"><?= Yii::t('Accounts', 'Open new account'); ?></div>
<div class="open-account-banner-cont">
    <div class="open-account-banner">
        <img src="/css/images/open_account_banner.png" alt=""/>
    </div>
    <div class="open-account-info">
        <?= Yii::t('Accounts', '[create_account_text]'); ?>
    </div>
</div>
<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'user_datas',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'errorMessageCssClass' => 'error-message',
    'htmlOptions' => array(
        'class' => 'form-validable',
    ),
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'errorCssClass' => 'input-error',
        'successCssClass' => 'valid',
        'afterValidate' => 'js:XForms.afterValidate',
        'afterValidateAttribute' => 'js:XForms.afterValidateAttribute',
    ),
)); ?>
<div class="open-account-form-cont">
    <div class="xabina-form-narrow">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-cell">
                    <div class="form-lbl">
                        <?= Yii::t('Account', 'Account Owner') ?>
                        <span class="tooltip-icon" title="<?= Yii::t('Account', 'create_account_owner_tooltip') ?>"></span>
                    </div>
                    <div class="form-input">
                        <input type="text" class="input-text" value="<?= Yii::user()->getFullName() ?>" disabled>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-cell">
                    <div class="form-lbl">
                        <?= Yii::t('Account', 'Account type') ?>
                        <span class="tooltip-icon" title="<?= Yii::t('Account', 'create_account_type_tooltip') ?>"></span>
                    </div>
                    <div class="form-input">
                        <input type="text" class="input-text" value="Платежный" disabled>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-cell">
                    <div class="form-lbl">
                        <?= Yii::t('Account', 'Name') ?>
                        <span class="tooltip-icon" title="<?= Yii::t('Account', 'create_account_name_tooltip') ?>"></span>
                    </div>
                    <div class="form-input category-select">
                        <div class="select-custom select-narrow ">
                            <span class="select-custom-label"></span>
                            <?= $form->dropDownList(
                                $model,
                                'name',
                                CHtml::listData($names, 'name', 'name') + array('add' => Yii::t('Front', 'Other')),
                                array(
                                    'class' => 'select-invisible country-select',
                                    'empty' => Yii::t('Front', 'Select'),
                                )
                            ) ?>
                        </div>
                        <?= $form->error($model, 'name') ?>
                    </div>
                    <div class="form-input add-new-category" style="display: none;">
                        <div>
                        <span class="clear-input-cont full-with">
                            <?= $form->textField($model, 'new_name', array('class' => 'input-text', 'disabled' => true)) ?>
                            <?= $form->error($model, 'new_name') ?>
                            <span class="clear-input-but" onclick="XForms.hideCategoryTextField(this)"></span>
                        </span>
                        </div>
                    </div>
                    <script>
                        $('#Accounts_name').change(function(){
                            XForms.showAddNewCategory(this)
                        })
                    </script>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-cell">
                    <div class="form-lbl">
                        <?= Yii::t('Account', 'Currency') ?>
                        <span class="tooltip-icon" title="<?= Yii::t('Account', 'create_account_currency_tooltip') ?>"></span>
                    </div>
                    <div class="form-input">
                        <div class="select-custom select-narrow ">
                            <span class="select-custom-label"></span>
                            <?= $form->dropDownList($model, 'currency_id', array('' => Yii::t('Front', 'Select')) + CHtml::listData($currencies, 'id', 'title'), array('class' => 'select-invisible country-select')) ?>
                        </div>
                        <?= $form->error($model, 'currency_id') ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-cell">
                    <div class="form-lbl">
                        <?= Yii::t('Account', 'Sub Type') ?>
                        <span class="tooltip-icon" title="<?= Yii::t('Account', 'create_account_subtype_tooltip') ?>"></span>
                    </div>
                    <div class="form-input category-select">
                        <div class="select-custom select-narrow ">
                            <span class="select-custom-label"></span>
                            <?= $form->dropDownList(
                                $model,
                                'sub_type',
                                Accounts::getAccountSubTypesForUser(),
                                array(
                                    'class' => 'select-invisible country-select',
                                    'empty' => Yii::t('Front', 'Select'),
                                )
                            ) ?>
                        </div>
                        <?= $form->error($model, 'sub_type') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="open-account-conditions">
    <div class="line">
        <div class="checkbox-custom mini">
            <label >
                <?= $form->checkBox($model, 'terms') ?>
            </label>
        </div>
        I have read and agree to the
        <a class="violet-link" href="#myModal1" role="button" data-toggle="modal" role="button" data-toggle="modal">terms</a> &amp; <a  data-toggle="modal" data-target="#myModal1" class="violet-link" href="#">conditions</a>
    <?= $form->error($model, 'terms') ?>
    </div>
    <div class="line">
        <div class="checkbox-custom mini">
            <label >
                <?= $form->checkBox($model, 'fees') ?>
            </label>
        </div>
        I have read and agree to the <a class="violet-link" href="#">Fees Structure</a>
    </div>
    <?= $form->error($model, 'fees') ?>
</div>
<div class="xabina-form-container">
    <div class="form-submit">
        <div class="submit-button button-back">Back</div>
        <input type="submit" class="submit-button button-open pull-right" value="<?= Yii::t('Accounts', 'Open Account') ?>" />
    </div>
</div>
<?php $this->endWidget(); ?>
    </div>