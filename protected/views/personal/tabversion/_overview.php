<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 31.07.14
 * Time: 15:51
 * @param Users $model
 */ ?>

<div class=" xabina-form-normal">
    <table class="table xabina-table-contacts">
        <tr class="table-header">
            <th style="width: 42%"><?= Yii::t('Personal', 'Section') ?></th>
            <th style="width: 49%"><?= Yii::t('Personal', 'Description') ?></th>
            <th style="width: 9%"></th>
        </tr>
        <tr class="align-top">
            <td><?= Yii::t('Personal', 'Personal Info') ?></td>
            <td>
                <?= $model->first_name ?> <?= $model->last_name ?>
                <span class="note"><?= Yii::t('Personal', 'First Name / Last Name') ?></span>
                <?= $model->login ?>
                <span class="note"><?= Yii::t('Site', 'User ID') ?></span>
            </td>
            <td>
            </td>
        </tr>
        <?php if($model->primary_paymentsmethod): ?>
            <tr class="align-top">
                <td><?= Yii::t('Personal', 'Payment Methods') ?></td>
                <td>
                    <span class="strong">**** **** <?= substr($model->primary_paymentsmethod->from_account_number, -4) ?></span>
                    <span class="note"><?= Users_Paymentinstruments::$methods[$model->primary_paymentsmethod->electronic_method] ?></span>
                </td>
                <td>
                    <div class="transaction-buttons-cont">
                        <a class="button share" title="Share" href="javaScript:void(0)"></a>
                    </div>
                </td>
            </tr>
        <?php endif; ?>
        <tr class="align-top">
            <td><?= Yii::t('Personal', 'E-Mail') ?></td>
            <td>
                <span class="strong">
                    <?php if($model->primary_email): ?>
                        <?= $model->primary_email->email ?>
                    <?php else: ?>
                        <?= $model->login ?>@xabina.com
                    <?php endif; ?>
                </span>
                <span class="note">
                    <?php if(!$model->primary_email): ?>
                        <?= Yii::t('Personal', 'System E-Mail') ?>
                    <?php else: ?>
                        <?= ($model->primary_email->category) ? $model->primary_email->category->value : "" ?>
                    <?php endif; ?>
                </span>
            </td>
            <td>
                <div class="transaction-buttons-cont">
                    <a class="button send" href="#" title="Send Email"></a>
                </div>
            </td>
        </tr>
        <?php if($model->primary_phone): ?>
        <tr class="align-top">
            <td><?= Yii::t('Personal', 'Phone') ?></td>
            <td>
                <span class="strong">+<?= chunk_split($model->primary_phone->phone, 3) ?></span>
                <span class="note"><?= ($model->primary_phone->category) ? $model->primary_phone->category->value : "" ?></span>
            </td>
            <td>
            </td>
        </tr>
        <?php endif; ?>
        <?php if($model->primary_address): ?>
            <tr class="align-top">
                <td><?= Yii::t('Personal', 'Adress') ?></td>
                <td>
                    <span class="strong">
                        <?= $model->primary_address->getAddressHtml() ?>
                    </span>
                    <span class="note"><?= ($model->primary_address->category) ? $model->primary_address->category->value : ""?></span>
                </td>
                <td>


                </td>
            </tr>
        <?php endif; ?>
    </table>
</div>