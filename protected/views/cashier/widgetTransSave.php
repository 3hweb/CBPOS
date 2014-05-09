<?php

$this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'modalSave',
    'header' => 'Save Transaction',
    'content' => '<table>
                        <tr>
                            <td>Total Amount</td>
                            <td>
                                '.TbHtml::textField('txtTotalAmount',"",
                                    array('id'=>'txtTotalAmt','class'=>'txtTotalAmtSave',
                                          'readonly'=>true)).'
                            </td>
                        </tr>
                        <tr>
                            <td>Cash Tendered</td>
                            <td>
                                '.TbHtml::textField('txtCashTendered', "", 
                                        array('id' => 'txtCashTendered')) 
                            .'</td>
                        </tr>
                        <tr>
                            <td>Cash Changed</td>
                            <td>
                                '.TbHtml::textField('txtCashChange',"",
                                        array('id'=>'txtCashChange','readonly'=>true)).'
                            </td>
                        </tr>
                        <tr>
                            <td>Table Number</td>
                            <td>'.TbHtml::textField('txtTableNum',"",
                                        array('id'=>'txtTableNum')).'</td>
                        </tr>
                     </table>
                     <div style="padding-top: 10px;">
                        <p align="left">Type of Payment</p>
                        '.TbHtml::buttonGroup(array(
                            array('label' => 'CASH','id'=>'cashType','onclick'=>'identifyTransPayment("CASH");'),
                            array('label' => 'CREDIT CARD','id'=>'cardType','onclick'=>'identifyTransPayment("CREDIT CARD");')),
                         array('toggle' => TbHtml::BUTTON_TOGGLE_RADIO,
                               'color' => TbHtml::BUTTON_COLOR_PRIMARY)).
                        TbHtml::hiddenField("txtTransPayment").'
                     </div>
                     <div style="padding-top: 10px;">
                        <p align="left">Type of Transaction</p>
                        ' . TbHtml::buttonGroup(array(
                                array('label' => 'DINE-IN','id'=>'dineinType','onclick'=>'identifyTransType("DINE-IN");'),
                                array('label' => 'TAKEOUT','id'=>'takeoutType','onclick'=>'identifyTransType("TAKEOUT");'),
                                array('label' => 'DELIVERY','id'=>'deliverType','onclick'=>'identifyTransType("DELIVERY");'),
                                array('label' => 'BULK ORDER','id'=>'bulkType','onclick'=>'identifyTransType("BULK");'),
                             ), 
                                array('toggle' => TbHtml::BUTTON_TOGGLE_RADIO,
                                      'color' => TbHtml::BUTTON_COLOR_PRIMARY)).
                            TbHtml::hiddenField("txtTransType").'
                     </div>',
    'footer' => array(
        TbHtml::button('SUBMIT', array('data-dismiss' => 'modal',
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
            'onclick' => 'saveRecord();')),
        TbHtml::button('Close', array('data-dismiss' => 'modal')),
    ),
));
?>