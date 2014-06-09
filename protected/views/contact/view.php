<div class="col-lg-9 col-md-9 col-sm-9" >
	<div class="contact-cont ">
		<div class="contact-header">
			<div class="contact-photo">
				<img src="/images/contact-photo-big.png" alt=""/>
				<span class="valid-status ok"></span>
			</div>
			<div class="contact-name"><?= $model->fullname ?></div>
			<div class="contact-actions transaction-buttons-cont">
				<div class="btn-group">
					<a class="button list" href="#"></a>
					<button class="list-caret" data-toggle="dropdown"></button>
					<ul class="dropdown-menu">
						<!--<li>
							<a class="button send" href="javaScript:void(0)"></a>
						</li>
						<li>
							<a class="button print" href="javaScript:void(0)"></a>
						</li>
						<li>
							<a class="button pdf" href="javaScript:void(0)"></a>
						</li>-->
						<li>
							<a class="button edit" href="<?= Yii::app()->createUrl('/contact/update', array('id' => $model->id)); ?>"></a>
						</li>
						<li>
							<a class="button delete" href="javaScript:void(0)"></a>
						</li>
					</ul>
				</div>

			</div>
			<div class="clearfix"></div>
		</div>

		<div class="xabina-tabs personal-tabs">
			<ul class="list-unstyled">
				<li style="width: 25%"><a href="#tab1"><?= Yii::t('Front', 'General Info'); ?></a></li>
				<li style="width: 25%"><a href="#tab2"><?= Yii::t('Front', 'Defaults'); ?></a></li>
				<li style="width: 25%"><a href="#tab3"><?= Yii::t('Front', 'Linked Transfers'); ?></a></li>
				<li style="width: 25%"><a href="#tab4"><?= Yii::t('Front', 'Analytics'); ?></a></li>
			</ul>
			<div class="clearfix"></div>
			<div id="tab1">

				<table class="table xabina-table-personal table-contact">
					<tr class="table-header">
						<th style="width: 42%"><?= Yii::t('Front', 'Section') ?></th>
						<th style="width: 58%"><?= Yii::t('Front', 'Description') ?></th>
					</tr>
					<tr>
						<td colspan="2">
							<table class="table inner personal-info">
								<?php $i = 0; ?>
								<?php if($model->first_name || $model->last_name): 
								$i++;
								?>
								<tr>
									<td class="names" style="width: 42%">
										<?php if($i == 1): ?>
											<?= Yii::t('Front', 'Personal Info') ?>
										<?php endif; ?>
									</td>
									<td class="values"  style="width: 52%">
										<span class="strong"><?= $model->first_name ?> <?= $model->last_name ?></span> <br>
										<?= Yii::t('Front', 'First Name') ?> / <?= Yii::t('Front', 'Last Name') ?> <br>
										
									</td>
									<td  style="width: 6%">
										&nbsp;
									</td>
								</tr>
								<?php endif; ?>
								<?php if($model->company): 
								$i++;
								?>
								<tr>
									<td class="names" style="width: 42%">
										<?php if($i == 1): ?>
											<?= Yii::t('Front', 'Personal Info') ?>
										<?php endif; ?>
									</td>
									<td class="values"  style="width: 52%">
										<span class="strong"><?= $model->company ?></span> <br>
										<?= Yii::t('Front', 'Company'); ?> <br>
									</td>
									<td  style="width: 6%">
										&nbsp;
									</td>
								</tr>
								<?php endif; ?>
								<?php if($model->nickname): 
								$i++;
								?>
								<tr>
									<td class="names" style="width: 42%">
										<?php if($i == 1): ?>
											<?= Yii::t('Front', 'Personal Info') ?>
										<?php endif; ?>
									</td>
									<td class="values"  style="width: 52%">
										<span class="strong"><?= $model->nickname ?></span> <br>
										<?= Yii::t('Front', 'Nickname'); ?> <br>
									</td>
									<td  style="width: 6%">
										&nbsp;
									</td>
								</tr>
								<?php endif; ?>
								<?php if($model->xabina_id): 
								$i++;
								?>
								<tr>
									<td class="names" style="width: 42%">
										<?php if($i == 1): ?>
											<?= Yii::t('Front', 'Personal Info') ?>
										<?php endif; ?>
									</td>
									<td class="values"  style="width: 52%">
										<span class="strong"><?= $model->xabina_id ?></span> <br>
										<?= Yii::t('Front', 'Xabina User Id'); ?> <br>
									</td>
									<td  style="width: 6%">
										&nbsp;
									</td>
								</tr>
								<?php endif; ?>
							</table>
						</td>
					</tr>
					<?php if($model->getDataByType('account')): ?>
					<tr>
						<td colspan="2">
							<table class="table inner">
								<?php $i = 0; ?>
								<?php foreach($model->getDataByType('account') as $account): 
								$i++; ?>
								<tr>
									<td class="names" style="width: 42%">
										<?php if($i == 1): ?>
											<?= Yii::t('Front', 'Account Number'); ?>
										<?php endif; ?>
									</td>
									<td class="values"  style="width: 52%">
										<span class="<?= ($account->dbModel->is_primary) ? 'account-number' : 'strong' ?>"><?= $account->account_number ?></span> <br>
										<?= $account->getPaementSystemModel()->name ?><br>
									</td>
									<td  style="width: 6%">
										<a class="acc-ico <?= ($account->dbModel->is_primary) ? 'priamry' : '' ?>"  href="#"></a>
									</td>
								</tr>
								<?php endforeach; ?>
							</table>
						</td>
					</tr>
					<?php endif; ?>
					<?php if($model->getDataByType('email')): ?>
					<tr>
						<td colspan="2">
							<table class="table inner">
								<?php $i = 0; ?>
								<?php foreach($model->getDataByType('email') as $account): 
								$i++; ?>
								<tr>
									<td class="names" style="width: 42%">
										<?php if($i == 1): ?>
											<?= Yii::t('Front', 'E-Mail'); ?>
										<?php endif; ?>
									</td>
									<td class="values"  style="width: 52%">
										<span class="<?= ($account->dbModel->is_primary) ? 'account-number' : 'strong' ?>"><?= $account->email ?></span> <br>
									</td>
									<td  style="width: 6%">
										<a class="acc-ico <?= ($account->dbModel->is_primary) ? 'priamry' : '' ?>"  href="#"></a>
									</td>
								</tr>
								<?php endforeach; ?>
							</table>
						</td>
					</tr>
					<?php endif; ?>
					<?php if($model->getDataByType('phone')): ?>
					<tr>
						<td colspan="2">
							<table class="table inner">
								<?php $i = 0; ?>
								<?php foreach($model->getDataByType('phone') as $account): 
								$i++; ?>
								<tr>
									<td class="names" style="width: 42%">
										<?php if($i == 1): ?>
											<?= Yii::t('Front', 'Phone'); ?>
										<?php endif; ?>
									</td>
									<td class="values"  style="width: 52%">
										<span class="<?= ($account->dbModel->is_primary) ? 'account-number' : 'strong' ?>">+<?= number_format($account->phone, 0, "", " ") ?></span> <br>
									</td>
									<td  style="width: 6%">
										<a class="acc-ico <?= ($account->dbModel->is_primary) ? 'priamry' : '' ?>"  href="#"></a>
									</td>
								</tr>
								<?php endforeach; ?>
							</table>
						</td>
					</tr>
					<?php endif; ?>
					<?php if($model->getDataByType('address')): ?>
					<tr>
						<td colspan="2">
							<table class="table inner">
								<?php $i = 0; ?>
								<?php foreach($model->getDataByType('address') as $account): 
								$i++; ?>
								<tr>
									<td class="names" style="width: 42%">
										<?php if($i == 1): ?>
											<?= Yii::t('Front', 'Address'); ?>
										<?php endif; ?>
									</td>
									<td class="values"  style="width: 52%">
										<span class="<?= ($account->dbModel->is_primary) ? 'account-number' : 'strong' ?>"><?= $account->address ?></span> <br>
										<?= $account->index ?> <?= $account->country_code ?>
									</td>
									<td  style="width: 6%">
										<a class="acc-ico <?= ($account->dbModel->is_primary) ? 'priamry' : '' ?>"  href="#"></a>
									</td>
								</tr>
								<?php endforeach; ?>
							</table>
						</td>
					</tr>
					<?php endif; ?>
					<?php if($model->getDataByType('contact')): ?>
					<tr>
						<td colspan="2">
							<table class="table inner">
								<?php $i = 0; ?>
								<?php foreach($model->getDataByType('contact') as $contact): 
								$i++; ?>
								<?php $contInfo = $contact->getContactInfo();
										if(!$contInfo) continue;
								?>
								<tr>
									<td class="names" style="width: 42%">
										<?php if($i == 1): ?>
											<?= Yii::t('Front', 'Linkining'); ?>
										<?php endif; ?>
									</td>
									<td class="values"  style="width: 52%">
										<div class="liniking-photo">
											<span class="valid-status error"></span>
											<?php if($contInfo->photo): ?>
												<img width="40" src="<?= $contInfo->getAvatarUrl() ?>" alt=""/>
											<?php else: ?>
												<img width="40" src="/images/contact_no_foto.png" alt="">
											<?php endif; ?>
										</div>
										<span class="strong"><?= $contInfo->fullname ?></span> <br>
										<?= $contact->category ?> <br>
									</td>
									<td  style="width: 6%">
										<a class="acc-ico <?= ($contact->dbModel->is_primary) ? 'priamry' : '' ?>"  href="#"></a>
									</td>
								</tr>
								<?php endforeach; ?>
							</table>
						</td>
					</tr>
					<?php endif; ?>
					<?php if($model->getDataByType('instmessaging')): ?>
					<tr>
						<td colspan="2">
							<table class="table inner">
								<?php $i = 0; ?>
								<?php foreach($model->getDataByType('instmessaging') as $account): 
								$i++; ?>
								<tr>
									<td class="names" style="width: 42%">
										<?php if($i == 1): ?>
											<?= Yii::t('Front', 'Instant Messaging'); ?>
										<?php endif; ?>
									</td>
									<td class="values"  style="width: 52%">
										<span class="strong"><?= $account->name ?></span> <br>
										<?= $account->messanger ?> <br>
									</td>
									<td  style="width: 6%">
										<a class="acc-ico <?= ($account->dbModel->is_primary) ? 'priamry' : '' ?>"  href="#"></a>
									</td>
								</tr>
								<?php endforeach; ?>
							</table>
						</td>
					</tr>
					<?php endif; ?>
					<?php if($model->getDataByType('urls')): ?>
					<tr>
						<td colspan="2">
							<table class="table inner">
								<?php $i = 0; ?>
								<?php foreach($model->getDataByType('urls') as $account): 
								$i++; ?>
								<tr>
									<td class="names" style="width: 42%">
										<?php if($i == 1): ?>
											<?= Yii::t('Front', 'URLs'); ?>
										<?php endif; ?>
									</td>
									<td class="values"  style="width: 52%">
										<span class="strong"><?= $account->url ?></span> <br>
										<?= $account->category ?> <br>
									</td>
									<td  style="width: 6%">
										<a class="acc-ico <?= ($account->dbModel->is_primary) ? 'priamry' : '' ?>"  href="#"></a>
									</td>
								</tr>
								<?php endforeach; ?>
							</table>
						</td>
					</tr>
					<?php endif; ?>
					<?php if($model->getDataByType('dates')): ?>
					<tr>
						<td colspan="2">
							<table class="table inner">
								<?php $i = 0; ?>
								<?php foreach($model->getDataByType('dates') as $account): 
								$i++; ?>
								<tr>
									<td class="names" style="width: 42%">
										<?php if($i == 1): ?>
											<?= Yii::t('Front', 'Dates'); ?>
										<?php endif; ?>
									</td>
									<td class="values"  style="width: 52%">
										<span class="strong"><?= $account->date ?></span> <br>
										<?= Yii::t('Front', Users_Contacts_Data_Dates::$categories[$account->category]) ?> <br>
									</td>
									<td  style="width: 6%">
										<a class="acc-ico <?= ($account->dbModel->is_primary) ? 'priamry' : '' ?>"  href="#"></a>
									</td>
								</tr>
								<?php endforeach; ?>
							</table>
						</td>
					</tr>
					<?php endif; ?>
					<?php if($model->getDataByType('social')): ?>
						<tr>
							<td colspan="2">
								<div class="messaging-actions">
									<?php foreach($model->getDataByType('social') as $soc): ?>
										<a href="<?= $soc->url ?>" class="messaging-button <?= $soc->social ?>"></a>
									<?php endforeach; ?>
								</div>
							</td>
						</tr>
					<?php endif; ?>
				</table>

			</div>
			<div id="tab2">
				<table class="table xabina-table-personal table-defaults">
					<tr class="table-header">
						<th style="width: 42%"><?= Yii::t('Front', 'Section') ?></th>
						<th style="width: 58%"><?= Yii::t('Front', 'Description') ?></th>
					</tr>
					<?php foreach($model->getDataByType('default') as $default): ?>
						<tr>
							<td><?= $default->type ?></td>
							<td><?= $default->value ?></td>
						</tr>
					<?php endforeach; ?>
				</table>
			</div>
			<div id="tab3">
				<?= $this->renderPartial('_linked', array('model' => $model)); ?>
			</div>
			<div id="tab4">
				<?= $this->renderPartial('_analytics', array('model' => $model, 'search' => $search)); ?>
			</div>
		</div>
	</div>
</div>