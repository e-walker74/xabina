<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 30.09.14
 * Time: 23:28
 */ ?>

<div class="xabina-form-container">
    <div class="form-lbl">
        <?= Yii::t('Contact', 'Contact') ?> <span class="tooltip-icon" title="<?= Yii::t('Contact', 'contact_link_popup') ?>"></span>
    </div>
    <div class="form-block">
        <div class="relative pull-left" style="width: 72%">
            <input class="add-input pull-left search-input-contacts" type="text">
            <span class="clear-input-but-for-all" id="clear-keyword"></span>
        </div>
        <a href="javaScript:void(0)" onclick="$('#createContactModal').modal('show')" data-dismiss="modal" class="rounded-buttons pull-right add-new"><?= Yii::t('Contact', 'ADD NEW') ?></a>
        <div class="clearfix"></div>
    </div>
</div>
<div class="scroll-cont">
    <?php $this->render('contactsList/alphabet') ?>
    <div class="account-search-results-cont with-alphabet scroll-block">
        <?php $this->render('contactsList/linkContactListUl', array('model' => $model, 'entity' => $entity, 'entity_id' => $entity_id)) ?>
    </div>
</div>