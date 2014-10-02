<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 30.09.14
 * Time: 23:11
 */ ?>

<div class="modal fade" id="<?= $htmlID ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="xabina-modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="/css/layout/account/img/close.png"></button>
            <h3 id="myModalLabel">Link payment</h3>
        </div>
        <div class="modal-body">
            <div class="change_dialog_block">
                <div class="select-custom account-select">
                    <span class="select-custom-label" rel="addLinkModal">Linked Contact</span>
                    <select name="" class="select-invisible change_modal_select">
                        <option value="editCommentModal">
                            Memo
                        </option>
                        <option value="addBuhModal">
                            Linked Category
                        </option>
                        <option value="addLinkModal">
                            Linked Contact
                        </option>
                        <option value="addTranModal">
                            Linked Transactions
                        </option>
                        <option value="addTagModal">
                            Tags
                        </option>
                        <option value="addNewFileModal">
                            Linked Files
                        </option>
                    </select>
                </div>
            </div>
            <form action="<?= Yii::app()->createUrl('/contact/link', array(
                'entity' => $entity,
                'entity_id' => $entity_id,
            )) ?>">
                <?php Widget::get('ContactListWidget')->renderLinkContacts() ?>

                <div class="submit_block">
                    <input onclick="return WLinkContact.link(this)" class="rounded-buttons submit pull-left" type="submit" value="<?= Yii::t('Contact', 'Link payment') ?>">
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </div>
</div>