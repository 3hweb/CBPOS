<?php

/*
 * @author : owliber
 * @date : 2014-04-21
 */

class UserModel extends CFormModel
{
    public $_connection;
    public $account_id;
    public $account_code;
    public $passcode;
    public $passcode_repeat;
    public $first_name;
    public $last_name;
    public $mobile_no;
    public $email;
    public $address;
    public $account_type;
    public $status;
    
    public function __construct() {
        $this->_connection = Yii::app()->db;
    }
    
    public function rules()
    {
        return array(
            array('first_name, last_name, mobile_no, email, address, account_type, account_code', 'required'),
            array('email','email'),
            array('passcode, passcode_repeat','required'),
            array('passcode, passcode_repeat,mobile_no','numerical'),
            array('passcode, passcode_repeat', 'length', 'min'=>5, 'max'=>40),
            array('passcode_repeat', 'compare', 'compareAttribute'=>'passcode'),
        );
    }
    
    public function attributeLabels() {
        return array(
            'account_type'=>'Account Type',
            'account_code'=>'Account Code',
            'passcode'=>'Pass Code',
            'passcode_repeat'=>'Confirm Code',
            'first_name'=>'First Name',
            'last_name'=>'Last Name',
            'mobile_no'=>'Mobile No',
            'email'=>'Email',
            'address'=>'Address',
        );
    }
    
    public function getAllUsers()
    {
        
        $query = "SELECT
                    a.account_id,
                    a.account_code,
                    ad.first_name,
                    ad.last_name,
                    ad.mobile_no,
                    ad.email,
                    CASE a.account_type_id WHEN 1 THEN 'Admin' WHEN 2 THEN 'Cashier'
                    END `account_type`,
                    CASE a.status WHEN 0 THEN 'Inactive' WHEN 1 THEN 'Active' WHEN 2 THEN 'Deactivated'
                    END `status`
                  FROM accounts a
                    INNER JOIN account_details ad
                      ON a.account_id = ad.account_id";
        $command = $this->_connection->createCommand($query);
        $result = $command->queryAll();
        return $result;
    }
    
    public function getUserInfo()
    {
        
        $query = "SELECT
                    a.account_id,
                    a.account_code,
                    ad.first_name,
                    ad.last_name,
                    ad.mobile_no,
                    ad.email,
                    CASE a.account_type_id WHEN 1 THEN 'Admin' WHEN 2 THEN 'Cashier'
                    END `account_type`,
                    CASE a.status WHEN 0 THEN 'Inactive' WHEN 1 THEN 'Active' WHEN 2 THEN 'Deactivated'
                    END `status`
                  FROM accounts a
                    INNER JOIN account_details ad
                      ON a.account_id = ad.account_id
                  WHERE a.account_id = :account_id";
        $command = $this->_connection->createCommand($query);
        $command->bindParam(':account_id', $this->account_id);
        $result = $command->queryRow();
        return $result;
    }
    
    public function getMaxAccountCode()
    {
        $query = "SELECT (max(account_code) + 1) as account_code
                  FROM accounts";
        $command = $this->_connection->createCommand($query);
        $result = $command->queryRow();
        return $result['account_code'];
    }
    
    public function save()
    {
        $conn = $this->_connection;
        $trx = $conn->beginTransaction();
        
        $query = "INSERT INTO accounts (account_type_id, account_code, passcode)
                    VALUES (:account_type_id, :acccount_code, :passcode)";
        
        $passcode = UserController::hashPassword($this->account_code, $this->passcode_repeat);
        $command = $conn->createCommand($query);
        $command->bindParam(':account_type_id', $this->account_type);
        $command->bindParam(':acccount_code', $this->account_code);
        $command->bindParam(':passcode', $passcode);
        $command->execute();
        $account_id = $conn->lastInsertID;
        
        try
        {
            if(!$this->hasErrors())
            {
                $query2 = "INSERT INTO account_details (account_id, first_name, last_name, mobile_no, email, address)
                            VALUES (:account_id, :first_name, :last_name, :mobile_no, :email, :address)";
                $command1 = $conn->createCommand($query2);
                $command1->bindParam(':account_id', $account_id);
                $command1->bindParam(':first_name', $this->first_name);
                $command1->bindParam(':last_name', $this->last_name);
                $command1->bindParam(':mobile_no', $this->mobile_no);
                $command1->bindParam(':email', $this->email);
                $command1->bindParam(':address', $this->address);
                $command1->execute();
                
                if(!$this->hasErrors())
                    $trx->commit ();
                else
                    $trx->rollback ();
            }
        }
        catch(PDOException $e)
        {
            $trx->rollback();
        }
    }
    
}
?>

