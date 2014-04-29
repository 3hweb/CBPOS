<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReferenceInfoController
 *
 * @author elperez
 */
class ReferenceInfoController{
    static $TAX_WITHHELD;
    static $NAME;
    static $ADDRESS;
    static $TIN;
    static $PERMIT_NO;
    
    public function __construct() {
        $this->getReceiptInfo();
    }

    public function getReceiptInfo(){
        $getReceiptInfoModel = new RefVariablesModel();
        
        //Display Receipt Info
        $getReceiptInfo = $getReceiptInfoModel->getUpdatedVariables();
        
        foreach ($getReceiptInfo as $val){
            switch ($val['variable_name']){
                case 'NAME':
                    self::$NAME = $val['variable_value'];
                    break;
                case 'TAX_WITHHELD':
                    self::$TAX_WITHHELD = $val['variable_value'];
                    break;
                case 'ADDRESS':
                    self::$ADDRESS = $val['variable_value'];
                    break;
                case 'TIN':
                    self::$TIN = $val['variable_value'];
                    break;
                case 'PERMIT_NO':
                    self::$PERMIT_NO = $val['variable_value'];
                    break;
                default:
                    echo 'INVALID Receipt Info';
                    break;
            }
        }
    }
    
    public static function getTransactionTypeId($transName){
        switch($transName){
            case 'DINE-IN':
                return 1;
                break;
            case 'TAKEOUT':
                return 2;
                break;
            case 'DELIVERY':
                return 3;
                break;
            case 'BULK':
                return 4;
                break;
        }
    }
    
    public static function getPaymentTypeId($paymentTypeName){
        switch ($paymentTypeName){
            case 'CASH':
                return 1;
            break;
            case 'CREDIT CARD':
                return 2;
            break;
        }
    }
    
}

?>
