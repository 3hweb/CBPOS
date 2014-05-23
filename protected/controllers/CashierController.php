<?php

/*
 * @author : owliber
 * @date : 2014-03-28
 */

class CashierController extends Controller
{
    public $layout = "cashier";
    public $cashierName;
    public $cashierId;

    private function setSessionVariables() {
        if(isset(Yii::app()->session['account_id']) && Yii::app()->session['account_id'] != "")
        {
            $aid = Yii::app()->session['account_id'];
            $accountsModel = new Accounts();    
            $this->cashierName = $accountsModel->getAccountName($aid);
            $this->cashierId = $aid;
        } else {
            $this->logout();
        }
    }

    public function actionIndex()
    {
        $menuGroupModel = new MenuGroupModel();
        $menuItemsModel = new MenuItemsModel();
        $referenceInfoController = new ReferenceInfoController();
        
        //Display Active Menu Group
        $menuGroupResult = $menuGroupModel->getActiveMenuGrps();
        
        $this->setSessionVariables(); //get session variables
        
        //Initialize Pagination
        $perPage = 6;
        $ctrMenuList = $menuItemsModel->countMenuItems();
        $pages = ceil((int)$ctrMenuList['ctrmenu']/$perPage);
        
        $referenceInfoController->getReceiptInfo();
        
        $this->render('index',array('pages'=>$pages,
                                    'menuGroupResult'=>$menuGroupResult,
                                    'accountName'=>$this->cashierName));
    }
    
    public function actionAddOrderToList() {
        $commonTransactionModel = new CommonTransactionsModel();
        $orderDetailsModel = new OrderDetailsModel();
        $orderSummaryModel = new OrderSummaryModel();
        $referenceInfoController = new ReferenceInfoController(); //required class
        
        $this->setSessionVariables(); //get session variables
        
        $terminalId = 1;
        $totalQuantity = 0;
        $totalAmount = 0;
        $taxAmount = 0;
        $netAmount = 0;
        $discountId = null;
        $paymentTypeId = 0;
        $isReprinted = 0;
        $dineType = 0;
        $createdByAid = $this->cashierId; //session variable of cashier
        $status = 0; 
        $menuItemId = $_POST['txtMenuId'];
        $itemQuantity = $_POST['txtQuantity'];
        $itemAmount = $_POST['txtPrice'];
        $itemNote = $_POST['txtItemNote'];
        
        if(isset($_POST['txtReceiptNo']) && $_POST['txtReceiptNo'] != ""){
            $invoiceNo = $_POST['txtReceiptNo'];
        } else {
            $invoiceNo = mt_rand().$menuItemId;
        }
        
        $orderSummaryId = $commonTransactionModel->recordTransaction($invoiceNo, $terminalId, 
                $menuItemId, $totalQuantity, $totalAmount, $taxAmount, $netAmount, 
                $discountId, $paymentTypeId, $isReprinted, $dineType, $createdByAid, 
                $status, $itemQuantity, $itemAmount, $itemNote);
         
        /*
        if((int)$orderSummaryId > 0){
            
        } else {
            
        }*/
        
        $orderSummary = $orderSummaryModel->getInvoiceNo($orderSummaryId);
        $invoiceNo = $orderSummary['invoice_no'];
        
        $orderDetailsResult = $this->searchTransaction($invoiceNo);
        
        // output some JSON instead of the usual text/html
        header('Content-Type: application/json; charset="UTF-8"');
        echo CJSON::encode($orderDetailsResult);
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
        $discountAmount = Utilities::removeComma($_POST['txtDiscAmt']);
        $cashTenderedAmount = Utilities::removeComma($_POST['txtCashTendered']);
        $cashChangeAmount = Utilities::removeComma($_POST['txtCashChange']);
        $txtTableNum = $_POST['txtTableNum'];
        
        $orderSummaryResult = $orderSummaryModel->getSummaryIdByInvoiceNo($invoiceNo);
        $orderSummaryId = $orderSummaryResult['order_summary_id'];
        
        $status = 1; //SAVE
        
        $dineTypeId = ReferenceInfoController::getTransactionTypeId($transTypeName);
        
        $paymentTypeId = ReferenceInfoController::getPaymentTypeId($paymentTypeName);
        
        $isSaveSuccess = $orderSummaryModel->updateTransactionSRecord($status, 
                $orderSummaryId, $totalAmount, $taxAmount, $netAmount, $dineTypeId, 
                $paymentTypeId, $discountAmount, $cashChangeAmount, $cashTenderedAmount,
                $txtTableNum);
        
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
        $referenceInfoController = new ReferenceInfoController(); //required class
        if(isset($_POST['txtReceiptNo']) && $_POST['txtReceiptNo'] != ""){
            $invoiceNo = $_POST['txtReceiptNo'];
            
            $orderDetailsResult = $this->searchTransaction($invoiceNo);
        }
        
        header('Content-Type: application/json; charset="UTF-8"');
        echo CJSON::encode($orderDetailsResult);
    }
    
