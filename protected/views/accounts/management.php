<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 08.09.14
 * Time: 23:50
 * @var AccountsController $this
 * @var Accounts           $model
 * @var CActiveForm        $form
 * @var Accounts[]         $accounts
 */
?>
<div class="col-lg-9 col-md-9 col-sm-9">
<div class="h1-header">
    <?= Yii::t('Accounts', 'Account Management') ?>
</div>
<div class="edit-tabs contact-tabs">
<ul class="list-unstyled">
    <li style="width: 21%"><a href="#tab1"><?= Yii::t('Accounts', 'Overview') ?></a></li>
    <li style="width: 20%"><a href="#tab2"><?= Yii::t('Accounts', 'Подписанты') ?></a></li>
    <li style="width: 23%"><a href="#tab3"><?= Yii::t('Accounts', 'Limits') ?></a></li>
    <li style="width: 19%"><a href="#tab4"><?= Yii::t('Accounts', 'Fees') ?></a></li>
    <li style="width: 17%"><a href="#tab5"><?= Yii::t('Accounts', 'Terms') ?></a></li>
</ul>
<div class="clearfix"></div>
<div id="tab1">
    <div class="account-management-general">
        <table class="table table-management">
            <tr>
                <td>
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
                    <table class="table table-management-inner-table">
                        <tr>
                            <td style="width: 47%"><span class="bold"><?= Yii::t('Accounts', 'Account  Owner') ?></span>
                            </td>
                            <td style="width: 53%">
                                <img src="<?= Yii::user()->getPhotoUrl() ?>" alt=""
                                     style="width: 30px; margin: 0 10px 0 0"/>
                                <?= Yii::user()->getFullName() ?>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="bold"><?= Yii::t('Accounts', 'Account Number') ?></span></td>
                            <td><?= chunk_split($model->number, 4) ?></td>
                        </tr>
                        <tr class="data-row">
                            <td><span class="bold"><?= Yii::t('Accounts', 'Account Name') ?></span></td>
                            <td>
                                <?= $model->name ?>
                                <div class="transaction-buttons-cont" style="margin: -6px 0 0">
                                    <a href="javaScript:" class="button edit edit-data"></a>
                                </div>
                            </td>
                        </tr>
                        <tr class="edit-row">
                            <td><span class="bold"><?= Yii::t('Accounts', 'Account Name') ?></span></td>
                            <td>
                                <?= $form->textField($model, 'name', array('class' => 'text-input')) ?>
                                <div class="transaction-buttons-cont" style="">
                                    <input type="submit" class="button ok" value=""/>
                                    <a href="javaScript:" class="button cancel"></a>
                                </div>
                                <?= $form->error($model, 'name') ?>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="bold"><?= Yii::t('Accounts', 'Account Type') ?></span></td>
                            <td>
                                Платежный <br/>
                                <span class="note"><?= Yii::t('Front', 'account_sub_type_' . $model->sub_type) ?></span>

                                <div class="transaction-buttons-cont" style="margin: -14px 0 0">
                                    <a href="#" class="button stairs-new"></a>
                                </div>
                            </td>
                        </tr>
                        <?php foreach ($accounts as $account): ?>
                            <tr>
                                <td><span class="bold"><?= Yii::t('Accounts', 'Balance') ?></span></td>
                                <td style="overflow: visible!important">
                                    <?php if($account->balance > 0): ?>
                                        <span class="sum-inc">+<?= number_format($account->balance, 2, '.', ' ') ?></span>&nbsp;<?= $account->currency->title ?>&nbsp;
                                    <?php elseif($account->balance < 0): ?>
                                        <span class="sum-dec "><?= number_format($account->balance, 2, '.', ' ') ?></span>&nbsp;<?= $account->currency->title ?>&nbsp;
                                    <?php else: ?>
                                        0&nbsp;<?= $account->currency->title ?>&nbsp;
                                    <?php endif; ?>
                                    <?php Widget::create(
                                        'WCurrencyConverter',
                                        'WCurrencyConverter',
                                        array('value' => $account->balance, 'currency_code' => $account->currency->code)
                                    ) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
<!--                        <tr>-->
<!--                            <td><span class="bold">--><?//= Yii::t('Accounts', 'Currency') ?><!--</span></td>-->
<!--                            <td>EUR</td>-->
<!--                        </tr>-->
                        <tr>
                            <td><span class="bold"><?= Yii::t('Accounts', 'Credit Facility') ?></span></td>
                            <td style="overflow: visible!important">
                                <?= $model->credit_facility ?> <?= $model->currency->title ?>&nbsp;
                                <?php Widget::create(
                                    'WCurrencyConverter',
                                    'WCurrencyConverter',
                                    array(
                                        'value' => $model->credit_facility,
                                        'currency_code' => $model->currency->code
                                    )
                                ) ?>
                                <div class="transaction-buttons-cont" style="margin: -6px 0 0">
                                    <a href="#" class="button stairs-new"></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="bold"><?= Yii::t('Accounts', 'Status') ?></span></td>
                            <td class="status" style="overflow: visible!important">
                                <?= AccountService::getAccountStatusIcon($model->status) ?> - <?= Accounts::$status_names[$model->status] ?>
                                <?php if($model->status_comment): ?>
                                    <div class="comment drdn-cont">
                                        <a href="#" class="transaction_comment dropdown-hover margin-left active"
                                           data-toggle="dropdown"></a>

                                        <div
                                            class="dropdown-menu no-close contact-select-dropdown list-actions-dropdown list-unstyled act-list"
                                            role="menu">
                                            <div class="arr"></div>
                                            <div class="content-dropdown">
                                                <div class="drop_title">
                                                    <?= Yii::t('Accounts', 'Comment') ?>
                                                    <a class="close-dropdown"></a>
                                                </div>
                                                <div class="casual_text">
                                                    <?= $model->status_comment ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                    <?php $this->endWidget(); ?>
                </td>
            </tr>
        </table>
    </div>

