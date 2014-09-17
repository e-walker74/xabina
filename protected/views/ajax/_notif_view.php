<li>
    <div class="message-container <?=$data->message->css_types[$data->message->type]?>">
        <div class="message-top">
            <div class="interlocutor-photo pull-left">
                <img src="/images/dialogues_photo_xabina.png" alt="">
            </div>
            <div class="news-title">
                <div class="author"><?=$data->message->manager->manager_name?> |</div>
				<span class="news-title-status <?=$data->message->sections[$data->message->section]?>"><?=Yii::t('Front', $data->message->section)?></span>
                <br/>

                <div class="news-datetime"><?=date('Y-m-d H:i',$data->message->published_at)?></div>
                <div class="news-status pin"></div>
            </div>
            <div class="message-actions-cont">
				<span class="drdn-cont">
					<a href="#" class="social-but" data-toggle="dropdown"></a>
					<ul class="dropdown-menu contact-select-dropdown list-actions-dropdown list-unstyled social-list"
						role="menu">

						<li class="clearfix">
							<a href="#" class="one-social-but fb"></a>
							<a href="#" class="one-social-but tw"></a>
							<a href="#" class="one-social-but vk"></a>
							<a href="#" class="one-social-but in"></a>
							<a href="#" class="one-social-but gog"></a>
						</li>
					</ul>
				</span>
				<span class="drdn-cont">
					<a href="#" class="act-but" data-toggle="dropdown"></a>
					<ul class="dropdown-menu contact-select-dropdown list-actions-dropdown list-unstyled act-list"
						role="menu">

						<li class="clearfix">
							<a href="#" class="action unread">Mark as unread</a>
						</li>
						<li class="clearfix">
							<a href="#" class="action favorite">Mark as favorites</a>
						</li>
						<li class="clearfix">
							<a href="#" class="action pin">Pin to top</a>
						</li>
					</ul>
				</span>
				<span class="drdn-cont">
					<a href="#" class="news-arrow-but" data-toggle="dropdown"></a>
				</span>
            </div>
        </div>
        <div class="news_content">
            <div class="message-text">
                <?=$data->message->announce?>
				<a href="#">Read more</a>
            </div>

            <div class="attachments-cont">
				<?if (count($data->message->files)) {?>
				<div class="files-many"></div>
                <div class="files-header">
                    <a href="#" class="news-files-toggle closed"><span><?=count($data->message->files)?> Files</span></a>

                    <div class="transaction-buttons-cont" style="margin: -3px 0 0"><a href="#"
                                                                                      class="button download-mini"></a>
                    </div>
                </div>
                <div class="clearfix"></div>
                <ul class="list-unstyled attachments-files-list" style="display: none;">
					<?

						foreach($data->message->files as $file) {
						?>
					<li>
                        <?=$file->file?>
                        <div class="transaction-buttons-cont" style="margin: -3px 0 0">
                            <a href="<?= Yii::app()->createUrl('/notifications/getfile', array('id'=>$file->id)) ?>" class="button download-mini"></a>
                        </div>
                    </li>

					<?}?>

                </ul>
				<?}?>
				<div class="news-border"></div>
				<a href="#" class="read_but">Mark as read</a>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</li>


<li style="display: none" class="notify-cat-<?=$data->message->sections[$data->message->section]?> notification-<?=($data->status == 'new')?
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