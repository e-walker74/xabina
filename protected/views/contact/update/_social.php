<div class=" xabina-form-narrow">
    <table class="table xabina-table-contacts">
        <tr class="table-header">
            <th style="width: 12%"><?= Yii::t('Front', 'Network') ?></th>
            <th style="width: 38%"><?= Yii::t('Front', 'URL address') ?></th>
            <th style="width: 26%"><?= Yii::t('Front', 'Category') ?></th>
            <th style="width: 15%"><?= Yii::t('Front', 'Status') ?></th>
            <th style="width: 9%"></th>
        </tr>
        <tr class="comment-tr empty-table <?php if (count($model->getDataByType('social'))): ?>hidden<?php endif; ?>">
            <td colspan="5" style="line-height: 1.43!important">
                <span class="rejected "><?= Yii::t('Front', 'You do not added a network yet. You can add new network by clicking “Add new” button') ?></span>
            </td>
        </tr>
        <?php foreach($model->getDataByType('social') as $m): ?>
        <tr class="data-row <?= (isset($new_model_id) && $new_model_id == $m->id) ? 'flash_notify_here' : '' ?>">
            <td>
                <?php if($m->social && isset(Users_Contacts_Data_Social::$socialsImages[$m->social])): ?>
                    <img src="<?= Users_Contacts_Data_Social::$socialsImages[$m->social] ?>" alt=""/>
                <?php endif; ?>
            </td>
            <td><a href="<?= Yii::app()->createUrl('/site/disclaime', array('tourl' => urlencode($m->url))) ?>" class="link"><?= $m->url ?></a></td>
            <td><?= ($m->getDbModel()->category) ? $m->getDbModel()->category->value : ''  ?></td>
            <td>
                <?php if($m->getDbModel()->is_primary): ?>
                    <span class="primary">
                        <?= Yii::t('Front', 'Primary') ?>
                    </span>
                <?php else: ?>
                    <a class="make-primary" href="javaScript:void(0)" data-url="<?= Yii::app()->createUrl('/contact/makePrimary', array('entity' => $m->getDbModel()->data_type, 'id' => $m->getDbModel()->id)) ?>" onclick="makePrimary(this)"><?= Yii::t('Front', 'Make primary') ?></a>
                <?php endif; ?>
            </td>
            <td style="overflow: visible!important;">
                <div class="contact-actions transaction-buttons-cont">
                    <div class="btn-group with-delete-confirm">
                        <a class="button menu" title="<?= Yii::t('Front', 'Options') ?>" data-toggle="dropdown" href="#"></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="button edit" title="<?= Yii::t('Front', 'Edit') ?>" href="edit_contact.html"></a>
                            </li>
                            <li>
                                <?= Html::link('', 'javaScript:void(0)', array(
                                    'class' => 'button delete',
                                    'onclick' => '$(this).addClass(\'opened\')',
                                    'data-url' => Yii::app()->createUrl('/contact/deleteData', array('type' => 'social', 'id' => $m->id)),
                                )) ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </td>
        </tr>
        <tr class="edit-row">
            <td colspan="5" style="overflow: visible!important;">
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'dataform-form-socials'.$m->id,
                    'action' => array('/contact/update', 'url' => $model->url),
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
                <?= $form->hiddenField($m, 'id') ?>
                <div class="row">
                    <div class="col-lg-2 col-md-2  col-sm-2" style="overflow: visible!important;">
                        <div class="form-cell">
                            <div class="form-lbl">
                                <?= Yii::t('Front', 'Network'); ?>
                            </div>
                            <div class="form-input" style="margin: 0; position: relative">
                                <div class="select-img">
                                    <div class="select-custom select-soocnet "  data-toggle="dropdown">
                                <span class="select-custom-label selected-img">
                                    <?php if($m->social && isset(Users_Contacts_Data_Social::$socialsImages[$m->social])): ?>
                                        <img src="<?= Users_Contacts_Data_Social::$socialsImages[$m->social] ?>" alt=""/>
                                    <?php endif; ?>
                                </span>
                                        <?= $form->hiddenField($m, 'social', array('class' => 'socnet-select')); ?>
                                    </div>
                                    <ul class="dropdown-menu socnet-dropdown img-dropdown" role="menu" >
                                        <?php foreach(Users_Contacts_Data_Social::$socialsImages as $key => $img): ?>
                                            <li>
                                                <a href="#" data-id="<?= $key ?>" ><img src="<?= $img ?>" alt=""/></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <?= $form->error($m, 'social'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-5">
                        <div class="form-cell">
                            <div class="form-lbl">
                                <?= Yii::t('Front', 'URL address') ?>
                                <span class="tooltip-icon" title="<?= Yii::t('Front', 'contact_url_address_tooltip') ?>"></span>
                            </div>
                            <div class="form-input">
                                <?= $form->textField($m, 'url', array('class' => 'input-text social-url-input')) ?>
                                <?= $form->error($m, 'url') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="form-cell">
                            <div class="form-lbl">
                                <?= Yii::t('Front', 'Category') ?>
                                <span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_contact_social_category') ?>"></span>
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
                                            'social'
                                        ) + array('add' => Yii::t('Front', 'Other')),
                                        array(
                                            'class' => 'select-invisible',
                                            'onchange' => 'showAddNewCategory(this)',
                                            'empty' => Yii::t('Front', 'Select'),
                                            'options' => array($m->getDbModel()->category_id => array('selected' => true)),
                                        )
                                    ) ?>
                                </div>
                            </div>
                            <div class="form-input add-new-category" style="display: none;">
                                <span class="clear-input-cont full-with">
                                    <input type="text" name="Data_Category" class="input-text" disabled="disabled">
                                    <span class="clear-input-but" onclick="hideCategoryTextField(this)"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <div class="transaction-buttons-cont edit-submit-cont">
                            <input type="submit" title="<?= Yii::t('Front', 'Save') ?>" class="button ok" value="" />
                            <a href="javaScript:void(0)" title="<?= Yii::t('Front', 'Cancel') ?>" class="button cancel"></a>
                        </div>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </td>
        </tr>
        <?php endforeach; ?>
        <tr class="data-row">
            <td colspan="5">
                <a href="#" class="rounded-buttons upload add-more"><?= Yii::t('Front', 'Add NEW') ?></a>
            </td>
        </tr>
        <tr class="edit-row">
            <td colspan="5" style="overflow: visible!important;">
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'dataform-form-socials',
                    'action' => array('/contact/update', 'url' => $model->url),
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
                <?php $m = new Users_Contacts_Data_Social; ?>
                <div class="table-subheader"><?= Yii::t('Front', 'Add new social network'); ?></div>
                <div class="row">
                    <div class="col-lg-2 col-md-2  col-sm-2">
                        <div class="form-cell">
                            <div class="form-lbl">
                                <?= Yii::t('Front', 'Network'); ?>
                            </div>
                            <div class="form-input" style="margin: 0; position: relative">
                                <div class="select-img">
                                    <div class="select-custom select-soocnet "  data-toggle="dropdown">
									<span class="select-custom-label selected-img">
										<img src="/images/soc_img_03.png" alt=""/>
									</span>
                                        <?= $form->hiddenField($m, 'social', array('class' => 'socnet-select')); ?>
                                    </div>
                                    <ul class="dropdown-menu socnet-dropdown img-dropdown" role="menu" >
                                        <?php foreach(Users_Contacts_Data_Social::$socialsImages as $key => $img): ?>
                                            <li>
                                                <a href="#" data-id="<?= $key ?>" ><img src="<?= $img ?>" alt=""/></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <?= $form->error($m, 'social'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-5">
                        <div class="form-cell">
                            <div class="form-lbl">
                                <?= Yii::t('Front', 'URL address') ?>
                                <span class="tooltip-icon" title="<?= Yii::t('Front', 'contact_url_address_tooltip') ?>"></span>
                            </div>
                            <div class="form-input">
                                <?= $form->textField($m, 'url', array('class' => 'input-text social-url-input')) ?>
                                <?= $form->error($m, 'url') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="form-cell">
                            <div class="form-lbl">
                                <?= Yii::t('Front', 'Category') ?>
                                <span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_contact_social_category') ?>"></span>
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
                                            'social'
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
                                    <input type="text" name="Data_Category" class="input-text" disabled="disabled">
                                    <span class="clear-input-but" onclick="hideCategoryTextField(this)"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <div class="transaction-buttons-cont edit-submit-cont">
                            <input type="submit" title="<?= Yii::t('Front', 'Save') ?>" class="button ok" value="" />
                            <a href="javaScript:void(0)" title="<?= Yii::t('Front', 'Cancel') ?>" class="button cancel"></a>
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