</div>
<div id="tab2">
    <table class="table table-management">
        <tr>
            <th style="width:53%"><?= Yii::t('Accounts', 'Name') ?></th>
            <th style="width:47%"><?= Yii::t('Accounts', 'Role') ?></th>
        </tr>
        <!--        <tr class="note-tr">-->
        <!--            <td colspan="2">Изменить управляющего можно в <a class="violet-link" href="#">Личном кабинете.</a></td>-->
        <!--        </tr>-->
        <tr>
            <td colspan="2">
                <table class="table table-management-inner-table">
                    <tr>
                        <td style="width: 51%">
                            <img src="<?= Yii::user()->getPhotoUrl() ?>" alt=""
                                 style="width: 30px; margin: 0 10px 0 0"/>
                            <span class="bold"><?= Yii::user()->getFullName() ?></span>
                        </td>
                        <td style="width: 41%">
                            <span class="bold"><?= Yii::t('Accounts', 'Owner') ?></span>
                        </td>
                        <td style="width: 8%">
                            <div class="transaction-buttons-cont" style="margin: -6px 0 0">
                                <a href="<?= Yii::app()->createUrl('/personal/index') ?>" class="button edit"></a>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<div id="tab3">
    <table class="table table-management">
        <tr>
            <th style="width: 35%">Name</th>
            <th style="width: 18%">Value</th>
            <th style="width: 24%">Currency</th>
            <th style="width: 23%">Period</th>
        </tr>
        <tr>
            <td colspan="4">
                <table class="table table-management-inner-table">
                    <tr>
                        <td style="width: 36%">Standart</td>
                        <td style="width: 19%">1 000</td>
                        <td style="width: 25%">EUR</td>
                        <td style="width: 20%">Month</td>
                    </tr>
                    <tr>
                        <td style="width: 36%">Service accumulation "Piggy"</td>
                        <td style="width: 19%">100</td>
                        <td style="width: 25%">EUR</td>
                        <td style="width: 20%">Day</td>
                    </tr>
                    <tr>
                        <td style="width: 36%">Poste restante</td>
                        <td style="width: 19%">10 000</td>
                        <td style="width: 25%">EUR</td>
                        <td style="width: 20%">Year</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<div id="tab4">
    <table class="table table-management">
        <tr>
            <th style="width: 53%">Name</th>
            <th style="width: 24%">Value</th>
            <th style="width: 23%">Currency</th>
        </tr>
        <tr>
            <td colspan="4">
                <table class="table table-management-inner-table">
                    <tr>
                        <td style="width: 55%">Standart</td>
                        <td style="width: 25%">1 000</td>
                        <td style="width: 20%">EUR</td>
                    </tr>
                    <tr>
                        <td style="width: 55%">Service accumulation "Piggy"</td>
                        <td style="width: 25%">100</td>
                        <td style="width: 20%">EUR</td>
                    </tr>
                    <tr>
                        <td style="width: 55%">Poste restante</td>
                        <td style="width: 25%">10 000</td>
                        <td style="width: 20%">EUR</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<div id="tab5">
    <div class="management-terms">
        <p>
            Вся информация, размещённая на данном сайте, является собственностью Xabina.
            Xabina сохраняет за собой право изменять содержание и/или структуру сайта в любое время
            и без предварительного уведомления.
        </p>

        <p>
            Любая информация, когда-либо размещённая на данном сайте, не должна рассматриваться
            как предложение продуктов и услуг в целом или банковских либо страховых продуктов
            отдельно, сделанное CREDIT EUROPE BANK. Данный сайт не содержит никаких советов либо
            рекомендаций касательно любой сферы деятельности. Никакие инвестиционные либо
            коммерческие проекты не инициируются и не развиваются на страницах сайта, и никакие
            решения любого другого характера не могут основываться на информации, содержащейся на
            сайте. Следовательно, банк не может нести ответственность за ущерб, причинённый
            посетителю сайта.
        </p>
    </div>
</div>
</div>
<div class="xabina-form-container">
    <div class="form-submit">
        <div class="submit-button button-back" onclick="window.location = 'personal_account_new.html'">Back</div>
    </div>
</div>
<div class="clearfix"></div>
</div>