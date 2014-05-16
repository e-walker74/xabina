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
            </div>
            <table class="extract-info-table">
                <tr>
                    <td class="headers pdf-td-width-17"><?= Yii::t('Front', 'Client'); ?>:</td>
                    <td><?= $user->fullname ?></td>
                </tr>
                <tr>
                    <td class="headers pdf-td-width-17"><?= Yii::t('Front', 'Address'); ?>:</td>
                    <td><?= $user->primary_address ? $user->primary_address->addressHtml : '';?></td>
                </tr>
                <tr>
                    <td class="headers pdf-td-width-17"><?= Yii::t('Front', 'Reg #'); ?>:</td>
                    <td>2546897</td>
                </tr>
                <tr>
                    <td class="headers pdf-td-width-17"><?= Yii::t('Front', 'Account number IBAN'); ?>:</td>
                    <td>254897546212ОР</td>
                </tr>
            </table>
            <table class="pdf-table">
                <tr>
                    <th class="detail" colspan="2"><?= Yii::t('Front', 'Indepland - Details overschrijving');?></th>
                </tr>
                <?php foreach($trans->info->getPublicAttrs() as $label => $value): ?>
                    <tr>
                        <td class="detail" width="20%"><?= $label ?></td>
                        <td width="80%"><?= $value ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <div class="push"></div>
    </div>
</div>
</body>
</html>