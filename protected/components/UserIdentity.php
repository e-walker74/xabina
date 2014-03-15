<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
        const USER_IS_NOT_ACTIVE = 3;
		protected $id;
        protected $firstTime = false;

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
            $user = Users::model()->find('LOWER(email)=?', array(strtolower($this->username)));
			if(!$user){
				$user = Users::model()->find('LOWER(login)=?', array(strtolower($this->username)));
			}
            if($user===null)
            {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            }
            elseif(trim($this->password)!==$user->password) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            } elseif($user->status == Users::USER_IS_NOT_ACTIVE){
				$this->errorCode = self::USER_IS_NOT_ACTIVE;
			}else {
                $this->id = $user->id;

                $this->username = $user->fullName;
                $this->errorCode = self::ERROR_NONE;
            }
			

            return !$this->errorCode;
	}

        public function getId(){
            return $this->id;
        }

        public function setFirstTime(){
            $this->firstTime = true;
        }
}