<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OrderSummaryModel
 *
 * @author elperez
 */
class OrderSummaryModel extends CFormModel{
    public $_connection;
    public function __construct() {
        $this->_connection = Yii::app()->db;
    }
    
    /**
     * 
     * @param type $status
     * @param type $orderSummaryId
     * @param type $totalAmt
     * @param type $taxAmt
     * @param type $netAmt
     * @return type
     */
    public function updateTransactionSRecord($status, $orderSummaryId, $totalAmt, 
            $taxAmt, $netAmt, $dineType, $paymentTypeId,$discountAmt, $cashChangeAmount, 
            $cashTenderedAmount, $txtTableNum){
        $sql = "UPDATE order_summary SET Status = :status, total_amount = :total_amount,
                tax_amount = :tax_amount, net_amount = :net_amount, dine_type = :dine_type,
                payment_type_id = :payment_type_id, discount_amount = :discount_amount,
                cash_tendered = :cash_tendered, cash_changed = :cash_changed, 
                table_no = :table_no
                WHERE order_summary_id = :order_summary_id";
        $command = $this->_connection->createCommand($sql);
        $command->bindValues(array(":status"=>$status,
                                   ":order_summary_id"=>$orderSummaryId,
                                   ":total_amount"=>$totalAmt,
                                   ":tax_amount"=>$taxAmt,
                                   ":net_amount"=>$netAmt,
                                   ":dine_type"=>$dineType,
                                   ":payment_type_id"=>$paymentTypeId,
                                   ":discount_amount"=>$discountAmt,
                                   ":cash_tendered"=>$cashTenderedAmount,
                                   ":cash_changed"=>$cashChangeAmount,
                                   ":table_no"=>$txtTableNum));
                                   
        return $command->execute();
    }
    
    public function getInvoiceNo($orderSummaryId){
        $sql = "SELECT invoice_no FROM order_summary WHERE order_summary_id = :order_summary_id";
        $command = $this->_connection->createCommand($sql);
        $command->bindParam(":order_summary_id", $orderSummaryId);
        return $command->queryRow();
    }
    
    public function getSummaryIdByInvoiceNo($invoiceNo){
        $sql = "SELECT order_summary_id FROM order_summary WHERE invoice_no = :invoice_no";
        $command = $this->_connection->createCommand($sql);
        $command->bindParam(":invoice_no", $invoiceNo);
        return $command->queryRow();
    }
    
    public function updateTransactionStatus($status, $orderSummaryId){
        $sql = "UPDATE order_summary SET status = :status 
                WHERE order_summary_id = :order_summary_id";
        $command = $this->_connection->createCommand($sql);
        $command->bindParam(":status", $status);
        $command->bindParam(":order_summary_id", $orderSummaryId);
        return $command->execute();
    }
    
    public function getPendingInvoice(){
        $sql = "SELECT invoice_no FROM order_summary WHERE status IN (0, 2)";
        $command = $this->_connection->createCommand($sql);
        return $command->queryAll();
    }
    
    public function getPendingTransactions($orderSummaryId){
        $sql = "SELECT os.discount_id, mi.menu_item_name, mi.menu_item_price, 
                SUM(od.quantity) AS quantity, SUM(od.amount) AS amount, 
                rd.discount_name, rd.discount_value, os.cash_tendered, os.cash_changed,
                os.table_no, os.dine_type, od.item_note
                FROM order_summary os
                INNER JOIN order_details od ON od.order_summary_id = os.order_summary_id
                INNER JOIN menu_items mi ON od.menu_item_id = mi.menu_item_id
                LEFT JOIN ref_discounts rd ON os.discount_id = rd.discount_id
                WHERE os.order_summary_id = :order_summary_id
                GROUP BY mi.menu_item_id";
        $command = $this->_connection->createCommand($sql);
        $command->bindParam(":order_summary_id", $orderSummaryId);
        return $command->queryAll();
    }
    
    public function updateDiscount($discountId, $orderSummaryId){
        $sql = "UPDATE order_summary SET discount_id = :discount_id 
                WHERE order_summary_id = :order_summary_id";
        $command = $this->_connection->createCommand($sql);
        $command->bindValues(array(':discount_id'=>$discountId,
                                   ':order_summary_id'=>$orderSummaryId));
        return $command->execute();
    }
    
    public function getCurrentDiscount($invoiceNo){
        $sql = "SELECT ";
    }
}

?>
