<?php
class LeftMenu extends CWidget
{
    public function run()
    {
		$activations = Users_Activation::model()->count('moderator_id = 0 AND step = 3');
		$this->render('LeftMenu', array('activations' => $activations));
	}
}