<div class="xabina-form-container">
	<table class="table xabina-table-personal soc-nets">
		<tbody>
		<tr class="table-header">
			<th style="width: 7%"></th>
			<th style="width: 23%"><?= Yii::t('Front', 'Username'); ?></th>
			<th style="width: 22%"><?= Yii::t('Front', 'Full Name'); ?></th>
			<th style="width: 28%"><?= Yii::t('Front', 'Profile Url'); ?></th>
			<th style="width: 15%"><?= Yii::t('Front', 'Status'); ?></th>
			<th style="width: 5%"></th>
		</tr>
		<tr class="comment-tr">
			<td colspan="6"><?= Yii::t('Front', 'Description for social networks'); ?></td>
		</tr>
		<?php $user = Users::model()->findByPk(Yii::app()->user->id) ?>

		<?php foreach($user->socials as $soc): ?>
			<tr>
				<td><div class="soc-net-ico <?= array_search($soc->provider, Users_Providers::$providersModel); ?>"></div></td>
				<td><img class="soc-avatar" src="<?= $soc->getProvider()->avatar ?>" width="30" /> <?= $soc->getProvider()->login ?></td>
				<td><?= $soc->getProvider()->full_name ?></td>
				<td><?= $soc->getProvider()->url ?></td>
				<td>
					<?php if($soc->is_master): ?>
						<span class="primary"><?= Yii::t('Front', 'Primary'); ?></span>
					<?php else: ?>
						<a href="javaScript:void(0)" onclick="js:makePrimary('<?= Yii::app()->createUrl('/personal/makePrimary', array('type' => 'socials', 'id' => $soc->id)) ?>')" class="make-primary"><?= Yii::t('Front', 'Make primary'); ?></a>
					<?php endif; ?>
				</td>
				<td class="actions-td">
					<a href="javaScript:void(0)" onclick="js:confirm('<?= Yii::t('Front', 'Are you sure you want to delete this network from profile?') ?>') ? deleteRow('<?= Yii::app()->createUrl('/personal/delete', array('type' => 'social', 'id' => $soc->id)) ?>', this) : false;" class="remove-btn"></a>
				</td>
			</tr>
		<?php endforeach; ?>
		<tr>
			<td class="add-new-td" colspan="6">
				<?php $this->widget('application.ext.eauth.EAuthWidget', array('action' => '/personal/editsocials')); ?>
			</td>
		</tr>
		</tbody>
	</table>
	<div class="form-submit">
		<a href="<?= $this->createUrl('/banking/personal') ?>" class="submit-button button-back">Back</a>
	</div>
	<div class="clearfix"></div>
</div>
<?php Yii::app()->clientScript->registerScriptFile('http://vkontakte.ru/js/api/openapi.js'); ?>