<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 17.10.14
 * Time: 9:25
 * @var CDataProvider $accounts
 */ ?>

<?php foreach($accounts->getData() as $data){
    $this->renderPartial('_item', array('data' => $data));
}
?>
<li class="totals">
    <div class="text">
        <span><?= Yii::t('Accounts', 'Total') ?>:</span>
    </div>
    <div class="sum">
        <?php if(isset($data)): ?>
            <?= $data->getUserBalanceInEUR() ?>
        <?php else: ?>
            0
        <?php endif; ?>
    </div>
    <div class="currency">
         <span class="dropdown_button  currency_dropdown">EUR<span class="currency_drdn_arr"></span>
         </span>
    </div>
    <div class="clearfix"></div>
</li>

<script>
    $(document).ready(function(){
        changeCurrency();
        if ($('.currency_dropdown').length != 0)
            $('.currency_dropdown').tempDropDown({
                list: {
                    EUR: 'EUR',
                    USD: 'USD',
                    RUB: 'RUB',
                    CHF: 'CHF',
                    JPY: 'JPY'
                },
                listClass: 'currencies_dropdown',
                callback: changeCurrency

            });
    })
</script>