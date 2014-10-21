<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 30.09.14
 * Time: 23:11
 */ ?>

<div class="modal fade" data-backdrop="static" id="<?= $htmlID ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-update-url="<?= Yii::app()->createUrl('/contact/getwidgetgrid') ?>" data-entity="<?= $entity ?>" data-entity-id="<?= $entity_id ?>">
    <script>WLinkContact._popupId = "<?= $htmlID ?>"</script>
    <div class="xabina-modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="/css/layout/account/img/close.png"></button>
            <h3 id="myModalLabel"><?= Yii::t('Linking', 'Link Contact') ?></h3>
        </div>
        <div class="modal-body">
            <div class="change_dialog_block">
                <div class="select-custom account-select">
                    <span class="select-custom-label" rel="addLinkModal"></span>
                    <select name="" class="select-invisible change_modal_select">
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
                        <option value="addNewFileModal">
                            <?= Yii::t('Linking', 'Linked Files') ?>
                        </option>
                    </select>
                </div>
            </div>
            <form action="<?= Yii::app()->createUrl('/contact/link', array(
                'entity' => $entity,
                'entity_id' => $entity_id,
            )) ?>">
                <div class="contacts-list">
                    <?php Widget::get('ContactListWidget'); ?>
<!--                    --><?php //Widget::get('ContactListWidget')->renderLinkContacts(false, $entity, $entity_id) ?>
                </div>

                <div class="submit_block">
                    <input onclick="return WLinkContact.link(this)" class="rounded-buttons submit pull-left" type="submit" value="<?= Yii::t('Contact', 'Link payment') ?>">
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </div>
</div>