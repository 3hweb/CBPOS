<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MenuItemsModel
 *
 * @author elperez
 */
class MenuItemsModel extends CFormModel{
    
    private $_connection;
    
    public $item_id;
    public $group_id;
    public $item_name;
    public $item_price;
    public $item_image_path;
    
    public function __construct() 
    {
        $this->_connection = Yii::app()->db;
    }
    
    public function rules()
    {
        return array(
            array('group_id, item_name, item_price', 'required'),
            array('item_image_path', 'file', 'allowEmpty'=>false, 'types'=>'jpg,jpeg,gif,png'),
            array('item_id, item_image_path', 'safe')
        );
    }
    
    public function attributeLabels()
    {
        return array(
            'group_id'=>'Group Menu',
            'item_image_path'=>'Item Image'
        );
    }
    
    public function getMenuItem($menuGrpID, $start, $limit){
        $link = mysql_connect('localhost', 'root', 'admin');
        mysql_select_db('records',$link);
        
        if(is_numeric($menuGrpID) && $menuGrpID > 0){
            $sql = "SELECT * FROM cbpos.menu_items WHERE menu_group_id = :menu_group
                    AND Status = 1";
        } else {
            $sql = "SELECT * FROM cbpos.menu_items WHERE Status = 1 ORDER BY menu_item_id
                    LIMIT $start, $limit";
        }

        $rsd = mysql_query($sql);
        return $rsd;
    }
    
    public function countMenuItems(){
        $command = Yii::app()->db;
        $sql = "SELECT COUNT(menu_item_id) as ctrmenu FROM cbpos.menu_items WHERE Status = 1";
        $query = $command->createCommand($sql);
        return $query->queryRow();
    }
    
    public function getAllItemMenus()
    {
        $query = "SELECT
                    a.menu_item_id,
                    b.menu_group_name,
                    a.menu_item_name,
                    a.menu_item_price,
                    a.menu_item_image_path,
                    CASE a.status WHEN 0 THEN 'Inactive' WHEN 1 THEN 'Active' WHEN 2 THEN 'Deactivated'
                    END `status`
                  FROM menu_items a
                    INNER JOIN menu_group b
                      ON a.menu_group_id = b.menu_group_id";
        $command = $this->_connection->createCommand($query);
        $result = $command->queryAll();
        
        return $result;
    }
    
    public function getItemMenuByID($id)
    {
        $connection = $this->_connection;
        $sql = "SELECT * FROM menu_items WHERE menu_item_id = :menu_item_id AND Status = 1";
        $command = $connection->createCommand($sql);
        $command->bindParam(':menu_item_id', $id);
        
        return $command->queryRow();
    }
    
    public function insertMenuItem($group_id, $item_name, $item_price, $image_path)
    {
        $conn = $this->_connection;
        
        $trx = $conn->beginTransaction();
        
        try
        {
            $query = "INSERT INTO menu_items (menu_group_id, menu_item_name, menu_item_price, menu_item_image_path, status) 
                VALUES (:menu_group_id, :menu_item_name, :menu_item_price, :menu_item_image_path, 1)";
            $command = $conn->createCommand($query);
            $command->bindParam(':menu_group_id', $group_id);
            $command->bindParam(':menu_item_name', $item_name);
            $command->bindParam(':menu_item_price', $item_price);
            $command->bindParam(':menu_item_image_path', $image_path);
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
