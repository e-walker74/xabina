<div class="details-accordion ">
<div class="accordion-header"><a href="#">Details</a></div>
<div class="accordion-content">
<div class="xabina-tabs">
<ul>
    <li style="width: 21%"><a href="#tab1"><?= Yii::t('Front', 'Charges & Urgency') ?></a></li>
    <li style="width: 17%"><a href="#tab2"><?= Yii::t('Front', 'Attachments') ?></a></li>
    <li style="width: 10%"><a href="#tab3"><?= Yii::t('Front', 'Notes') ?></a></li>
    <li style="width: 13%"><a href="#tab4"><?= Yii::t('Front', 'Сategory') ?></a></li>
    <li style="width: 14%"><a href="#tab5"><?= Yii::t('Front', 'Frequency') ?></a></li>
    <li style="width: 11%"><a href="#tab6"><?= Yii::t('Front', 'Action') ?></a></li>
    <li style="width: 14%"><a href="#tab7"><?= Yii::t('Front', 'Conditions') ?></a></li>
</ul>
<div id="tab1">
    <div class="charges-urgency-tab">
        <div class="tab-comment">
            <?= Yii::t('Front', 'comment_for_charges') ?>
        </div>
        <div class="form-line">
            <div class="form-cell pull-left" style="width:59%">
                <div class="charges">
                    <div class="lbl">
                        <?= Yii::t('Front', 'Charges'); ?>
                        <span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_text_charges') ?>"></span>
                    </div>
                    <div class="input">
                        <div class="select-custom currency-select">
                            <span class="select-custom-label"><?= Yii::t('Front', 'Shared (mandatory for EC payments)') ?></span>

                            <?= $form->dropDownList(
                                $model,
                                'charges',
                                SiteService::arrayTranslate('Front', Form_Outgoingtransf::$chargesList),
                                array('class' => 'select-invisible', 'options' => array(1 => array('selected' => true)))
                            ) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-cell pull-left" style="width:30%">
                <div class="urgency">
                    <div class="lbl">
                        <?= Yii::t('Front', 'Urgent') ?>
                        <span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_urgent') ?>"></span>
                    </div>
                    <div class="input">
                        <div class="checkbox-custom green">
                            <label>
                                <?= $form->checkbox($model, 'urgent', array('onclick' => '$(this).parent().toggleClass("checked")')); ?>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="tab2">
    <div class="attachments-tab">
        <div class="tab-comment">
            <?= Yii::t('Front', 'comment_for_attachments') ?>
        </div>

        <?php //$this->widget('WidgetUpload', array('inTable' => false))->html($model)?>

        <?php $this->widget('WidgetUpload')->getFilesTable($model, Yii::app()->user->id) ?>

    </div>

