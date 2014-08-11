<?php
class Header extends QWidget {
	
    public function run()
    {
		if(isset(Yii::app()->session['flash_notify'])){
			if(isset(Yii::app()->session['flash_notify']['title']) && isset(Yii::app()->session['flash_notify']['message'])){
				Yii::app()->clientScript->registerScript('notify', 
					'$(document).ready(function(){successNotify("'.Yii::t('Front', Yii::app()->session['flash_notify']['title']).'","'.Yii::app()->session['flash_notify']['message'].'")})', 
					CClientScript::POS_END
				);
			}
			unset(Yii::app()->session['flash_notify']);
		}
        $this->render('header/html');
    }
}