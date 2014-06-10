<?php
class AccountInfo extends QWidget {
	
    public $account = array();

    public function run()
    {
        $this->render('accountInfo/html', array('account' => $this->account));
    }
    
}
