<?php

$this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'modalHold',
    'header' => 'Authorization Required',
    'content' => '<table>
                        <tr>
                            <td>Passcode</td>
                            <td>
                                '.TbHtml::textField('txtPasscode', "", 
                                        array('id' => 'txtPasscode')) 
                            .'</td>
                        </tr>
                  </table>',
    'footer' => array(
        TbHtml::button('OK', array('data-dismiss' => 'modal',
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
            'onclick' => '')),
        TbHtml::button('Close', array('data-dismiss' => 'modal')),
    ),
));
?>