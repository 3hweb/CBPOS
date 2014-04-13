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
        $orderDetailsModel = new OrderDetailsModel();
        $orderSummaryModel = new OrderSummaryModel();
        $referenceInfoController = new ReferenceInfoController(); //required class
        
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
        $itemAmount = $_POST['txtPrice'];
        
        $orderSummaryId = $commonTransactionModel->recordTransaction($invoiceNo, $terminalId, 
                $menuItemId, $totalQuantity, $totalAmount, $taxAmount, $netAmount, 
                $discountId, $paymentTypeId, $isReprinted, $dineType, $createdByAid, 
                $status, $itemQuantity, $itemAmount);
         
        /*
        if((int)$orderSummaryId > 0){
            
        } else {
            
        }*/
        
        $orderDetailsResult = array();
        $orderSummary = $orderSummaryModel->getInvoiceNo($orderSummaryId);
        $invoiceNo = $orderSummary['invoice_no'];
        
        $orderDetails = $orderDetailsModel->getTransactionDetails($orderSummaryId);
        $subTotalAmount = 0;
        $totalAmount = 0;
        $vatAmount = 0;
        foreach ($orderDetails as $val){
            $subTotalAmount = $subTotalAmount + (float)$val['amount']; //get the sub total amount
            
            array_push($orderDetailsResult, array("MenuItemName"=>$val['menu_item_name'],
                "MenuItemPrice"=>$val['menu_item_price'], "Quantity"=>$val['quantity'],
                "Amount"=>  number_format($val['amount'], 2,'.',','),
                "InvoiceNo"=>$invoiceNo,"SubTotalAmount"=>  number_format($subTotalAmount, 2,'.',','),
                "TotalAmount"=>$totalAmount,"VatAmount"=>$vatAmount));
        }
                           
        //$subTotalAmount = $orderDetailsResult[1]['SubTotalAmount'];

        $vatAmount = $subTotalAmount * ReferenceInfoController::$TAX_WITHHELD;

        $totalAmount = $subTotalAmount + $vatAmount; //amount inclusive with 

        $i = 0;
        while($i < count($orderDetailsResult)){
            
            $orderDetailsResult[$i]['VatAmount'] = number_format($vatAmount, 2, '.', ',');
            $orderDetailsResult[$i]['TotalAmount'] = number_format($totalAmount, 2, '.',',');
            
            $i++;
        }
        
        // output some JSON instead of the usual text/html
        header('Content-Type: application/json; charset="UTF-8"');
        echo CJSON::encode($orderDetailsResult);
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
    
    public function actionSaveRecord(){
        $orderSummaryModel = new OrderSummaryModel();
        
        $invoiceNo = $_POST['txtReceiptNo'];
        $taxAmount = $_POST['txtVatAmt'];
        $totalAmount = $_POST['txtTotalAmt'];
        $netAmount = $_POST['txtSubTotal'];
        
        $orderSummaryResult = $orderSummaryModel->getSummaryIdByInvoiceNo($invoiceNo);
        $orderSummaryId = $orderSummaryResult['order_summary_id'];
        
        $status = 1; //SAVE
        
        $isSaveSuccess = $orderSummaryModel->updateTransactionSRecord($status, 
                $orderSummaryId, $totalAmount, $taxAmount, $netAmount);
        
        if($isSaveSuccess){
            $msg = "Transaction Successful";
        } else {
            $msg = "Transaction Failed";
        }
        
        header('Content-Type: application/json; charset="UTF-8"');
        echo CJSON::encode(array('message'=>$msg));
    }
}
?>
