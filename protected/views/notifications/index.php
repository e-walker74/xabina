
<div class="col-lg-9 col-md-9 col-sm-9">
<div class="news-tabs-cont">
<ul class="list-unstyled news_tabs">
    <li><a href="#tab1">News<?$model->status = Users_NotificationsStatuses::STATUS_NEW;$count = $model->search()->getTotalItemCount();if($count){?><span class="messages-count"><?= $count ?></span><?}$model->status=null;?></a></li>
    <li><a href="#tab2" data-url="<?= Yii::app()->createUrl('/accounts/index') ?>"><?= Yii::t('Notifications', 'Accounts') ?></a></li>
    <li><a href="#tab3" data-url="<?= Yii::app()->createUrl('/transaction/list') ?>"><?= Yii::t('Notifications', 'Transaction') ?></a></li>
</ul>
<div class="news-tab-cont" id="tab1">
<div class="balance-accordion filter-accordion xabina-accordion" id="search_accordion">
    <div class="accordion-header">
        <a href="#" class="search-acc">Show Filter</a>

<!--        <div class="news-open"><a class="link" href="news_only.html" target="_blank" onclick="event.stopPropagation();"></a>-->
<!--        </div>-->
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
</div>
<div class="news-tab-cont" id="tab3">
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