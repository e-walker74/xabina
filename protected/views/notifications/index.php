
<div class="col-lg-9 col-md-9 col-sm-9">
<div class="news-tabs-cont">
<ul class="list-unstyled news_tabs">
    <li><a href="#tab1">News<span class="messages-count">6</span></a></li>
    <li><a href="#tab2">Accounts<span class="messages-count">1</span></a></li>
    <li><a href="#tab3">Transaction</a></li>
</ul>
<div class="news-tab-cont" id="tab1">
<div class="balance-accordion filter-accordion xabina-accordion" id="search_accordion">
    <div class="accordion-header">
        <a href="#" class="search-acc">Show Filter</a>

        <div class="news-open"><a class="link" href="news_only.html" target="_blank" onclick="event.stopPropagation();"></a>
        </div>
    </div>
    <div class="accordion-content">
		<form id="notifications_filter">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 ">
					<div class="select-custom select-narrow">
						<span class="select-custom-label"><?=Yii::t('Front','Category')?></span>
						<?php echo CHtml::activeDropDownList($model, 'section', Users_Notifications::model()->sections,array('prompt'=>Yii::t('Front','Category'),'class' => 'select-invisible')); ?>

					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 ">
					<div class="select-custom select-narrow">
						<span class="select-custom-label"><?=Yii::t('Front','Notification Type')?></span>
						<?php echo CHtml::activeDropDownList($model, 'type', Users_Notifications::model()->types,array('prompt'=>Yii::t('Front','Notification Type'),'class' => 'select-invisible')); ?>

					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 ">
					<div class="chose_year">
						<div class="list_year">
							<span>2013</span>
							<span>2014</span>

							<div class="clearfix"></div>
						</div>
						<div class="year_and_month" style="display: none;">
							<a class="active_year"><span class="val_year">2013</span><span class="x_year"></span></a>

							<div class="tire"></div>
							<label><input type="checkbox">Jan</label>
							<label><input type="checkbox">Feb</label>
							<label><input type="checkbox">Mar</label>
							<label><input type="checkbox">Apr</label>
							<label><input type="checkbox">May</label>
							<label><input type="checkbox">Jun</label>
							<label><input type="checkbox">Jul</label>
							<label><input type="checkbox">Aug</label>
							<label><input type="checkbox">Sep</label>
							<label><input type="checkbox">Oct</label>
							<label><input type="checkbox">Nov</label>
							<label><input type="checkbox">Dec</label>

							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</form>
    </div>
</div>
<div class="dialoques-table dialogues-content news-type">
	<div class="dialogues-messages">
		<ul class="dialogues-list list-unstyled">
			<?php $this->widget('zii.widgets.CListView',array(
				'dataProvider'=>$model->search(),
				'itemView'=>'_notif_view',
				'id'=>'notifListView',
				'template'=>'{items}{pager}',
				'pager' => array(
					'class' => 'ext.infiniteScroll.IasPager',
					'rowSelector'=>'li.nrow',
					'listViewId' => 'notifListView',
					'header' => '',
					'loaderText'=>'Loading...',
					'options' => array('history' => false, 'triggerPageTreshold' => 5, 'trigger'=>'Load more'),
			  	)

			)); ?>
		</ul>
	</div>
