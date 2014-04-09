<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MenuGroupModel
 *
 * @author elperez
 */
class MenuGroupModel extends CFormModel{
    private $_connection;
    
    public function getActiveMenuGrps(){
        $connection = Yii::app()->db;
        $sql = "SELECT * FROM menu_group WHERE Status = 1";
        $query = $connection->createCommand($sql);
        return $query->queryAll();
    }
}

?>
