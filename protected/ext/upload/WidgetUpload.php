<?php
class WidgetUpload extends CWidget {
	
	public $inTable = true;
	public $showDialog = true;
	public $formId = 'file-form';
	public $typeSuffix = '';

    public function run()
    {
        if($this->typeSuffix) {
            $this->formId = $this->formId.$this->typeSuffix;
        }       
        
        $cs = Yii::app()->clientScript;
		$assets_path = dirname(__FILE__).DIRECTORY_SEPARATOR.'assets';
		$url = Yii::app()->assetManager->publish($assets_path, false, -1, YII_DEBUG);
		$cs->registerScriptFile($url.'/upload.js',CClientScript::POS_END);
    }
	
	public function getFilesTable($model, $user, $processOutput = false)
    {
		$type = get_class($model).$this->typeSuffix;
		if(isset($model->id)){
			$files = Users_Files::model()->findAll(
				array(
					'condition' => 'user_id = :uid AND form = :type AND model_id = :mId AND deleted = 0', 
					'params' => array(
						':uid' => $user,
						':type' => $type,
						':mId' => $model->id,
					),
					'order' => 'created_at desc',
				)
			);
		} else {
			$files = Users_Files::model()->findAll(
				array(
					'condition' => 'user_id = :uid AND form = :type AND deleted = 0', 
					'params' => array(
						':uid' => $user,
						':type' => $type,
					),
					'order' => 'created_at desc',
				)
			);
		}
		
		return $this->render('files', array('files' => $files), $processOutput);
	}
	
	public function html($model)
    {
		$this->render('form', array('model' => $model));
	}
}