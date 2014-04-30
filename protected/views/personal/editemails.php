<div class="col-lg-9 col-md-9 col-sm-9" >
  <div class="h1-header">
    <?= Yii::t('Front', 'My personal cabinet'); ?>
  </div>
  <?php $this->widget('XabinaAlert'); ?>
  <div id="emails_edit">
    <div class="xabina-form-container">
      <div class="subheader">
        <?= Yii::t('Front', 'Change E-Mail addresses'); ?>
      </div>
      <?php $this->renderPartial('_emails', array('users_emails' => $users_emails, 'model_emails' => $model_emails)); ?>
    </div>
    <div class="clearfix"></div>
  </div>
</div>

<?php 
	Yii::app()->clientScript->registerScript('email', 
		'$(document).ready(function(){

			$(".delete").confirmation({
				title: "'. Yii::t('Front', 'Are you sure?') .'",
				singleton: true,
				popout: true,
				onConfirm: function(){
					link = $(this).parents(".popover").prev("a")
					deleteRow(link);
					successNotify("'. Yii::t('Front', 'Email Address?') .'", "'. Yii::t('Front', 'Email Address was successfully deleted!') .'")
					return false;
				}
			})

		})', 
		CClientScript::POS_END
	);
?>
