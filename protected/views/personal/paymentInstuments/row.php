<tr class="view-payment-tr">
    <td>
        <?php if (!empty($model->card_type) && isset(Transfers_Incoming::$card_types[$model->card_type])) {?>
            <img src="/images/<?=Transfers_Incoming::$card_types[$model->card_type]?>.png">
        <?php }?>
    </td>
    <td><span class="grey"><?=$model->from_account_number?></span></td>
    <td><span class="approved"><?=$model->htmlStatus?></span></td>
    <td>
        <div class="transaction-buttons-cont">
            <a class="button share" title="share" href="#"></a>
            <a class="button edit" title="edit" href="#"></a>
            <a class="button delete" title="<?php echo Yii::t('Front', 'Are you sure?');?>" data-url="/personal/deletePaymentInstument/<?=$model->id?>"></a>
        </div>
    </td>
</tr>
<tr class="edit-payment-tr" style="display:none;">
    <td colspan="4">
        <?php $this->renderPartial('//personal/paymentInstuments/_form', Array(
            'method'=>'update',
            'model'=>$model
        ));?>
    </td>
</tr>