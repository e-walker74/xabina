<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 08.10.14
 * Time: 14:11
 */ ?>

<div class="modal fade" id="createContactModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="xabina-modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="/css/layout/account/img/close.png"></button>
            <h3 id="myModalLabel"><?= Yii::t('Contacts', 'Add contact') ?></h3>
        </div>
        <form action="<?= Yii::app()->createUrl('/contact/fastCreate') ?>">
        <div class="modal-body">
            <div class="xabina-form-container">
                <div class="form-lbl">
                    <?= Yii::t('Contacts', 'Contacts') ?> <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                </div>
                <div class="form-block">
                    <input class="add-input pull-left gray_bg" type="text">
                    <a href="transfer_overview.html" class="rounded-buttons pull-right gray-add-new"><?= Yii::t('Contacts', 'ADD NEW') ?></a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="messages-list-table-overflow">
                <table class="table messages-list-table">
                    <!--<tr class="form-tr xabina-form-container">
                        <td class="new-checkbox-td">
                            <label class="modal-galka-checkbox active"><input type="checkbox"/></label>
                        </td>
                        <td class="name_td_two">Платежное имя <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span></td>
                        <td class="value_td_big" colspan="2"><input type="text" class="add-input long-input" value="Ivan Ivanov" /></td>
                    </tr>-->
                    <tr class="form-tr xabina-form-container">
                        <td class="new-checkbox-td">
                            <label class="modal-galka-radiobutton"><input name="Users_Contacts[type]" value="personal" type="radio"/></label>
                        </td>
                        <td class="name_td_two"><?= Yii::t('Contacts', 'Name and Lastname') ?> <span class="tooltip-icon" title="<?= Yii::t('Contacts', 'contact_name_tooltip') ?>"></span></td>
                        <td class="value_td_small">
                            <input name="Users_Contacts[first_name]" type="text" class="add-input long-input" value="" placeholder="<?= Yii::t('Contacts', 'Enter name') ?>" /></td>
                        <td class="value_td_small">
                            <input name="Users_Contacts[last_name]"  type="text" class="add-input long-input" value="" placeholder="<?= Yii::t('Contacts', 'Enter lastname') ?>" /></td>
                    </tr>
                    <tr class="form-tr xabina-form-container">
                        <td class="new-checkbox-td">
                            <label class="modal-galka-radiobutton"><input name="Users_Contacts[type]" value="company" type="radio"/></label>
                        </td>
                        <td class="name_td_two"><?= Yii::t('Contacts', 'Company') ?> <span class="tooltip-icon" title="<?= Yii::t('Contacts', 'contact_companyname_tooltip') ?>"></span></td>
                        <td class="value_td_big" colspan="2">
                            <input name="Users_Contacts[company]"  type="text" class="add-input long-input" value="" placeholder="<?= Yii::t('Contacts', 'Enter company name') ?>" /></td>
                    </tr>
                </table>
            </div>
            <div class="submit_block">
                <input class="rounded-buttons marg-right-15 submit pull-left" type="submit" value="<?= Yii::t('Contacts', 'Create contact') ?>" onclick="return WLinkContact.createContact(this);">
                <input class="rounded-buttons cansel pull-left" type="button" data-dismiss="modal" aria-hidden="true" value="<?= Yii::t('Contacts', 'Cancel') ?>" onclick="$('#addLinkModal').modal('show')">
                <div class="clearfix"></div>
            </div>
        </div>
        </form>
    </div>
</div>