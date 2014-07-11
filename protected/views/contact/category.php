<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 30.06.14
 * Time: 13:08
 */
?>
<?php if (!Yii::request()->isAjaxRequest): ?>
    <div class="col-lg-9 col-md-9 col-sm-9 tab">
<?php endif; ?>
    <div class="h1-header"><?= Yii::t('From', 'Category') ?></div>
    <div class="xabina-form-container">
        <table class="table xabina-table category-table">
            <tr class="table-header">
                <th style="width: 24%"><?= Yii::t('From', 'Category') ?></th>
                <th style="width: 27%"><?= Yii::t('From', 'Description') ?></th>
                <th style="width: 49%"><?= Yii::t('From', 'Used by') ?></th>
            </tr>
            <?php if (empty($categories)): ?>
                <tr class="comment-tr">
                    <td colspan="3" style="line-height: 1.43!important">
                        <span class="rejected "><?= Yii::t('Front', 'Table is empty') ?></span>
                    </td>
                </tr>
            <?php endif; ?>

            <?php foreach ($categories as $category): ?>
                <tr class="data-row <?= (isset($new_model_id) && $new_model_id == $category->id) ? 'flash_notify_here' : '' ?>">
                    <td><?= $category->section ?></td>
                    <td><?= $category->description ?></td>
                    <td style="overflow: visible!important;">
                        <div class="dropdown-list-cont">
                            <?php if($category->contacts): ?>

                            <div class="pull-left">
                                <a href="javaScript:void(0)" data-opened-text="<span><?= count($category->contacts) ?></span> <?= Yii::t('Front', 'n==1#User|n>1#Users', count($category->contacts)) ?>" data-closed-text="<span><?= count($category->contacts) ?></span> <?= Yii::t('Front', 'n==1#User|n>1#Users', count($category->contacts)) ?>"
                                   class="dropdown-toggle closed"><span><span><?= count($category->contacts) ?></span> <?= Yii::t('Front', 'n==1#User|n>1#Users', count($category->contacts)) ?></span></a>
                            </div>
                            <?php endif; ?>
                            <div class="transaction-buttons-cont">
                                <div class="btn-group with-delete-confirm">
                                    <a href="#" class="button menu" data-toggle="dropdown"></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="button edit" href="javaScript:void(0)"></a>
                                        </li>
                                        <li>
                                            <a class="button delete" onclick="$(this).addClass('opened')" data-url="<?= Yii::app()->createUrl('/contact/deleteCategory', array('id' => $category->id)) ?>" ></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <ul class="list-unstyled list-contacts list-dropdown-toggle">
                                <?php foreach($category->contacts as $contact): ?>
                                <li>
                                    <?= $contact->fullname ?>
                                    <div class="transaction-buttons-cont">
                                        <?= Html::link('', array('/contact/unlinkContact', 'id' => $contact->id), array(
                                            'data-url' => Yii::app()->createUrl('/contact/unlinkContact', array(
                                                    'category' => $category->id,
                                                    'contact' => $contact->id,
                                                )),
                                            'class' => 'button remove-mini',
                                        )) ?>
                                    </div>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr class="edit-row">
                    <td colspan="3">
                        <div class="xabina-form-narrow">
                            <?php $form = $this->beginWidget('CActiveForm', array(
                                'id' => 'contacts-category-form-' . $category->id,
                                'action' => array('/contact/category', 'id' => $category->id),
                                'enableAjaxValidation' => true,
                                'enableClientValidation' => true,
                                'errorMessageCssClass' => 'error-message',
                                'htmlOptions' => array(
                                    'class' => 'form-validable',
                                    'enctype' => 'multipart/form-data',
                                ),
                                'clientOptions' => array(
                                    'validateOnSubmit' => true,
                                    'validateOnChange' => true,
                                    'errorCssClass' => 'input-error',
                                    'successCssClass' => 'valid',
                                    'afterValidate' => 'js:afterValidate',
                                    'afterValidateAttribute' => 'js:afterValidateAttribute'
                                ),
                            )); ?>
                            <?= $form->hiddenField($category, 'id') ?>
                            <div class="row">
                                <div class="col-lg-5 col-md-5 col-sm-5">
                                    <div class="form-cell">
                                        <div class="form-lbl">
                                            <?= Yii::t('Front', 'Category name') ?>
                                            <span class="tooltip-icon"
                                                  title="<?= Yii::t('Front', 'contact_category_tooltip') ?>"></span>
                                        </div>
                                        <div class="form-input">
                                            <?= $form->textField($category, 'section', array('class' => 'input-text')) ?>
                                            <?= $form->error($category, 'section') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-5">
                                    <div class="form-cell">
                                        <div class="form-lbl">
                                            <?= Yii::t('Front', 'Description') ?>
                                            <span class="tooltip-icon"
                                                  title="<?= Yii::t('Front', 'contact_description_category_tooltip') ?>"></span>
                                        </div>
                                        <div class="form-input">
                                            <?= $form->textField($category, 'description', array('class' => 'input-text')) ?>
                                            <?= $form->error($category, 'description') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2">
                                    <div class="transaction-buttons-cont add-new-buttons">
                                        <input type="submit" class="button ok" value=""/>
                                        <a href="javaScript:void(0)" class="button cancel"></a>
                                    </div>
                                </div>
                            </div>
                            <?php $this->endWidget(); ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr class="data-row">
                <td colspan="3">
                    <a href="javaScript:void(0)"
                       class="rounded-buttons upload add-more"><?= Yii::t('Front', 'Add new'); ?></a>
                </td>
            </tr>
            <tr class="edit-row">
                <td colspan="3">
                    <div class="xabina-form-narrow">
                        <?php $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'contacts-category-form',
                            'action' => array('/contact/category'),
                            'enableAjaxValidation' => true,
                            'enableClientValidation' => true,
                            'errorMessageCssClass' => 'error-message',
                            'htmlOptions' => array(
                                'class' => 'form-validable',
                                'enctype' => 'multipart/form-data',
                            ),
                            'clientOptions' => array(
                                'validateOnSubmit' => true,
                                'validateOnChange' => true,
                                'errorCssClass' => 'input-error',
                                'successCssClass' => 'valid',
                                'afterValidate' => 'js:afterValidate',
                                'afterValidateAttribute' => 'js:afterValidateAttribute'
                            ),
                        )); ?>
                        <div class="row">
                            <div class="col-lg-5 col-md-5 col-sm-5">
                                <div class="form-cell">
                                    <div class="form-lbl">
                                        <?= Yii::t('Front', 'Category name') ?>
                                        <span class="tooltip-icon"
                                              title="<?= Yii::t('Front', 'contact_category_tooltip') ?>"></span>
                                    </div>
                                    <div class="form-input">
                                        <?= $form->textField($model, 'section', array('class' => 'input-text')) ?>
                                        <?= $form->error($model, 'section') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-5">
                                <div class="form-cell">
                                    <div class="form-lbl">
                                        <?= Yii::t('Front', 'Description') ?>
                                        <span class="tooltip-icon"
                                              title="<?= Yii::t('Front', 'contact_description_category_tooltip') ?>"></span>
                                    </div>
                                    <div class="form-input">
                                        <?= $form->textField($model, 'description', array('class' => 'input-text')) ?>
                                        <?= $form->error($model, 'description') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2">
                                <div class="transaction-buttons-cont add-new-buttons">
                                    <input type="submit" class="button ok" value=""/>
                                    <a href="javaScript:void(0)" class="button cancel"></a>
                                </div>
                            </div>
                        </div>
                        <?php $this->endWidget(); ?>
                    </div>
                </td>
            </tr>
        </table>
        <div class="clearfix"></div>
    </div>
