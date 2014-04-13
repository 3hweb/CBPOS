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
                                        array('id'=>'txtCashChange')).'
                            </td>
                        </tr>
                        <tr>
                            <td>Type of Payment</td>
                            <td><select id="cmbPayments" name="cmbPayments">
                                <option value="0">Please Select</option>
                                </select>
                            </td>
                        </tr>      
                     </table>
                     <div style="padding-top: 50px;">
                        ' . TbHtml::buttonGroup(array(
                                array('label' => 'DINE-IN'),
                                array('label' => 'TAKEOUT'),
                                array('label' => 'DELIVERY'),
                                array('label' => 'BULK ORDER'),
                             ), 
                                array('toggle' => TbHtml::BUTTON_TOGGLE_RADIO,
                                      'color' => TbHtml::BUTTON_COLOR_PRIMARY)). '
                     </div>',
    'footer' => array(
        TbHtml::button('SUBMIT', array('data-dismiss' => 'modal',
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
            'onclick' => 'saveRecord();')),
        TbHtml::button('Close', array('data-dismiss' => 'modal')),
    ),
));
?>