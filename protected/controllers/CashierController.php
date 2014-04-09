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
        $menuGroupModel = new MenuGroupModel();
        $menuItemsModel = new MenuItemsModel();
        $referenceInfoController = new ReferenceInfoController();
        
        //Display Active Menu Group
        $menuGroupResult = $menuGroupModel->getActiveMenuGrps();
        
        //Initialize Pagination
        $perPage = 6;
        $ctrMenuList = $menuItemsModel->countMenuItems();
        $pages = ceil((int)$ctrMenuList['ctrmenu']/$perPage);
        
        $referenceInfoController->getReceiptInfo();
        
        $this->render('index',array('pages'=>$pages,
                                    'menuGroupResult'=>$menuGroupResult));
    }
    
    public function actionAddOrderToList() {
        $commonTransactionModel = new CommonTransactionsModel();
        
        $invoiceNo = 1;
        $terminalId = 1;
        $totalQuantity = 0;
        $totalAmount = 0;
        $taxAmount = 0;
        $netAmount = 0;
        $discountId = 0;
        $paymentTypeId = 0;
        $isReprinted = 0;
        $dineType = 0;
        $createdByAid = 1; //session variable of cashier
        $status = 0;
        $menuItemId = $_POST['txtMenuId'];
        $itemQuantity = $_POST['txtQuantity'];
        
        $orderSummaryId = $commonTransactionModel->recordTransaction($invoiceNo, $terminalId, 
                $menuItemId, $totalQuantity, $totalAmount, $taxAmount, $netAmount, 
                $discountId, $paymentTypeId, $isReprinted, $dineType, $createdByAid, 
                $status, $itemQuantity, $itemAmount);
         
        // output some JSON instead of the usual text/html
        header('Content-Type: application/json; charset="UTF-8"');
        echo CJSON::encode(array('Quantity' => $itemQuantity));
    }
    
    public function actionAjaxSetMenuDialog(){
        
        header('Content-Type: application/json; charset="UTF-8"');
        echo CJSON::encode(array('output' => 'good to go'));
    }
    
    public function actionItemMenuResults(){
        $menuItemsModel = new MenuItemsModel();
	
        $limit = 6;
        $page = $_GET['page'];

        $start = ($page-1)*$limit;
        $rsd = $menuItemsModel->getMenuItem(0, $start, $limit);
        
        $this->render('itemMenuResults',array('rsd'=>$rsd));
    }
    
    public function actionGetPaymentTypes(){
        $refPaymentsModel = new RefPaymentsModel();
        
        $paymentResult = $refPaymentsModel->getActivePayments();
        $showActivePayments = array();
        foreach ($paymentResult as $val){
            array_push($showActivePayments, array("PaymentTypeId"=>$val['payment_type_id'], 
                "PaymentTypeName"=>$val['payment_type_name']));
        }
        header('Content-Type: application/json; charset="UTF-8"');
        echo CJSON::encode($showActivePayments);
    }
}
?>
