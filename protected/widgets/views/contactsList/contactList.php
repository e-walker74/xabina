<?php if(!Yii::app()->request->isAjaxRequest): ?>
<div id="contactsList">
<?php endif; ?>

<?php $this->render('contactsList/contactListUl', array('model' => $model)) ?>

<?php if(!Yii::app()->request->isAjaxRequest): ?>
</div>
<?php endif; ?>