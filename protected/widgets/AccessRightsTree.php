<?php
class AccessRightsTree extends QWidget {
	
    public $rightsTree = array();

    public function run()
    {
        $this->render('accessRightsTree/html', array('rightsTree' => $this->rightsTree));
    }
    
}