</div>
</div>
<div class="news-tab-cont" id="tab2">
    <table class="table xabina-table">
        <tr class="table-header">
            <th style="width: 27%">Account</th>
            <th style="width: 19%">Type</th>
            <th style="width: 18%">Environment</th>
            <th class="text-right" style="width: 17%">Amount</th>
            <th style="width: 11%">Сurrency</th>
            <th style="width: 8%"></th>
        </tr>
        <tr>
            <td>
                John Doe <br/>
                <span class="bold">0252 0989 0890 9890</span> <br/>
                <span class="grey">Семейный</span>
            </td>
            <td>Кредитный</td>
            <td>BlauStein</td>
            <td class="text-right"><span class="approved">1 000 000.00</span></td>
            <td class="currency-td">
                <div class="relative"><span class="dropdown_button">EUR</span></div>
            </td>
            <td>
                <div class="transaction-buttons-cont ">
                    <a href="#" class="button edit"></a>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                John Doe <br/>
                <span class="bold">0252 0989 0890 9890</span> <br/>
                <span class="grey">Семейный</span>
            </td>
            <td>Кредитный</td>
            <td>BlauStein</td>
            <td class="text-right"><span class="approved">1 000 000.00</span></td>
            <td class="currency-td">
                <div class="relative"><span class="dropdown_button">EUR</span></div>
            </td>
            <td>
                <div class="transaction-buttons-cont ">
                    <a href="#" class="button edit"></a>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                John Doe <br/>
                <span class="bold">0252 0989 0890 9890</span> <br/>
                <span class="grey">Семейный</span>
            </td>
            <td>Кредитный</td>
            <td>BlauStein</td>
            <td class="text-right"><span class="rejected">1 000 000.00</span></td>
            <td class="currency-td">
                <div class="relative"><span class="dropdown_button">EUR</span></div>
            </td>
            <td>
                <div class="transaction-buttons-cont ">
                    <a href="#" class="button edit"></a>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                John Doe <br/>
                <span class="bold">0252 0989 0890 9890</span> <br/>
                <span class="grey">Семейный</span>
            </td>
            <td>Кредитный</td>
            <td>BlauStein</td>
            <td class="text-right"><span class="approved">1 000 000.00</span></td>
            <td class="currency-td">
                <div class="relative"><span class="dropdown_button">EUR</span></div>
            </td>
            <td>
                <div class="transaction-buttons-cont ">
                    <a href="#" class="button edit"></a>
                </div>
            </td>
        </tr>
        <tr class="totals">
            <td colspan="3" class="totals-lbl"><span>Общая сумма:</span></td>
            <td class="text-right"><span class="rejected">15 000</span></td>
            <td style="overflow: visible!important" class="currency-td">
                <div class="relative"><span class="dropdown_button  currency_dropdown">EUR <span
                        class="currency_drdn_arr"></span></span></div>
            </td>
            <td></td>
        </tr>

    </table>
</div>
<div class="news-tab-cont" id="tab3">
<div class="transaction-table-header">
    <table class="transaction-header">
        <tr>
            <td style="width: 13%;">Date</td>
            <td style="width: 9%;">Type</td>
            <td style="width: 23%;">From</td>
            <td style="width: 22%;">To</td>
            <td style="width: 24%;" class="text-right">Value</td>
            <td style="width: 9%;">&nbsp;</td>
        </tr>
    </table>


</div>
<div class="transaction-table-overflow" style=" border-top: 1px solid #cccdd2;">
<table class="table">
<tr>
    <td width="14%">12.01.2014</td>
    <td width="8%">OV</td>
    <td width="25%">
        <strong class="holder">Viktor Kupets</strong><br>
        <span class="account"> 0121 0101 2585 01541</span>
    </td>
    <td width="25%">
        <strong class="holder">Viktor Kupets</strong><br>
        <span class="account"> 0121 0101 2585 01541</span>
    </td>
    <td width="21%" class="text-right"><span class="sum-inc">+1 000 000</span> EUR</td>
    <td width="7%" style="overflow: visible!important">
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
<tr class="note-tr">
    <td colspan="6">
        <div class="note-cont">
            Advertising giants Publicis and Omnicom announced in July that they were combining in
            <a class="more-link" href="#">More</a>
        </div>

    </td>
