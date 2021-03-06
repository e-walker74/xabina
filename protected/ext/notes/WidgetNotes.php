<?php
class WidgetNotes extends QWidget {
	
    public function run()
    {
        $cs = Yii::app()->clientScript;
		$cs->registerCoreScript('jquery');

		$assets_path = dirname(__FILE__).DIRECTORY_SEPARATOR.'assets';
		$url = Yii::app()->assetManager->publish($assets_path, false, -1, YII_DEBUG);
		$cs->registerScriptFile($url.'/notes.js',CClientScript::POS_END);
    }
	
	public function getFilesTable($model, $user, $processOutput = false){
		$files = Users_Files::model()->findAll('user_id = :uid AND form = :type AND deleted = 0', array(
			':uid' => $user,
			':type' => get_class($model),
		));
		return $this->render('list', array('files' => $files), $processOutput);
	}
	
	public function html($model){
		$this->render('form', array('model' => $model));
	}
}