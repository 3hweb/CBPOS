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
}

?>
