<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
</head>
<body>
<div class="pdf-wrapper">
    <div class="content-wrapper">
    <div class="pdf-content">
        <div class="extract-header">
            <?= Yii::t('Front', 'Account Statement'); ?>
        </div>
        <table class="extract-info-table">
            <tr>
                <td class="headers pdf-td-width-17"><?= Yii::t('Front', 'Client'); ?>:</td>
                <td class="pdf-td-width-35"><?= $user->fullname ?></td>
                <td class="headers pdf-td-width-13"><?= Yii::t('Front', 'Period'); ?>:</td>
                <td class="pdf-td-width-35"><?= date('d M', strtotime($model->from_date)); ?> - <?= ($model->to_date) ? date('d M Y', strtotime($model->to_date)) : date('d M Y', time()) ?></td>
            </tr>
            <tr>
                <td class="headers pdf-td-width-17"><?= Yii::t('Front', 'Address'); ?>:</td>
                <td class="pdf-td-width-35"><?= $user->primary_address ? $user->primary_address->addressHtml : '';?></td>
                <td class="headers pdf-td-width-13"><?= Yii::t('Front', 'Transactions'); ?>:</td>
                <td class="pdf-td-width-35"><?= $model->type ? Yii::t('Front', ucfirst($model->type)) : Yii::t('Front', 'All') ; ?></td>
            </tr>
            <tr>
                <td class="headers pdf-td-width-17"><?= Yii::t('Front', 'Reg #'); ?>:</td>
                <td class="pdf-td-width-35">2546897</td>
                <?php if($model->from_sum != '' || $model->to_sum != ''): ?>
                    <td class="headers pdf-td-width-13"><?= Yii::t('Front', 'Sum'); ?>:</td>
                    <td class="pdf-td-width-35">
                        <?php if($model->from_sum != ''): ?><?= Yii::t('Front', 'from'); ?> <?= $model->from_sum ; ?><?php endif; ?>
                        <?php if($model->to_sum != ''): ?><?= Yii::t('Front', 'to'); ?> <?= $model->to_sum ; ?><?php endif; ?>
                         EUR
                    </td>
                <?php endif; ?>
            </tr>
            <tr>
                <td class="headers pdf-td-width-17"><?= Yii::t('Front', 'Account number IBAN'); ?>:</td>
                <td class="pdf-td-width-35">254897546212ОР</td>
                <?php if($model->keyword != ''): ?>
                    <td class="headers pdf-td-width-13"><?= Yii::t('Front', 'Keyword'); ?>:</td>
                    <td class="pdf-td-width-35"><?= $model->keyword; ?></td>
                <?php endif; ?>
            </tr>
        </table>
        <table class="pdf-table">
            <tr>
                <th width="13%"><?= Yii::t('Front', 'Currency'); ?></th>
                <th width="22%"><?= Yii::t('Front', 'Balance at the starting date'); ?></th>
                <th width="20%"><?= Yii::t('Front', 'Balance at the ending date'); ?></th>
                <th width="23%"><?= Yii::t('Front', 'Credit turnover'); ?></th>
                <th width="20%"><?= Yii::t('Front', 'Debit turnover'); ?></th>
            </tr>
            <tr class="text-center">
			<?php if(!empty($transactions)): ?>
                <td><?= current($transactions)->account->currency->code ?></td>
                <td><?= number_format(current($transactions)->acc_balance - current($transactions)->sum, 2, ".", " ") ?></td>
                <td><?= number_format(end($transactions)->acc_balance, 2, ".", " ") ?></td>
                <td><span class="inc"><?= number_format($credit, 2, ".", " ") ?></span></td>
                <td><span class="dec"><?= number_format($debit, 2, ".", " ") ?></span></td>
			<?php else: ?>
                <td><?= $account->currency->code ?></td>
                <td><?= number_format($account->transactions[0]->acc_balance, 2, ".", " ") ?></td>
                <td><?= number_format($account->transactions[0]->acc_balance, 2, ".", " ") ?></td>
                <td class="inc"><?= number_format($credit, 2, ".", " ") ?></td>
                <td class="dec"><?= number_format($debit, 2, ".", " ") ?></td>
			<?php endif; ?>
            </tr>
        </table>
        <table class="pdf-table">
            <tr>
                <th width="13%"><?= Yii::t('Front', 'Date'); ?></th>
                <th width="8%"><?= Yii::t('Front', 'Type'); ?></th>
                <th width="46%"><?= Yii::t('Front', 'Details'); ?></th>
                <th width="17%"><?= Yii::t('Front', 'Sum'); ?></th>
                <th width="16%"><?= Yii::t('Front', 'Balance'); ?></th>
            </tr>
			<?php foreach($transactions as $trans): ?>
			<tr>
                <td><?= date('d.m.Y', $trans->created_at) ?></td>
                <td><?= $trans->info->type ?></td>
                <td>
                    <strong><?= ($trans->type == 'positive') ? $trans->info->sender : $trans->info->recipient ?></strong> <br>
                    <?= $trans->info->details_of_payment ?>
                </td>
                <td class="nowrap">
                    <?php
                    if($trans->type == 'positive')
                        $class = 'inc';
                    else
                        $class = 'dec';
                    ?>
                    <span class="<?=$class;?>"><?= ($trans->type == 'negative') ? "-" : "" ?><?= number_format($trans->sum, 2, ".", " ") ?></span> <?=$trans->account->currency->code; ?>
                </td>
                <td>
                    <?= number_format($trans->acc_balance, 2, ".", " ") ?>
                </td>
            </tr>
			<?php endforeach; ?>
        </table>

    </div>

    </div>
    
</div>
</body>
</html>