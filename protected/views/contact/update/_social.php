<div class=" xabina-form-narrow">
	<table class="table xabina-table-contacts">
		<tr class="table-header">
			<th style="width: 14%"><?= Yii::t('Front', 'Social'); ?></th>
			<th style="width: 86%"><?= Yii::t('Front', 'URL address'); ?></th>
			<th style="width: 0"></th>
		</tr>
		<?php foreach($model->getDataByType('urls') as $model): ?>
		<tr class="data-row">
			<td>
				<img src="<?= $model->social ?>" alt=""/>
			</td>
			<td><?= $model->url ?></td>
			<td>
				<div class="transaction-buttons-cont">
					<a href="javaScript:void(0)" class="button edit"></a>
				</div>
			</td>
		</tr>
		<tr class="edit-row">
			<td colspan="3">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'dataform-form-socials'.$model->id,
					'enableAjaxValidation'=>true,
					'enableClientValidation'=>true,
					'errorMessageCssClass' => 'error-message',
					'htmlOptions' => array(
						'class' => 'form-validable',
						'enctype' => 'multipart/form-data',
					),
					'clientOptions'=>array(
						'validateOnSubmit'=>true,
						'validateOnChange'=>true,
						'errorCssClass'=>'input-error',
						'successCssClass'=>'valid',
						'afterValidate' => 'js:afterValidate',
						'afterValidateAttribute' => 'js:afterValidateAttribute'
					),
				)); ?>
				<?= $form->hiddenField($model, 'id') ?>
				<div class="row">
					<div class="col-lg-2 col-md-2  col-sm-2">
						<div class="form-cell">
							<div class="form-input" style="margin: 0; position: relative">
								<div class="select-custom select-soocnet"  data-toggle="dropdown">
									<span class="select-custom-label">
										<img src="/images/soc_img_03.png" alt=""/>
									</span>
								</div>
								<ul class="dropdown-menu socnet-dropdown" role="menu" >
									<li>
										<a href="javaScript:void(0)"><img src="/images/soc_img_06.png" alt=""/></a>
									</li>
									<li>
										<a href="javaScript:void(0)"><img src="/images/soc_img_09.png" alt=""/></a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-lg-7 col-md-7 col-sm-7">
						<div class="form-cell">
							<div class="form-input">
								<div class="form-input">
									<?= $form->textField($model, 'url', array('class' => 'input-text')) ?>
									<?= $form->error($model, 'url') ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3">
						<div class="transaction-buttons-cont edit-submit-cont">
							<input type="submit" class="button ok" value="" />
							<a href="javaScript:void(0)" class="button cancel"></a>
						</div>
					</div>
				</div>
				<?php $this->endWidget(); ?>
			</td>
		</tr>
		<?php endforeach; ?>
		<tr class="data-row">
			<td colspan="3">
				<a href="#" class="rounded-buttons upload add-more"><?= Yii::t('Front', 'Add NEW') ?></a>
			</td>
		</tr>
		<tr class="edit-row">
			<td colspan="3">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'dataform-form-socials',
					'enableAjaxValidation'=>true,
					'enableClientValidation'=>true,
					'errorMessageCssClass' => 'error-message',
					'htmlOptions' => array(
						'class' => 'form-validable',
						'enctype' => 'multipart/form-data',
					),
					'clientOptions'=>array(
						'validateOnSubmit'=>true,
						'validateOnChange'=>true,
						'errorCssClass'=>'input-error',
						'successCssClass'=>'valid',
						'afterValidate' => 'js:afterValidate',
						'afterValidateAttribute' => 'js:afterValidateAttribute'
					),
				)); ?>
				<?php $model = new Users_Contacts_Data_Social; ?>
				<div class="row">
					<div class="col-lg-2 col-md-2  col-sm-2">
						<div class="form-cell">
							<div class="form-input" style="margin: 0; position: relative">
								<div class="select-custom select-soocnet"  data-toggle="dropdown">
									<span class="select-custom-label">
										<img src="/images/soc_img_03.png" alt=""/>
									</span>
								</div>
								<ul class="dropdown-menu socnet-dropdown" role="menu" >
									<li>
										<a href="javaScript:void(0)"><img src="/images/soc_img_06.png" alt=""/></a>
									</li>
									<li>
										<a href="javaScript:void(0)"><img src="/images/soc_img_09.png" alt=""/></a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-lg-7 col-md-7 col-sm-7">
						<div class="form-cell">
							<div class="form-input">
								<?= $form->textField($model, 'url', array('class' => 'input-text')) ?>
								<?= $form->error($model, 'url') ?>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3">
						<div class="transaction-buttons-cont edit-submit-cont">
							<input type="submit" class="button ok" value="" />
							<a href="javaScript:void(0)" class="button cancel"></a>
						</div>
					</div>
				</div>
				<?php $this->endWidget(); ?>
			</td>
		</tr>
	</table>
</div>