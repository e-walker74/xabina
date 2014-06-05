<tr>
    <td>
        <?php if (!empty($paymentInstrument->card_type) && isset(Transfers_Incoming::$card_types[$paymentInstrument->card_type])) {?>
            <img src="/images/<?=Transfers_Incoming::$card_types[$paymentInstrument->card_type]?>.png">
        <?php }?>
    </td>
    <td><span class="grey"><?=$paymentInstrument->from_account_number?></span></td>
    <td><span class="approved"><?=$paymentInstrument->htmlStatus?></span></td>
    <td>
        <div class="transaction-buttons-cont">
            <a class="button share" href="#"></a>
            <a class="button edit" href="#"></a>
            <a class="button delete" href="#"></a>
        </div>
    </td>
</tr>