    public function actionPrintReceipt(){
        $referenceInfoController = new ReferenceInfoController(); //required class
        $this->setSessionVariables(); //get session variables
        $isReprint = $_POST['isReprint'];
        $invoiceNo = $_POST['invoiceNo'];
        $transDetailsResult = $this->searchTransaction($invoiceNo);
        $htmlHeader = "<html><head></head><body>";
        
        $htmlBodyHeader = '<p align="left" style=\"font-size:large;\">'.
                            ReferenceInfoController::getTransactionTypeName($transDetailsResult[0]['TransactionType']).
                            ' - '.$transDetailsResult[0]['TableNo'].'</p>
                        <div class="content" style="width: 100%;margin: 0 auto;font-size:xx-small;" align="center">
                        <p align="center" style="word-break: normal;">'.str_replace('-', '&dash;', ReferenceInfoController::$NAME).'</p>
                        <p align="center" style="word-break: normal;">'.str_replace('-', '&dash;', ReferenceInfoController::$ADDRESS1).'</p>
                        <p align="center" style="word-break: normal;">'.str_replace('-', '&dash;', ReferenceInfoController::$ADDRESS2).'</p>
                        <p align="left" style="word-break: normal;">TIN: '.str_replace('-', '&dash;', ReferenceInfoController::$TIN).'</p>
                        <p align="left" style="word-break: normal;">EMAIL: '.str_replace('-', '&dash;', ReferenceInfoController::$EMAIL).'</p>    
                        <p align="left">DATE: ' . date('d F Y h:i A') .'</p>
                        <p align="left"> Terminal :  Terminal 1</p>
                        <p align="left">Cashier : '.$this->cashierName.'</p>
                        </div>';
       
        /** Transaction Details - Item List **/
        $htmlBodyContentHeader = '<table style=\"text-align: right;font-size: small;font-size:xx-small;\"><thead><tr>'.
            '<td style=\"width: 20%\">Item</td><td>QTY</td><td>Price</td><td>Amount</td>'.
            '</tr></thead>';
        
        $htmlBodyContentInfo = '<tbody>';
        $subTotalAmount = 0;
        foreach($transDetailsResult as $val){
            $subTotalAmount = $val['SubTotalAmount']; //get the sub total amount
            $vatAmount = $val['VatAmount'];
            $totalAmount = $val['TotalAmount'];
            $vatExemptAmount = $val['VatExemptAmount'];
            $discountAmount = $val['DiscountAmount'];
            $discountName = $val['DiscountName'];
            $cashTenderedAmt = $val['CashTendered'];
            $cashChangedAmt = $val['CashChanged'];
            if($val['ItemNote'] != ""){
                $htmlBodyContentInfo .= '<tr>'.
                                        '<td style=\"width: 20px;\">'.$val['MenuItemName'].'</td>'.
                                        '<td>'.$val['Quantity'].'</td>'.
                                        '<td>'.$val['MenuItemPrice'].'</td>'.
                                        '<td>'.$val['Amount'].'</td>'.
                                    '</tr>'.
                                    '<tr><th colspan=4><label style=\"font-style: italic;width: 130px;font-size: 10px;\"> >>>'.$val['ItemNote'].'</label></th></tr>';
            } else {
                $htmlBodyContentInfo .= '<tr>'.
                                        '<td style=\"width: 20px;\">'.$val['MenuItemName'].'</td>'.
                                        '<td>'.$val['Quantity'].'</td>'.
                                        '<td>'.$val['MenuItemPrice'].'</td>'.
                                        '<td>'.$val['Amount'].'</td>'.
                                    '</tr>';
            }
        }
        
        $htmlBodyContentFooter = "</tbody></table>";
        
        $htmlBodyContent = $htmlBodyContentHeader.$htmlBodyContentInfo.$htmlBodyContentFooter;
        
        /***************** Transaction Details - Total Part*******************/
        
        $htmlBodyContentHeader2 = '<table style=\"text-align: right;font-size:xx-small;\"><thead>'.
            '<tr><td>Subtotal (12% VAT Inclusive) </td><td>'.$subTotalAmount.'</td></tr>'.       
            '<tr><td>VAT Amount</td><td>'.$vatAmount.'</td></tr>'.
            //'<tr><td>Less 12% VAT</td><td>'.$vatExemptAmount.'</td></tr>'.
            '<tr><td>Discount  <label style="font-size: xxx-small;">'.$discountName.'</label></td><td>('.$discountAmount.')</td></tr>'.
            '<tr><td>Amount Due</td><td>'.$totalAmount.'</td></tr>'.        
            '</thead>';
        
        $htmlBodyContentInfo2 = '<tbody>';
        $htmlBodyContentFooter2 = "</tbody></table>";
        
        $htmlBodyContent2 = $htmlBodyContentHeader2.$htmlBodyContentInfo2.$htmlBodyContentFooter2;
        
        $htmlBodyContent3 = '<table style=\"text-align: right;font-size:xx-small;\"><thead>'.
                            '<tr><td>Cash Tendered: </td> <td>'.$cashTenderedAmt.'</td>'.
                            '<tr><td>Cash Change: </td> <td>'.$cashChangedAmt.'</td>'.
                            '</tr>';
        
        $htmlBodyFooter = '<hr/>
                           <div style="font-size:xx-small;width: 50%;margin: 0 auto;">
                           <p>Receipt # : '.$invoiceNo.'</p>
                           <p>This serves as an official receipt</p></div>';
        
        $htmlBody = $htmlBodyHeader."<hr/>".$htmlBodyContent."<hr />".$htmlBodyContent2."<hr />".$htmlBodyContent3.$htmlBodyFooter;
        
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
        $discountId = null;
        foreach ($pendingTransResult as $val) {
            $subTotalAmount = $subTotalAmount + (float) $val['amount']; //get the sub total amount
            $discountId = $val['discount_id'];
            $discountValue = $val['discount_value'];
            
            array_push($orderDetailsResult, array("MenuItemName" => $val['menu_item_name'],
                "MenuItemPrice" => $val['menu_item_price'], "Quantity" => $val['quantity'],
                "Amount" => number_format($val['amount'], 2, '.', ','),
                "InvoiceNo" => $invoiceNo, "SubTotalAmount" => $subTotalAmount,
                "TotalAmount" => $totalAmount, "VatAmount" => $vatAmount,
                "DiscountName"=>$val['discount_name'],"CashTendered"=>$val['cash_tendered'],
                "CashChanged"=>$val['cash_changed'],"TableNo"=>$val['table_no'],
                "TransactionType"=>$val['dine_type'],"ItemNote"=>$val['item_note']));
        }
        
        $vatExemptAmt = 0;
        $discountAmount = 0;
        if(is_null($discountId)){
            $vatAmount = $subTotalAmount * ReferenceInfoController::$TAX_WITHHELD;
            $subTotalAmount = $subTotalAmount - $vatAmount;
            $totalAmount = $subTotalAmount + $vatAmount; //amount inclusive with 
        } else {
            //$vatExemptAmt = $subTotalAmount / (float)ReferenceInfoController::$TAX_EXEMPT;
            $discountAmount = $subTotalAmount * $discountValue;
            $totalAmount = $subTotalAmount - $discountAmount; 
        }

        $i = 0;
        while($i < count($orderDetailsResult)){
            
            $orderDetailsResult[$i]['VatAmount'] = number_format($vatAmount, 2, '.', ',');
            $orderDetailsResult[$i]['TotalAmount'] = number_format($totalAmount, 2, '.',',');
            $orderDetailsResult[$i]['VatExemptAmount'] = number_format($vatExemptAmt, 2, '.',',');
            $orderDetailsResult[$i]['DiscountAmount'] = number_format($discountAmount, 2, '.', ',');
            $orderDetailsResult[$i]['SubTotalAmount'] = number_format($subTotalAmount, 2, '.', ',');
            
            $i++;
        }
        
        return $orderDetailsResult;
    }
    
