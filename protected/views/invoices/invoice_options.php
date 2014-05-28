<table class="custom-options invoice-options-block">
        <tr>
            <th>
                <div class="field-lbl">
                <?= $model->getAttributeLabel('name') ?>
<span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                </div>
            </th>
            <th>
                <div class="field-lbl">
                    <?= $model->getAttributeLabel('quantity') ?>
                    <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                </div>
            </th>
            <th class="text-right">
                <div class="field-lbl">
Amount
                </div>
            </th>
        </tr>
        <tr>
            <td width="48%">
                <div class="field-input">
                    <div class="relative">
                        <?= CHtml::activeTextField($model,"[$_GET[_]]name", array ('class' => 'input-text')); ?>
                    </div>
                </div>
            </td>
            <td width="27%">
                <div class="field-input">
                    <div class="relative">
                        <?= CHtml::activeTextField($model,"[$_GET[_]]quantity", array ('class' => 'input-text invoice-option-quantity-input invoice-only-float', 'value' => 1)); ?>
                    </div>
                </div>
            </td>
            <td width="25%" class="text-right">
                <div class="field-lbl">
<span class="invoice-item-amount-block">0</span><br>
                   <span class="invoice-current-currency-block"></span>
                    </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="field-lbl">
                <?= $model->getAttributeLabel('price') ?>
<span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                </div>
                <div class="field-input">
                    <div class="relative">
                        <?= CHtml::activeTextField($model,"[$_GET[_]]price", array ('class' => 'input-text invoice-option-price-input invoice-only-float', 'value' => 0)); ?>
                    </div>
                </div>
            </td>
            <td>
                <div class="field-lbl">
                    <?= $model->getAttributeLabel('tax') ?>
                    <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                </div>
                <div class="field-input">
                    <div class="field-input">
                        <div class="invoice-option-tax-input-percent">%</div>
                        <?= CHtml::activeTextField($model,"[$_GET[_]]tax", array ('class' => 'input-text invoice-option-tax-input invoice-only-float', 'value' => 0)); ?>
                    </div>
                </div>
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="field-lbl">
                    <?= $model->getAttributeLabel('description') ?>  <span class="grey">(optional)</span>
                    <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                </div>
                <div class="field-input">
                    <div class="relative">
                        <?= CHtml::activeTextField($model,"[$_GET[_]]description", array ('class' => 'input-text')); ?>
                    </div>
                </div>
            </td>
            <td></td>
        </tr>
    </table>

