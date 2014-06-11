<?php
class QWidget extends CWidget
{
    public $viewFile;

    private $_data = array();

    public function beforeHtml(){}
    public function afterHtml(){}

	public function init(){
		if(isset($_GET['show_all_widgets']) && $_GET['show_all_widgets'] == 1){
			echo get_class($this);
		}
	}
	
    public function setData(array $data){
		foreach($data as $key => $val){
			$this->_data[$key] = $val;
		}
		return $this;
    }
	
	public function getData(){
		return $this->_data;
	}

    public function html($captureOutput = false)
    {
        if(!$this->viewFile){
            throw new CHttpException(404, Yii::t('Widget', 'Виджет {widget} не имеет представления. Укажите наименование файла представления "public $viewFile" в классе "{widget}"', array('{widget}' => get_called_class())));
        }
        $this->beforeHtml();
        $html = parent::render($this->viewFile, $this->_data, $captureOutput);
        $this->afterHtml();
		return $html;
    }
}