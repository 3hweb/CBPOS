<?php
/*------------------------
 * Author: J.O. Pormento
 * Date Created: 04-22-2014
------------------------*/

class SalesModel extends CFormModel
{
    public $_connection;
    public $report_type;
    public $date_from;
    public $date_to;
    
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
            'date_to'=>'To'
        );
    }
    
    public function getDailyReport()
    {
        $conn = $this->_connection;
        
        $query = "SELECT
                        o.order_detail_id,
                        mi.menu_item_name,
                        SUM(o.quantity) AS quantity ,
                        SUM(o.amount) AS amount
                    FROM order_details o
                    INNER JOIN menu_items mi
                        ON o.menu_item_id = mi.menu_item_id
                    WHERE date_created BETWEEN :datefrom AND :dateto
                    GROUP BY o.menu_item_id;";
        
        $command =  $conn->createCommand($query);
        $command->bindParam(':datefrom', $this->date_from);
        $command->bindParam(':dateto', $this->date_to);
        $result = $command->queryAll();
        
        return $result;
    }
}
?>
