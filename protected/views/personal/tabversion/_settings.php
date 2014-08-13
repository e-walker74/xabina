<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 29.07.14
 * Time: 16:06
 */ ?>
<div class="xabina-form-normal">
<form name="settings-form" id="settings_form">
    <table class="table  xabina-table-contacts">
        <tbody><tr class="table-header">
            <th width="35%"><?= Yii::t('Front', 'Options'); ?></th>
            <th width="50%"></th>
            <th width="15%"></th>
        </tr>
        <tr class="user-settings-data">
            <td><?= Yii::t('Front', 'Language'); ?></td>
            <td class="data"><?= Languages::$languages[$user->settings->language] ?></td>
            <td>
                <div class="transaction-buttons-cont">
                    <a href="#" class="button edit"></a>
                </div>
            </td>
        </tr>
        <tr class="edit-block" data-type="language">
            <td><?= Yii::t('Front', 'Language'); ?></td>
            <td>
                <div class="select-custom ">
                    <span class="select-custom-label"><?= Languages::$languages[$user->settings->language] ?></span>
                    <?= CHtml::activeDropDownList($user->settings, 'language', Languages::$languages, array('class' => 'select-invisible')) ?>
                </div>
            </td>
            <td style="width:50px">
                <div class="transaction-buttons-cont">
                    <input type="submit" class="button ok" value="" />
                    <a class="button cancel" href="javaScript:void(0)"></a>
                </div>
            </td>
        </tr>
        <tr class="user-settings-data">
            <td><?= Yii::t('Front', 'Statement language'); ?></td>
            <td class="data"><?= Languages::$languages[$user->settings->statement_language] ?></td>
            <td>
                <div class="transaction-buttons-cont">
                    <a href="#" class="button edit"></a>
                </div>
            </td>
        </tr>
        <tr class="edit-block" data-type="statement-timezone">
            <td><?= Yii::t('Front', 'Statement language'); ?></td>
            <td>
                <div class="select-custom ">
                    <span class="select-custom-label"><?= Languages::$languages[$user->settings->statement_language] ?></span>
                    <?= CHtml::activeDropDownList($user->settings, 'statement_language', Languages::$languages, array('class' => 'select-invisible')) ?>
                </div>
            </td>
            <td>
                <div class="transaction-buttons-cont">
                    <input type="submit" class="button ok" value="" />
                    <a class="button cancel" href="javaScript:void(0)"></a>
                </div>
            </td>
        </tr>
        <tr class="user-settings-data">
            <td><?= Yii::t('Front', 'Font size'); ?></td>
            <td class="data"><?= $user->settings->font_size ?>px</td>
            <td>
                <div class="transaction-buttons-cont">
                    <a href="#" class="button edit"></a>
                </div>
            </td>
        </tr>
        <tr class="edit-block" data-type="fontsize">
            <td><?= Yii::t('Front', 'Font size'); ?></td>
            <td>
                <div class="select-custom ">
                    <span class="select-custom-label"><?= $user->settings->font_size ?>px</span>
                    <?= CHtml::activeDropDownList($user->settings, 'font_size', array(
                        '14' => '14px',
                        '16' => '16px',
                        '18' => '18px',
                    ), array('class' => 'select-invisible')) ?>
                </div>
            </td>
            <td>
                <div class="transaction-buttons-cont">
                    <input type="submit" class="button ok" value="" />
                    <a class="button cancel" href="javaScript:void(0)"></a>
                </div>
            </td>
        </tr>
        <tr class="user-settings-data">
            <td><?= Yii::t('Front', 'Time zone'); ?></td>
            <td class="data">
                <?= Zone::$showZones[$user->settings->time_zone_id] ?>
            </td>
            <td>
                <div class="transaction-buttons-cont">
                    <a href="#" class="button edit"></a>
                </div>
            </td>
        </tr>
        <tr class="edit-block" data-type="timezone">
            <td><?= Yii::t('Front', 'Time zone'); ?></td>
            <td>
                <div class="select-custom">
                    <span class="select-custom-label"></span>
                    <?=
                        CHtml::activeDropDownList(
                            $user->settings,
                            'time_zone_id',
                            Zone::$showZones,
                            array(
                                'class' => 'select-invisible'
                            )
                        ) ?>
                </div>
            </td>
            <td>
                <div class="transaction-buttons-cont">
                    <input type="submit" class="button ok" value="" />
                    <a class="button cancel" href="javaScript:void(0)"></a>
                </div>
            </td>
        </tr>
        <tr class="user-settings-data">
            <td><?= Yii::t('Front', 'Currency'); ?></td>
            <td class="data"><?= $user->settings->currency->code ?></td>
            <td>
                <div class="transaction-buttons-cont">
                    <a href="#" class="button edit"></a>
                </div>
            </td>
        </tr>
        <tr class="edit-block" data-type="currency">
            <td><?= Yii::t('Front', 'Currency'); ?></td>
            <td>
                <div class="select-custom ">
                    <span class="select-custom-label"><?= $user->settings->currency->code ?></span>
                    <?= CHtml::activeDropDownList($user->settings, 'currency_id',
                        CHtml::listData(Currencies::model()->findAll(), 'id', 'title'),
                        array('class' => 'select-invisible')) ?>
                </div>
            </td>
            <td>
                <div class="transaction-buttons-cont">
                    <input type="submit" class="button ok" value="" />
                    <a class="button cancel" href="javaScript:void(0)"></a>
                </div>
            </td>
        </tr>
        </tbody></table>
</form>
</div>
<script>

    $('.edit').click(function(){
        resetPage()
        $(this).parents('tr').hide().next('.edit-block').show()
        return false;
    })


    $('#settings_form .ok').click(function(){
        row = $(this).parents('tr')
        backgroundBlack()
        $.ajax({
            type: "POST",
            url: "<?= Yii::app()->createUrl('/personal/settings') ?>",
            success: function(data){
                if(data.success){
                    var text = row.find('select option:selected').text()
                    var datafield = row.prev('.user-settings-data').find('.data')
                    datafield.html(text)
                    resetPage()
                    if(data.html){
                        row.closest('.tab').html(data.html)
                    }
                    if(row.attr('data-type') == 'fontsize'){
                        Personal.changeFontSize(data.attrs.font_size)
                    }
                    if(row.attr('data-type') == 'timezone'){
                        window.location.reload()
                    } else {
                        successNotify('<?= Yii::t('Front', 'Account Settings') ?>', '<?= Yii::t('Front', 'Changes was successfully saved') ?>', row)
                    }
                    if(data.redirect){
                        window.location.replace(data.redirect);
                    }
                    dellBackgroundBlack()
                }
            },
            dataType: 'json',
            data: $('#settings_form').serialize()
        });
        return false;
    })

</script>