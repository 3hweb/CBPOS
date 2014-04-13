<?php

$this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'myModal',
    'header' => 'Menu Item',
    'content' => '<table>
                                <tr>
                                    <td>Menu Item</td>
                                    <td>' . TbHtml::textField('txtMenuItem', "", array('id' => 'txtMenuItem',
        'readonly' => true)) .
    '</td>
                                </tr>
                                <tr>
                                    <td>Price</td>
                                    <td>' . TbHtml::textField('txtPrice', "", array('id' => 'txtPrice', 'readonly' => true)) .
    '</td>
                                </tr>
                                <tr>
                                    <td>Quantity</td>
                                    <td>' . TbHtml::textField('txtQuantity', "", array('id' => 'txtQuantity')) . '</td>
                                </tr>
                                ' . TbHtml::hiddenField('txtMenuId', "") . '
                             </table>',
    'footer' => array(
        TbHtml::button('Add Order', array('data-dismiss' => 'modal',
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
            'onclick' => 'addToList();')),
        TbHtml::button('Close', array('data-dismiss' => 'modal')),
    ),
));
?>
