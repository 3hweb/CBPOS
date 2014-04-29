<?php

$this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'modalHold',
    'header' => 'Hold Transaction',
    'content' => '<h3>Are you sure you want to hold the current transaction?</h3>',
    'footer' => array(
        TbHtml::button('OK', array('data-dismiss' => 'modal',
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
            'onclick' => 'holdTransaction();')),
        TbHtml::button('Close', array('data-dismiss' => 'modal')),
    ),
));
?>