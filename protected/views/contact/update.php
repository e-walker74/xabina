<div class="edit-tabs inner-tabs">
<ul class="list-unstyled">
    <li style="width:16%; border-radius: 3px 0 0 0"><a href="#tab1-0"><?= Yii::t('Front', 'Overview'); ?></a></li>
    <li style="width:17%;"><a href="#tab1-1"><?= Yii::t('Front', 'Personal Info'); ?></a></li>
    <li style="width:17%;"><a href="#tab1-2"><?= Yii::t('Front', 'Accounts'); ?></a></li>
    <li style="width:17%;"><a href="#tab1-3"><?= Yii::t('Front', 'E-Mail'); ?></a></li>
    <li style="width:16%;"><a href="#tab1-4"><?= Yii::t('Front', 'Phone'); ?></a></li>
    <li style="width:17%;border-right: 1px solid #b9babf; border-radius:0 3px 0 0"><a
            href="#tab1-5"><?= Yii::t('Front', 'Address'); ?></a></li>
    <li style="clear: both; width:0;" class="clearfix"></li>
    <li style="width:20%;"><a href="#tab1-6"><?= Yii::t('Front', 'Social Networks'); ?></a></li>
    <li style="width:13%;"><a href="#tab1-7"><?= Yii::t('Front', 'Linking'); ?></a></li>
    <li style="width:22%;"><a href="#tab1-8"><?= Yii::t('Front', 'Instant Messaging'); ?></a></li>
    <li style="width:10%;"><a href="#tab1-9"><?= Yii::t('Front', 'URLs'); ?></a></li>
    <li style="width:11%;"><a href="#tab1-10"><?= Yii::t('Front', 'Date'); ?></a></li>
    <li style="width:12%;"><a href="#tab1-11"><?= Yii::t('Front', 'Categories'); ?></a></li>
    <li style="width:12%;"><a href="#tab1-12"><?= Yii::t('Front', 'Others'); ?></a></li>
</ul>
<div id="tab1-0" class="tab">
    <table class="table xabina-table-contacts ">
        <tr class="table-header">
            <th style="width: 42%"><?= Yii::t('Front', 'Section') ?></th>
            <th style="width: 49%"><?= Yii::t('Front', 'Description') ?></th>
            <th style="width: 9%"></th>
        </tr>
        <tr class="align-top">
            <td><?= Yii::t('Front', 'Personal Info') ?></td>
            <td>
                <?php if($model->first_name || $model->last_name): ?>
                <?= $model->first_name ?> <?= $model->last_name ?>
                <span class="note"><?= Yii::t('Front', 'First Name / Last Name') ?></span>
                <?php endif; ?>
                <?php if($model->company): ?>
                    <?= $model->company ?>
                    <span class="note"><?= Yii::t('Front', 'Company') ?></span>
                <?php endif; ?>
