<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		$users = Users::model()->findAll(array('limit' => 6, 'order' => 'created_at desc'));
		$this->render('index', array('statistics' => '', 'users' => $users));
	}
}