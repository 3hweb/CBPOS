<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RefPaymentsModel
 *
 * @author elperez
 */
class RefPaymentsModel extends CFormModel{
    public $_connectionString;
    
    public function __construct() {
        $this->_connectionString = Yii::app()->db;
    }
    
    public function getActivePayments(){
        $sql = "SELECT * FROM ref_payment_types WHERE Status = 1";
        $command = $this->_connectionString->createCommand($sql);
        return $command->queryAll();
    }
}

?>
