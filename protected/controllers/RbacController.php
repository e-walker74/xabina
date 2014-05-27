<?php

class RbacController extends Controller
{

    public $layout = 'banking';
    public $title  = '';

    public function actionSwitchAccount() {
        $uid = (int)$_POST['account'];
        
    }
}