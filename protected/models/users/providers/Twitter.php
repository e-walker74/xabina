<?php

/**
 * This is the model class for table "user_providers".
 *
 * The followings are the available columns in table 'user_providers':
 * @property integer $id
 * @property integer $user_id
 * @property integer $provider_id
 * @property integer $soc_id
 */
class Users_Providers_Twitter extends Users_Providers
{
	public function tableName()
	{
		return 'users_providers_twitter';
	}
}