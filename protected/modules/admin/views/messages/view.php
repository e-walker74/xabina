<div id="wrap">
	<div id="page-heading">
		<h1><?= Yii::t('Messages', 'Messages') ?></h1>
	</div>

	<div class="container">
		<div class="panel panel-midnightblue">
			<div class="panel-heading ">
				<h4><?= Yii::t('Messages', 'Dialog with') ?>: <?= $model->email ?></h4>
				<div class="options">   
					<!--<a href="javascript:;"><i class="fa fa-cog"></i></a>
					<a href="javascript:;"><i class="fa fa-wrench"></i></a>-->
					<a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
				</div>
			</div>
			<div class="panel-body collapse in">
				<a class="btn btn-primary" href="<?= Yii::app()->createUrl('/admin/messages/create', array('dialog_id' => $messages[0]->dialog_id)) ?>"><?= Yii::t('Front', 'Reply') ?></a>
				<div style="clear: both;"></div>
				<?php foreach($messages as $mes): ?>
					<?php if($mes->user_id != $mes->from_id): ?>
						<blockquote class="pull-right">
							<p><?= $mes->message ?></p>
							<small><?= $mes->to->name ?> for <cite title="Source Title"><?= $mes->subject->title ?></cite></small>
						</blockquote>
						<div style="clear: both;"></div>
					<?php else: ?>
						<blockquote>
							<p><?= $mes->message ?></p>
							<small><?= $mes->user->email ?></small>
						</blockquote>
						<div style="clear: both;"></div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>
