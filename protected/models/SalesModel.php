<?php
/*------------------------
 * Author: J.O. Pormento
 * Date Created: 04-22-2014
------------------------*/

class SalesModel extends CFormModel
{
    public $_connection;
    //public $report_type;
    //public $date_from;
    //public $date_to;
    public $account_id;
    
    public function __construct() 
    {
        $this->_connection = Yii::app()->db;
    }
    
    public function rules()
    {
        return array(
            array('report_type', 'required'),
            array('date_from','required'),
            array('date_to','required'),
        );
    }
    
    public function attributeLabels()
    {
        return array(
            'report_type' => 'Report Type',
            'date_from' => 'From',
            'date_to'=>'To',
            'account_id'=>'To'
        );
    }
    
    public function getDailyReport($account_id)
    {
        $conn = $this->_connection;
        
        $query = "SELECT
                        o.order_summary_id,
                        mi.menu_item_name,
                        od.quantity,
                        od.amount,
                        od.quantity * od.amount AS subtotal
                    FROM order_summary o
                    INNER JOIN order_details od
                      ON o.order_summary_id = od.order_summary_id
                    LEFT OUTER JOIN menu_items mi
                      ON od.menu_item_id = mi.menu_item_id
                    WHERE o.date_created > CURDATE()
                    AND o.created_by_aid = :account_id
                    AND o.status = 1;";
        
        $command =  $conn->createCommand($query);
        $command->bindParam(':account_id', $account_id);
        $result = $command->queryAll();
        
        return $result;
    }
    
    public function getTotal($account_id)
    {
        $conn = $this->_connection;
        
        $query = "SELECT
                        SUM(od.quantity * od.amount) AS total
                    FROM order_summary o
                    INNER JOIN order_details od
                      ON o.order_summary_id = od.order_summary_id
                    LEFT OUTER JOIN menu_items mi
                      ON od.menu_item_id = mi.menu_item_id
                    WHERE o.date_created > CURDATE()
                    AND o.created_by_aid = :account_id
                    AND o.status = 1;";
        
        $command =  $conn->createCommand($query);
        $command->bindParam(':account_id', $account_id);
        $result = $command->queryAll();
        
        return $result;
    }
    
    public function getCashierName()
    {
        $conn = $this->_connection;
        
        $query = "SELECT
                        a.account_id,
                        CONCAT(ad.last_name, ', ', ad.first_name) AS cashier_name
                    FROM accounts a
                    INNER JOIN account_details ad
                      ON a.account_id = ad.account_id
                    WHERE a.account_id = 2;";
        
        $command =  $conn->createCommand($query);
        $result = $command->queryAll();
        
        return $result;
    }
}
?>
