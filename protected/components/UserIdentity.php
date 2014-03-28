<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
        const ERROR_ACCOUNT_INVALID = 5;
        const ERROR_PASSCODE_INVALID = 6;
        
	private $_id;

	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
                $account = Accounts::model()->findByAttributes(array('account_code'=>  substr($this->password, 0,3)));
                
		if($account===null)
			$this->errorCode=self::ERROR_ACCOUNT_INVALID;
		else if(!$account->validatePassword($this->password))
			$this->errorCode=self::ERROR_PASSCODE_INVALID;
		else
		{
			$this->_id=$account->account_id;
			$this->username=$account->account_code;
			$this->errorCode=self::ERROR_NONE;
		}
		return $this->errorCode==self::ERROR_NONE;
	}

	/**
	 * @return integer the ID of the user record
	 */
	public function getId()
	{
		return $this->_id;
	}
}