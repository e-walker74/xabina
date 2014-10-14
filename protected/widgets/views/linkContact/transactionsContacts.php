<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 30.09.14
 * Time: 23:13
 */ ?>

<?php if (!Yii::request()->isAjaxRequest): ?>
    <tr class="before-contacts" style="display: none"></tr>
<?php endif; ?>
<?php if($model): ?>
<tr class="title_tr linked_tr transaction-contact">
    <td colspan="5"><?= Yii::t('Category', 'Contact') ?></td>
</tr>
<?php endif; ?>
<?php foreach($model as $contact): ?>
    <tr class="linked_tr transaction-contact">
        <td class="icon_td">
            <a href="<?= Yii::app()->createUrl('/contact/view', array('url' => $contact->url)) ?>" target="_blank">
            <?php if($contact->photo): ?>
                <img width="26" src="<?= $contact->getAvatarUrl() ?>" alt=""/>
            <?php else: ?>
                <img width="26" src="/images/contact_no_foto.png" alt=""/>
            <?php endif; ?>
            <?php if ($contact->xabina_id): ?>
<!--                --><?php //$activityState = Yii::app()->user->getActivityStatus($contact->xabina_id); ?>
<!--                --><?php //if ($activityState == Users::USER_ACTIVITY_STATUS_ONLINE){
//                    $cssClass = 'ok';
//                } elseif ($activityState == Users::USER_ACTIVITY_STATUS_BUSY) {
//                    $cssClass = 'time';
//                } else {
//                    $cssClass = 'err';
//                }
//                ?>
<!--                <a class="ico --><?//=$cssClass?><!--" href="#"></a>-->
            <?php endif ?>
            </a>
        </td>
        <td class="title">
            <a href="<?= Yii::app()->createUrl('/contact/view', array('url' => $contact->url)) ?>" target="_blank">
                <div class="account-data pull-left">
                    <div class="account-name"><?= $contact->fullname ?></div>
                    <div class="account-info"><?= $contact->hint ?></div>
                </div>
            </a>
        </td>
        <td class="edit">
            <?= Widget::get('WCrossLink')->changeCategory($contact->cross_id, $contact->cross_category, 'cross_' . $contact->tableName()) ?>
        </td>
        <td class="comment">
            <?= Widget::get('WCrossLink')->changeComment($contact->cross_id, $contact->cross_comment) ?>
        </td>

        <td class="delete"><div class="attach_del_block"><a class="del_a" data-url="<?= Yii::app()->createUrl('/ajax/removetag', array('id' => $contact->id, 'entity' => $contact->form, 'entity_id' => $contact->model_id, 'cross_type' => $contact->tableName())) ?>"></a></div></td>
    </tr>
<?php endforeach; ?>
<script>
    WLinkDrive.bindUnlinkFile()
</script>