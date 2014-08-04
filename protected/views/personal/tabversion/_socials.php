<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 29.07.14
 * Time: 8:59
 */ ?>

<div class=" xabina-form-normal">
    <table class="table xabina-table-contacts">
        <tr class="table-header">
            <th style="width: 8%"></th>
            <th style="width: 20%"><?= Yii::t('Personal', 'Username') ?></th>
            <th style="width: 32%"><?= Yii::t('Personal', 'Profile Url') ?></th>
            <th style="width: 32%"><?= Yii::t('Personal', 'Status') ?></th>
            <th style="width: 8%"></th>
        </tr>
        <?php foreach($user->socials as $soc): ?>
            <tr>
                <td>
                    <div class="soc-net-ico <?= array_search($soc->provider, Users_Providers::$providersModel); ?>"></div>
                </td>
                <td>
                    <img class="soc-avatar" src="<?= $soc->getProvider()->avatar ?>" width="30" /> <?= $soc->getProvider()->login ?>
                </td>
                <td>
                    <a target="_blank" href="<?= Yii::app()->createUrl('/site/disclaime', array('tourl' => urlencode($soc->getProvider()->url))) ?>" class="make-primary"><?= $soc->getProvider()->url ?></a>
                <td>
                    <?php if($soc->is_master): ?>
                        <span class="bold"><?= Yii::t('Personal', 'Primary'); ?></span>
                    <?php else: ?>
                        <a href="javaScript:void(0)" onclick="js:Personal.makePrimary('<?= Yii::app()->createUrl('/personal/makePrimary', array('type' => 'socials', 'id' => $soc->id)) ?>', this)" class="make-primary"><?= Yii::t('Personal', 'Make primary'); ?></a>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if(!$soc->is_master): ?>
                    <div class=" transaction-buttons-cont">
                        <?= Html::link('', 'javaScript:void(0)', array(
                            'class' => 'button delete',
                            'onclick' => '$(this).addClass(\'opened\')',
                            'data-url' => Yii::app()->createUrl('/personal/delete', array('type' => 'social', 'id' => $soc->id)),
                        )) ?>
                    </div>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach?>
        <tr>
            <td class="add-new-td" colspan="5">
                <?php $this->widget('application.ext.eauth.EAuthWidget', array('action' => '/personal/editsocials')); ?>
            </td>
        </tr>
    </table>
</div>