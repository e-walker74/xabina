<div class="col-lg-9 col-md-9 col-sm-9">
    <div class="xabina-form-container">
        <div class="h1-header">
            <?= Yii::t('Front', 'Favorite Payment Instuments'); ?>
        </div>
        <table class="table xabina-table middle">
            <tr class="table-header">
                <th><?=Yii::t('Front', 'Method')?></th>
                <th><?=Yii::t('Front', 'Account')?></th>
                <th><?=Yii::t('Front', 'Status')?></th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach ($paymentInstruments as $paymentInstrument) {?>
                <tr>
                    <td>
                        <?php if (!empty($paymentInstrument->card_type) && isset(Transfers_Incoming::$card_types[$paymentInstrument->card_type])) {?>
                            <img src="/images/<?=Transfers_Incoming::$card_types[$paymentInstrument->card_type]?>.png">
                        <?php }?>
                    </td>
                    <td><span class="grey"><?=$paymentInstrument->from_account_number?></span></td>
                    <td><span class="approved"><?=PaymentService::getHtmlStatus($paymentInstrument->status)?></span></td>
                    <td>
                        <div class="transaction-buttons-cont">
                            <a class="button share" href="#"></a>
                            <a class="button edit" href="#"></a>
                            <a class="button delete" href="#"></a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <div class="form-submit">
            <a href="/personal/addPaymentInstument" class="rounded-buttons upload add-more">ADD NEW</a>
        </div>
    </div>
</div>
