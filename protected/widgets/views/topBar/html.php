<div class="top-bar">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class=" clearfix">
                    <select name="" id="" class="language-select pull-left">
                        <option value="">Ru</option>
                        <option value="">En</option>
                    </select>

                    <div class="font-size-adjust-container pull-left">
                        <?= Yii::t('Front', 'Font size'); ?>
                        <ul class="font-size-adjust   list-inline">
                            <li class="small-size" onclick="fontScale(1);">A</li>
                            <li class="medium-size" onclick="fontScale(1.25);">A</li>
                            <li class="large-size" onclick="fontScale(1.5);">A</li>
                        </ul>
                    </div>
                    <ul class="user-menu pull-right  list-inline">
                        <li class="user-personal"><a href="<?= Yii::app()->createUrl('personal/index'); ?>"></a></li>
                        <li class="user-email"><a href="#"></a></li>
                        <li class="user-settings"><a href="#"></a></li>
                        <li class="user-logout"><?= CHtml::link('', array('/logout'), array('onclick'=>'return confirm("'.Yii::t('Front', 'Are you sure you want to logout?').'")')); ?></li>
                    </ul>
                    <div class="user-greeting pull-right"><?= Yii::t('Front', 'Hello, <span>:name</span>', array(':name' => Yii::app()->user->name)); ?></div>
                </div>
            </div>
        </div>
    </div>

</div>