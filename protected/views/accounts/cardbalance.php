
<div class="col-lg-9 col-md-9 col-sm-9">
    <?php $form=$this->beginWidget('CActiveForm', array(
        //'action'=>Yii::app()->createUrl(),
        'method'=>'get',
        'id' => 'searchForm',
        'htmlOptions' => array(
            'class' => 'advanced-search-form',
            'data-pdf-url' => $this->createUrl('/accounts/transactionsonpdf').'/',
            'data-pdfp-url' => $this->createUrl('/accounts/transactionsonpdfp/').'/',
            'data-doc-url' => $this->createUrl('/accounts/transactionsondoc').'/',
            'data-csv-url' => $this->createUrl('/accounts/transactionsoncsv').'/',
            'data-xls-url' => $this->createUrl('/accounts/transactionsonxls').'/'
        ),
    )); ?>
	<div class="h1-header"><?= Yii::t('Front', 'Balance'); ?></div>
	<?php $this->widget('XabinaAlert'); ?>



    <div class="account-selection xabina-form-narrow">

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-cell">
                    <div class="form-lbl"><?= Yii::t('Front', 'Account'); ?></div>
                    <div class="form-input">
                        <div class="select-custom select-narrow account-select-holder">
                                    <span class="select-custom-label">
					<?= $selectedAcc->user->fullName ?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?= chunk_split($selectedAcc->number, 4) ?>
                                        <?/*
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?= number_format($selectedAcc->balance, 0, "", " ") ?>
                                        <?= $selectedAcc->currency->title ?>
                                        */?>
				</span>
                            <select name="" class=" select-invisible">
                                <?php foreach($accounts as $acc): ?>
                                    <option <?php if($acc->number == $selectedAcc->number): ?>selected<?php endif; ?> value="<?= $acc->number ?>">
                                        <?= $acc->user->fullName ?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?= chunk_split($acc->number, 4) ?>
                                        <?/*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?= number_format($acc->balance, 0, "", " ") ?>
                                        <?= $acc->currency->title ?>
                                        */?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-cell">
                    <div class="form-lbl"><?= $model->getAttributeLabel('keyword') ?> </div>
                    <div class="form-input">
                        <?= $form->textField($model, 'keyword', array('autocomplete' => 'off', 'class' => 'input-text', 'placeholder' => Yii::t('Front', 'You can filter transactions by Sender, Account number or any Keyword'))); ?>
                        <span class="clear-input-but-for-all" id="clear-keyword"></span>

                        <?= $form->hiddenField($model, 'account_number', array('id'=>'searchForm_account_number')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<div class="balance-accordion xabina-accordion" id="search_accordion">
		<div class="accordion-header"><a href="#" class="search-acc"><?= Yii::t('Front', 'Advanced search'); ?> </a><span class="arr"></span></div>
		<div class="accordion-content">
            <div class="advanced-search-form xabina-form-narrow">
				<div class="row second-row" >
					<div class="col-nested-3">
						<div class="form-cell">
                            <div class="form-lbl"><?= Yii::t('Front', 'Date'); ?></div>
                            <div class="form-input ">
                                <?= $form->textField($model, 'from_date', array('autocomplete' => 'off', 'class' => 'input-text calendar-input-2 calendar-input')); ?>
                                <span class="calendar-ico"></span>
                            </div>
                        </div>
                        <div class="form-cell">
                            <div class="form-input two-line">
                                <?= $form->textField($model, 'to_date', array('autocomplete' => 'off', 'class' => 'input-text calendar-input-2 calendar-input')); ?>
                                <span class="calendar-ico"></span>
                            </div>
                        </div>
					</div>
					<div class="col-nested-3 transaction-sum">
                        <div class="form-cell">
                            <div class="form-lbl "><?= Yii::t('Front', 'Sum') ?></div>
                            <div class="form-input ">
                                <span class="from-lbl"><?= Yii::t('Front', 'from') ?></span>
                                <?= $form->textField($model, 'from_sum', array('autocomplete' => 'off', 'class' => 'input-text two-row-input numeric-currency')); ?>
                            </div>
                        </div>
                        <div class="form-cell">
                            <div class="form-input two-line">
                                <span class="from-lbl "><?= Yii::t('Front', 'to') ?></span>
                                <?= $form->textField($model, 'to_sum', array('autocomplete' => 'off', 'class' => 'input-text two-row-input numeric-currency')); ?>
                            </div>
                        </div>
					</div>
					<div class="col-nested-3">
                        <div class="form-cell">
                            <div class="form-lbl empty">&nbsp;</div>
                            <div class="form-input ">
                                <div class="select-custom select-narrow">
                                <span class="select-custom-label"><?= Yii::t('Front', 'All transactions') ?></span>
                                    <?=  $form->dropDownList($model, 'type', array(
                                        '' => Yii::t('Front', 'All transactions'),
                                        'incoming' => Yii::t('Front', 'Incoming'),
                                        'outgoing' => Yii::t('Front', 'Outgoing'),
                                    ), array('class' => 'select-invisible')); ?>
                                </div>
                            </div>
						</div>
                        <div class="form-cell">
                            <div class="field-input form-input two-line" style="margin: 7px  0 0;">
                                <div class="button-find" onclick="js:searchTransactions(this); return false;"><?= Yii::t('Front', 'Search'); ?></div>
                            </div>
                            <input type="submit" class="hidden" onclick="js:searchTransactions(this); return false;" value="<?= Yii::t('Front', 'Search'); ?>" />
						</div>
					</div>
				</div>
            </div>
		</div>
	</div>

	<div class="subheader"><?= Yii::t('Front', 'Transaction'); ?>
        <div class="relative pull-right transaction-actions transaction-buttons-cont">

            <div class="btn-group">
                <a href="#" class="button download" data-toggle="dropdown"></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="button pdf file-export-get" data-id="pdf" href="#"></a>
                    </li>
                    <li>
                        <a class="button xls file-export-get" data-id="xls" href="#"></a>
                    </li>
                    <li>
                        <a class="button doc file-export-get" data-id="doc" href="#"></a>
                    </li>
                    <li>
                        <a class="button csv file-export-get" data-id="csv" href="#"></a>
                    </li>
                </ul>
            </div>
<!--            <div class="btn-group">-->
<!--                <a href="#" class="button menu" data-toggle="dropdown"></a>-->
<!--                <ul class="dropdown-menu">-->
<!--                    <li>-->
<!--                        <a class="button send" href="#"></a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="button file-export-get print" data-id="pdfp" href="#"></a>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </div>-->
        </div>

	</div>
    <?php $this->endWidget(); ?>
	<div class="transaction-table-overflow no-overflow"><table class="table  right-button-clickable">
            <thead>
                <tr class="transaction-header">
                    <th style="width: 15%;"><?= Yii::t('Front', 'Date'); ?></th>
                    <th style="width: 10%;"><?= Yii::t('Front', 'Type'); ?></th>
                    <th style="width: 25%;"><?= Yii::t('Front', 'Account'); ?></th>
                    <th style="width: 21%;" class="text-right"><?= Yii::t('Front', 'Value'); ?></th>
                    <th style="width: 20%;" class="text-right"><?= Yii::t('Front', 'Balance'); ?></th>
                    <th  style="width: 9%;"> </th>
                </tr>
            </thead>
            <tbody>
		        <?php $this->renderPartial('cardbalance/_table', array('selectedAcc' => $selectedAcc, 'transactions' => $transactions)) ?>
            </tbody>
        </table>
    </div>
    <div class="load-more-container">
        <div class="load-more-text">
            <a href="#" class="load-more-arr-transactions"><?= Yii::t('Front', 'Load more'); ?></a>
        </div>
        <div class="load-more-arr">
            <a href="#" class="load-more-arr-transactions"></a>
        </div>
    </div>
	
	<?php $this->widget('AdsBlocks'); ?>

</div>

<?php Yii::app()->clientScript->registerScriptFile('/js/balance.js'); ?>