<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	const ERROR_ACCOUNT_EXPIRED = 200;
	
	private $_id;
	
    public function authenticate()
    {
        $oUser = Users::model()->find('username = :usr AND status = "enabled"', array(':usr'=>$this->username));
        
        if($oUser===null){
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        } else if($oUser->password!==md5($this->password)){
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        } else if($oUser->expire && (strtotime($oUser->expire) < time())){
        	$this->errorCode=self::ERROR_ACCOUNT_EXPIRED;
        } else {
            $this->_id=$oUser->id;
            $this->setState('credentials', $oUser->attributes);
            $this->errorCode=self::ERROR_NONE;
        }
        return !$this->errorCode;
    }
 
    public function getId()
    {
        return $this->_id;
    }
}