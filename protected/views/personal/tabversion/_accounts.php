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
            <th style="width: 26%"><?= Yii::t('Personal', 'Account') ?></th>
            <th style="width: 14%"><?= Yii::t('Personal', 'Type') ?></th>
            <th style="width: 14%"><?= Yii::t('Personal', 'Environment') ?></th>
            <th style="width: 10%"><?= Yii::t('Personal', 'Сurrency') ?></th>
            <th style="width: 10%"><?= Yii::t('Personal', 'Status') ?></th>
            <th style="width: 18%"></th>
            <th style="width: 8%"></th>
        </tr>
        <?php foreach($model->accounts as $account): ?>
            <tr>
                <td>
                    <?= $model->first_name ?> <?= $model->last_name ?><br>
                    <span class="bold"><?= chunk_split($account->number, 4) ?></span> <br>
<!--                    <span class="grey">--><?//= ($account->category) ? $account->category->title : "" ?><!--</span>-->
                </td>
                <td><?= $account->type_info->title ?></td>
                <td>BlauStein</td>
                <td><?= $account->currency->title ?></td>
                <td><img src="/css/layout/account/img/statuses-ico-ok.png" alt=""></td>
                <td><span class="bold">Primary</span></td>
                <td style="overflow: visible!important">
                    <div class="contact-actions transaction-buttons-cont">
                        <div class="btn-group">
                            <a class="button menu" data-toggle="dropdown" href="#"></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="button edit" href="edit_contact.html"></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="7" class="add-new-td">
                <a href="#" class="rounded-buttons add-more upload">Add new</a>
            </td>
        </tr>
    </table>
</div>