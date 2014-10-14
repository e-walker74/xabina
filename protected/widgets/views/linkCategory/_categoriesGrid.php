<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 30.09.14
 * Time: 22:05
 */ ?>
<?php $categories = $this->getCategories($entity_id, $entity); ?>
<?php foreach($model as $category): ?>
    <?php if(isset($categories[$category->id])) continue; ?>
    <tr class="wcategory-row">
        <td class="new-checkbox-td">
            <label class="modal-galka-checkbox">
                <input name="categories[]" value="<?= $category->id ?>" type="checkbox"/>
            </label>
        </td>
        <td onclick="CrossLinks.clickCheckbox(this)" class="name_td drive-search-text"><?= $category->title ?></td>
        <td onclick="CrossLinks.clickCheckbox(this)" class="value_td drive-search-text"><?= $category->description ?></td>
        <td class="button_td" style="overflow: visible!important;">
            <div class="transaction-buttons-cont book">
                <!--                                    <a href="#" class="book_button"></a>-->
            </div>
        </td>
    </tr>
<?php endforeach; ?>