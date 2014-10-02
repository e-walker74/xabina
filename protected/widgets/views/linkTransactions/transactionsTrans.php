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
    <tr class="before-transactions" style="display: none"></tr>
<?php endif; ?>
<?php if($model): ?>
<tr class="title_tr linked_tr transaction-transactions-row">
    <td colspan="5"><?= Yii::t('Transactions', 'Transactions') ?></td>
</tr>
<?php endif; ?>
<?php foreach($model as $trans): ?>
    <tr class="linked_tr transaction-transactions-row">
        <td class="icon_td"><img src="/css/images/one_transaction.png" /></td>
        <td class="title">
            <div class="account-data pull-left">
                <div class="account-name">
                    <?php if($trans->outgoing_id): ?>
                        <?= $trans->info->recipient ?>
                    <?php else: ?>
                        <?= $trans->info->sender ?>
                    <?php endif; ?>
                </div>
                <div class="account-info">
                    <?php if($trans->outgoing_id): ?>
                        <?= $trans->info->recipient_description ?>
                    <?php else: ?>
                        <?= $trans->info->sender_description ?>
                    <?php endif; ?>
                </div>
            </div>
        </td>
        <td class="edit">
            <?= Widget::get('WCrossLink')->changeCategory($trans->cross_id, $trans->cross_category) ?>
        </td>
        <td class="comment">
            <?= Widget::get('WCrossLink')->changeComment($trans->cross_id, $trans->cross_comment) ?>
        </td>
        <td class="delete"><div class="attach_del_block"><a class="del_a" data-url="<?= Yii::app()->createUrl('/ajax/removetag', array('id' => $trans->id, 'entity' => $trans->form, 'entity_id' => $trans->model_id, 'cross_type' => $trans->tableName())) ?>"></a></div></td>
    </tr>
<?php endforeach; ?>