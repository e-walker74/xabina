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
            <?= Yii::t('Front', 'Contact'); ?>
        </div>
        <table class="extract-info-table">
            <tr>
                <td class="headers pdf-td-width-17"><?= Yii::t('Front', 'Full Name'); ?>:</td>
                <td class="pdf-td-width-35"><?= $model->fullname ?></td>
                <td class="headers pdf-td-width-13"><?= Yii::t('Front', 'Name'); ?>:</td>
                <td class="pdf-td-width-35"><?= $model->getNameWithCompany(); ?></td>
            </tr>
        </table>
        <?php if($accounts = $model->getDataByType('account')): ?>
            <table class="pdf-table">
            <tr>
                <th width="30%"><?= Yii::t('Front', 'Account Number') ?></th>
                <th width="70%"><?= Yii::t('Front', 'Type'); ?></th>
            </tr>
            <?php foreach($accounts as $acc): ?>
                <tr>
                        <td width="30%"><?= $acc->account_number ?></td>
                        <td width="70%"><?= Yii::t('Front', Users_Contacts_Data_Account::$contacts_account_types[$acc->account_type]) ?></td>
                </tr>
            <?php endforeach; ?>
            </table>
        <?php endif; ?>
        <?php if($emails = $model->getDataByType('email')): ?>
        <table class="pdf-table">
            <tr>
                <th width="30%"><?= Yii::t('Front', 'Email') ?></th>
                <th width="70%"><?= Yii::t('Front', 'Category'); ?></th>
            </tr>
            <?php if($model->xabina_id): ?>
            <tr>
                <td width="30%"><?= $model->xabina_id ?>@xabina.com</td>
                <td width="70%"><?= Yii::t('Front', 'System Email'); ?></td>
            </tr>
            <?php endif; ?>
            <?php foreach($emails as $email): ?>
                <tr>
                    <td width="30%"><?= $email->email ?></td>
                    <td width="70%"><?= ($email->getDbModel()->category) ? $email->getDbModel()->category->value : '' ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
        <?php if($phones = $model->getDataByType('phone')): ?>
        <table class="pdf-table">
            <tr>
                <th width="30%"><?= Yii::t('Front', 'Phone') ?></th>
                <th width="70%"><?= Yii::t('Front', 'Category'); ?></th>
            </tr>
            <?php foreach($phones as $phone): ?>
                <tr>
                    <td width="30%"><?= chunk_split($phone->phone, 3) ?></td>
                    <td width="70%"><?= ($phone->getDbModel()->category) ? $phone->getDbModel()->category->value : '' ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
        <?php if($addresses = $model->getDataByType('address')): ?>
            <table class="pdf-table">
                <tr>
                    <th width="100%"><?= Yii::t('Front', 'Address') ?></th>
                </tr>
                <?php foreach($addresses as $address): ?>
                    <tr>
                        <td width="100%"><?= $address->getAddressHtml() ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>

    </div>
    
</div>
</body>
</html>