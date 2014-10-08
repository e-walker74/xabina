<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 30.09.14
 * Time: 15:45
 */ ?>

<div class="modal fade" id="<?= $htmlID ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="xabina-modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="/css/layout/account/img/close.png"></button>
            <h3 id="myModalLabel"><?= Yii::t('Category', 'Link category'); ?></h3>
        </div>
        <div class="modal-body">
            <div class="change_dialog_block">
                <div class="select-custom account-select">
                    <span class="select-custom-label" rel="addBuhModal"></span>
                    <select name="" class="select-invisible change_modal_select">
                        <option value="addBuhModal">
                            <?= Yii::t('Linking', 'Linked Category') ?>
                        </option>
                        <option value="linkNewMemoModal">
                            <?= Yii::t('Linking', 'Memo') ?>
                        </option>
                        <option value="addLinkModal">
                            <?= Yii::t('Linking', 'Linked Contact') ?>
                        </option>
                        <option value="addTranModal">
                            <?= Yii::t('Linking', 'Linked Transactions') ?>
                        </option>
                        <option value="addNewFileModal">
                            <?= Yii::t('Linking', 'Linked Files') ?>
                        </option>
                    </select>
                </div>
            </div>
            <div class="xabina-form-container">
                <div class="form-lbl">
                    <?= Yii::t('Category', 'Category') ?> <span class="tooltip-icon" title="<?= Yii::t('Category', 'popup_category_tooltip') ?>"></span>
                </div>
                <div class="form-block">
                    <input class="add-input pull-left search-input-category" type="text">
                    <a href="#" onclick="return WLinkCategory.showCreateCategoryRow(this)" class="rounded-buttons pull-right add-new"><?= Yii::t('Category', 'ADD NEW') ?></a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <form action="<?= Yii::app()->createUrl('/category/link', array('entity' => $entity, 'entity_id' => $entity_id)) ?>">
            <div class="messages-list-table-overflow">
                <table class="table messages-list-table wcategory-table">
                    <tr class="add-tr xabina-form-container add-new-category-row" style="display: none;" data-url="<?= Yii::app()->createUrl('/category/create', array(
                        'entity' => $entity,
                        'entity_id' => $entity_id
                    )) ?>">
                        <td class="new-checkbox-td"></td>
                        <td class="name_td" style="overflow: visible!important;">
                            <div class="form-lbl margin-left">
                                Cчет <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                            </div>
                            <div class="margin-left">
                                <input type="text" class="add-input short-input" value="" />
                                <div class="error-message"><?= Yii::t('Category', 'name_can_not_be_blank') ?></div>
                            </div>
                        </td>
                        <td class="value_td">
                            <div class="form-lbl">
                                Description <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                            </div>
                            <div>
                                <input type="text"  class="add-input long-input" value="" />
                            </div>
                        </td>
                        <td class="button_td" style="overflow: visible!important;">
                            <div class="transaction-buttons-cont">
                                <a href="#" class="button ok" onclick="return WLinkCategory.createCategory(this)"></a>
                                <a href="#" class="button remove" onclick="return WLinkCategory.cancel(this)"></a>
                            </div>
                        </td>
                    </tr>
                    <?php $this->renderCategoriesGridInPopup() ?>
                </table>
            </div>
            <div class="submit_block">
                <input onclick="return WLinkCategory.link(this)" class="rounded-buttons submit pull-left" type="submit" value="<?= Yii::t('Category', 'Submit') ?>">
                <div class="clearfix"></div>
            </div>
            </form>
        </div>
    </div>
</div>