<table class="table">
	<tbody>
		<?php foreach($transactions as $trans): ?>
			<?php if($trans->transfer_type == 'outgoing'): ?>
				<tr class="clickable-row" data-transaction-info-url="<?= Yii::app()->createUrl('/accounts/transaction', array('id' => $trans->url)) ?>">
					<td width="15%"><?= date('d.m.Y', $trans->created_at) ?></td>
					<td width="10%">OV</td>
					<td width="26%">
                        <strong class="holder">
                            <?php if($trans->type == 'positive'): ?>
                                <?= $trans->info->sender ?>
                            <?php elseif($trans->type == 'negative'): ?>
							    <?= ($trans->info) ? $trans->info->recipient : ""?>
						    <?php endif; ?>
                        </strong><br>
                        <span class="account">
                            <?= $trans->operation ?>
                        </span>
					</td>
					<td width="22%" style="text-align:right;">
						<?php if($trans->type == 'positive'): ?>
							<span class="sum-inc">+<?= number_format($trans->sum, 2, ".", " ") ?></span>
						<?php else: ?>
							<span class="sum-dec">-<?= number_format($trans->sum, 2, ".", " ") ?></span>
						<?php endif; ?>
						<?= $selectedAcc->currency->code ?></td>
					<td width="19%" style="text-align:right;">
						<?php if($trans->acc_balance >= 0): ?>
							<span class="sum-inc"><?= number_format($trans->acc_balance, 2, ".", " ") ?></span>
						<?php else: ?>
							<span class="sum-dec"><?= number_format($trans->acc_balance, 2, ".", " ") ?></span>
						<?php endif; ?>
						<?= $selectedAcc->currency->code ?></td>
					</td>
					<td width="7%">
                        <div class="contact-actions transaction-buttons-cont">
                            <div class="btn-group">
                                <a class="button menu" data-toggle="dropdown" href="#"></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="button edit" href="edit_contact.html"></a>
                                    </li>
                                    <li>
                                        <a class="button refresh" href="#"></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
					</td>
				</tr>
			<?php elseif($trans->transfer_type == 'incoming'): ?>
				<tr class="clickable-row" data-transaction-info-url="<?= Yii::app()->createUrl('/accounts/transaction', array('id' => $trans->url)) ?>">
					<td width="15%"><?= date('d.m.Y', $trans->created_at) ?></td>
					<td width="10%">OV</td>
					<td width="26%">
                        <strong class="holder">
                            <?php if($trans->type == 'positive'): ?>
                                <?= ($trans->info) ? $trans->info->sender : ""?>
                            <?php endif; ?>
                        </strong><br>
                        <span class="account">
                            <?= $trans->operation ?>
                        </span>
					</td>
					<td width="22%" style="text-align:right;">
						<?php if($trans->type == 'positive'): ?>
							<span class="sum-inc">+<?= number_format($trans->sum, 2, ".", " ") ?></span>
						<?php else: ?>
							<span class="sum-dec">-<?= number_format($trans->sum, 2, ".", " ") ?></span>
						<?php endif; ?>
						<?= $selectedAcc->currency->code ?></td>
					<td width="19%" style="text-align:right;">
						<?php if($trans->acc_balance >= 0): ?>
							<span class="sum-inc"><?= number_format($trans->acc_balance, 2, ".", " ") ?></span>
						<?php else: ?>
							<span class="sum-dec"><?= number_format($trans->acc_balance, 2, ".", " ") ?></span>
						<?php endif; ?>
						<?= $selectedAcc->currency->code ?></td>
					</td>
					<td width="7%">
                        <div class="contact-actions transaction-buttons-cont">
                            <div class="btn-group">
                                <a class="button menu" data-toggle="dropdown" href="#" onclick="javascript:return false;"></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="button edit" href="#"></a>
                                    </li>
                                    <li>
                                        <a class="button refresh" href="#"></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
					</td>
				</tr>
			<?php endif; ?>
            <tr class="note-tr">
                <td colspan="6">
                    <div class="note-cont">
                        <?= Yii::t('Front', 'Advertising giants Publicis and Omnicom announced in July that they were combining in'); ?>
                        <a href="#"><?= Yii::t('Front', 'More '); ?></a>
                    </div>

                </td>
            </tr>
		<?php endforeach; ?>
		<?php if(empty($transactions)): ?>
			<tr>
				<td colspan="5"><?= Yii::t('Front', 'No transaction match the filter criterias. Please, change the filter criterias in Advanced Search tab.') ?></td>
			</tr>
		<?php endif; ?>
	</tbody>
</table>