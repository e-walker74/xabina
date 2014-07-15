<div class=" xabina-form-narrow">
	<table class="table xabina-table-contacts">
        <tr class="table-header">
            <th style="width: 18%"><?= Yii::t('Front', 'Photo'); ?></th>
            <th style="width: 45%"><?= Yii::t('Front', 'Contact Name'); ?></th>
            <th style="width: 29%"><?= Yii::t('Front', 'Linkining Type'); ?></th>
            <th style="width: 8%"></th>
        </tr>
        <tr class="comment-tr empty-table <?php if (count($model->getDataByType('contact'))): ?>hidden<?php endif; ?>">
            <td colspan="4" style="line-height: 1.43!important">
                <span class="rejected "><?= Yii::t('Front', 'You do not added a link yet. You can add new link by clicking “Add new” button') ?></span>
            </td>
        </tr>
		<?php foreach($model->getDataByType('contact') as $m): ?>
		<?php if(!$ci = $m->getContactInfo()) continue; ?>
		<tr class="data-row <?= (isset($new_model_id) && $new_model_id == $m->id) ? 'flash_notify_here' : '' ?>" data-select-id="<?= $ci->id ?>">
			<td>
				<?php if($ci->photo): ?>
					<img width="40" src="<?= $ci->getAvatarUrl() ?>" alt=""/>
				<?php else: ?>
					<img width="40" src="/images/contact_no_foto.png" alt="">
				<?php endif; ?>
			</td>
			<td><?= Html::link($ci->fullname, array('/contact/view', 'url' => $ci->url), array('class' => 'link')) ?></td>
			<td><?= ($m->getDbModel()->category) ? $m->getDbModel()->category->value : ''  ?></td>
			<td>
				<div class="transaction-buttons-cont">
					<a class="button delete" data-url="<?= Yii::app()->createUrl('/contact/deleteData', array('type' => 'contact', 'id' => $m->id)) ?>" ></a>
				</div>
			</td>
		</tr>
		<?php endforeach; ?>
		<tr class="data-row">
			<td colspan="4">
				<a href="javaScript:void(0)" class="rounded-buttons upload add-more"><?= Yii::t('Front', 'Link new contact'); ?></a>
			</td>
		</tr>
		<tr class="edit-row">
			<td colspan="4" style="overflow: visible!important;">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'dataform-form-contact',
                    'action' => array('/contact/update', 'url' => $model->url),
					'enableAjaxValidation'=>true,
					'enableClientValidation'=>true,
					'errorMessageCssClass' => 'error-message',
					'htmlOptions' => array(
						'class' => 'form-validable',
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
				<?php $m = new Users_Contacts_Data_Contact; ?>
				<div class="table-subheader"><?= Yii::t('Front', 'Link new contact'); ?></div>

				<div class="row">
					<div class="col-lg-10 col-md-10 col-sm-10">
						<div class="form-cell">
							<div class="form-lbl">
								<?= Yii::t('Front', 'Contact Name'); ?>
								<span class="tooltip-icon" title="<?= Yii::t('Front', 'add_contact_name_tooltip'); ?>"></span>
							</div>
							<div class="form-input add-contact">
                                <div class="input-text account-search-input-block input-block">
<!--                                    <input id="linkName" type="text" class="/>-->
                                    <?= $form->textField($m, 'contact_id'); ?>
                                </div>

                                <div class="account-search pull-left"></div>
                                <?php Widget::create('ContactListWidget')->renderPupUpSearch() ?>
							</div>
                            <div class="error-message duplicate"><?= Yii::t('Front', 'Duplicate contact') ?></div>
						</div>
					</div>
                    <script>
                        $(document).ready(function(){
                            $('.account-search').popUpSearchContact({
                                inputSelectorForName : '#Users_Contacts_Data_Contact_contact_id',
                                inputSelectorForID  : '#Users_Contacts_Data_Contact_contact_id',
                                searchLineSelector  : '#Users_Contacts_Data_Contact_contact_id',
                                parentSelector      : '.form-input.add-contact'
                            })
                        })
                    </script>
					<div class="col-lg-2 col-md-2  col-sm-2 ">
						<div class="transaction-buttons-cont edit-submit-cont" style="margin-top: 30px">
							<input type="submit" title="<?= Yii::t('Front', 'Save') ?>" class="button ok" value="" />
							<a href="javaScript:void(0)" title="<?= Yii::t('Front', 'Cancel') ?>" class="button cancel"></a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-10 col-md-10 col-sm-10">
						<?= $form->error($m, 'contact_id') ?>
					</div>
				</div>
				<div class="row" style="margin-top: 15px">

					<div class="col-lg-10 col-md-10  col-sm-10 ">
						<div class="form-cell">
							<div class="form-lbl">
								<?= Yii::t('Front', 'Category') ?>
								<span class="tooltip-icon" title="<?= Yii::t('Front', 'category_contact') ?>"></span>
							</div>
                            <div class="form-input category-select">
                                <div class="select-custom select-narrow ">
                                    <span class="select-custom-label"></span>
                                    <?= $form->dropDownList(
                                        $m,
                                        'category_id',
                                        Html::listDataWithFilter(
                                            $data_categories,
                                            'id',
                                            'value',
                                            'data_type',
                                            'contact'
                                        ) + array('add' => Yii::t('Front', 'Other')),
                                        array(
                                            'class' => 'select-invisible',
                                            'onchange' => 'showAddNewCategory(this)',
                                            'empty' => Yii::t('Front', 'Select'),
                                        )
                                    ) ?>
                                </div>
                            </div>
                            <div class="form-input add-new-category" style="display: none;">
                                    <span class="clear-input-cont full-with">
                                        <input type="text" name="Data_Category" maxlength="25" class="input-text" disabled="disabled">
                                        <span class="clear-input-but" onclick="hideCategoryTextField(this)"></span>
                                    </span>
                            </div>
						</div>
					</div>
				</div>
				<?php $this->endWidget(); ?>
			</td>
		</tr>
	</table>
</div>
<script>
$(document).ready(function(){
	$('.xabina-form-narrow .transaction-buttons-cont .delete').confirmation({
		title: '<?= Yii::t('Front', 'Are you sure?') ?>',
		singleton: true,
		popout: true,
		onConfirm: function(){
			deleteRow($(this).parents('.popover').prev('a'));
			return false;
		}
	})
})
</script>