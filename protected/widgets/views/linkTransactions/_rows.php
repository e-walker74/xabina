<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 14.10.14
 * Time: 2:25
 */
?>

<?php $model = $this->getTransactions($entity_id, $entity); ?>
<?php foreach ($transactions as $trans): ?>
    <?php if (isset($model[$trans->id])) continue; ?>
    <tr class="wcategory-row">
        <td width="6%">
            <label class="modal-galka-checkbox">
                <input name="transactions[]" value="<?= $trans->id ?>" type="checkbox"/>
            </label>
        </td>
        <td width="17%" onclick="CrossLinks.clickCheckbox(this)"><?= date('d.m.Y', $trans->execution_time) ?></td>
        <td width="25%" class="drive-search-text" onclick="CrossLinks.clickCheckbox(this)">
            <strong class="holder"><?= $trans->info->sender ?></strong><br>
            <span class="account"><?= $trans->info->sender_description ?></span>
        </td>
        <td width="25%" class="drive-search-text" onclick="CrossLinks.clickCheckbox(this)">
            <strong class="holder"><?= $trans->info->recipient ?></strong><br>
            <span class="account"> <?= $trans->info->recipient_description ?></span>
        </td>
        <td width="20%" class="drive-search-text" class="text-right" onclick="CrossLinks.clickCheckbox(this)">
            <?php if ($trans->amount > 0): ?>
                <span
                    class="sum-inc">+<?= number_format($trans->amount, 2, ".", " ") ?></span> <?= $trans->account->currency->title ?>
            <?php elseif ($subAccount->balance < 0): ?>
                <span
                    class="sum-inc">-<?= number_format($trans->amount, 2, ".", " ") ?></span> <?= $trans->account->currency->title ?>
            <?php
            else: ?>
                0 <?= $trans->account->currency->title ?>
            <?php endif; ?>
        </td>
        <td width="7%" style="overflow: visible!important">
            <!--                                        --><?php //if($trans->info->details_of_payment): ?>
            <div class="transaction-buttons-cont book">
                <a href="#" class="book_button trans-but open"></a>
            </div>
            <!--                                        --><?php //endif; ?>
        </td>
    </tr>

    <tr class="note-tr wcategory-row" style="display: table-row;">
        <?php if ($trans->info->details_of_payment): ?>
            <td colspan="6">
                <div class="note-cont">
                    <?= $trans->info->details_of_payment ?>
                </div>
            </td>
        <?php endif; ?>
    </tr>

<?php endforeach; ?>