</div>
<div id="tab3">
    <div class="notes-tab">
        <div class="form-line">
            <div class="form-cell pull-left" style="width:86%">
                <div class="note">
                    <div class="form-lbl">
                        Note
                        <span class="tooltip-icon" title="tooltip text"></span>
                    </div>
                    <div class="form-input ">
                        <textarea class="notes-textarea"></textarea>
                    </div>
                </div>
            </div>
            <div class="form-cell pull-right" style="width:10%">
                <div class="form-lbl">
                    &nbsp;
                </div>
                <div class="form-input" style="text-align: right">
                    <a href="#" class="add-button">Add</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="tab4">
    <div class="category-tab">
        <div class="tab-comment">
            <?= Yii::t('Front', 'comment_for_category_tab') ?>
        </div>
        <div class="form-line">
            <div class="form-cell" style="width: 100%">

                <div class="category">
                    <div class="form-line">

                        <div class="form-lbl">
                            <?= Yii::t('Front', 'Counter Agent'); ?>
                            <span class="tooltip-icon" title="<?= Yii::t('Front', 'counter_agent_tooltip') ?>"></span>
                        </div>
                        <div class="form-input pull-left" style="width: 93%">
                            <?= $form->textField($model, 'counter_agent') ?>
                            <?= $form->error($model, 'counter_agent'); ?>
                        </div>
                        <div class="form-input pull-right " style="width: 6%">
                            <div class="transaction-buttons-cont quick-remove">
                                <a href="#" class="button search"></a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-line">
                        <div class="form-cell tags-cell">
                            <div class="form-lbl">
                                <?= Yii::t('Front', 'Tag 1') ?>
                                <span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_text_tag1') ?>"></span>
                            </div>
                            <div class="form-input">
                                <?= $form->textField($model, 'tag1') ?>
                                <?= $form->error($model, 'tag1'); ?>
                            </div>
                        </div>
                        <div class="form-cell tags-cell">
                            <div class="form-lbl">
                                <?= Yii::t('Front', 'Tag 2') ?>
                                <span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_text_tag2') ?>"></span>
                            </div>
                            <div class="form-input">
                                <?= $form->textField($model, 'tag2') ?>
                                <?= $form->error($model, 'tag2'); ?>
                            </div>
                        </div>
                        <div class="form-cell tags-cell">
                            <div class="form-lbl">
                                <?= Yii::t('Front', 'Tag 3') ?>
                                <span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_text_tag3') ?>"></span>
                            </div>
                            <div class="form-input">
                                <?= $form->textField($model, 'tag3') ?>
                                <?= $form->error($model, 'tag3'); ?>
                            </div>
                        </div>


                        <div class="clearfix"></div>
                    </div>
                    <div class="form-line">
                        <div class="form-lbl">
                            <?= Yii::t('Front', 'Category'); ?>
                            <span class="tooltip-icon" title="tooltip text"></span>
                        </div>
                        <div class="form-input ">
                            <div class="select-custom select-narrow ">
                                <span class="select-custom-label"><?= Yii::t('Front', 'Choose') ?></span>
                                <?= $form->dropDownList(
                                    $model,
                                    'category_id',
                                    array('' => Yii::t('Front', 'Choose')) + CHtml::listData($categories, 'id', 'title'),
                                    array('class' => 'select-invisible', 'options' => array('' => array('disabled' => true)))
                                ) ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div id="tab5">
    <div class="frequency-tab">

        <div class="xabina-tabs">
            <ul>
                <li style="width: 18%"><a class="freq-type" href="#tab-one" data-type="1"><?= Yii::t('Front', 'One-time'); ?></a></li>
                <li style="width: 18%"><a class="freq-type" href="#tab-standing" data-type="2"><?= Yii::t('Front', 'Standing'); ?></a></li>
                <?= $form->hiddenField($model, 'frequency_type', array('class' => 'frequency_type_field')) ?>
                <script>
                    $('.frequency-tab').on('click', 'ul li a.freq-type', function(){
                        $(this).parents('ul').find('.frequency_type_field').val($(this).attr('data-type'))
                    })
                </script>

            </ul>
            <div id="tab-one">
                <div class="form-cell">
                    <div class="form-lbl"><?= Yii::t('Front', 'Execution date'); ?></div>
                    <div class="form-input">
                        <?= $form->textField($model, 'execution_date', array('class' => 'date-input with_datepicker')) ?>
                        <?= $form->error($model, 'execution_date'); ?>
                    </div>
                </div>
            </div>
            <div id="tab-standing">
                <div class="standing-tab">
                    <div class="row period-row">
                        <div class="col-lg-5 col-md-5 col-sm-5">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Front', 'Remaining balance'); ?>
                                    <span class="tooltip-icon" title="<?= Yii::t('Front', 'tooltip_remaining_balance'); ?>"></span>
                                </div>
                                <div class="form-input ">
                                    <div class="remaining-balance">
                                        <?= $form->textField($model, 'remaining_balance', array('class' => 'sum')) ?>
                                        <span class="delimitter">.</span>
                                        <?= $form->textField($model, 'remaining_balance_cent', array('class' => 'cent')) ?>
                                        &nbsp;
                                        <span>EUR</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-7  period-cell">

                        </div>
                    </div>
                    <div class="row period-row">
                        <div class="col-lg-5 col-md-5 col-sm-5">
                            <div class="form-cell">
                                <div class="form-lbl">
                                    <?= Yii::t('Front', 'Each'); ?>
                                    <span class="tooltip-icon" title="tooltip text"></span>
                                </div>
                                <div class="form-input " style="width: 30%; margin:0 7px 0 0;">
                                    <div class="select-custom select-narrow ">
                                        <span class="select-custom-label"><?= Yii::t('Front', 'Choose') ?></span>
                                        <?= $form->dropDownList(
                                            $model,
                                            'each_period',
                                            array('' => Yii::t('Front', 'Choose')) + array(1,2,3,4),
                                            array('class' => 'select-invisible')
                                        ); ?>
                                    </div>
                                </div>
                                <div class="form-input " style="width: 58%">
                                    <div class="select-custom select-narrow ">
                                        <span class="select-custom-label"><?= Yii::t('Front', 'Choose') ?></span>
                                        <?= $form->dropDownList(
                                            $model,
                                            'period',
                                            array('' => Yii::t('Front', 'Choose')) + Form_Outgoingtransf::$periods,
                                            array('class' => 'select-invisible')
                                        ); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-7  period-cell">
                            <div class="form-cell " style="width: 41%; margin: 0 29px 0 0">
                                <div class="form-lbl">
                                    <?= Yii::t('Front', 'Start date'); ?>
                                    <span class="tooltip-icon" title="tooltip text"></span>
                                </div>
                                <div class="form-input ">
                                    <?= $form->textField($model, 'start_date', array('class' => 'date-input with_datepicker')) ?>
                                    <?= $form->error($model, 'start_date'); ?>
                                </div>
                            </div>
                            <div class="form-cell" style="width: 41%">
                                <div class="form-lbl">
                                    <?= Yii::t('Front', 'End date'); ?>
                                    <span class="tooltip-icon" title="tooltip text"></span>
                                </div>
                                <div class="form-input ">
                                    <?= $form->textField($model, 'end_date', array('class' => 'date-input with_datepicker')) ?>
                                    <?= $form->error($model, 'end_date'); ?>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
