<div class="transaction-table-header">
    <table class="transaction-header table xabina-table-personal  table-defaults">
        <tbody><tr class="table-header">
            <th width="13%"><?= Yii::t('Front', 'Date'); ?></th>
            <th width="24%"><?= Yii::t('Front', 'From'); ?></th>
            <th width="31%"><?= Yii::t('Front', 'To'); ?></th>
            <th width="23%"><?= Yii::t('Front', 'Value'); ?></th>
            <th width="7%"> </th>
        </tr>
        </tbody></table>
</div>

<div class="transaction-table-overflow" style="overflow: inherit;">
    <table class="table">
        <tbody>
        <?php if(!count($transaction)): ?>
            <tr class="comment-tr" style="cursor: default!important">
                <td colspan="5">
                    <span><?= Yii::t('Front', 'You have not linked any transfers to this contact yet.'); ?></span>
                </td>
            </tr>
        <?php else: ?>
            <?php foreach($transaction as $trans): ?>
                <tr style="overflow: visible!important">
                    <td width="14%" class="clickable-row" data-url="<?= Yii::app()->createUrl('/accounts/transaction', array('id' => $trans['url'])) ?>"><?= date('d.m.Y', $trans['created_at']) ?></td>
                    <td width="26%" class="clickable-row" data-url="<?= Yii::app()->createUrl('/accounts/transaction', array('id' => $trans['url'])) ?>">
                        <strong class="holder"><?= $trans['from_holder'] ?></strong><br>
                        <span class="account"><?= $trans['from_number'] ?></span>
                    </td>
                    <td width="33%" class="clickable-row" data-url="<?= Yii::app()->createUrl('/accounts/transaction', array('id' => $trans['url'])) ?>">
                        <strong class="holder"><?= $trans['to_holder'] ?></strong><br>
                        <span class="account"><?= $trans['to_number'] ?></span>
                    </td>
                    <td width="19%" class="clickable-row" data-url="<?= Yii::app()->createUrl('/accounts/transaction', array('id' => $trans['url'])) ?>"><span class="<?= ($trans['type'] == 'positive') ? 'sum-inc' : 'sum-dec' ?>">
						<?= ($trans['type'] == 'positive') ? '+' : '-' ?>
                        <?= number_format($trans['amount'], 2, ".", " ") ?></span> <?= $trans['currency'] ?></td>
                    <td width="8%" style="overflow: visible!important">
                        <div class="contact-actions transaction-buttons-cont">
                            <div class="btn-group with-delete-confirm">
                                <a class="button menu" data-toggle="dropdown" href="#"></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <?= Html::link('',
                                            array('/accounts/transaction', 'id' => $trans['url']),
                                            array(
                                                'class' => 'button eye',
                                                'title' => Yii::t('Front', 'Show transaction info')
                                            )) ?>
                                    </li>
                                    <li>
                                        <?= Html::link('',
                                            'javaScript:void(0)',
                                            array(
                                                'onclick' => '$(this).addClass(\'opened\')',
                                                'class' => 'button link',
                                                'data-url' => Yii::app()->createUrl('/contact/unlinkcontragent', array('type' => $trans['transfer_type'], 'id' => $trans['transfer_id'], 'contact_id' => $model->id))
                                            )) ?>
                                    </li>
                                    <li>
                                        <?= Html::link('',
                                            array(
                                                '/transfers/duplicate',
                                                'type' => $trans['transfer_type'],
                                                'id' => $trans['transfer_id'],
                                            ), array(
                                                'class' => 'button refresh',
                                                'title' => Yii::t('Front', 'Repeat transaction')
                                            )) ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php if($trans['description']): ?>
                    <tr class="note-tr">
                        <td colspan="5">
                            <div class="note-cont">
                                <div class="short-description"><?= SiteService::subStrEx($trans['description'], 100)  ?>
                                    <?php if(mb_strlen($trans['description']) > 100): ?>
                                        <a onclick="$(this).closest('div').hide().next().show()" href="javaScript:void(0)"><?= Yii::t('Front', 'More'); ?></a>
                                    <?php endif ;?></div>
                                <div class="description" style="display: none">
                                    <?= $trans['description'] ?>
                                    <a onclick="$(this).closest('div').hide().prev().show()" href="javaScript:void(0)"><?= Yii::t('Front', 'Short'); ?></a>
                                </div>
                            </div>

                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody></table>
</div>
<script>
    $(document).ready(function(){
        $('.transaction-table-overflow .transaction-buttons-cont .link').confirmation({
            title: '<?= Yii::t('Front', 'Are you sure?') ?>',
            singleton: true,
            popout: true,
            onConfirm: function(){
                var next = $(this).parents('.popover').prev('a').closest('tr').next('tr')
                if(next.hasClass('note-tr')){
                    next.remove()
                }
                deleteRow($(this).closest('.popover').prev('a'));
                return false;
            }
        })
    })
</script>