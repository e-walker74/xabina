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
            <span class="select-custom-label"></span>
            <select name="cross_category" class="select-invisible">
                <?php foreach($this->getCategories() as $category): ?>
                    <option value="<?= $category->id ?>" <?php if($category->id == $cat_id): ?>selected="selected"<?php endif; ?>>
                        <?= $category->value ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>