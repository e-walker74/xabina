<li class="notify-cat-<?=$data->message->sections[$data->message->section]?> notification-<?=($data->status == 'new')?
	$data->message->css_types[$data->message->type]:'na'?>
	<?=$data->message->css_types[$data->message->type]?>">
	<div class="notify-category-ico pull-left <?=$data->message->sections[$data->message->section]?>">
	</div>
	<div class="message-container ">
		<div class="message-arr"></div>
		<div class="message-top">
			<div class="interlocutor-name"><?=$data->message->manager->manager_name?></div>
			<div class="meassage-datetime"><?=date('Y-m-d H:i',$data->message->published_at)?></div>
			<div class="message-status sent1"></div>
			<div class="message-actions-cont">
				<a class="notify-button-ok" href="<?=$data->message->button_link?>"></a>
			</div>
		</div>
		<div class="message-text">
			<?=$data->message->announce?>
			<?if (count($data->message->files)) {
				echo 'Files:<br/>';
				foreach($data->message->files as $file) {
				?>
			<a href="<?= Yii::app()->createUrl('/notifications/getfile', array('id'=>$file->id)) ?>/"><?=$file->file?></a><br/>
			<?}}?>
		</div>
		<div class="clearfix"></div>
	</div>
</li>