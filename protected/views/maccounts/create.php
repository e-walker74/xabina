<div class="module-window">
<div class="module-control-panel">
    <div class="module-control sidebar-toggle">

    </div>
    <div class="header"><?= Yii::t('Accounts', 'Accounts') ?></div>
    <div class="window-controls pull-right">
        <!--        <a class="module-control settings" href="#"></a>-->
        <a class="module-control blank" target="_blank" href="?w=1"></a>
        <a class="module-control module-close" href="<?= Yii::app()->createUrl('/banking/index') ?>"></a>
    </div>

</div>
    <div class="module-menu-panel">
        <ul class="menu list-unstyled list-inline">
            <li>
                <?= Html::link(Yii::t('Accounts', 'Open account'), array('/maccounts/create')) ?>
            </li>
            <!--        <li><a class="chart" href="#"></a></li>-->
        </ul>
        <!--    <a class="download " href="#"></a>-->
    </div>
    <div class="module-search-panel">
        <span class="pop_up_input_wrap">
            <input type="text" disabled="disabled" class="search"/>
            <a class="clear_text_box" href="#" style="display: none"></a>
        </span>
        <span class="drdn-cont">
            <a class="button tags_but" style="cursor: default" data-toggle="dropdown"></a>
        </span>
        <?= Html::link(Yii::t('Accounts', 'NEW ACCOUNT'), array('/maccounts/create'), array(
            'class' => 'rounded-buttons add-new pull-right'
        )) ?>
    </div>
<div class="module-breadcrumbs-panel">
    <?php
    $this->widget('XBreadcrumbsForModule', array(
        'links'=>$this->breadcrumbs
    ));
    ?>
<!--    <div class="controls">-->
<!--        <a href="#" class="watch"></a>-->
<!--        <a href="#" class="remove"></a>-->
<!--    </div>-->

    <div class="clearfix"></div>
</div>
<div class="window-content">
<table class="layout">
<tr>
<td style="width: 18%" class="layout-sidebar">
<!--    <div class="filter-block">-->
<!--        <div class="filter-header">Filters</div>-->
<!--        <div class="filter-content">-->
<!--            <div class="form-cell">-->
<!--                <div class="form-label">Keyword</div>-->
<!--                <div class="form-input">-->
<!--                    <input class="text-input" type="text"/>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="form-cell">-->
<!--                <div class="form-label">Currency</div>-->
<!--                <div class="form-input">-->
<!--                    <div class="select-custom select-narrow ">-->
<!--                        <span class="select-custom-label">EUR</span>-->
<!--                        <select name="" class=" select-invisible country-select">-->
<!--                            <option value="">USD</option>-->
<!--                            <option value="">EUR</option>-->
<!--                            <option value="">RUB</option>-->
<!--                        </select>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="form-cell">-->
<!--                <div class="form-label">Account Type</div>-->
<!--                <div class="form-input">-->
<!--                    <input class="text-input" type="text"/>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="form-cell">-->
<!--                <div class="form-label">Status</div>-->
<!--                <div class="form-input">-->
<!--                    <div class="select-custom select-narrow ">-->
<!--                        <span class="select-custom-label">Approved</span>-->
<!--                        <select name="" class=" select-invisible country-select">-->
<!--                            <option value="">USD</option>-->
<!--                            <option value="">EUR</option>-->
<!--                            <option value="">RUB</option>-->
<!--                        </select>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</td>
<td style="width: 82%" class="layout-main">
    <?= $this->renderPartial('create/_form', array('model' => $model, 'names' => $names, 'currencies' => $currencies)) ?>
    <div class="clearfix"></div>
</td>
</tr>
</table>
</div>
</div>
<div class="clearfix"></div>