</tr>
<tr>
    <td width="14%">12.01.2014</td>
    <td width="8%">OV</td>
    <td width="25%">
        <strong class="holder">Viktor Kupets</strong><br>
        <span class="account"> 0121 0101 2585 01541</span>
    </td>
    <td width="25%">
        <strong class="holder">Viktor Kupets</strong><br>
        <span class="account"> 0121 0101 2585 01541</span>
    </td>
    <td width="21%" class="text-right"><span class="sum-dec">+1 000 000</span> EUR</td>
    <td width="7%" style="overflow: visible!important">
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
<tr class="note-tr">
    <td colspan="6">
        <div class="note-cont">
            Advertising giants Publicis and Omnicom announced in July that they were combining in
            <a class="more-link" href="#">More</a>
        </div>

    </td>
</tr>
<tr>
    <td width="14%">12.01.2014</td>
    <td width="8%">OV</td>
    <td width="25%">
        <strong class="holder">Viktor Kupets</strong><br>
        <span class="account"> 0121 0101 2585 01541</span>
    </td>
    <td width="25%">
        <strong class="holder">Viktor Kupets</strong><br>
        <span class="account"> 0121 0101 2585 01541</span>
    </td>
    <td width="21%" class="text-right"><span class="sum-dec">+1 000 000</span> EUR</td>
    <td width="7%" style="overflow: visible!important">
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
<tr class="note-tr">
    <td colspan="6">
        <div class="note-cont">
            Advertising giants Publicis and Omnicom announced in July that they were combining in
            <a class="more-link" href="#">More</a>
        </div>

    </td>
</tr>
<tr>
    <td width="14%">12.01.2014</td>
    <td width="8%">OV</td>
    <td width="25%">
        <strong class="holder">Viktor Kupets</strong><br>
        <span class="account"> 0121 0101 2585 01541</span>
    </td>
    <td width="25%">
        <strong class="holder">Viktor Kupets</strong><br>
        <span class="account"> 0121 0101 2585 01541</span>
    </td>
    <td width="21%" class="text-right"><span class="sum-dec">+1 000 000</span> EUR</td>
    <td width="7%" style="overflow: visible!important">
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
<tr class="note-tr">
    <td colspan="6">
        <div class="note-cont">
            Advertising giants Publicis and Omnicom announced in July that they were combining in
            <a class="more-link" href="#">More</a>
        </div>

    </td>
</tr>
<tr>
    <td width="14%">12.01.2014</td>
    <td width="8%">OV</td>
    <td width="25%">
        <strong class="holder">Viktor Kupets</strong><br>
        <span class="account"> 0121 0101 2585 01541</span>
    </td>
    <td width="25%">
        <strong class="holder">Viktor Kupets</strong><br>
        <span class="account"> 0121 0101 2585 01541</span>
    </td>
    <td width="21%" class="text-right"><span class="sum-inc">+1 000 000</span> EUR</td>
    <td width="7%" style="overflow: visible!important">
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
<tr class="note-tr">
    <td colspan="6">
        <div class="note-cont">
            Advertising giants Publicis and Omnicom announced in July that they were combining in
            <a class="more-link" href="#">More</a>
        </div>

    </td>
</tr>
<tr>
    <td width="14%">12.01.2014</td>
    <td width="8%">OV</td>
    <td width="25%">
        <strong class="holder">Viktor Kupets</strong><br>
        <span class="account"> 0121 0101 2585 01541</span>
    </td>
    <td width="25%">
        <strong class="holder">Viktor Kupets</strong><br>
        <span class="account"> 0121 0101 2585 01541</span>
    </td>
    <td width="21%" class="text-right"><span class="sum-inc">+1 000 000</span> EUR</td>
    <td width="7%" style="overflow: visible!important">
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
<tr class="note-tr">
    <td colspan="6">
        <div class="note-cont">
            Advertising giants Publicis and Omnicom announced in July that they were combining in
            <a class="more-link" href="#">More</a>
        </div>

    </td>
