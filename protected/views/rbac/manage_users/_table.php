<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 13.06.14
 * Time: 11:32
 */
?>

<table class="table xabina-table user-management-table">
    <tr class="table-header">
        <th style="width: 29%"><?= Yii::t('Front', 'User'); ?></th>
        <th style="width: 13%"><?= Yii::t('Front', 'ID'); ?></th>
        <th style="width: 20%"><?= Yii::t('Front', 'Status'); ?></th>
        <th style="width: 20%"><?= Yii::t('Front', 'Role'); ?></th>
        <th style="width: 18%"></th>
    </tr>
    <?php if(!count($roles)): ?>
    <tr>
        <td colspan="5">
            <span class="rejected"><?= Yii::t('Front', 'No users on this account'); ?></span>
        </td>
    </tr>
    <?php endif; ?>
    <?php foreach($roles as $role): ?>
        <tr>
            <td><span class="primary"><?= $role->user->fullname ?></span></td>
            <td><?= $role->user->login ?></td>
            <td><span class="approved"><?= Yii::t('Front', 'Accepted'); ?></span></td>
            <td><?= $role->role->name?></td>
            <td >
                <div class="transaction-buttons-cont">
                    <a href="<?= Yii::app()->createUrl('/rbac/adduser', array('rid' => $role->id)) ?>" class="button edit"></a>
                    <a class="button delete" data-url="<?= Yii::app()->createUrl('/rbac/deleteUser', array('id' => $role->id)) ?>" ></a>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<script>
    $(document).ready(function(){
        $('.transaction-buttons-cont .delete').confirmation({
            title: '<?= Yii::t('Front', 'Are you sure?') ?>',
            singleton: true,
            popout: true,
            onConfirm: function(){
                deleteRow($(this).parents('.popover').prev('a'));
                return false;
            }
        })
    })
</script>