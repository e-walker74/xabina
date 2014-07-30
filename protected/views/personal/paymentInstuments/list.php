<?php if(!Yii::request()->isAjaxRequest): ?>
<div class="col-lg-9 col-md-9 col-sm-9" id="paymentsList">
<?php endif; ?>
    <div class="xabina-form-container">
        <div class="h1-header">
            <?=Yii::t('Front', 'Favorite Payment Instruments')?>
        </div>
        <table class="xabina-table table middle payment-instruments">
            <tr class="table-header">
                <th><?=Yii::t('Front', 'Method')?></th>
                <th><?=Yii::t('Front', 'Account')?></th>
                <th><?=Yii::t('Front', 'Status')?></th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach ($paymentInstruments as $paymentInstrument) {
                $this->renderPartial('paymentInstuments/row', Array(
                    'model'=>$paymentInstrument
                ));
            } ?>
            <tr id="add-more">
                <td colspan="4" class="table-form-subheader">
                    <a href="#" id="add-new-payment-instrument" class="rounded-buttons upload add-more">ADD NEW</a>
                </td>
            </tr>
            <tr class="add-new-form" style="display: none;">
                <td colspan="4" class="table-form-subheader">
                    <div class="table-subheader">Add new favorite payment instument</div>
                </td>
            </tr>
            <tr class="add-new-form" style="display: none;">
                <td colspan="4">
                    <?php $this->renderPartial('paymentInstuments/_form', Array(
                        'method'=>'create',
                        'model'=>new Users_Paymentinstruments
                    )); ?>
                </td>
            </tr>
        </table>
    </div>
<?php if(!Yii::request()->isAjaxRequest): ?>
</div>
<?php endif; ?>
<?php 
$cs = Yii::app()->clientScript;
$cs->registerScriptFile('/js/paymentInstruments.js');


