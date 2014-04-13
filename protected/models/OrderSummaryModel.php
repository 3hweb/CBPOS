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
            $taxAmt, $netAmt){
        $sql = "UPDATE order_summary SET Status = :status, total_amount = :total_amount,
                tax_amount = :tax_amount, net_amount = :net_amount
                WHERE order_summary_id = :order_summary_id";
        $command = $this->_connection->createCommand($sql);
        $command->bindValues(array(":status"=>$status,
                                   ":order_summary_id"=>$orderSummaryId,
                                   ":total_amount"=>$totalAmt,
                                   ":tax_amount"=>$taxAmt,
                                   ":net_amount"=>$netAmt));
                                   
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
}

?>
