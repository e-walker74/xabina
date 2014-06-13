<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 13.06.14
 * Time: 1:26
 * #parse("RbacController.php")
 */

?>

<div class="col-lg-9 col-md-9 col-sm-9" >
    <div class="h1-header">User Management</div>
    <div class="account-selection">
        <span class="select-lbl">Счет</span>
        <div class="select-custom account-select">
            <span class="select-custom-label">
                <?php $this->widget('AccountInfo', array('account' => $selectedAcc));?>
            </span>
            <select id="usersForAccount" name="" class="select-invisible">
                <?php foreach($accounts as $acc): ?>
                    <option <?php if($acc->number == $selectedAcc->number): ?>selected<?php endif; ?>
                            value="<?= $acc->number ?>">
                        <?php $this->widget('AccountInfo', array('account' => $acc));?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="xabina-form-container">
        <div id="ajax-users-table">

        </div>
        <div class="form-submit">
            <a href="<?=Yii::app()->createUrl("/rbac/adduser") ?>" class="rounded-buttons upload add-more"><?= Yii::t('Front', 'Add New User'); ?></a>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<script>
    RBAC
        .addRolePage()
        .bindCheckUsersForAccount()
        .getUsersForAccount()
</script>