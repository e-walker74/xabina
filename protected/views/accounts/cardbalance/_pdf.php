<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
</head>
<body>
<div class="pdf-wrapper">
    <div class="content-wrapper">
    <div class="pdf-header">
        <div class="pdf-logo"></div>
        <div class="pdf-contacts">
            Xabina/Stadsring 99 <br>
            3811 HP Amersfoort/The Netherlands <br>
            Telephone: +31 880 200 200    Fax: +31 880 200 100 <br>
            Company Registration Number: 32168526 <br>
        </div>
    </div>
    <div class="pdf-content">
        <div class="extract-header">
            <?= Yii::t('Front', 'Account Statement'); ?>
            <div class="extract-period"><?= Yii::t('Front', 'Period'); ?>: <?= date('d M Y', strtotime($model->from_date)); ?> - <?= ($model->to_date) ? date('d M Y', strtotime($model->to_date)) : date('d M Y', time()) ?></div>
        </div>
        <table class="extract-info-table">
            <tr>
                <td width="20%" class="headers"><?= Yii::t('Front', 'Client'); ?>:</td>
                <td width="80%"><?= $user->fullname ?></td>
            </tr>
            <!--<tr>
                <td class="headers"><?= Yii::t('Front', 'Address'); ?>:</td>
                <td>Square des Places 1, 1700 Fribourg, Switzerland</td>
            </tr>
            <tr>
                <td class="headers"><?= Yii::t('Front', 'Reg #'); ?>:</td>
                <td>2546897</td>
            </tr>
            <tr>
                <td class="headers"><?= Yii::t('Front', 'Account number IBAN'); ?>:</td>
                <td>254897546212ОР</td>
            </tr>-->
        </table>
        <table class="pdf-table">
            <tr>
                <th width="13%"><?= Yii::t('Front', 'Currency'); ?></th>
                <th width="22%"><?= Yii::t('Front', 'Balance at the starting date'); ?></th>
                <th width="20%"><?= Yii::t('Front', 'Balance at the ending date'); ?></th>
                <th width="23%"><?= Yii::t('Front', 'Credit turnover'); ?></th>
                <th width="20%"><?= Yii::t('Front', 'Debit turnover'); ?></th>
            </tr>
            <tr>
			<?php if(!empty($transactions)): ?>
                <td><?= current($transactions)->account->currency->code ?></td>
                <td><?= number_format(current($transactions)->acc_balance - current($transactions)->sum, 2, ".", " ") ?></td>
                <td><?= number_format(end($transactions)->acc_balance, 2, ".", " ") ?></td>
                <td><span class="inc"><?= number_format($credit, 2, ".", " ") ?></span></td>
                <td><span class="dec"><?= number_format($debit, 2, ".", " ") ?></span></td>
			<?php else: ?>
				<td colspan="5"><?= Yii::t('Front', 'No data meets the filter criterias'); ?></td>
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
                <td><?= date('d.m.Y', strtotime($trans->created_at)) ?></td>
                <td><?= $trans->info->type ?></td>
                <td>
                    <strong><?= $trans->info->sender ?></strong> <br>
                    <?= $trans->info->details_of_payment ?>
                </td>
                <td><span class="inc"><?= number_format($trans->sum, 2, ".", " ") ?></span> &nbsp; <?= $trans->account->currency->code ?></td>
                <td><?= number_format($trans->acc_balance, 2, ".", " ") ?></td>
            </tr>
			<?php endforeach; ?>
			<?php if(empty($transactions)): ?>
			<tr>			
				<td colspan="5"><?= Yii::t('Front', 'No transactions meet the filter criterias'); ?></td>
			</tr>
			<?php endif; ?>
        </table>

    </div>
        <div class="push"></div>
    </div>
    
</div>
</body>
</html>