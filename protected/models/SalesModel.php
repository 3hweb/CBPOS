<?php
/*------------------------
 * Author: J.O. Pormento
 * Date Created: 04-22-2014
------------------------*/

class SalesModel extends CFormModel
{
    public $_connection;
    public $report_type;
    
    public function __construct() 
    {
        $this->_connection = Yii::app()->db;
    }
    
    public function rules()
    {
        return array(
            array('report_type', 'required'),
        );
    }
    
    public function attributeLabels()
    {
        return array(
            'report_type'=>'Report Type',
        );
    }
}
?>
