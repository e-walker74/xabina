<div class="col-lg-9 col-md-9 col-sm-9" >
  <div class="h1-header">
    <?= Yii::t('Front', 'My personal cabinet'); ?>
  </div>
  <div class="subheader">
    <?= Yii::t('Front', 'E-Mail addresses'); ?>
  </div>
  <table class="table xabina-table">
    <tbody>
      <tr class="table-header">
        <th style="width: 39%"><?= Yii::t('Front', 'E-Mail')?></th>
        <th style="width: 25%"><?= Yii::t('Front', 'Type')?></th>
        <th style="width: 24%"><?= Yii::t('Front', 'Status')?></th>
        <th style="width: 12%" class="edit-th"> <div class="table-edit-btn">
        <?=CHtml::link('Edit',array('personal/editemails')); ?>
        </div>
        </th>
      </tr>
      <? foreach ($users_emails as $users_email): ?>
      <tr>
        <td><?= $users_email->email ?></td>
        <td><div class="relative"> <span class="dropdown_button types_dropdown">
            <?= $users_email->emailType->type_name ?>
            </span> </div></td>
        <td><span class="primary">
          <? if($users_email->status == 0 && $users_email->is_master == 0):?>
          <?= Yii::t('Front', 'Resend email'); ?>
          <? elseif ($users_email->status == 1 && $users_email->is_master == 0):?>
          <?= Yii::t('Front', 'Make primary'); ?>
          <? elseif ($users_email->status == 1 && $users_email->is_master == 1):?>
          <?= Yii::t('Front', 'Primary'); ?>
          <? endif;?>
          </span></td>
        <td class="remove-td"><div class="remove-btn"></div></td>
      </tr>
      <? endforeach; ?>
    </tbody>
  </table>
  <div class="subheader">
    <?= Yii::t('Front', 'Phone numbers'); ?>
  </div>
  <table class="table xabina-table">
    <tbody>
      <tr class="table-header">
        <th style="width: 39%"><?= Yii::t('Front', 'Phone')?></th>
        <th style="width: 25%"><?= Yii::t('Front', 'Type')?></th>
        <th style="width: 24%"><?= Yii::t('Front', 'Status')?></th>
        <th style="width: 12%" class="edit-th"> <div class="table-edit-btn">
        <?=CHtml::link('Edit',array('personal/editphones')); ?>
        </div>
        </th>
      </tr>
      <? foreach ($users_phones as $users_phone): ?>
      <tr>
        <td><?= $users_phone->phone ?></td>
        <td><div class="relative"> <span class="dropdown_button types_dropdown">
            <?= $users_phone->emailType->type_name ?>
            </span> </div></td>
        <td><span class="primary">
          <? if($users_phone->status == 0 && $users_phone->is_master == 0):?>
          <?= Yii::t('Front', 'Resend email'); ?>
          <? elseif ($users_phone->status == 1 && $users_phone->is_master == 0):?>
          <?= Yii::t('Front', 'Make primary'); ?>
          <? elseif ($users_phone->status == 1 && $users_phone->is_master == 1):?>
          <?= Yii::t('Front', 'Primary'); ?>
          <? endif;?>
          </span></td>
        <td class="remove-td"><div class="remove-btn"></div></td>
      </tr>
      <? endforeach; ?>
    </tbody>
  </table>
  <div class="subheader">
    <?= Yii::t('Front', 'Change addresses'); ?>
  </div>
  <table class="table xabina-table">
    <tbody>
      <tr class="table-header">
        <th style="width: 39%"><?= Yii::t('Front', 'Address')?></th>
        <th style="width: 25%"><?= Yii::t('Front', 'Type')?></th>
        <th style="width: 24%"><?= Yii::t('Front', 'Status')?></th>
        <th style="width: 12%" class="edit-th"> <div class="table-edit-btn">
         <?=CHtml::link('Edit',array('personal/editaddress')); ?>
        </div>
        </th>
      </tr>
      <? foreach ($users_address as $users_addr): ?>
        <tr>
            <td>
			<?= $users_addr->address ?><br>
            <?= empty($users_addr->address_optional) ? '' : $users_addr->address_optional .'<br>' ?>
            <?= $users_addr->indx?><br>
            <?= $users_addr->city?><br>
            <?= $users_addr->country_id?>
            </td>
            <td>
                <div class="relative">
                    <span class="dropdown_button types_dropdown">
                        <?= $users_addr->emailType->type_name ?>
                    </span>
               </div>
            </td>
            <td>
            	<span class="primary">
                <? if($users_addr->status == 0 && $users_addr->is_master == 0):?>
                	<?= Yii::t('Front', 'Resend address'); ?>
                <? elseif ($users_addr->status == 1 && $users_addr->is_master == 0):?>
                	<?= Yii::t('Front', 'Make primary'); ?>
                <? elseif ($users_addr->status == 1 && $users_addr->is_master == 1):?>
                	<?= Yii::t('Front', 'Primary'); ?>
                <? endif;?></span>
            </td>
            <td class="remove-td">
                <div class="remove-btn"></div>
            </td>
        </tr>
    <? endforeach; ?>
    </tbody>
  </table>
</div>
