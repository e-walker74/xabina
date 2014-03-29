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
            <tr>
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
            <tr>
                <td><?= current($transactions)->account->currency->code ?></td>
                <td><?= number_format(current($transactions)->acc_balance - current($transactions)->sum, 2, ".", " ") ?></td>
                <td><?= number_format(end($transactions)->acc_balance, 2, ".", " ") ?></td>
                <td><span class="inc">???3 000.00</span></td>
                <td><span class="dec">???5 000.00</span></td>
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
        </table>

    </div>
        <div class="push"></div>
    </div>
    <div class="pdf-footer">
        <table class="footer-info">
            <tr>
                <td width="25%" class="left">LV3834753475457-47157475</td>
                <td width="35%"><?= date('d M Y', strtotime($model->from_date)); ?> - <?= ($model->to_date) ? date('d M Y', strtotime($model->to_date)) : date('d M Y', time()) ?></td>
                <td width="30%"><?= date('d,m,Y H:i:s', time()); ?></td>
                <!--<td width="10%" class="right">1/1</td>-->
            </tr>
        </table>
    </div>
</div>
</body>
</html>