<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 16.10.14
 * Time: 19:31
 * @var Accounts $data
 */ ?>

<li class="clickable-row account-item" data-url="<?= Yii::app()->createUrl("/accounts/cardbalance", array("account" => $data->number)) ?>">
    <div class="check">
        <div class="checkbox-custom narrow-17">
            <label class="">
                <input class="row-checkbox" name="account[]" value="<?= $data->number ?>" type="checkbox">
            </label>
        </div>
    </div>
    <div class="account text-ellipsis search-text-hear">
        <?= $data->user->fullName ?><br/>
        <span class="bold"><?= chunk_split($data->number, 4) ?></span>
    </div>
    <div class="type text-ellipsis search-text-hear">
        <?= $data->name ?> <br/>
        <span class="grey font-size-12"><?= Yii::t('Account', 'Payments') ?></span>
        <?php if($data->sub_type == 'anonymous'): ?>
            &nbsp;&nbsp;&nbsp;<span class="xabina-badge">A</span>
        <?php endif; ?>
    </div>
    <div class="balance">
        <ul class="currencies-list list-unstyled pull-right">
            <li>
                <?php if($data->multi_balance > 0): ?>
                    <a href="<?= Yii::app()->createUrl("/accounts/cardbalance", array("account" => $data->number)) ?>">
                        <span class="sum sum-inc ">+<?= number_format($data->multi_balance, 2, ".", " ") ?></span></a><span class="currency search-text-hear"><?= $data->currency->title ?></span>
                <?php elseif($data->multi_balance < 0): ?>
                    <a href="<?= Yii::app()->createUrl("/accounts/cardbalance", array("account" => $data->number)) ?>">
                        <span class="sum sum-dec "><?= number_format($data->multi_balance, 2, ".", " ") ?></span></a><span class="currency search-text-hear"><?= $data->currency->title ?></span>
                <?php else: ?>
                    <a href="<?= Yii::app()->createUrl("/accounts/cardbalance", array("account" => $data->number)) ?>">0</a> <span class="currency search-text-hear"><?= $data->currency->title ?></span>
                <?php endif; ?>
            </li>
            <?php foreach($data->getSubAccounts() as $subAccount): ?>
            <li class="font-size-12">

                <?php if($subAccount->balance > 0): ?>
                    <a href="<?= Yii::app()->createUrl("/maccounts/balance", array("account" => $subAccount->number, 'Accounts_currency' => $subAccount->currency->code)) ?>">
                        <span class="sum sum-inc ">+<?= number_format($subAccount->balance, 2, ".", " ") ?></span></a><span class="currency grey"><?= $subAccount->currency->title ?></span>&nbsp;
                <?php elseif($subAccount->balance < 0): ?>
                    <a href="<?= Yii::app()->createUrl("/maccounts/balance", array("account" => $subAccount->number, 'Accounts_currency' => $subAccount->currency->code)) ?>">
                        <span class="sum sum-dec "><?= number_format($subAccount->balance, 2, ".", " ") ?></span></a><span class="currency grey"><?= $subAccount->currency->title ?></span>&nbsp;
                <?php else: ?>
                    <a href="<?= Yii::app()->createUrl("/maccounts/balance", array("account" => $subAccount->number, 'Accounts_currency' => $subAccount->currency->code)) ?>">0</a> <span class="currency grey"><?= $subAccount->currency->title ?></span>&nbsp;
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="status">
        <?= AccountService::getAccountStatusIcon($data->status) ?>
    </div>
    <div class="menu relative">
        <?php if($data->is_master): ?>
            <span class="primary-button pull-left is-primary"></span>
            <a href="javaScript:" onclick="Accounts.makeAccountPrimary('<?= Yii::app()->createUrl("/maccounts/makePrimary") ?>', '<?= $data->id ?>')" class="primary-button m-primary pull-left" style="display: none"></a>
        <?php else: ?>
            <span class="primary-button pull-left is-primary" style="display: none"></span>
            <a href="javaScript:" onclick="Accounts.makeAccountPrimary('<?= Yii::app()->createUrl("/maccounts/makePrimary") ?>', '<?= $data->id ?>', this)" class="primary-button m-primary pull-left"></a>
        <?php endif; ?>
        <span class="btn-gr">
            <a class="menu-mini pull-right relative" data-toggle="dropdown"></a>
            <ul class="dropdown-menu menu-b-wa list-unstyled" role="menu">
                <li class="arr"></li>
                <li class="clearfix">
                    <a href="<?= Yii::app()->createUrl("/accounts/cardbalance", array("account" => $data->number)) ?>" class="action view"><?= Yii::t('Accounts', 'View') ?></a>
                </li>
                <li class="clearfix">
                    <a href="<?= Yii::app()->createUrl("/accounts/management", array("url" => $data->number)) ?>" class="action edit"><?= Yii::t('Accounts', 'Edit') ?></a>
                </li>
                <li class="clearfix">
                    <a href="<?= Yii::app()->createUrl("/accounts/cardbalance", array("account" => $data->number, '#' => 'analytics')) ?>" class="action analyt"><?= Yii::t('Accounts', 'Analytics') ?></a>
                </li>
<!--                <li class="clearfix">-->
<!--                    <a href="#" class="action delete">Delete</a>-->
<!--                </li>-->
            </ul>
        </span>
    </div>
    <div class="hidden search-text-hear">
        <?= $data->number ?><br/>
        <?php foreach($data->tags as $tag): ?>
            <?= $tag->title ?>
        <?php endforeach; ?>
    </div>
    <div class="hidden row-filter-data"><?= $data->currency->code ?>|<?= $data->status ?>|<?= $data->sub_type ?></div>
    <div class="clearfix"></div>
</li>