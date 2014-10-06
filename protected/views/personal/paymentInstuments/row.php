<tr class="data-row">
    <td>
        <?php if (
            isset(Form_Incoming_Electronic::$methods[$model->electronic_method])
        &&  Form_Incoming_Electronic::$methods[$model->electronic_method] == 'creditcard'
        &&  !empty($model->card_type) && isset(Transfers_Incoming::$card_types[$model->card_type])):
        ?>
            <img src="/css/images/<?=Transfers_Incoming::$card_types[$model->card_type]?>.png">
        <?php else: ?>
            <img src="/css/images/<?=Users_Paymentinstruments::$logos[$model->electronic_method]?>">
        <?php endif; ?>
    </td>
    <td>
        <span class="bold"><?= $model->from_account_holder ?></span> <br>
        <?php if(isset(Form_Incoming_Electronic::$methods[$model->electronic_method])
            &&  Form_Incoming_Electronic::$methods[$model->electronic_method] == 'creditcard'): ?>
            <span class="grey">xxxx xxxx xxxx <?= substr($model->from_account_number, -4)?></span>
        <?php else: ?>
            <span class="grey"><?= $model->from_account_number ?></span>
        <?php endif; ?>
    </td>
    <td class="text-center">
        <?= $model->getHtmlStatus() ?>
    </td>
    <td class="status-td">
        <div class="pull-left">
            <a <?php if($model->is_master == 1):?>style="display:none;"<?php endif; ?> title="<?= Yii::t('Personal', 'Make primary') ?>" class="tooltip-icon primary-button m-primary" href="javaScript:void(0)" onclick="js:Personal.makePrimary('<?= Yii::app()->createUrl('/personal/makePrimary', array('type' => 'paymentInstruments', 'id' => $model->id)) ?>', this)"></a>
            <span title="<?= Yii::t('Personal', 'Primary') ?>" <?php if($model->is_master == 0):?>style="display:none;"<?php endif; ?> class="tooltip-icon primary-button is-primary" alt="<?= Yii::t('Front', 'Primary') ?>"></span>
        </div>
    </td>
    <td style="overflow: visible!important;">
        <div class="contact-actions transaction-buttons-cont">
            <div class="btn-group with-delete-confirm">
                <a class="button menu" title="<?= Yii::t('Front', 'Options') ?>" data-toggle="dropdown" href="#"></a>
                <ul class="dropdown-menu">
<!--                    <li>-->
<!--                        <a class="button share" title="--><?//= Yii::t('Front', 'Share') ?><!--" href="javaScript:void(0)"></a>-->
<!--                    </li>-->
                    <li>
                        <a href="javaScript:void(0)" title="<?= Yii::t('Front', 'Edit') ?>" class="button edit"></a>
                    </li>
                    <li>
                        <?= Html::link('', 'javaScript:void(0)', array(
                            'class' => 'button delete',
                            'onclick' => '$(this).addClass(\'opened\')',
                            'data-url' => Yii::app()->createUrl('/personal/deletePaymentInstument', array('id' => $model->id)),
                        )) ?>
                    </li>
                </ul>
            </div>
        </div>
    </td>
</tr>
<tr class="edit-row">
    <td colspan="5">
        <?php $this->renderPartial('paymentInstuments/_form', Array(
            'method'=>'update',
            'model'=>$model,
            'data_categories' => $data_categories,
        ));?>
    </td>
</tr>