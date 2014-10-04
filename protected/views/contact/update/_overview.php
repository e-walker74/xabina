<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 23.07.14
 * Time: 20:58
 */ ?>

<table class="table xabina-table-contacts ">
    <tr class="table-header">
        <th style="width: 42%"><?= Yii::t('Front', 'Section') ?></th>
        <th style="width: 49%"><?= Yii::t('Front', 'Description') ?></th>
        <th style="width: 9%"></th>
    </tr>
    <tr class="align-top">
        <td><?= Yii::t('Front', 'Personal Info') ?></td>
        <td>
            <?php if($model->first_name || $model->last_name): ?>
                <?= $model->first_name ?> <?= $model->last_name ?>
                <span class="note"><?= Yii::t('Front', 'First Name / Last Name') ?></span>
            <?php endif; ?>
            <?php if($model->company): ?>
                <?= $model->company ?>
                <span class="note"><?= Yii::t('Front', 'Company') ?></span>
            <?php endif; ?>
            <!--                --><?php //if($model->sex && $model->type == 'personal'): ?>
            <!--                    --><?//= $model->sex ?>
            <!--                    <span class="note">--><?//= Yii::t('Front', 'Sex') ?><!--</span>-->
            <!--                --><?php //endif; ?>
            <?php if($model->xabina_id): ?>
                <?= $model->xabina_id ?>
                <span class="note"><?= Yii::t('Front', 'Xabina User ID') ?></span>
            <?php endif; ?>

        </td>
        <td>
        </td>
    </tr>
    <?php if($account = $model->getDataByType('account', true)): ?>
        <tr class="align-top">
            <td><?= Yii::t('Front', 'Account Number') ?></td>
            <td>
                <span class="strong"><?= $account->account_number ?></span>
                <span class="note">
                    <?php if(isset(Users_Contacts_Data_Account::$contacts_account_types[$account->account_type])): ?>
                        <?= Yii::t('Front', Users_Contacts_Data_Account::$contacts_account_types[$account->account_type]) ?>
                    <?php else: ?>
                        <?= Yii::t('Front', $account->account_type) ?>
                    <?php endif; ?>
            </span>
            </td>
            <td>
                <div class="transaction-buttons-cont">
                    <a class="button card" title="<?= Yii::t('Front', 'New transfer') ?>" href="#"></a>
                </div>
            </td>
        </tr>
    <?php endif; ?>
    <?php if($model->xabina_id): ?>
        <tr class="align-top">
            <td>
                <?= Yii::t('Front', 'E-Mail') ?></td>
            <td>
                <span class="strong"><?= $model->xabina_id ?>@xabina.com</span>
                <span class="note"><?= Yii::t('Front', 'System email') ?></span>
            </td>
            <td>
                <div class="transaction-buttons-cont">
                    <a class="button send" title="<?= Yii::t('Front', 'Send Email') ?>" href="#"></a>
                </div>
            </td>
        </tr>
    <?php elseif($email = $model->getDataByType('email', true)): ?>
        <tr class="align-top">
            <td>
                <?= Yii::t('Front', 'E-Mail') ?></td>
            </td>
            <td>
                <span class="strong"><?= $email->email ?></span>
                <span class="note"><?= ($email->getDbModel()->category) ? $email->getDbModel()->category->value : '' ?></span>
            </td>
            <td>
                <div class="transaction-buttons-cont">
                    <a class="button send" href="#"  title="<?= Yii::t('Front', 'Send Email') ?>"></a>
                </div>
            </td>
        </tr>
    <?php endif; ?>
    <?php if($phone = $model->getDataByType('phone', true)): ?>
        <tr class="align-top">
            <td><?= Yii::t('Front', 'Phone') ?></td>
            <td>
                <span class="strong"><?= chunk_split($phone->phone, 3) ?></span>
                <span class="note"></span>
            </td>
            <td>
            </td>
        </tr>
    <?php endif; ?>
    <?php if($address = $model->getDataByType('address', true)): ?>
        <tr class="align-top">
            <td><?= Yii::t('Front', 'Address') ?></td>
            <td>
                <span class="strong"><?= $address->getAddressHtml() ?></span>
                <span class="note"></span>
            </td>
            <td>
            </td>
        </tr>
    <?php endif; ?>
</table>