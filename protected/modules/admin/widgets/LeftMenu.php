<?php
class LeftMenu extends CWidget
{
    public function run()
    {
		$activations = Users_Activation::model()->count('moderator_id = 0 AND step = 3');
		$verifications = Users_Verification::model()->count('moderator_id = 0 AND status = ' . Users_Verification::REQUIRES_MODERATION);
		$this->render('LeftMenu', array('activations' => $activations, 'verifications' => $verifications));
	}
}