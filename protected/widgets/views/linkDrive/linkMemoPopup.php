<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 30.09.14
 * Time: 14:54
 */ ?>

<div class="modal fade" id="<?= $htmlID ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="xabina-modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <img src="/css/layout/account/img/close.png">
            </button>
            <h3 id="myModalLabel"></h3>
        </div>
        <div class="modal-body" data-folder-url="<?= Yii::app()->createUrl('/file/openFolder') ?>">
            <div class="xabina-form-container" >
                <div class="change_dialog_block">
                    <div class="select-custom account-select">
                        <span class="select-custom-label" rel="addNewFileModal">Linked Files</span>
                        <select name="" class="select-invisible change_modal_select">
                            <option value="addNewFileModal">
                                Linked Files
                            </option>
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
                        </select>
                    </div>
                </div>
                <div class="form-lbl">
                    <?= Yii::t('Drive', 'File') ?> <span class="tooltip-icon" title="<?= Yii::t('Drive', 'file') ?>"></span>
                </div>
                <div class="form-block file-dir-link">
<!--                    <a href="#" class="file-dir-but" onclick="return WLinkDrive.openFolder(this)"><img style="height: 30px;" src="/css/layout/account/img/up_arrow_img.png" alt=""></a>-->
<!--                    <a href="#" class="file-dir-but" onclick="return WLinkDrive.createFolderButton(this)"><img style="height: 30px;" src="/css/layout/account/img/folder_add_img.png" alt=""></a>-->
                    <input class="add-input pull-left search-input-drive" type="text">
					<span class="drdn-cont pull-right file-dial">
						<a href="#" class="rounded-buttons pull-right add-new new_file_but" onclick="$('#editCommentModal').modal('show');" data-dismiss="modal"><?= Yii::t('Drive', 'ADD NEW MEMO') ?></a>
					</span>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="file_top_menu" data-url="<?= Yii::app()->createUrl('/file/openFolder') ?>">
                <div class="top_menu_name pull-left" data-sort="asc" data-sort-param="user_file_name" onclick="WLinkDrive.sort(this)"><span><?= Yii::t('Drive', 'Name') ?></span></div>
                <div class="top_menu_create pull-left" data-sort="asc" data-sort-param="created_at" onclick="WLinkDrive.sort(this)"><span><?= Yii::t('Drive', 'Created') ?></span></div>
                <div class="clearfix"></div>
            </div>
            <form action="<?= Yii::app()->createUrl('/file/linkMemo', array('entity' => $entity, 'entity_id' => $entity_id)) ?>">
                <div class="account-search-results-cont with-alphabet ">
                    <div class="letter-block">
                        <ul class="search-results-list list-unstyled file-directions" >
                            <li style="display: none" class="add-new-folder" data-url="<?= Yii::app()->createUrl('/file/createFolder') ?>">
                                <div class="bg-color">
                                    <div class="cont_check_block">
                                        <label >
                                            <!--                            <input type="checkbox">-->
                                        </label>
                                    </div>
                                    <div class="account-photo pull-left">
                                        <img style="height: 30px;" src="/css/layout/account/img/folder_img.png" alt="">
                                    </div>
                                    <div class="account-data pull-left name-block">
                                        <input type="text" class="add-input" value="">
                                    </div>
                                    <div class="account-data pull-left descr-block">
                                    </div>
                                    <div class="account-data pull-left created-block">
                                    </div>
                                    <div class="account-data pull-left size-block">
                                    </div>
                                    <div class="transaction-buttons-cont book">
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </li>
                            <?php $this->renderMemoGridInPopup($folder) ?>
                        </ul>
                    </div>
                </div>
                <div class="submit_block">
                    <input class="rounded-buttons submit pull-left" onclick="return WLinkDrive.linkMemo(this)" type="submit" value="<?= Yii::t('Drive', 'Link') ?>">
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </div>
</div>