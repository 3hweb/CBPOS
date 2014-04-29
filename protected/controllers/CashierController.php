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
        
        if(isset($_POST['txtReceiptNo']) && $_POST['txtReceiptNo'] != ""){
            $invoiceNo = $_POST['txtReceiptNo'];
        } else {
            $invoiceNo = mt_rand().$menuItemId;
        }
        $discountId = 1;
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
        $taxAmount = Utilities::removeComma($_POST['txtVatAmt']);
        $totalAmount = Utilities::removeComma($_POST['txtTotalAmt']);
        $netAmount = Utilities::removeComma($_POST['txtSubTotal']);
        $transTypeName = $_POST['dineType'];
        $paymentTypeName = $_POST['paymentType'];
        
        $orderSummaryResult = $orderSummaryModel->getSummaryIdByInvoiceNo($invoiceNo);
        $orderSummaryId = $orderSummaryResult['order_summary_id'];
        
        $status = 1; //SAVE
        
        $dineTypeId = ReferenceInfoController::getTransactionTypeId($transTypeName);
        
        $paymentTypeId = ReferenceInfoController::getPaymentTypeId($paymentTypeName);
        
        $isSaveSuccess = $orderSummaryModel->updateTransactionSRecord($status, 
                $orderSummaryId, $totalAmount, $taxAmount, $netAmount, $dineTypeId, 
                $paymentTypeId);
        
        if($isSaveSuccess){
            $msg = "Transaction Successful";
        } else {
            $msg = "Transaction Failed";
        }
        
        header('Content-Type: application/json; charset="UTF-8"');
        echo CJSON::encode(array('message'=>$msg));
    }
    
    public function actionModifyTransaction(){
        $orderSummaryModel = new OrderSummaryModel();
        
        if(isset($_POST['txtReceiptNo']) && $_POST['txtReceiptNo'] != ""){
            $invoiceNo = $_POST['txtReceiptNo'];
            $isCancelTransaction = $_POST['isTransactionCancel'];
            
            if($isCancelTransaction == 1)
                $status = 3; //cancel transaction
            else
                $status = 2; //hold transaction

            $orderSummaryId = $orderSummaryModel->getSummaryIdByInvoiceNo($invoiceNo);

            $isSuccess = $orderSummaryModel->updateTransactionStatus((int)$status,(int)$orderSummaryId['order_summary_id']);

            if($isSuccess){
                $msg = "Transaction Successful";
            } else {
                $msg = "Transaction Failed";
            }
        } else {
            $msg = "No active transaction";
        }
        
        header('Content-Type: application/json; charset="UTF-8"');
        echo CJSON::encode(array('message'=>$msg));
    }
    
    public function actionGetPendingInvoice(){
        $orderSummaryModel = new OrderSummaryModel();
        $invoiceResult = $orderSummaryModel->getPendingInvoice();
        $pendingInvoice = array();
        foreach ($invoiceResult as $val){
            array_push($pendingInvoice, array("InvoiceNo"=>$val['invoice_no']));
        }
        
        header('Content-Type: application/json; charset="UTF-8"');
        echo CJSON::encode($pendingInvoice);
    }
    
    public function actionGetPendingTransaction(){
        $orderSummaryModel = new OrderSummaryModel();
        
        if(isset($_POST['txtReceiptNo']) && $_POST['txtReceiptNo'] != ""){
            $invoiceNo = $_POST['txtReceiptNo'];
            
            $orderSummaryId = $orderSummaryModel->getSummaryIdByInvoiceNo($invoiceNo);
            
            $pendingTransResult = $orderSummaryModel->getPendingTransactions($orderSummaryId['order_summary_id']);
            
            $subTotalAmount = 0;
            $totalAmount = 0;
            $vatAmount = 0;
            $orderDetailsResult = array();
            foreach ($pendingTransResult as $val) {
                $subTotalAmount = $subTotalAmount + (float) $val['amount']; //get the sub total amount

                array_push($orderDetailsResult, array("MenuItemName" => $val['menu_item_name'],
                    "MenuItemPrice" => $val['menu_item_price'], "Quantity" => $val['quantity'],
                    "Amount" => number_format($val['amount'], 2, '.', ','),
                    "InvoiceNo" => $invoiceNo, "SubTotalAmount" => number_format($subTotalAmount, 2, '.', ','),
                    "TotalAmount" => $totalAmount, "VatAmount" => $vatAmount));
            }
            
            $vatAmount = $subTotalAmount * ReferenceInfoController::$TAX_WITHHELD;

            $totalAmount = $subTotalAmount + $vatAmount; //amount inclusive with 

            $i = 0;
            while ($i < count($orderDetailsResult)) {

                $orderDetailsResult[$i]['VatAmount'] = number_format($vatAmount, 2, '.', ',');
                $orderDetailsResult[$i]['TotalAmount'] = number_format($totalAmount, 2, '.', ',');

                $i++;
            }
        }
        
        header('Content-Type: application/json; charset="UTF-8"');
        echo CJSON::encode($orderDetailsResult);
    }
    
    public function actionPrintReceipt(){
        $referenceInfoController = new ReferenceInfoController(); //required class
        
        $isReprint = $_POST['isReprint'];
        $invoiceNo = $_POST['invoiceNo'];
        
        $htmlHeader = "<html><head></head><body>";
        
        $htmlBodyHeader = '<div class="content" style="width: 50%;margin: 0 auto;font-size:xx-small;">
                        <p align="center">'.str_replace('-', '&dash;', ReferenceInfoController::$NAME).'</p>
                        <p align="center">'.str_replace('-', '&dash;', ReferenceInfoController::$ADDRESS).'</p>
                        <p align="left">TIN: '.str_replace('-', '&dash;', ReferenceInfoController::$TIN).'</p>
                        <p align="left">DATE: ' . date('d F Y h:i A') .'</p>
                        <p align="left"> Terminal :  Terminal 1</p>
                        <p align="left">Cashier :  Juan Dela Cruz</p>
                        </div>';
       
        /** Transaction Details - Item List **/
        $htmlBodyContentHeader = '<table style=\"text-align: right;font-size: small;font-size:xx-small;\"><thead><tr>'.
            '<td style=\"width: 20%\">Item</td><td>QTY</td><td>Price</td><td>Amount</td>'.
            '</tr></thead>';
        
        $transDetailsResult = $this->searchTransaction($invoiceNo);
        
        $htmlBodyContentInfo = '<tbody>';
        $subTotalAmount = 0;
        foreach($transDetailsResult as $val){
            $subTotalAmount = $val['SubTotalAmount']; //get the sub total amount
            $vatAmount = $val['VatAmount'];
            $totalAmount = $val['TotalAmount'];
            $htmlBodyContentInfo .= '<tr>'.
                                        '<td style=\"width: 20px;\">'.$val['MenuItemName'].'</td>'.
                                        '<td>'.$val['Quantity'].'</td>'.
                                        '<td>'.$val['MenuItemPrice'].'</td>'.
                                        '<td>'.$val['Amount'].'</td>'.
                                    '</tr>';
        }
        
        $htmlBodyContentFooter = "</tbody></table>";
        
        $htmlBodyContent = $htmlBodyContentHeader.$htmlBodyContentInfo.$htmlBodyContentFooter;
        
        /***************** Transaction Details - Total Part*******************/
        
        $htmlBodyContentHeader2 = '<table style=\"text-align: right;font-size:xx-small;\"><thead>'.
            '<tr><td>Total (VAT Inclusive)</td><td>'.$totalAmount.'</td></tr>'.
            '<tr><td>Subtotal (12% VAT) </td><td>'.$subTotalAmount.'</td></tr>'.       
            '<tr><td>VAT Amount</td><td>'.$vatAmount.'</td></tr>'.        
            '</thead>';
        
        $htmlBodyContentInfo2 = '<tbody>';
        $htmlBodyContentFooter2 = "</tbody></table>";
        
        $htmlBodyContent2 = $htmlBodyContentHeader2.$htmlBodyContentInfo2.$htmlBodyContentFooter2;
        
        $htmlBodyFooter = '<hr/>
                           <div style="font-size:xx-small;width: 50%;margin: 0 auto;">
                           <p>Receipt # : '.$invoiceNo.'</p>
                           <p>This serves as an official receipt</p></div>';
        
        $htmlBody = $htmlBodyHeader."<hr/>".$htmlBodyContent."<hr />".$htmlBodyContent2.$htmlBodyFooter;
        
        $htmlFooter = '</body></html>';
        
        header('Content-Type: application/html; charset="UTF-8"');
        
        echo $htmlHeader.$htmlBody.$htmlFooter;
    }
    
    public function searchTransaction($invoiceNo){
        $orderSummaryModel = new OrderSummaryModel();
        
        $orderSummaryId = $orderSummaryModel->getSummaryIdByInvoiceNo($invoiceNo);
            
        $pendingTransResult = $orderSummaryModel->getPendingTransactions($orderSummaryId['order_summary_id']);

        $subTotalAmount = 0;
        $totalAmount = 0;
        $vatAmount = 0;
        $orderDetailsResult = array();
        foreach ($pendingTransResult as $val) {
            $subTotalAmount = $subTotalAmount + (float) $val['amount']; //get the sub total amount

            array_push($orderDetailsResult, array("MenuItemName" => $val['menu_item_name'],
                "MenuItemPrice" => $val['menu_item_price'], "Quantity" => $val['quantity'],
                "Amount" => number_format($val['amount'], 2, '.', ','),
                "InvoiceNo" => $invoiceNo, "SubTotalAmount" => number_format($subTotalAmount, 2, '.', ','),
                "TotalAmount" => $totalAmount, "VatAmount" => $vatAmount));
        }
        
        $vatAmount = $subTotalAmount * ReferenceInfoController::$TAX_WITHHELD;

        $totalAmount = $subTotalAmount + $vatAmount; //amount inclusive with 

        $i = 0;
        while($i < count($orderDetailsResult)){
            
            $orderDetailsResult[$i]['VatAmount'] = number_format($vatAmount, 2, '.', ',');
            $orderDetailsResult[$i]['TotalAmount'] = number_format($totalAmount, 2, '.',',');
            
            $i++;
        }
        
        return $orderDetailsResult;
    }
}
?>