<div class="from-form" style="overflow: visible">
    <div class="update-about">
        <div class="field-lbl">
            <?=Yii::t('Front', 'Method')?>
            <span class="tooltip-icon" title="<?=Yii::t('Front', 'tooltip_electronic_methods')?>"></span>
        </div>
    </div>
    
    <div class="form-input">
         <span class="select-custom-label"></span>
         <div class="select-custom select-narrow ">
            <span class="select-custom-label"></span>
            <?=$form->dropDownList(
                $model,
                'electronic_method',
                Form_Incoming_Electronic::$methods,
                array(
                'class' => 'select-invisible', 
                'id'=>"{$this->modelName}_electronic_method_{$this->formId}",
                'options' => array($model->electronic_method => array('selected' => true)),
                'empty' => Yii::t('Front', 'Select a method')
                )
            ); ?>
         </div>
    </div>
    <div class="clearfix"></div>
</div>

<div class="method-1 electronic-method-fields" style="<?php if (!isset($model->electronic_method) || $model->electronic_method!=PaymentService::METHOD_CREDITCARD) {?>display:none;<?php } else {?>display:block;<?php }?>">
    <div class="form-line">
        <div class="form-cell">
            <div class="lbl"><?=Yii::t('Front', 'Creditcard holder')?>
                <span class="tooltip-icon" title="<?=Yii::t('Front', 'tooltip_creditcard_holder')?>"></span>
            </div>
            <div class="field-input">
                <?=$form->textField($model, 'creditcard_holder', array(
                    'class' => 'input-text',
                    'value'=>$model->from_account_holder,
                    'style' => 'width:100%'
                ))?>
                <?=$form->error($model, 'creditcard_holder')?>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="form-line" style="margin: 10px 0">
    <div class="form-cell pull-left credit-number" style="width: 42%">
        <div class="lbl"><?=Yii::t('Front', 'Credit Card Number')?>
            <span class="tooltip-icon" title="<?=Yii::t('Front', 'tooltip_creditcard_number')?>"></span>
        </div>
        <div class="field-input">
            <?=$form->textField($model, 'creditcard_number', array(
                'class' => 'input-text',
                'value'=>$model->from_account_number,
                'id'=>"{$this->modelName}_creditcard_number_{$this->formId}",
            ))?>
            <?=$form->error($model, 'creditcard_number')?>
        </div>
    </div>

    <div class="form-cell pull-right" style="width: 27%">
        <div class="lbl"><?=Yii::t('Front', 'CSC')?>
            <span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_creditcard_p_csc') ?>"></span>
        </div>
        <div class="field-input">
            <?=$form->textField($model, 'p_csc', array('class' => 'input-text card-csc')) ?>
            <?=$form->error($model, 'p_csc'); ?>
        </div>
    </div>

    <div class="form-cell pull-right expiration-dates" style="width: 28%">
        <div class="lbl"><?=Yii::t('Front', 'Expiration Date')?>
            <span class="tooltip-icon" title="<?=Yii::t('Front', 'tooltip_creditcard_p_month')?>"></span>
        </div>
        <div class="field-input">
            <div class="select-custom currency-select exp-month">
                <span class="select-custom-label"><?=Yii::t('Front', 'Month')?></span>
                <?=$form->dropDownList(
                    $model,
                    'p_month',
                    array(
                        1 => '01',
                        2 => '02',
                        3 => '03',
                        4 => '04',
                        5 => '05',
                        6 => '06',
                        7 => '07',
                        8 => '08',
                        9 => '09',
                        10 => '10',
                        11 => '11',
                        12 => '12',
                    ),
                    array(
                        'options' => array($model->p_month=>array('selected'=>true)),
                        'class' => 'select-invisible',
                    )
                ); ?>
            </div>
            <span class="exp-delimitter">/</span>
            <div class="select-custom currency-select exp-year">
                <span class="select-custom-label"><?=Yii::t('Front', 'Year')?></span>
                <?php 
                $year = array();
                for ($i = 0, $y = date('Y', time()); $i <= 20; $i++, $y++ ){
                    $year[$y] = $y;
                }
                echo $form->dropDownList(
                    $model,
                    'p_year',
                    $year,
                    array(
                        'class' => 'select-invisible',
                        'options' => array($model->p_year=>array('selected'=>true)),
                    )
                );
                ?>
            </div>
            <?= $form->error($model, 'p_year');?>
            <?= $form->error($model, 'p_month');?>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
    <div class="form-line">
        <div class="form-cell" >
            <div class="lbl"><?= Yii::t('Front', 'Payment Type') ?>
                <span class="tooltip-icon" title="<?= Yii::t('Front', 'Payment Type') ?>"></span>
            </div>
            <div class="field-input">
                <ul class="list-inline payments-list">
                    <li>
                        <label>
                            <input type="radio" name="<?=$this->modelName?>[card_type]" class="master-card" value="<?= array_search('master-card', Transfers_Incoming::$card_types) ?>">
                            <div class="logo master-card active">

                            </div>

                        </label>
                    </li>
                    <li>
                        <label>
                            <input type="radio" name="<?=$this->modelName?>[card_type]" class="jcb" value="<?= array_search('jcb', Transfers_Incoming::$card_types) ?>">
                            <div class="logo jcb ">
                            </div>
                        </label>
                    </li>
                    <li>
                        <label>
                            <input type="radio" name="<?=$this->modelName?>[card_type]" class="union-pay" value="<?= array_search('union-pay', Transfers_Incoming::$card_types) ?>">
                            <div class="logo union-pay ">
                            </div>
                        </label>
                    </li>
                    <li>
                        <label>
                            <input type="radio" name="<?=$this->modelName?>[card_type]" class="maestro" value="<?= array_search('maestro', Transfers_Incoming::$card_types) ?>">
                            <div class="logo maestro ">
                            </div>
                        </label>
                    </li>
                    <li>
                        <label>
                            <input type="radio" name="<?=$this->modelName?>[card_type]" class="visa" value="<?= array_search('visa', Transfers_Incoming::$card_types) ?>">
                            <div class="logo visa ">
                            </div>
                        </label>
                    </li>
                    <li>
                        <label>
                            <input type="radio" name="<?=$this->modelName?>[card_type]" class="american-ecspress" value="<?= array_search('american-ecspress', Transfers_Incoming::$card_types) ?>">
                            <div class="logo american-ecspress ">
                            </div>
                        </label>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="method-2 electronic-method-fields" style="<?php if (!isset($model->electronic_method) || $model->electronic_method!=PaymentService::METHOD_IDEAL) {?>display:none;<?php } else {?>display:block;<?php }?>">
    <div class="from-form">
        <div class="lbl"><?= Yii::t('Front', 'ideal_account_number') ?>
            <span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_ideal_account_number') ?>"></span>
        </div>
        <div class="field-input">
            <?= $form->textField($model, 'ideal_account_number', array('class' => 'input-text')) ?>
            <?= $form->error($model, 'ideal_account_number'); ?>
        </div>
    </div>
</div>