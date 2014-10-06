<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 04.10.14
 * Time: 21:11
 * @var Transactions[] $transactions
 */ ?>

<div class="transaction-table-overflow no-overflow">
<table class="table  right-button-clickable">
<tbody><tr class="transaction-header">
    <th style="width: 16%;"><?= Yii::t('Transactions', 'Date/Type') ?></th>
    <th style="width: 24%;"><?= Yii::t('Transactions', 'From') ?></th>
    <th style="width: 24%;"><?= Yii::t('Transactions', 'To') ?></th>
    <th style="width: 22%;" class="text-right"><?= Yii::t('Transactions', 'Value') ?></th>
    <th style="width: 5%;"></th>
    <th style="width: 9%;">
<!--        <div class="relative pull-right  transaction-buttons-cont">-->
<!--            <div class="btn-group">-->
<!--                <a href="#" class="button download" data-toggle="dropdown"></a>-->
<!--                <ul class="dropdown-menu">-->
<!--                    <li>-->
<!--                        <a class="button pdf" href="#"></a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="button xls" href="#"></a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="button doc" href="#"></a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="button csv" href="#"></a>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>-->
    </th>
</tr>
<?php foreach($transactions as $trans): ?>
    <tr>
        <td>
            <?= date('d.m.Y', $trans->created_at) ?>
    <div class="grey">OV</div>
            <a href="<?= Yii::app()->createUrl('/accounts/transaction', array('id' => $trans->url)) ?>" class="right-click-shadow"></a>
        </td>
        <td>
            <strong class="holder"><?= $trans->info->sender ?></strong><br>
            <span class="account"><?= $trans->info->sender_description ?></span>
            <a href="<?= Yii::app()->createUrl('/accounts/transaction', array('id' => $trans->url)) ?>" class="right-click-shadow"></a>
        </td>
        <td>
            <strong class="holder"><?= $trans->info->recipient ?></strong><br>
            <span class="account"><?= $trans->info->recipient_description ?></span>
            <a href="<?= Yii::app()->createUrl('/accounts/transaction', array('id' => $trans->url)) ?>" class="right-click-shadow"></a>
        </td>
        <td class="text-right">
            <?php if($trans->type == 'positive'): ?>
                <span class="sum-inc">+<?= number_format($trans->amount, 2, '.', ' ') ?></span> <?= $trans->account->currency->title ?>
            <?php else: ?>
                <span class="sum-dec">-<?= number_format($trans->amount, 2, '.', ' ') ?></span> <?= $trans->account->currency->title ?>
            <?php endif; ?>
            <a href="<?= Yii::app()->createUrl('/accounts/transaction', array('id' => $trans->url)) ?>" class="right-click-shadow"></a>
        </td>
        <td>
            <?= AccountService::getTransactionStatus($trans->status) ?>
        </td>
        <td style="overflow: visible!important">
<!--            <div class="contact-actions transaction-buttons-cont">-->
<!--                <div class="btn-group">-->
<!--                    <a class="button menu" data-toggle="dropdown" href="#"></a>-->
<!--                    <ul class="dropdown-menu">-->
<!--                        <li>-->
<!--                            <a class="button edit" href="edit_contact.html"></a>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <a class="button back" href="#"></a>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <a class="button book" href="#"></a>-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                </div>-->
<!--            </div>-->
        </td>
    </tr>
    <?php if($trans->info->details_of_payment): ?>
    <tr class="note-tr">
        <td colspan="6">
            <div class="note-cont">
                <?= $trans->info->details_of_payment ?>
<!--    <a class="more-link" href="#">More</a>-->
            </div>
        </td>
    </tr>
    <?php endif; ?>
<?php endforeach; ?>
</tbody></table>
</div>