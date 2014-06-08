<div class="col-lg-9 col-md-9 col-sm-9" >
    <div class="h1-header">Аdding a new user</div>
    <div class="role-form xabina-form-container">
        <div class="account-selection" >
            <span class="select-lbl pull-left">Счет</span>
            <div class="select-custom account-select pull-right" style="width: 92%!important">
                <span class="select-custom-label">
                    <?php $this->widget('AccountInfo', array('account' => $selectedAcc));?>
                </span>
                <select name="" class=" select-invisible">
                    <?php foreach($accounts as $acc): ?>
                    <option <?php if($acc->number == $selectedAcc->number): ?>selected<?php endif; ?> 
                            value="<?= $acc->number ?>">
                        <?php $this->widget('AccountInfo', array('account' => $acc));?>
                    </option>
                    <?php endforeach; ?>                    
                </select>
            </div>
        </div>
    </div>
</div>

