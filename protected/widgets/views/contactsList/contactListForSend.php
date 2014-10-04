<?php if(!Yii::app()->request->isAjaxRequest): ?>
<div id="contactsList" class="contacts-list-cont scroll-block" >
<?php endif; ?>

<?php $this->render('contactsList/contactListForSendUl', array('model' => $model)) ?>

<?php if(!Yii::app()->request->isAjaxRequest): ?>
</div>
<?php endif; ?>