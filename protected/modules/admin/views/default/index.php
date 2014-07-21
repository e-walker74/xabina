<h1>Dashboard</h1>

<div class="col-md-12">
	<div class="tab-content">
		<div class="row">
			<div class="col-md-3">
				<a class="info-tiles tiles-info" href="<?= Yii::app()->createUrl('/admin/users/admin/') ?>">
					<div class="tiles-heading">
						<div class="pull-left"><?= Yii::t('Users', 'Users'); ?></div>
						<!--<div class="pull-right"><i class="fa fa-caret-up"></i> 9.8%</div>-->
					</div>
					<div class="tiles-body">
						<div class="pull-left"><i class="fa fa-group"></i></div>
						<div class="pull-right"><?= Users::model()->count()?></div>
					</div>
				</a>
			</div>
			<div class="col-md-3">
				<a class="info-tiles tiles-magenta" href="<?= Yii::app()->createUrl('/admin/accounts/index/') ?>">
					<div class="tiles-heading">
						<div class="pull-left"><?= Yii::t('Users', 'Accounts'); ?></div>
						<!--<div class="pull-right"><i class="fa fa-caret-up"></i> 9.8%</div>-->
					</div>
					<div class="tiles-body">
						<div class="pull-left"><i class="fa fa-credit-card"></i></div>
						<div class="pull-right"><?= Accounts::model()->count()?></div>
					</div>
				</a>
			</div>
			<div class="col-md-6">
				<div class="panel panel-indigo">
					<div class="panel-heading">
						<h4>New Users</h4>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table" style="margin-bottom: 0px;">
								<thead>
									<tr>
										<th class="col-xs-9 col-sm-3">Registered</th>
										<th class="col-sm-6 hidden-xs">Email Address</th>
										<th class="col-xs-2 col-sm-2">Status</th>
									</tr>
								</thead>
								<tbody class="selects">
									<?php foreach($users as $user): ?>
										<tr>
											<td><?= date("d-m-Y H:i", $user->created_at) ?></td>
											<td class="hidden-xs"><?= $user->email ?></td>
											<td>
												<?php if($user->status == Users::USER_IS_NOT_ACTIVE): ?>
													<span class="label label-grape"><?= Yii::t('Front', 'USER_IS_NOT_ACTIVE'); ?></span>
												<?php endif; ?>
												<?php if($user->status == Users::USER_EMAIL_IS_ACTIVE): ?>
													<span class="label label-danger"><?= Yii::t('Front', 'USER_EMAIL_IS_ACTIVED'); ?></span>
												<?php endif; ?>
												<?php if($user->status == Users::USER_IS_ACTIVATED): ?>
													<span class="label label-warning"><?= Yii::t('Front', 'USER_IS_ACTIVATED'); ?></span>
												<?php endif; ?>
												<?php if($user->status == Users::USER_IS_VERIFICATED): ?>
													<span class="label label-success"><?= Yii::t('Front', 'USER_IS_VERIFICATED'); ?></span>
												<?php endif; ?>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>