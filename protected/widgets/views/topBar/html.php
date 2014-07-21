<?php /*<div class="top-bar">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class=" clearfix">
                    <select name="" id="" class="language-select pull-left">
						<?php foreach(Yii::app()->params->translatedLanguages as $label => $translate): ?>
							<option <?php if($label == Yii::app()->language): ?>selected="selected"<?php endif; ?> value="<?= Yii::app()->createUrl(Yii::app()->request->url, array('language' => $label)) ?>"><?= $label ?></option>
						<?php endforeach; ?>
                    </select>

                    <div class="font-size-adjust-container pull-left">
                        <?= Yii::t('Front', 'Font size'); ?>
                        <ul class="font-size-adjust   list-inline">
                            <li class="small-size" onclick="fontScale(1);">A</li>
                            <li class="medium-size" onclick="fontScale(1.25);">A</li>
                            <li class="large-size" onclick="fontScale(1.5);">A</li>
                        </ul>
                        <script>
                            <?php if(Yii::app()->user->getFontSize() == '16'): ?>
                                fontScale(1.25)
                            <?php elseif(Yii::app()->user->getFontSize() == '18'): ?>
                                fontScale(1.5)
                            <?php endif; ?>
                        </script>
                    </div>
                    <ul class="user-menu pull-right  list-inline">
                        <li class="user-settings"><a href="<?= Yii::app()->createUrl('personal/index'); ?>"></a></li>
                        <li class="user-email"><a href="<?= Yii::app()->createUrl('message/index'); ?>"></a></li>
                        <!--<li class="user-personal"><a href="#"></a></li>-->
                        <li class="user-logout"><?= CHtml::link('', array('/site/logout')); ?></li>
                    </ul>
                    <div class="user-greeting pull-right"><?= Yii::t('Front', 'Hello, <span>:name</span>', array(':name' => Yii::app()->user->name)); ?></div>
                </div>
            </div>
        </div>
    </div>

</div>*/?>
<div class="top-bar">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class=" clearfix">
                    <select name="" id="" class="language-select pull-left">
						<?php foreach(Yii::app()->params->translatedLanguages as $label => $translate): ?>
							<option <?php if($label == Yii::app()->language): ?>selected="selected"<?php endif; ?> value="<?= Yii::app()->createUrl(Yii::app()->request->url, array('language' => $label)) ?>"><?= $label ?></option>
						<?php endforeach; ?>
                    </select>

                    <div class="font-size-adjust-container pull-left">
                        <?= Yii::t('Front', 'Font size'); ?>
                        <ul class="font-size-adjust   list-inline">
                            <li class="small-size" onclick="fontScale(1);">A</li>
                            <li class="medium-size" onclick="fontScale(1.25);">A</li>
                            <li class="large-size" onclick="fontScale(1.5);">A</li>
                        </ul>
                        <script>
                            <?php if(Yii::app()->user->getFontSize() == '16'): ?>
                                fontScale(1.25)
                            <?php elseif(Yii::app()->user->getFontSize() == '18'): ?>
                                fontScale(1.5)
                            <?php endif; ?>
                        </script>
                    </div>
                    <ul class="user-menu pull-right  list-inline">
                        <li class="user-personal"><a href="/account/personal_account.html"></a></li>
                        <li class="user-email"><a href="<?= Yii::app()->createUrl('message/index'); ?>"></a></li>
                        <li class="user-settings"><a href="<?= Yii::app()->createUrl('personal/index'); ?>"></a></li>
                        <li class="user-logout"><?= CHtml::link('', array('/site/logout')); ?></li>
                    </ul>
                    <div class="user-greeting pull-right"><?= Yii::t('Front', 'Hello, <span>:name</span>', array(':name' => Yii::app()->user->fullName)); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

$(document).ready(function(){

	$('.user-logout').confirmation({
		title: '<?= Yii::t('Front', 'Are you sure?') ?>',
		singleton: true,
		popout: true,
		href: '<?= Yii::app()->createUrl('/site/logout') ?>',
		placement: 'bottom'
	})
})

</script>