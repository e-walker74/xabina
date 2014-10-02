<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 28.09.14
 * Time: 18:21
 * @var WLinkDrive $this
 */ ?>

<div class="modal fade" id="editCommentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="xabina-modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="img/close.png"></button>
            <h3 id="myModalLabel">Memo</h3>
        </div>
        <div class="modal-body">
            <div class="change_dialog_block">
                <div class="select-custom account-select">
                    <span class="select-custom-label" rel="editCommentModal">Memo</span>
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
            <div class="xabina-form-container">
                <div class="form-lbl">
                    Memo <span class="tooltip-icon" title="Add Your first name using latin alphabet"></span>
                </div>
            </div>
            <div class="memo_edit"><textarea class="ckeditor"></textarea></div>
            <div><input class="rounded-buttons marg-right-15 submit pull-left" type="submit" value="Отправить"></div>
        </div>
    </div>
</div>