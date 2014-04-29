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
        
        if (isset($_POST["SalesModel"]))
        {   
            $model->date_from = $_POST["SalesModel"]["date_from"];
            $model->date_to = $_POST["SalesModel"]["date_to"];
            
            $rawData = $model->getDailyReport();

            $dataProvider = new CArrayDataProvider($rawData, array(
                                                    'keyField' => false,
                                                    'pagination' => array(
                                                    'pageSize' => 10,
                                                ),
                                    ));

            $this->render('index', array('dataProvider' => $dataProvider, 'model' => $model));
        }
        else
        {
            $model->date_from = date('Y-m-d');
            $model->date_to = date('Y-m-d');
        
            $this->render('index', array('model' => $model));
        }
    }
}
?>