<!--                --><?php //if($model->sex && $model->type == 'personal'): ?>
<!--                    --><?//= $model->sex ?>
<!--                    <span class="note">--><?//= Yii::t('Front', 'Sex') ?><!--</span>-->
<!--                --><?php //endif; ?>
                <?php if($model->xabina_id): ?>
                    <?= $model->xabina_id ?>
                    <span class="note"><?= Yii::t('Front', 'Xabina User ID') ?></span>
                <?php endif; ?>

            </td>
            <td>
            </td>
        </tr>
        <?php if($account = $model->getDataByType('account', true)): ?>
            <tr class="align-top">
                <td><?= Yii::t('Front', 'Account Number') ?></td>
                <td>
                    <span class="strong"><?= $account->account_number ?></span>
                    <span class="note"><?= Yii::t('Front', Users_Contacts_Data_Account::$contacts_account_types[$account->account_type]) ?></span>
                </td>
                <td>
                    <div class="transaction-buttons-cont">
                        <a class="button card" title="<?= Yii::t('Front', 'New transfer') ?>" href="#"></a>
                    </div>
                </td>
            </tr>
        <?php endif; ?>
        <?php if($model->xabina_id): ?>
            <tr class="align-top">
                <td>
                    <?= Yii::t('Front', 'E-Mail') ?></td>
                <td>
                    <span class="strong"><?= $model->xabina_id ?>@xabina.com</span>
                    <span class="note"><?= Yii::t('Front', 'System email') ?></span>
                </td>
                <td>
                    <div class="transaction-buttons-cont">
                        <a class="button send" title="<?= Yii::t('Front', 'Send Email') ?>" href="#"></a>
                    </div>
                </td>
            </tr>
        <?php elseif($email = $model->getDataByType('email', true)): ?>
            <tr class="align-top">
                <td>
                    <?= Yii::t('Front', 'E-Mail') ?></td>
                </td>
                <td>
                    <span class="strong"><?= $email->email ?></span>
                    <span class="note"><?= ($email->getDbModel()->category) ? $email->getDbModel()->category->value : '' ?></span>
                </td>
                <td>
                    <div class="transaction-buttons-cont">
                        <a class="button send" href="#"  title="<?= Yii::t('Front', 'Send Email') ?>"></a>
                    </div>
                </td>
            </tr>
        <?php endif; ?>
        <?php if($phone = $model->getDataByType('phone', true)): ?>
            <tr class="align-top">
                <td><?= Yii::t('Front', 'Phone') ?></td>
                <td>
                    <span class="strong"><?= chunk_split($phone->phone, 3) ?></span>
                    <span class="note"></span>
                </td>
                <td>
                </td>
            </tr>
        <?php endif; ?>
        <?php if($address = $model->getDataByType('address', true)): ?>
            <tr class="align-top">
                <td><?= Yii::t('Front', 'Address') ?></td>
                <td>
                    <span class="strong"><?= $address->getAddressHtml() ?></span>
                    <span class="note"></span>
                </td>
                <td>
                </td>
            </tr>
        <?php endif; ?>
    </table>

</div>
<div id="tab1-1" class="personal tab">
    <?php $this->renderPartial('update/_personal', array('model' => $model)); ?>
</div>
<div id="tab1-2" class="account tab">
    <?php $this->renderPartial('update/_account', array('model' => $model, 'data_categories' => $data_categories)); ?>
</div>
<div id="tab1-3" class="email tab">
    <?php $this->renderPartial('update/_email', array('model' => $model, 'data_categories' => $data_categories)); ?>
</div>
<div id="tab1-4" class="phone tab">
    <?php $this->renderPartial('update/_phone', array('model' => $model, 'data_categories' => $data_categories)); ?>
</div>
<div id="tab1-5" class="address tab">
    <?php $this->renderPartial('update/_address', array('model' => $model, 'data_categories' => $data_categories)); ?>
</div>
<!--			<div id="tab6" class="default tab">-->
<!--				--><?php //$this->renderPartial('update/_default', array('model' => $model)); ?>
<!--			</div>-->
<div id="tab1-6" class="social tab">
    <?php $this->renderPartial('update/_social', array('model' => $model, 'data_categories' => $data_categories)); ?>
</div>
<div id="tab1-7" class="linking tab">
    <?php $this->renderPartial('update/_contact', array('model' => $model, 'data_categories' => $data_categories)); ?>
</div>
<div id="tab1-8" class="instmessaging tab">
    <?php $this->renderPartial('update/_instmessaging',
        array(
            'model' => $model,
            'data_categories' => $data_categories,
            'instMessengers' => $instMessengers,
        )); ?>
</div>
<div id="tab1-9" class="urls tab">
    <?php $this->renderPartial('update/_urls', array('model' => $model, 'data_categories' => $data_categories)); ?>
</div>
<div id="tab1-10" class="dates tab">
    <?php $this->renderPartial('update/_dates', array('model' => $model, 'data_categories' => $data_categories)); ?>
</div>
<div id="tab1-11" class="categories tab">
    <?php $this->renderPartial('update/_category', array(
            'model' => $model,
            'data_categories' => $data_categories,
            'link' => $link,
            'contact_categories' => $contact_categories
    )); ?>
</div>
<div id="tab1-12" class="others tab">
    <?php $this->renderPartial('update/_others', array(
        'model' => $model,
        'data_categories' => $data_categories,
    )); ?>
</div>
</div>