<?php
class WidgetUpload extends QWidget {
	
	public $inTable = true;
	public $showDialog = true;
	
    public function run()
    {
        $cs = Yii::app()->clientScript;
		$cs->registerCoreScript('jquery');

		$assets_path = dirname(__FILE__).DIRECTORY_SEPARATOR.'assets';
		$url = Yii::app()->assetManager->publish($assets_path, false, -1, YII_DEBUG);
		$cs->registerScriptFile($url.'/upload.js',CClientScript::POS_END);
    }
	
	public function getFilesTable($model, $user, $processOutput = false){
		$files = Users_Files::model()->findAll(
			array(
				'condition' => 'user_id = :uid AND form = :type AND deleted = 0', 
				'params' => array(
					':uid' => $user,
					':type' => get_class($model),
				),
				'order' => 'created_at desc',
			)
		);
		return $this->render('files', array('files' => $files), $processOutput);
	}
	
	public function html($model){
		$this->render('form', array('model' => $model));
	}
}