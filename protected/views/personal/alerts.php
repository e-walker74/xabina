<?php
/**
 * @var PersonalController $this
 * @var Alerts[] $alerts
 * @var Users_AlertsRules[] $userAlertsRules
 * @var Users_Emails[] $emailAddresses
 * @var Users_Phones[] $phones
 * @var Accounts $selectedAcc
 */
?>
<div class="xabina-tabs col-lg-9 col-md-9 col-sm-9">
	<div class="h1-header"><?= Yii::t('Front', 'Alerts'); ?></div>
    <ul>
        <li><a href="#account-alert-tab">Account Alerts</a></li>
        <li><a href="#enviroment-alert-tab">Environment Alerts</a></li>
    </ul>
    <div id="account-alert-tab">
        <div class="account-selection">
            <span class="select-lbl"><?= Yii::t('Front', 'Account'); ?></span>
            <div class="select-custom account-select">
                    <span class="select-custom-label">
                            <?= $selectedAcc->user->fullName ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?= chunk_split($selectedAcc->number, 4) ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?= number_format($selectedAcc->balance, 0, "", " ") ?>
                        <?= $selectedAcc->currency->title ?>
                        </span>
                <select name="" id="account-number-select" class="select-invisible">
                    <?php foreach($accounts as $acc): ?>
                        <option <?php if($acc->number == $selectedAcc->number): ?>selected<?php endif; ?> value="<?= $acc->number ?>">
                            <?= $acc->user->fullName ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?= chunk_split($acc->number, 4) ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?= number_format($acc->balance, 0, "", " ") ?>
                            <?= $acc->currency->title ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="table-alert-header-cont">
            <table class="table table-alert-header">
                <tbody><tr>
                    <th width="20%"><?= Yii::t('Front', 'Rule'); ?></th>
                    <th width="23%"><?= Yii::t('Front', 'Charachteristics'); ?></th>
                    <th width="29%"><?= Yii::t('Front', 'E-mail'); ?></th>
                    <th width="15%"><?= Yii::t('Front', 'Phone'); ?></th>
                    <th width="13%" style="text-align: right"><a class="slide-but" data-toggle="collapse" href="#alerts-table"></a></th>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="table-alert-cont collapse in" id="alerts-table">
            <?php $this->renderPartial('_rulesTable', array(
                    'emailAddresses' => $emailAddresses,
                    'phones' => $phones,
                    'selectedAcc' => $selectedAcc,
                    'userAlertsRules' => $userAlertsRules
                )); ?>
        </div>
    </div>

    <div id="enviroment-alert-tab">
        <div class="table-alert-header-cont">
            <table class="table table-alert-header">
                <tbody><tr>
                    <th width="43%"><?= Yii::t('Front', 'Options'); ?></th>
                    <th width="29%"><?= Yii::t('Front', 'E-mail'); ?></th>
                    <th width="18%"><?= Yii::t('Front', 'Phone'); ?></th>
                    <th width="10%" style="text-align: right"><a class="slide-but" data-toggle="collapse" href="#static-alerts"></a></th>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="table-alert-cont collapse in" id="static-alerts">
            <table class="table table-alert">
                <tbody>
                <?php foreach ($alerts as $alert): ?>
                <tr>
                    <td style="width: 43%">
                        <?= $alert->name; ?> <br>
                        <div class="tips">
                            <?= $alert->desc; ?>
                        </div>
                    </td>
                    <td class="lh" style="width: 29%">
                        <?php
                        if(isset($alert->userAlertRules[0])) {
                            $model = $alert->userAlertRules[0];
                        } else {
                            $model = new Users_AlertsRules();
                        }
                        $url = $this->createUrl('updatealerts', array('id'=> !$model->isNewRecord ? $model->id : 'new'));
                        $form=$this->beginWidget('CActiveForm', array(
                                'action' => $url,
                                'method' => 'post',
                                'htmlOptions' => array(
                                    'data-new' => $model->isNewRecord ? 'true' : 'false'
                                )
                                )); ?>
                        <?= $form->hiddenField($model, "alert_code", array('value'=>$alert->code));?>
                        <?php foreach ($emailAddresses as $email) : ?>
                        <label>
                            <?= $form->checkBox($model, "emails[{$email->id}]", array(
                                    'class'=>'input-checkbox',
                                    'checked' => $model->inEmails($email)
                                ));?>
                            <?= $email->email; ?>
                        </label>
                        <?php endforeach; ?>
                        <?php $this->endWidget(); ?>
                    </td>
                    <td class="lh" style="width: 19%">
                        <?php $form=$this->beginWidget('CActiveForm', array(
                                'action' => $url,
                                'method' => 'post',
                                'htmlOptions' => array(
                                    'data-new' => $model->isNewRecord ? 'true' : 'false'
                                )
                            )); ?>
                        <?= $form->hiddenField($model, "alert_code", array('value'=>$alert->code));?>
                        <?php foreach ($phones as $phone) : ?>
                            <label>
                            <?= $form->checkBox($model, "phones[{$phone->id}]", array(
                                    'class'=>'input-checkbox',
                                    'checked' => $model->inPhones($phone)
                                ));?>
                                +<?= $phone->phone; ?>
                            </label>
                        <?php endforeach; ?>
                        <?php $this->endWidget(); ?>
                    </td>
                    <td style="width: 10%" class="actions-td"></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>