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
        
        $this->render('index', array('model' => $model));
    }
}
?>

