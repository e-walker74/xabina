<div class="message-container">
  <div class="messages-history">
    <ul class="history-list list-unstyled">
		
      <?php foreach ($dialogs as $dialog):?>
      <li>
        <div class="message-headers">
          <table class="message-headers-table">
            <tbody>
              <tr>
                <td width="12%"><?= Yii::t('Front', 'From:'); ?></td>
                <td width="88%" class="from">
					<?php if($dialog->from_id == (int)Yii::app()->user->id):?>
						<?= Yii::t('Front', 'Me'); ?>
                    <?php else: ?> 
                         <?=$dialog->from?>  
                    <?php endif;?>
                </td>
              </tr>
              <tr>
                <td><?= Yii::t('Front', 'Subject:'); ?></td>
                <td><?=$dialog->subject?></td>
              </tr>
              <tr>
                <td><?= Yii::t('Front', 'Date:'); ?></td>
                <td><?=date('d M Y H:i',$dialog->sent_at)?></td>
              </tr>
              <tr>
                <td><?= Yii::t('Front', 'To:'); ?></td>
                <td><?=$dialog->to?></td>
              </tr>
            </tbody>
          </table>
          <!--<a class="attachment-link" href="#">Annual Financial Summary 2013</a></div>-->
        <div class="message-text">
          <?=$dialog->message?>
        </div>
      </li>
      <?php endforeach;?>
    </ul>
  </div>
</div>
