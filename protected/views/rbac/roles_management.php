<div class="col-lg-9 col-md-9 col-sm-9" >
    <div class="xabina-form-container">
        <div class="h1-header"><?= Yii::t('Front', 'Role Management') ?></div>
        <div class="h4"><b><?= Yii::t('Front', 'My role') ?></b></div>
        <table class="table xabina-table">
            <tbody><tr class="table-header">
                <th width="45%"><?= Yii::t('Front', 'Role') ?></th>
                <th width="40%"><?= Yii::t('Front', 'Used by') ?></th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach($roles as $role): ?>
            <tr>
                <td>
                    <b><?php echo $role->name; ?></b>
                </td>
                <td>
                    <?php if($role->rbacUserRoles): ?>
                        <?php echo count($role->rbacUserRoles); ?> <?= Yii::t('Front', 'Users') ?><br>
                        <div class="show-users">
                            <div class="accordion-header"><?php if(count($role->rbacUserRoles)): ?><a href="#"><?= Yii::t('Front', 'Show users') ?></a><?php endif; ?></div>
                            <?php if(count($role->rbacUserRoles)): ?>
                            <div class="users-content">
                                <?php foreach($role->rbacUserRoles as $ur): ?>
                                <a href="#"><?php echo $ur->user->getFullName(); ?></a><br>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </td>

                <td>
                    <?php if($role->create_uid): ?>
                    <div class="transaction-buttons-cont">
                        <a class="button edit" href="<?= Yii::app()->createUrl('/rbac/addrole', array('role_id' => $role->id)) ?>"></a>
                        <a class="button delete" data-url="<?= Yii::app()->createUrl('/rbac/deleteRole', array('id' => $role->id)) ?>" ></a>
                    </div>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody></table>
        <div class="form-submit">
            <a href="<?=Yii::app()->createUrl("/rbac/addrole") ?>" class="rounded-buttons upload add-more"><?= Yii::t('Front', 'ADD NEW ROLE') ?></a>
        </div>
    </div>
</div>
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