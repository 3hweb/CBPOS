<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CommonTransactionsModel
 *
 * @author elperez
 */
class CommonTransactionsModel extends CFormModel{
    private $_connection;
    
    public function __construct() {
        $this->_connection = Yii::app()->db;
    }

    public function recordTransaction($invoiceNo, $terminalId, $menuItemId, 
            $totalQuantity, $totalAmount, $taxAmount, $netAmount, $discountId,
            $paymentTypeId, $isReprinted, $dineType, $createdByAid, $status, 
            $itemQuantity, $itemAmount, $itemNote){
       
       $orderSummaryId = 0;
       
       $beginTransaction = $this->_connection->beginTransaction();
       $sql = "SELECT order_summary_id FROM order_summary 
                WHERE invoice_no = :invoice_no";
       $command = $this->_connection->createCommand($sql);
       $command->bindParam(":invoice_no", $invoiceNo);
       $result = $command->queryRow();
       
       $orderSummaryId = (int)$result['order_summary_id'];
       
       $totalAmount = $itemQuantity * $itemAmount;
       
       $isExecuteSuccess = false;
       //if has existing record with the same invoice_no then update the record 
       //else insert
       if($orderSummaryId > 0){
            $sql = 'UPDATE order_summary SET total_quantity = total_quantity + :item_quantity,
                    total_amount = total_amount + :total_amount, tax_amount = :tax_amount,
                    net_amount = :net_amount, status = :status 
                    WHERE order_summary_id = :order_summary_id AND invoice_no = :invoice_no';
            
            $command = $this->_connection->createCommand($sql);
            
            $command->bindValues(array(':item_quantity'=>$itemQuantity,
                                       ':total_amount'=>$totalAmount,
                                       ':tax_amount'=>$taxAmount,
                                       ':net_amount'=>$netAmount,
                                       ':status'=>$status,
                                       ':order_summary_id'=>$orderSummaryId,
                                       ':invoice_no'=>$invoiceNo));
            $isExecuteSuccess = $command->execute();
            
       } else {
           
           $sql = 'INSERT INTO order_summary(invoice_no, terminal_id,
                total_quantity, total_amount, tax_amount, net_amount, discount_id, 
                payment_type_id, reprinted, dine_type, date_created, created_by_aid, 
                status) VALUES(:invoice_no + order_summary_id, :terminal_id,:total_quantity,
                       :total_amount, :tax_amount, :net_amount, :discount_id,
                       :payment_type_id, :reprinted, :dine_type, NOW(6), :created_by_aid,
                       :status)';
            $command = $this->_connection->createCommand($sql);

            $command->bindValues(array(':invoice_no'=>$invoiceNo,
                                       ':terminal_id'=>$terminalId,
                                       ':total_quantity'=>$itemQuantity,
                                       ':total_amount'=>$totalAmount,
                                       ':tax_amount'=>$taxAmount,
                                       ':net_amount'=>$netAmount,
                                       ':discount_id'=>$discountId,
                                       ':payment_type_id'=>$paymentTypeId,
                                       ':reprinted'=>$isReprinted,
                                       ':dine_type'=>$dineType,
                                       ':created_by_aid'=>$createdByAid,
                                       ':status'=>$status
                                     )
                                );
            $isExecuteSuccess = $command->execute();
            
            $orderSummaryId = $this->_connection->getLastInsertID();
            
       }
       
       if ($isExecuteSuccess) {
            
            $sql = "INSERT INTO order_details(order_summary_id, menu_item_id, quantity, 
                        amount, date_created, item_note)
                        VALUES(:order_summary_id, :menu_item_id, :quantity, :amount, NOW(6),
                        :item_note)";
            $command = $this->_connection->createCommand($sql);

            $command->bindValues(array(':order_summary_id' => $orderSummaryId,
                ':menu_item_id' => $menuItemId,
                ':quantity' => $itemQuantity,
                ':amount' => $totalAmount,
                ':item_note'=>$itemNote
            ));

            if ($command->execute()) {
                $beginTransaction->commit();
                return $orderSummaryId;
            } else {
                $beginTransaction->rollback();
                return false;
            }
        } else {
            $beginTransaction->rollback();
            return false;
        }
   }
}

?>
