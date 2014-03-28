<?php

/*
 * @author : owliber
 * @date : 2014-03-28
 */

class CashierController extends Controller
{
    public $layout = "cashier";
    
    public function actionIndex()
    {
        $this->render('index');
    }
}
?>