<div id="tab6">
    <div class="tab-action">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="form-cell">
                    <div class="form-lbl">
                        Pay & Mail
                        <span class="tooltip-icon" title="tooltip text"></span>
                    </div>
                    <div class="form-input ">
                        <div class="checkbox-custom">
                            <label>
                                <input type="checkbox"/>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-cell">
                    <div class="form-lbl">
                        User ID
                        <span class="tooltip-icon" title="tooltip text"></span>
                    </div>
                    <div class="form-input">
                        <input type="text"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="form-cell">
                    <div class="form-lbl">
                        Pay & Share
                        <span class="tooltip-icon" title="tooltip text"></span>
                    </div>
                    <div class="form-input ">
                        <div class="checkbox-custom">
                            <label>
                                <input type="checkbox"/>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-cell">
                    <div class="form-lbl">
                        Social Networks
                        <span class="tooltip-icon" title="tooltip text"></span>
                    </div>
                    <div class="form-input">
                        <div class="select-custom select-narrow currency-select">
                            <span class="select-custom-label">EUR</span>
                            <select name="" class=" select-invisible country-select">
                                <option value="">USD</option>
                                <option value="">EUR</option>
                                <option value="">RUB</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="tab7">
    <div class="conditions-tab ">
        <div class=" period-row">
            <div class="form-cell pull-left" style="width: 10%;">
                <div class="form-lbl">&nbsp;</div>
                <div class="form-input " style="padding: 6px 0 0">Balance</div>
            </div>
            <div class="form-cell pull-left" style="width: 28%;margin: 0 31px 0 0;">
                <div class="form-lbl"><span class="tooltip-icon" title="tooltip text" style="visibility: hidden"></span>
                </div>
                <div class="form-input " style="width: 100%">
                    <div class="select-custom select-narrow ">
                        <span class="select-custom-label">Higher than</span>
                        <select name="" class=" select-invisible country-select">
                            <option value="">Higher than</option>
                            <option value="">Lower than</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-cell pull-left " style="width: 36%">
                <div class="form-lbl">
                    Amount
                    <span class="tooltip-icon" title="tooltip text"></span>
                </div>
                <div class="form-input ">
                    <div class="remaining-balance">
                        <input class="sum" type="text" style="width: 67%;" value="">
                        <span class="delimitter">.</span>
                        <input class="cent" type="text" style="width: 25%;" value="">
                    </div>
                </div>
            </div>
            <div class="form-cell pull-right" style="width: 16%;">
                <div class="form-lbl">
                    Currency
                    <span class="tooltip-icon" title="tooltip text"></span>
                </div>
                <div class="form-input">
                    <div class="select-custom select-narrow ">
                        <span class="select-custom-label">EUR</span>
                        <select name="" class=" select-invisible country-select">
                            <option value="">EUR</option>
                            <option value="">RUB</option>
                            <option value="">USD</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class=" period-row">
            <div class="form-cell pull-left" style="width: 16%;">
                <div class="form-lbl">&nbsp;</div>
                <div class="form-input " style="padding: 6px 0 0">Exchange rate</div>
            </div>
            <div class="form-cell pull-left" style="width: 15%;margin: 0 12px 0 0;">
                <div class="form-lbl">Currency
                    <span class="tooltip-icon" title="tooltip text"></span>
                </div>
                <div class="form-input " style="width: 100%">
                    <div class="select-custom select-narrow ">
                        <span class="select-custom-label">EUR</span>
                        <select name="" class=" select-invisible country-select">
                            <option value="">EUR</option>
                            <option value="">RUB</option>
                            <option value="">USD</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-cell pull-left" style="margin: 0 7px 0 0;">
                <div class="form-lbl">&nbsp;</div>
                <div class="form-input " style="padding: 6px 0 0">To</div>
            </div>
            <div class="form-cell pull-left" style="width: 15%;margin: 0 11px 0 0;">
                <div class="form-lbl">Currency
                    <span class="tooltip-icon" title="tooltip text"></span>
                </div>
                <div class="form-input " style="width: 100%">
                    <div class="select-custom select-narrow ">
                        <span class="select-custom-label">EUR</span>
                        <select name="" class=" select-invisible country-select">
                            <option value="">EUR</option>
                            <option value="">RUB</option>
                            <option value="">USD</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-cell pull-left" style="margin: 0 7px 0 0;">
                <div class="form-lbl">&nbsp;</div>
                <div class="form-input " style="padding: 6px 0 0">Is</div>
            </div>
            <div class="form-cell pull-left" style="width: 24%;">
                <div class="form-lbl"><span class="tooltip-icon" title="tooltip text" style="visibility: hidden"></span>
                </div>
                <div class="form-input " style="width: 100%">
                    <div class="select-custom select-narrow ">
                        <span class="select-custom-label">Higher than</span>
                        <select name="" class=" select-invisible country-select">
                            <option value="">Higher than</option>
                            <option value="">Lower than</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-cell pull-right" style="width: 17%;">
                <div class="form-lbl">
                    Ratio
                    <span class="tooltip-icon" title="tooltip text"></span>
                </div>
                <div class="form-input">
                    <input type="text">
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="period-row">
            <div class="form-lbl">
                Signed by user
                <span class="tooltip-icon" title="tooltip text"></span>
            </div>
            <div class="form-input pull-left" style="width: 93%">
                <input type="text">
            </div>
            <div class="form-input pull-right " style="width: 6%">
                <div class="transaction-buttons-cont quick-remove">
                    <a href="#" class="button search"></a>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="add-more-cont">
            <a href="#" class=" rounded-buttons upload add-more">Add more users</a>
        </div>
    </div>

</div>
</div>
</div>
</div>