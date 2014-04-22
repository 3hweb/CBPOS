<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
        public $passcode;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('passcode', 'required','message'=>'Passcode is required.'),
			// password needs to be authenticated
			array('passcode', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'passcode'=>'Passcode',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		$this->_identity=new UserIdentity(substr($this->passcode,0,3),$this->passcode);
		if(!$this->_identity->authenticate())
			$this->addError('password','Incorrect passcode.');
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity(substr($this->passcode,0,3),$this->passcode);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration= 3600*8; // 8 hours
			Yii::app()->user->login($this->_identity,$duration);
                        
                        $account = Accounts::model()->findByAttributes(array('account_code'=>  substr($this->passcode, 0,3)));
                        
                        Yii::app()->session['account_type_id'] = $account->account_type_id;
                        Yii::app()->session['account_id'] = $account->account_id;
                        
			return true;
		}
		else
			return false;
	}
}
