<div class="col-lg-9 col-md-9 col-sm-9">
    <div class="xabina-form-container">
        <div class="h1-header">
            <?=Yii::t('Front', 'Favorite Payment Instuments')?>
        </div>
        <table class="xabina-table table middle">
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
            }?>
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
        <script language="JavaScript"><!--
            $('#add-new-payment-instrument').click(function() {
                hideEditForm();
                $('.add-new-form').css('display', 'table-row');
                $('#add-more').css('display', 'none');
                return false;
            });
            $('.add-new-form .button.cancel').click(function() {
                hideAddNewForm();
                return false;
            });
            var editButtonEnable = function() {
                $('.button.edit').click(function() {
                    hideEditForm();
                    hideAddNewForm();
                    var tr = $(this).parents('tr');
                    tr.next('tr').toggle('slow');
                    tr.hide()
                    return false;
                });
            };
            editButtonEnable();
            $('.edit-payment-tr .button.cancel').click(function() {
                hideEditForm();
                return false;
            });
            var hideAddNewForm = function() {
                $('.add-new-form').css('display', 'none');
                $('#add-more').css('display', 'table-row');
            };
            var hideEditForm = function() {
                $('.edit-payment-tr').hide();
                $('.edit-payment-tr').prev('tr').show('slow');
            };
        //--></script>
    </div>
</div>
<?php 
$cs = Yii::app()->clientScript;
$cs->registerScriptFile('/js/paymentInstruments.js');
$cs->registerScriptFile('/js/deleteButton.js');
$cs->registerScript('deleteButton', 'deleteButtonEnable();');


