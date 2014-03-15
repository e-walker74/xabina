<?php

class AccountsController extends Controller
{

	public function actionIndex(){
		$accounts = new Accounts('adminSearch');
		$accounts->unsetAttributes();  // clear any default values
		if(isset($_GET['Accounts'])){
			$accounts->attributes=$_GET['Accounts'];
		}
		
		$this->render('index', array('accounts' => $accounts));
	}
}
