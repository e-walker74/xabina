<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 08.09.14
 * Time: 16:21
 * @var Accounts[] $accounts
 */
?>

    <table class="table xabina-table-account-managment right-button-clickable">
    <tr class="table-header">
        <th style="width: 28%"><?= Yii::t('Accounts', 'Account') ?></th>
        <th style="width: 16%"><?= Yii::t('Accounts', 'Type') ?></th>
        <th style="width: 19%" class="text-right"><?= Yii::t('Accounts', 'Balance') ?></th>
        <th style="width: 17%"><?= Yii::t('Accounts', 'Сurrency') ?></th>
        <th style="width: 13%"><?= Yii::t('Accounts', 'Status') ?></th>
        <th style="width: 8%"></th>
    </tr>
    <?php foreach($accounts->searchWithGroup()->getData() as $account): ?>
        <tr>
            <td>
                <?= $account->user->fullName ?><br/>
                <span class="bold"><?= chunk_split($account->number, 4) ?></span>
                <a href="<?= Yii::app()->createUrl("/accounts/cardbalance", array("account" => $account->number)) ?>" class="right-click-shadow"></a>
            </td>
            <td>
                <?= $account->name ?> <br/>
                <span class="grey font-size-12">Платежный</span><?php if($account->sub_type == 'anonymous'): ?>&nbsp;&nbsp;&nbsp;<span class="xabina-badge">A</span><?php endif; ?>
                <a href="<?= Yii::app()->createUrl("/accounts/cardbalance", array("account" => $account->number)) ?>" class="right-click-shadow"></a>
            </td>
            <td colspan="2" >
                <ul class="currencies-list list-unstyled pull-right" style="margin:0 31% 0 17%;">
                    <li>
                        <?php if($account->getGroupBalance() > 0): ?>
                            <a href="#">
                            <span class="sum sum-inc ">+<?= number_format($account->getGroupBalance(), 2, ".", " ") ?></span><span class="currency"><?= $account->currency->title ?></span></a>
                        <?php elseif($account->getGroupBalance() < 0): ?>
                            <a href="#">
                            <span class="sum sum-dec "><?= number_format($account->getGroupBalance(), 2, ".", " ") ?></span><span class="currency"><?= $account->currency->title ?></span></a>
                        <?php else: ?>
                            <a href="#"><span>0</span><span class="currency"><?= $account->currency->title ?></span></a>
                        <?php endif; ?>
                    </li>
                    <?php foreach($account->getSubAccounts() as $subAccount): ?>
                        <li class="font-size-12">
                            <?php if($subAccount->balance > 0): ?>
                                <a href="#">
                                    <span class="sum sum-inc ">+<?= number_format($subAccount->balance, 2, ".", " ") ?></span> <span class="currency grey"><?= $subAccount->currency->title ?></span></a>&nbsp;
                            <?php elseif($subAccount->balance < 0): ?>
                                <a href="#">
                                    <span class="sum sum-dec "><?= number_format($subAccount->balance, 2, ".", " ") ?></span> <span class="currency grey"><?= $subAccount->currency->title ?></span></a>&nbsp;
                            <?php else: ?>
                                <a href="#">0<span class="currency grey"><?= $subAccount->currency->title ?></span></a> &nbsp;
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

            </td>
            <td style="overflow: visible!important;">
                <?= AccountService::getAccountStatusIcon($account->status) ?>
                <?php if($account->is_master): ?>
                    <span data-original-title="Primary" class="primary-button is-primary tooltip-icon"></span>
                <?php else: ?>
                    <a data-original-title='Make primary' href="javaScript:" onclick="Accounts.makeAccountPrimary('<?= Yii::app()->createUrl("/accounts/makePrimary") ?>', '<?= $account->id ?>')" class="primary-button m-primary tooltip-icon"></a>
                <?php endif; ?>
            </td>
            <td style="overflow: visible!important;">
                <div class="contact-actions transaction-buttons-cont">
                <div class="btn-group">
                    <a title="<?= Yii::t("Front", "Menu")?>" class="button menu" data-toggle="dropdown" href="#"></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a title="<?= Yii::t("Front", "Show")?>" class="button eye" href="<?= Yii::app()->createUrl("/accounts/cardbalance", array("account" => $account->number)) ?>"></a>
                        </li>
                        <li>
                            <a title="<?= Yii::t("Front", "Edit")?>" class="button edit" href="<?= Yii::app()->createUrl("/accounts/management", array("url" => $account->number)) ?>"></a>
                        </li>
                        <li>
                            <a title="<?= Yii::t("Front", "Statistic")?>" class="button chart" href="<?= Yii::app()->createUrl("/accounts/cardbalance", array("account" => $account->number))?>"></a>
                        </li>
                    </ul>
                </div>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr class="totals">
        <td colspan="2" class="text-right">
                        <span>
                          <?= Yii::t('Front', 'Total') ?>:
                        </span>
        </td>
        <td class="text-right">
            <?php if(isset($account)): ?>
                <?= $account->getUserBalanceInEUR() ?>
            <?php else: ?>
                0
            <?php endif; ?>
        </td>
        <td style="overflow: visible!important" class="currency-td">
            <div class="relative">
                          <span class="dropdown_button  currency_dropdown">EUR<span class="currency_drdn_arr"></span>
                          </span>
            </div>
        </td>
        <td colspan="2"></td>
    </tr>
    </table>
<script>
    $(document).ready(function(){
        changeCurrency();
        if ($('.currency_dropdown').length != 0)
        $('.currency_dropdown').tempDropDown({
            list: {
                EUR: 'EUR',
                USD: 'USD',
                RUB: 'RUB',
                CHF: 'CHF',
                JPY: 'JPY'
            },
            listClass: 'currencies_dropdown',
            callback: changeCurrency

        });
    })
</script>