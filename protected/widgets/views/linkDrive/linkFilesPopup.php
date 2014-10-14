<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 28.09.14
 * Time: 22:47
 * @var Users_Files[] $files
 */ ?>

<div class="modal fade" id="<?= $htmlID ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-type="files" data-entity="<?= $entity ?>" data-entity-id="<?= $entity_id ?>">
    <script>WLinkDrive._filesPopupId = "<?= $htmlID ?>"</script>
<div class="xabina-modal">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        <img src="/css/layout/account/img/close.png">
    </button>
    <h3 id="myModalLabel"><?= Yii::t('Files', 'Linked Files') ?></h3>
</div>
<div class="modal-body" data-folder-url="<?= Yii::app()->createUrl('/file/openFolder') ?>">
<div class="xabina-form-container" >
    <div class="change_dialog_block">
        <div class="change_dialog_block">
            <div class="select-custom account-select">
                <span class="select-custom-label" rel="addNewFileModal"></span>
                <select name="" class="select-invisible change_modal_select">
                    <option value="addNewFileModal">
                        <?= Yii::t('Linking', 'Linked Files') ?>
                    </option>
                    <option value="addLinkModal">
                        <?= Yii::t('Linking', 'Linked Contact') ?>
                    </option>
                    <option value="addBuhModal">
                        <?= Yii::t('Linking', 'Linked Category') ?>
                    </option>
                    <option value="linkNewMemoModal">
                        <?= Yii::t('Linking', 'Memo') ?>
                    </option>
                    <option value="addTranModal">
                        <?= Yii::t('Linking', 'Linked Transactions') ?>
                    </option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-lbl">
        <?= Yii::t('Drive', 'File') ?> <span class="tooltip-icon" title="<?= Yii::t('Drive', 'file') ?>"></span>
    </div>
    <div class="form-block file-dir-link">
        <a href="#" class="file-dir-but" onclick="return WLinkDrive.openFolder(this)"><img style="height: 30px;" src="/css/layout/account/img/up_arrow_img.png" alt=""></a>
        <a href="#" class="file-dir-but" onclick="return WLinkDrive.createFolderButton(this)"><img style="height: 30px;" src="/css/layout/account/img/folder_add_img.png" alt=""></a>
        <div class="relative pull-left" style="width: 61%" >
            <input class="add-input pull-left search-input-drive file-search-inp" type="text" >
            <span class="clear-input-but-for-all" id="clear-keyword"></span>
        </div>
					<span class="drdn-cont pull-right file-dial">

                        <form enctype="multipart/form-data" class="drive-upload-form" action="<?= Yii::app()->createUrl('/file/UploadDrive', array(
                            'form' => $entity,
                            'model_id' => $entity_id,
                        )) ?>">
                            <label class="rounded-buttons pull-right add-new new_file_but">
                                <?= Yii::t('Drive', 'Upload file') ?>
                                <input type="file" name="file" style="display: none"/>
                            </label>
                            <input type="hidden" name="folder" value=""/>
                        </form>

<!--						<a href="transfer_overview.html" class="rounded-buttons pull-right add-new new_file_but" data-toggle="dropdown">--><?//= Yii::t('Drive', 'ADD NEW FILE') ?><!--</a>-->
<!--						<div class="dropdown-menu no-close link-select-dropdown list-actions-dropdown list-unstyled act-list file-dialog" role="menu">-->
<!--                            <div class="content-dropdown">-->
<!--                                <div class="drop_main_block">-->
<!--                                    <ul class="drop_link_ul">-->
<!--                                        <li class="up_files">-->
<!--                                            <form enctype="multipart/form-data" class="drive-upload-form" action="--><?//= Yii::app()->createUrl('/file/UploadDrive', array(
//                                                'form' => $entity,
//                                                'model_id' => $entity_id,
//                                            )) ?><!--">-->
<!--                                            <label>-->
<!--                                                --><?//= Yii::t('Drive', 'Upload file') ?>
<!--                                                <input type="file" name="file" style="display: none"/>-->
<!--                                            </label>-->
<!--                                                <input type="hidden" name="folder" value=""/>-->
<!--                                            </form>-->
<!--                                        </li>-->
<!--                                        <li class="memo">--><?//= Yii::t('Drive', 'Create file') ?><!--</li>-->
<!--                                    </ul>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
					</span>
        <div class="clearfix"></div>
    </div>
</div>
<div class="file_top_menu" data-url="<?= Yii::app()->createUrl('/file/openFolder') ?>">
    <div class="top_menu_name pull-left" data-sort="asc" data-sort-param="user_file_name" onclick="WLinkDrive.sort(this)"><span><?= Yii::t('Drive', 'Name') ?></span></div>
    <div class="top_menu_desc pull-left" data-sort="asc" data-sort-param="description" onclick="WLinkDrive.sort(this)"><span><?= Yii::t('Drive', 'Description') ?></span></div>
    <div class="top_menu_create pull-left" data-sort="asc" data-sort-param="created_at" onclick="WLinkDrive.sort(this)"><span><?= Yii::t('Drive', 'Created') ?></span></div>
    <div class="top_menu_size pull-left" data-sort="asc" data-sort-param="file_size" onclick="WLinkDrive.sort(this)"><span><?= Yii::t('Drive', 'Size') ?></span></div>
    <div class="clearfix"></div>
</div>
<form action="<?= Yii::app()->createUrl('/file/link', array('entity' => $entity, 'entity_id' => $entity_id)) ?>">
<div class="account-search-results-cont with-alphabet file-popup-table">
    <div class="letter-block">
        <ul class="search-results-list list-unstyled file-directions" >
            <li style="display: none" class="add-new-folder" data-url="<?= Yii::app()->createUrl('/file/createFolder', array('entity' => $entity, 'entity_id' => $entity_id)) ?>">
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
<!--                        <div title="Send to Admin" class="one_str">Send to Admin</div>-->
                    </div>
                    <div class="account-data pull-left created-block">
<!--                        <div class="one_str small-text">03.03.2014</div>-->
                    </div>
                    <div class="account-data pull-left size-block">
<!--                        <div class="one_str small-text">9 001 Kb</div>-->
                    </div>
                    <div class="transaction-buttons-cont book">
                    </div>
                    <div class="clearfix"></div>
                </div>
            </li>
<!--            --><?php //$this->renderFilesGridInPopup($folder) ?>
        </ul>
    </div>
</div>
<div class="submit_block">
    <input class="rounded-buttons submit pull-left" onclick="return WLinkDrive.linkFiles(this)" type="submit" value="<?= Yii::t('Drive', 'Link') ?>">
    <div class="clearfix"></div>
</div>
</form>
</div>
</div>
</div>