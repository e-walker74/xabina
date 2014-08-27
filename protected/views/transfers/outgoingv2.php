<div class="col-lg-9 col-md-9 col-sm-9 accordions-container">
<div class="h1-header"><?= Yii::t('Front', 'New transfer') ?></div>
<div class="transfer-accordion xabina-accordion xabina-transfer-accordion">
<?php
	$this->renderPartial(
		'outgoingv2/_quick', 
		array(
			'quickTransfers' => $quickTransfers, 
			'quickForm' 	=> $quickForm,
			'currencies' 	=> $currencies,
			'selectedAcc' 	=> $selectedAcc,
			'user' 			=> $user,
		)
	); ?>
<?php 
	$this->renderPartial(
		'outgoingv2/_own', 
		array(
			'quickTransfers' => $quickTransfers, 
			'ownForm' 		=> $ownForm,
			'currencies' 	=> $currencies,
			'selectedAcc' 	=> $selectedAcc,
			'user' 			=> $user,
			'categories'	=> $categories,
		)
	); ?>
<?php 
	$this->renderPartial(
		'outgoingv2/_bank', 
		array(
			'quickTransfers' => $quickTransfers, 
			'externalForm' 		=> $externalForm,
			'currencies' 	=> $currencies,
			'selectedAcc' 	=> $selectedAcc,
			'user' 			=> $user,
			'categories'	=> $categories,
		)
	); ?>
<?php 
	$this->renderPartial(
		'outgoingv2/_ewallet', 
		array(
			'quickTransfers' => $quickTransfers, 
			'ewalletForm' 	=> $ewalletForm,
			'currencies' 	=> $currencies,
			'selectedAcc' 	=> $selectedAcc,
			'user' 			=> $user,
			'categories'	=> $categories,
		)
	); ?>


</div>
</div>

<?php Yii::app()->clientScript->registerScriptFile('/js/transfersv2.js'); ?>

<?php if($transfer): ?>
    <script>
        $(document).ready(function(){
            $('.label-<?= $transfer->form_type ?>-form').click();
            $('#Form_Outgoingtransf_Ewallet_ewallet_type').change();
        })
    </script>
<?php endif; ?>
