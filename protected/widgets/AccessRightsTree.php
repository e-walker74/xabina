<?php
class AccessRightsTree extends QWidget {
	
    public $rightsTree = array();

    public function run()
    {
        // foreach ($this->rightsTree as $right) {
        //     echo $right['name'].'<br/>';
        //     if(isset($right['children'])) {
        //         $this->tree($right['children']);
        //     }
        // }        
        $this->render('accessRightsTree/html');
    }
    
    private function tree($children) {
        // foreach ($children as $right) {
        //     echo '--'.$right['name'].'<br/>';
        //     if(isset($right['children'])) {
        //         $this->tree($right['children']);
        //     }
        // }
    }
    
    
}
