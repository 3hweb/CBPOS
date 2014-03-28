<?php

/*
 * @author : owliber
 * @date : 2014-03-27
 */

class Accounts extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function tableName()
    {
            return 'accounts';
    }
    
    public function validatePassword($passcode)
    {
            return $this->hashPassword($passcode)===$this->passcode;
    }

    /**
     * Generates the password hash.
     * @param string password
     * @param string salt
     * @return string hash
     */
       
    public function hashPassword($passcode)
    {
        return sha1($passcode);
    }

    public function get_account_status()
    {
        $conn = $this->_connection;

        $query = "SELECT status FROM accounts
                    WHERE passcode = :passcode";

        $passcode = $this->hashPassword($this->passcode);
        $command = $conn->createCommand($query);
        $command->bindParam(':passcode', $passcode);
        $result = $command->queryRow();
        return $result['status'];

    }
    
    public function validate_passcode()
    {
        $conn = $this->_connection;

        $query = "SELECT * FROM accounts
                    WHERE passcode = :passcode";

        $passcode = $this->hashPassword($this->passcode);
        $command = $conn->createCommand($query);
        $command->bindParam(':passcode', $passcode);
        $result = $command->queryRow();
        if(count($result)>0)
            return true;
        else
            return false;

    }
    
    public function getAccountName($id)
    {
        $query = "SELECT CONCAT(last_name, ' ', first_name) as account_name 
                    FROM account_details
                    WHERE account_id = :account_id";
        $command = Yii::app()->db->createCommand($query);
        $command->bindParam(':account_id', $id);
        $result = $command->queryRow();
        return $result['account_name'];
    }
}
?>
