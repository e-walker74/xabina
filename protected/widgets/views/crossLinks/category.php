<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 01.10.14
 * Time: 17:59
 * @var WCrossLink $this
 */
?>
<div class="category-block">
    <span class="change_dropdown"><?= $cat ?></span>
    <div class="edit_select" style="display: none;">
        <span class="save_but" onclick="CrossLinks.changeCategory(this)" data-url="<?= Yii::app()->createUrl('/ajax/crosscategory', array('cross_id' => $cross_id)) ?>"></span>

        <div class="select-custom account-select">
            <span class="select">
                <span class="select-custom-label"></span>
                <?= CHtml::dropDownList(
                    'cross_category',
                    $cat_id,
                    CHtml::listData($this->getCategories(), 'id', 'value') + array('other' => Yii::t('Front', 'Other')),
                    array(
                        'class' => 'select-invisible select-category'
                    )
                ) ?>
            </span>
            <span class="other" style="display: none;">
                <span class="clear-input-content">
                    <input type="text"/>
                <span class="clear-but"></span>
            </span>
            </span>
        </div>
    </div>
</div>