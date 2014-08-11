<div class=" xabina-form-normal">
    <div class="status-legend" style="margin:0 0 10px; font-size: 100%">
        <span><img src="/css/layout/account/img/statuses-ico-ok.png" alt=""/> - <?= Yii::t('Personal', 'Approved') ?></span>
        <span><img src="/css/layout/account/img/statuses-ico-pen.png" alt=""/> - <?= Yii::t('Personal', 'Pending') ?></span>
        <span><img src="/css/layout/account/img/statuses-ico-rej.png" alt=""/> - <?= Yii::t('Personal', 'Rejected') ?></span>
    </div>
    <table class="table xabina-table-contacts payment-instruments">
        <tr class="table-header">
            <th style="width: 15%"><?=Yii::t('Front', 'Method')?></th>
            <th style="width: 35%"><?=Yii::t('Front', 'Account')?></th>
            <th style="width: 10%" class="text-center"><?=Yii::t('Front', 'Verified')?></th>
            <th style="width: 18%"><?=Yii::t('Front', 'Status')?></th>
            <th style="width: 22%"></th>
        </tr>
        <?php foreach ($paymentInstruments as $paymentInstrument) {
            $this->renderPartial('paymentInstuments/row', Array(
                'model'=>$paymentInstrument,
                'data_categories' => $data_categories
            ));
        } ?>
        <tr class="data-row">
            <td colspan="5" class="table-form-subheader">
                <a href="javaScript:void(0)" id="add-new-payment-instrument" class="rounded-buttons upload add-more"><?= Yii::t('Front', 'ADD NEW'); ?></a>
            </td>
        </tr>
        <tr class="edit-row">
            <td colspan="5">
                <div class="table-subheader"><?= Yii::t('Personal', 'Add new payments method') ?></div>
                <?php $this->renderPartial('paymentInstuments/_form', Array(
                    'method'=>'create',
                    'model'=>new Users_Paymentinstruments,
                    'data_categories' => $data_categories,
                )); ?>
            </td>
        </tr>
    </table>
<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile('/js/paymentInstruments.js');
?>
<script>
    Personal.bindPayments()
</script>
</div>


