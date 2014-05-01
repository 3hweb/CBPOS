<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RefDiscountsModel
 *
 * @author elperez
 */
class RefDiscountsModel extends CFormModel{
    private $_connection;
    
    public function __construct() {
        $this->_connection = Yii::app()->db;
    }
    public function getActiveDiscounts(){
        $sql = "SELECT discount_id, discount_name, discount_value, status 
                FROM ref_discounts WHERE status = 1";
        $command = $this->_connection->createCommand($sql);
        return $command->queryAll();
    }
}

?>
