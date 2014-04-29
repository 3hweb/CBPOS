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
    
    public $group_id;
    public $group_name;
    
    public function __construct() 
    {
        $this->_connection = Yii::app()->db;
    }
    
    public function rules()
    {
        return array(
            array('group_name', 'required'),
            array('group_id', 'safe')
        );
    }
    
    public static function getActiveMenuGrps(){
        $connection = Yii::app()->db;
        $sql = "SELECT * FROM menu_group WHERE Status = 1";
        $query = $connection->createCommand($sql);
        return $query->queryAll();
    }
    
    
    public function getAllGroupMenus()
    {
        $query = "SELECT menu_group_id, menu_group_name, 
                    CASE status WHEN 0 THEN 'Inactive' WHEN 1 THEN 'Active'
                    END `status`
                  FROM menu_group";
        $command = $this->_connection->createCommand($query);
        $result = $command->queryAll();
        
        return $result;
    }
    
    
    public function getGroupMenuByID($id)
    {
        $connection = $this->_connection;
        $sql = "SELECT * FROM menu_group WHERE menu_group_id = :menu_group_id AND Status = 1";
        $command = $connection->createCommand($sql);
        $command->bindParam(':menu_group_id', $id);
        
        return $command->queryRow();
    }
    
    
    public function insertMenuGroup()
    {
        $conn = $this->_connection;
        
        $trx = $conn->beginTransaction();
        
        try
        {
            $query = "INSERT INTO menu_group (menu_group_name) VALUES (:menu_group_name)";
            $command = $conn->createCommand($query);
            $command->bindParam(':menu_group_name', $this->group_name);
            $result = $command->execute();
            
            if ($result > 0)
            {
                $trx->commit();
                return true;
            }
            else
            {
                $trx->rollback();
                return false;
            }
        }
        catch (PDOException $e)
        {
            $trx->rollback();
            return false;
        }
    }
    
    public function updateMenuGroup()
    {
        $conn = $this->_connection;
        
        $trx = $conn->beginTransaction();
        
        try
        {
            $query = "UPDATE menu_group SET menu_group_name = :menu_group_name
                    WHERE menu_group_id = :menu_group_id";
            $command = $conn->createCommand($query);
            $command->bindParam(':menu_group_id', $this->group_id);
            $command->bindParam(':menu_group_name', $this->group_name);
            $result = $command->execute();
            
            if ($result > 0)
            {
                $trx->commit();
                return true;
            }
            else
            {
                $trx->rollback();
                return false;
            }
        }
        catch (PDOException $e)
        {
            $trx->rollback();
            return false;
        }
    }
}

?>
