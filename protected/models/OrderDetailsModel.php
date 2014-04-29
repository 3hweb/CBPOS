<?php
/**
 * Model class for order details model
 *
 * @author elperez
 */
class OrderDetailsModel extends CFormModel{
    public $_connectionString;
    
    public function __construct() {
        $this->_connectionString = Yii::app()->db;
    }
    
    public function getTransactionDetails($orderSummaryId){
        $sql = "SELECT mi.menu_item_name, mi.menu_item_price, SUM(od.quantity) AS quantity, 
                SUM(od.amount) AS amount
                FROM order_details od 
                INNER JOIN menu_items mi ON od.menu_item_id = mi.menu_item_id
                WHERE od.order_summary_id = :order_summary_id
                GROUP BY mi.menu_item_id";
        $command = $this->_connectionString->createCommand($sql);
        $command->bindParam(":order_summary_id", $orderSummaryId);
        return $command->queryAll();
    }
}

?>
