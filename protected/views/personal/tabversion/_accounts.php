<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 01.08.14
 * Time: 12:56
 * @param Users $model
 */ ?>

<div class=" xabina-form-normal">
    <div class="status-legend" style="margin:0 0 10px; font-size: 100%">
        <span><img src="/css/layout/account/img/statuses-ico-ok.png" alt=""/> - <?= Yii::t('Personal', 'Approved') ?></span>
        <span><img src="/css/layout/account/img/statuses-ico-pen.png" alt=""/> - <?= Yii::t('Personal', 'Pending') ?></span>
        <span><img src="/css/layout/account/img/statuses-ico-rej.png" alt=""/> - <?= Yii::t('Personal', 'Rejected') ?></span>
    </div>
    <table class="table  xabina-table-contacts">
        <tr class="table-header">
            <th style="width: 21%"><?= Yii::t('Personal', 'Account') ?></th>
            <th style="width: 15%"><?= Yii::t('Personal', 'Type') ?></th>
            <th style="width: 15%"><?= Yii::t('Personal', 'Environment') ?></th>
            <th style="width: 18%"><?= Yii::t('Personal', 'Amount') ?></th>
            <th style="width: 11%"><?= Yii::t('Personal', 'Сurrency') ?></th>
            <th style="width: 12%"><?= Yii::t('Personal', 'Status') ?></th>
            <th style="width: 8%"></th>
        </tr>
        <?php foreach($model->accounts as $account): ?>
            <tr>
                <td>
                    <?= $model->first_name ?> <?= $model->last_name ?><br>
                    <span class="bold"><?= chunk_split($account->number, 4) ?></span> <br>
                    <span class="grey"><?= $account->name ?></span>
                </td>
                <td><?= $account->type_info->title ?></td>
                <td><?= Yii::t('Front', 'Main Environment') ?></td>
                <td class="text-right">
                    <?php if($account->balance > 0): ?>
                        <span class="approved"><?= number_format($account->balance, 2) ?></span>
                    <?php elseif($account->balance < 0): ?>
                        <span class="rejected"><?= number_format($account->balance, 2) ?></span>
                    <?php else: ?>
                        <span class=""><?= $account->balance ?></span>
                    <?php endif; ?>
                </td>
                <td><?= $account->currency->title ?></td>
                <td class="status-td">
                    <img src="/css/layout/account/img/statuses-ico-ok.png" alt="">
                    <a <?php if($account->is_master == 1):?>style="display:none;"<?php endif; ?> title="<?= Yii::t('Personal', 'Make primary') ?>" class="tooltip-icon primary-button m-primary" href="javaScript:void(0)" onclick="js:Personal.makePrimary('<?= Yii::app()->createUrl('/personal/makePrimary', array('type' => 'accounts', 'id' => $account->id)) ?>', this)"></a>
                    <span title="<?= Yii::t('Personal', 'Primary') ?>" <?php if($account->is_master == 0):?>style="display:none;"<?php endif; ?> class="tooltip-icon primary-button is-primary" alt="<?= Yii::t('Front', 'Primary') ?>"></span>
                </td>
                <td style="overflow: visible!important">
                    <div class="contact-actions transaction-buttons-cont">
                        <?= Html::link('', array('/banking/accounts'), array('class' => 'button edit', 'title' => Yii::t('Front', 'Edit'))) ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
<!--        <tr>-->
<!--            <td colspan="7" class="add-new-td">-->
<!--                <a href="#" class="rounded-buttons add-more upload">Add new</a>-->
<!--            </td>-->
<!--        </tr>-->
    </table>
</div>