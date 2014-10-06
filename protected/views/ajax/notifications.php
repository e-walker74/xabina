<a href="#" data-toggle="dropdown" role="button"><?$count = $model->search()->getTotalItemCount();if($count){?><span><?= $count ?></span><?}?></a>
<div class="dropdown-menu notification-popup dialogues-popup" role="menu">
<div class="arrow_gray"></div>
<div class="popup-notify-select-cont">
    <div class="select-custom select-narrow ">
        <span class="select-custom-label">Notification Type</span>
        <select name="" class=" select-invisible country-select">
            <option value="">USD</option>
            <option value="">EUR</option>
            <option value="">RUB</option>
        </select>
    </div>
</div>


<div class="dialogues-content">
<div class="dialogues-list-cont">
<ul class="dialogues-popup-list list-unstyled">
<?php $this->widget('zii.widgets.CListView',array(
	'dataProvider'=>$model->search(),
	'itemView'=>'_notif_view',
	'template'=>'{items}'
)); ?>

</ul>
</div>

</div>
<a href="/banking/notifications" class="notification-all">See all notification</a>
</div>