</tr>
<tr>
    <td width="14%">12.01.2014</td>
    <td width="8%">OV</td>
    <td width="25%">
        <strong class="holder">Viktor Kupets</strong><br>
        <span class="account"> 0121 0101 2585 01541</span>
    </td>
    <td width="25%">
        <strong class="holder">Viktor Kupets</strong><br>
        <span class="account"> 0121 0101 2585 01541</span>
    </td>
    <td width="21%" class="text-right"><span class="sum-inc">+1 000 000</span> EUR</td>
    <td width="7%" style="overflow: visible!important">
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
<tr class="note-tr">
    <td colspan="6">
        <div class="note-cont">
            Advertising giants Publicis and Omnicom announced in July that they were combining in
            <a class="more-link" href="#">More</a>
        </div>

    </td>
</tr>
<tr>
    <td width="14%">12.01.2014</td>
    <td width="8%">OV</td>
    <td width="25%">
        <strong class="holder">Viktor Kupets</strong><br>
        <span class="account"> 0121 0101 2585 01541</span>
    </td>
    <td width="25%">
        <strong class="holder">Viktor Kupets</strong><br>
        <span class="account"> 0121 0101 2585 01541</span>
    </td>
    <td width="21%" class="text-right"><span class="sum-inc">+1 000 000</span> EUR</td>
    <td width="7%" style="overflow: visible!important">
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
<tr class="note-tr">
    <td colspan="6">
        <div class="note-cont">
            Advertising giants Publicis and Omnicom announced in July that they were combining in
            <a class="more-link" href="#">More</a>
        </div>

    </td>
</tr>

</table>
</div>
</div>
</div>
</div>







<?
$model->status = Users_NotificationsStatuses::STATUS_NEW;
?>
<div class="col-lg-9 col-md-9 col-sm-9" style="display: none">
            <div class="h1-header"><?= Yii::t('Front', 'Notifications'); ?></div>
            <div class="edit-tabs notify-tabs ui-tabs ui-widget ui-widget-content ui-corner-all">
                <ul class="list-unstyled ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
                    <li style="width: 25%" class="ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="0" aria-controls="tab1" aria-labelledby="ui-id-1" aria-selected="true"><a href="#tab1" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-1"><div class="general">&nbsp;</div></a><?$count = $model->search()->getTotalItemCount();if($count){?><span class="notification-count"><?= $count ?></span><?}?></li>
                    <li style="width: 25%" class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tab2" aria-labelledby="ui-id-2" aria-selected="false"><a href="#tab2" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-2"><div class="danger">&nbsp;</div></a><?$count = $model->search(Users_Notifications::TYPE_EMERGENCY)->getTotalItemCount();if($count){?><span class="notification-count"><?= $count ?></span><?}?></li>
                    <li style="width: 25%" class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tab3" aria-labelledby="ui-id-3" aria-selected="false"><a href="#tab3" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-3"><div class="warning">&nbsp;</div></a><?$count = $model->search(Users_Notifications::TYPE_WARNING)->getTotalItemCount();if($count){?><span class="notification-count"><?= $count ?></span><?}?></li>
                    <li style="width: 25%" class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tab4" aria-labelledby="ui-id-4" aria-selected="false"><a href="#tab4" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-4"><div class="info">&nbsp;</div></a><?$count = $model->search(Users_Notifications::TYPE_INFORMATION)->getTotalItemCount();if($count){?><span class="notification-count"><?= $count ?></span><?}?></li>
                </ul>
<?
$model->status = null;
?>
                <div class="clearfix"></div>
                <div id="tab1" aria-labelledby="ui-id-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="true" aria-hidden="false">
                    <div class="notification-table-header">
                            <table class="notification-header">
                                <tbody><tr>
                                    <td colspan="99">

                                        <div class="select-custom select-notification">
                                        <span class="select-custom-label">

                                        </span>
											<?php echo CHtml::dropDownList('section', '', Users_Notifications::model()->sections,array('prompt'=>Yii::t('Front','Select category'),'class' => 'select-invisible')); ?>
                                        </div>


                                    </td>
                                </tr>
                            </tbody></table>
                        </div>
                    <div class="dialogues-content" style="border: 1px solid #cccdd2">
                    <div class="dialogues-list-cont">
                        <ul class="dialogues-list list-unstyled">
