<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 30.09.14
 * Time: 15:46
 */ ?>

<?php if (!Yii::request()->isAjaxRequest): ?>
    <tr class="before-categories" style="display: none"></tr>
<?php endif; ?>
<?php if($data): ?>
<tr class="title_tr linked_tr transaction-category">
    <td colspan="5"><?= Yii::t('Category', 'Category') ?></td>
</tr>
<?php endif; ?>
<?php foreach($data as $model): ?>
    <tr class="linked_tr transaction-category">
        <td class="icon_td"><img src="/css/images/one_category.png" /></td>
        <td class="title">
            <div class="account-data pull-left">
                <div class="account-name"><?= $model->title ?></div>
                <div class="account-info"><?= $model->user->fullname ?></div>
            </div>
        </td>
        <td class="edit">
            <?= Widget::get('WCrossLink')->changeCategory($model->cross_id, $model->cross_category) ?>
        </td>
        <td class="comment">
            <?= Widget::get('WCrossLink')->changeComment($model->cross_id, $model->cross_comment) ?>
        </td>
        <td class="delete"><div class="attach_del_block"><a class="del_a" data-url="<?= Yii::app()->createUrl('/ajax/removetag', array('id' => $model->id, 'entity' => $model->form, 'entity_id' => $model->model_id, 'cross_type' => $model->tableName())) ?>"></a></div></td>
    </tr>
<?php endforeach; ?>