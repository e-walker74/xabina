<div class="col-lg-9 col-md-9 col-sm-9" >
	<div class="h1-header"><?= Yii::t('Front', 'My personal cabinet'); ?></div>

	<?php $this->widget('XabinaAlert'); ?>

	<table class="table xabina-table table-account">
		<tr class="table-header">
			<th width="37%"><?= Yii::t('Front', 'Section'); ?></th>
			<th width="52%"><?= Yii::t('Front', 'Description'); ?></th>
			<th width="11%"></th>
		</tr>
		<tr>
			<td class="header"><?= Yii::t('Front', 'Personal Information Management'); ?></td>
			<td><?= Yii::t('Front', 'Change name, last name, password, and download files, documents. Information about uploaded files, as well as the validity of the document') ?>
			</td>
			<td>
				<div class="transaction-buttons-cont">
					<a class="button edit" href="<?= Yii::app()->createUrl('/personal/editname') ?>" ></a>
				</div>
			</td>
		</tr>
		<tr>
			<td class="header"><?= Yii::t('Front', 'Manage email addresses'); ?></td>
			<td><?= Yii::t('Front', 'Changing or deleting email addresses'); ?></td>
			<td>
				<div class="transaction-buttons-cont">
					<a class="button edit" href="<?= Yii::app()->createUrl('/personal/editemails') ?>" ></a>
				</div>
			</td>
		</tr>
		<tr>
			<td class="header"><?= Yii::t('Front', 'Manage phones'); ?></td>
			<td>
				<?= Yii::t('Front', 'Changing or deleting phone appointment number of personal, corporate, and the main  secondary'); ?>
			</td>
			<td>
				<div class="transaction-buttons-cont">
					<a class="button edit" href="<?= Yii::app()->createUrl('/personal/editphones') ?>" ></a>
				</div>
			</td>
		</tr>
		<tr>
			<td class="header"><?= Yii::t('Front', 'Manage addresses'); ?></td>
			<td>
				<?= Yii::t('Front', 'Changing or deleting addresses. Adding additional addresses as well as the appointment of mailing address as a personal or corporate'); ?>
			</td>
			<td>
				<div class="transaction-buttons-cont">
					<a class="button edit" href="<?= Yii::app()->createUrl('/personal/editaddress') ?>" ></a>
				</div>
			</td>
		</tr>
        <tr>
			<td class="header"><?= Yii::t('Front', 'Manage soccial networks'); ?></td>
			<td>
				<?= Yii::t('Front', 'Edit social netrworks'); ?>
			</td>
			<td>
				<div class="transaction-buttons-cont">
					<a class="button edit" href="<?= Yii::app()->createUrl('/personal/editsocials') ?>" ></a>
				</div>
			</td>
		</tr>
		<tr>
			<td class="header"><?= Yii::t('Front', 'Manage instant messager services'); ?></td>
			<td>
				<?= Yii::t('Front', 'Edit instant messager services'); ?>
			</td>
			<td>
				<div class="transaction-buttons-cont">
					<a class="button edit" href="<?= Yii::app()->createUrl('/personal/editmessagers') ?>" ></a>
				</div>
			</td>
		</tr>
		<tr>
			<td class="header"><?= Yii::t('Front', 'Manage Security Questions'); ?></td>
			<td>
				<?= Yii::t('Front', 'Edit security questions list'); ?>
			</td>
			<td>
				<div class="transaction-buttons-cont">
					<a class="button edit" href="<?= Yii::app()->createUrl('/personal/editqustions') ?>" ></a>
				</div>
			</td>
		</tr>
		<tr>
			<td class="header"><?= Yii::t('Front', 'Manage Password'); ?></td>
			<td>
				<?= Yii::t('Front', 'Edit passwords'); ?>
			</td>
			<td>
				<div class="transaction-buttons-cont">
					<a class="button edit" href="<?= Yii::app()->createUrl('/personal/editpins') ?>" ></a>
				</div>
			</td>
		</tr>
		<tr>
			<td class="header"><?= Yii::t('Front', 'Account Settings'); ?></td>
			<td>
				<?= Yii::t('Front', 'Account Settings'); ?>
			</td>
			<td>
				<div class="transaction-buttons-cont">
					<a class="button edit" href="<?= Yii::app()->createUrl('/personal/settings') ?>" ></a>
				</div>
			</td>
		</tr>
        <tr>
            <td class="header"><?= Yii::t('Front', 'Alert Settings'); ?></td>
            <td>
                <?= Yii::t('Front', 'Alert Settings'); ?>
            </td>
            <td>
                <div class="transaction-buttons-cont">
                    <a class="button edit" href="<?= Yii::app()->createUrl('/personal/alerts') ?>" ></a>
                </div>
            </td>
        </tr>
		<tr>
			<td class="header"><?= Yii::t('Front', 'Favorite Payment Instuments'); ?></td>
			<td>
				<?= Yii::t('Front', 'Favorite Payment Instuments'); ?>
			</td>
			<td>
				<div class="transaction-buttons-cont">
					<a class="button edit" href="<?= Yii::app()->createUrl('/personal/paymentinstuments') ?>" ></a>
				</div>
			</td>
		</tr>
		<tr>
			<td class="header"><?= Yii::t('Front', 'Roles'); ?></td>
			<td>
				<?= Yii::t('Front', 'Roles'); ?>
			</td>
			<td>
				<div class="transaction-buttons-cont">
					<a class="button edit" href="<?= Yii::app()->createUrl('/rbac/roles') ?>" ></a>
				</div>
			</td>
		</tr>
        <tr>
            <td class="header"><?= Yii::t('Front', 'Users Managment'); ?></td>
            <td>
                <?= Yii::t('Front', 'Users Managment'); ?>
            </td>
            <td>
                <div class="transaction-buttons-cont">
                    <a class="button edit" href="<?= Yii::app()->createUrl('/rbac/manageusers') ?>" ></a>
                </div>
            </td>
        </tr>
	</table>
</div>
