<div class="col-lg-9 col-md-9 col-sm-9">
<div class="contact-cont " id="print-area">
<div class="contact-header">
    <div class="contact-photo">
        <?php if ($model->photo): ?>
            <img width="40" src="<?= $model->getAvatarUrl() ?>" alt=""/>
        <?php else: ?>
            <img width="40" src="/images/contact_no_foto.png" alt="">
        <?php endif; ?>
        <span class="valid-status ok"></span>
    </div>
    <div class="contact-name"><?= $model->fullname ?><br>
        <span class="company-name"><?= $model->getNameWithCompany() ?></span>
    </div>
    <div class="contact-actions transaction-buttons-cont">
        <div class="btn-group with-delete-confirm">
            <a class="button menu" title="<?= Yii::t('Front', 'Options') ?>" data-toggle="dropdown" href="#"></a>
            <ul class="dropdown-menu">
                <li>
                    <a class="button print" title="<?= Yii::t('Front', 'Print this window') ?>" href="javaScript:void(0)" onclick="js:printDiv('print-area')"></a>
                </li>
                <li>
                    <?= Html::link('', array('/contact/pdf', 'url' => $model->url), array('class' => 'button pdf', 'title' => Yii::t('Front', 'Contact to PDF'))) ?>
                </li>
                <li>
                    <a class="button delete del-contact" onclick="$(this).addClass('opened')"
                       data-url="<?= Yii::app()->createUrl('/contact/delete', array('id' => $model->id)) ?>"></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="edit-tabs contact-tabs">
<ul class="list-unstyled">
    <li style="width: 38%"><a href="#tab1"><?= Yii::t('Front', 'General Info'); ?></a></li>
<!--    <li style="width: 16%"><a href="#tab2">--><?//= Yii::t('Front', 'Settings'); ?><!--</a></li>-->
    <li style="width: 33%"><a href="#tab3"><?= Yii::t('Front', 'Linked Transfers'); ?></a></li>
    <li style="width: 29%"><a href="#tab4"><?= Yii::t('Front', 'Analytics'); ?></a></li>
<!--    <li style="width: 17%"><a href="#tab5">--><?//= Yii::t('Front', 'Drive'); ?><!--</a></li>-->
<!--    <li style="width: 20%"><a href="#tab6">--><?//= Yii::t('Front', 'Dialogues'); ?><!--</a></li>-->
</ul>
<div class="clearfix"></div>
<div id="tab1">

<?php $this->renderPartial('update',
    array(
        'model' => $model,
        'data_categories' => $data_categories,
        'link' => $link,
        'contact_categories' => $contact_categories,
    )); ?>

</div>
<div id="tab3">
    <?= $this->renderPartial('_links_search', array('model' => $model, 'searchLink' => $searchLink)); ?>
    <div id="links-table">
        <?= $this->renderPartial('_linked', array('model' => $model, 'transaction' => $transaction)); ?>
    </div>
</div>
<div id="tab4">
    <?= $this->renderPartial('_analytics', array('model' => $model, 'search' => $search)); ?>
</div>
<!--<div id="tab5">5</div>-->
<!--<div id="tab6">-->
<!--6ef-->
<!--</div>-->
</div>
</div>
</div>
<script>
    $(document).ready(function () {
        $('.transaction-buttons-cont .delete.del-contact').confirmation({
            title: '<?= Yii::t('Front', 'Are you sure?') ?>',
            singleton: true,
            popout: true,
            onConfirm: function () {
                window.location = $(this).parents('.popover').prev('a').attr('data-url')
                return false;
            }
        })
    })

    $(".xabina-tabs , .edit-tabs").tabs({});
</script>