<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RefVariablesModel
 *
 * @author elperez
 */
class RefVariablesModel {
    public $_connection;
    
    public function __construct() {
        $this->_connection = Yii::app()->db;
        
        $this->getUpdatedVariables();
    }

    public function getUpdatedVariables(){
        $sql = "SELECT * FROM ref_variables";
        $command = $this->_connection->createCommand($sql);
        return $command->queryAll();
    }
    
    /**
     * @todo Do a array searching then return the corresponding array value
     */
    public static function searchVariableName(){
        $result = $this->getUpdatedVariables();
        
    }
}

?>