    public function actionGetDiscounts(){    
        if(isset($_POST['invoiceNo']) && strlen($_POST['invoiceNo']) > 0){
            $invoiceNo = $_POST['invoiceNo'];
            $refDiscountsModel = new RefDiscountsModel();
            $rdiscounts = $refDiscountsModel->getActiveDiscounts();

            header('Content-Type: application/html; charset="UTF-8"');

            echo CJSON::encode($rdiscounts);
        } else {
            header('Content-Type: application/html; charset="UTF-8"');
        
            echo CJSON::encode("Get Discounts: No active transaction.");
        }
    }
    
    public function actionApplyDiscount(){
        $orderSummaryModel = new OrderSummaryModel();
        
        $invoiceNo = $_POST['invoiceNo'];
        $discountId = $_POST['discountId'];
        
        $orderSummaryResult = $orderSummaryModel->getSummaryIdByInvoiceNo($invoiceNo);
        $orderSummaryId = $orderSummaryResult['order_summary_id'];
        
        $isDiscountApplied = $orderSummaryModel->updateDiscount($discountId, $orderSummaryId);
        
        if($isDiscountApplied){
            $msg = "ApplyDiscount: Successfully Applied";
        } else {
            $msg = "ApplyDiscount: Failed to apply the discount. Please try again.";
        }
        
        header('Content-Type: application/html; charset="UTF-8"');
        echo CJSON::encode($msg);
    }
    
    /**
     * Logs out the current user and redirect to homepage.
     */
    public function logout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
}
?>