<?php $this->widget('zii.widgets.CListView',array(
	'dataProvider'=>$model->search(),
	'itemView'=>'_notif_view',
	'template'=>'{items}'
)); ?>

                    </ul>
                    </div>

                    </div>
                </div>
                <div id="tab2" aria-labelledby="ui-id-2" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="false" aria-hidden="true" style="display: none;">
                <div class="notification-table-header">
                    <table class="notification-header">
                        <tbody><tr>
                            <td colspan="99">

                                <div class="select-custom select-notification">
                                        <span class="select-custom-label">

                                        </span>
                                    	<?php echo CHtml::dropDownList('section', '', Users_Notifications::model()->sections,array('prompt'=>Yii::t('Front','Select category'),'class' => 'select-invisible')); ?>


                                </div>


                            </td>
                        </tr>
                    </tbody></table>
                </div>
                <div class="dialogues-content" style="border: 1px solid #cccdd2">
                    <div class="dialogues-list-cont">
                        <ul class="dialogues-list list-unstyled">

<?php
$this->widget('zii.widgets.CListView',array(
	'dataProvider'=>$model->search(Users_Notifications::TYPE_EMERGENCY),
	'itemView'=>'/notifications/_notif_view',
	'emptyText'=>'<div class="empty-list">'.Yii::t('Front', 'There is no notification in this section.').'</div>',
	'template'=>'{items}'
)); ?>
                        </ul>
                    </div>
                </div>
                </div>
                <div id="tab3" aria-labelledby="ui-id-3" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="false" aria-hidden="true" style="display: none;">
                <div class="notification-table-header">
                    <table class="notification-header">
                        <tbody><tr>
                            <td colspan="99">

                                <div class="select-custom select-notification">
                                        <span class="select-custom-label">

                                        </span>
                                    	<?php echo CHtml::dropDownList('section', '', Users_Notifications::model()->sections,array('prompt'=>Yii::t('Front','Select category'),'class' => 'select-invisible')); ?>


                                </div>


                            </td>
                        </tr>
                    </tbody></table>
                </div>
                <div class="dialogues-content" style="border: 1px solid #cccdd2">
                    <div class="dialogues-list-cont">
                        <ul class="dialogues-list list-unstyled">
                            <?php
$this->widget('zii.widgets.CListView',array(
	'dataProvider'=>$model->search(Users_Notifications::TYPE_WARNING),
	'itemView'=>'/notifications/_notif_view',
	'emptyText'=>'<div class="empty-list">'.Yii::t('Front', 'There is no notification in this section.').'</div>',
	'template'=>'{items}'
)); ?>
                        </ul>
                    </div>
                </div>
                </div>
                <div id="tab4" aria-labelledby="ui-id-4" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="false" aria-hidden="true" style="display: none;">
                <div class="notification-table-header">
                    <table class="notification-header">
                        <tbody><tr>
                            <td colspan="99">

                                <div class="select-custom select-notification">
                                        <span class="select-custom-label">

                                        </span>
                                    	<?php echo CHtml::dropDownList('section', '', Users_Notifications::model()->sections,array('prompt'=>Yii::t('Front','Select category'),'class' => 'select-invisible')); ?>


                                </div>


                            </td>
                        </tr>
                    </tbody></table>
                </div>
                <div class="dialogues-content" style="border: 1px solid #cccdd2">
                    <div class="dialogues-list-cont">
                        <ul class="dialogues-list list-unstyled">
                            <?php
$this->widget('zii.widgets.CListView',array(
	'dataProvider'=>$model->search(Users_Notifications::TYPE_INFORMATION),
	'itemView'=>'/notifications/_notif_view',
	'emptyText'=>'<div class="empty-list">'.Yii::t('Front', 'There is no notification in this section.').'</div>',
	'template'=>'{items}'
)); ?>
                        </ul>
                    </div>
                </div>
                </div>
            </div>
        </div>