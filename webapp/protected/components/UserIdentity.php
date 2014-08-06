<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$record=User::model()->findByAttributes(array('login'=>$this->username));
		if($record==null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif($record->password!=$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else{
			$this->errorCode=self::ERROR_NONE;
			$this->_id=$record->_id;
			
		}
		return $this->errorCode;
	}
	public function getId()
	{
		return $this->_id;
	}
}