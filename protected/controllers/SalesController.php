<?php
/*------------------------
 * Author: J.O. Pormento
 * Date Created: 04-22-2014
------------------------*/

class SalesController extends Controller
{
    public function actionIndex()
    {
        $model = new SalesModel();
        
        if (isset($_POST["account_id"]))
        {   
//            $model->date_from = $_POST["SalesModel"]["date_from"];
//            $model->date_to = $_POST["SalesModel"]["date_to"];
            $account_id = $_POST["account_id"];
            
            $rawData = $model->getDailyReport($account_id);
            $total = $model->getTotal($account_id);
            $dataProvider = new CArrayDataProvider($rawData, array(
                                                    'keyField' => false,
                                                    'pagination' => array(
                                                    'pageSize' => 10000,
                                                ),
                                    ));
                                    
            $this->render('index', array('dataProvider' => $dataProvider, 'model' => $model, 'total' => $total[0]['total']));
        }
        else
        {
            //$model->date_from = date('Y-m-d');
            //$model->date_to = date('Y-m-d');
        
            $this->render('index', array('model' => $model));
        }
    }
    
    public function list_cashier_acounts()
    {
        $model = new SalesModel();
        
        return CHtml::listData($model->getCashierName(), 'account_id', 'cashier_name');
    }
}
?>

