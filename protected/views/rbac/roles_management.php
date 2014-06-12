<div class="col-lg-9 col-md-9 col-sm-9" >
    <div class="xabina-form-container">
        <div class="h1-header">Role Management</div>
        <div class="h4"><b>My role</b></div>
        <table class="table xabina-table">
            <tbody><tr class="table-header">
                <th width="45%">Role</th>
                <th width="40%">Used by</th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach($roles as $role): ?>
            <tr>
                <td>
                    <b><?php echo $role->name; ?></b>
                </td>
                <td>
                    <?php echo count($role->rbacUserRoles); ?> users <br>
                    <div class="show-users">
                        <div class="accordion-header"><?php if(count($role->rbacUserRoles)): ?><a href="#">Show users</a><?php endif; ?></div>
                        <?php if(count($role->rbacUserRoles)): ?>
                        <div class="users-content">
                            <?php foreach($role->rbacUserRoles as $ur): ?>
                            <a href="#"><?php echo $ur->user->getFullName(); ?></a><br>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </td>

                <td>
                    <div class="transaction-buttons-cont">
                        <a class="button edit" href="#"></a>
                        <a class="button delete" href="#"></a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody></table>
        <div class="form-submit">
            <a href="<?=Yii::app()->createUrl("/rbac/addrole") ?>" class="rounded-buttons upload add-more"><?= Yii::t('Front', 'ADD NEW ROLE') ?></a>
            <a href="<?=Yii::app()->createUrl("/rbac/adduser") ?>" class="rounded-buttons upload add-more"><?= Yii::t('Front', 'ADD NEW User') ?></a>
        </div>
    </div>
</div>