<script>
    $(document).ready(function(){
        $('.transaction-buttons-cont .delete').confirmation({
            title: '<?= Yii::t('Front', 'Are you sure?') ?>',
            singleton: true,
            popout: true,
            onConfirm: function(){
                successNotify('Category', '<?= Yii::t('Front', 'Category successfully removed') ?>', $(this).parents('.popover').prev('a'))
                deleteRow($(this).parents('.popover').prev('a'));
                return false;
            }
        })
        $('.remove-mini').confirmation({
            title: '<?= Yii::t('Front', 'Are you sure?') ?>',
            singleton: true,
            popout: true,
            onConfirm: function(){
                var link = $(this).parents('.popover').prev('a')
                $.ajax({
                    url: link.attr('data-url'),
                    success: function (response) {
                        if (response.success) {
                            successNotify('Category', '<?= Yii::t('Front', 'Contact successfully unlinked') ?>', $(link))
                            var countUsersSpan = link.closest('td').find('a.dropdown-toggle span span')
                            var countUsers = parseFloat(countUsersSpan.text()) - 1
                            countUsersSpan.html( countUsers )
                            var aCount = countUsersSpan.closest('a');
                            aCount.attr('data-closed-text', aCount.html())
                            aCount.attr('data-opened-text', aCount.html())
                            if(countUsers == 0){
                                aCount.click().removeClass('dropdown-toggle')
                            }
                            link.closest('li').remove()
                        }
                    },
                    cache: false,
                    async: false,
                    type: 'POST',
                    dataType: 'json'
                });
                return false;
            }
        })
    })
</script>

<?php if (!Yii::request()->isAjaxRequest): ?>
    </div>
<?php endif; ?>