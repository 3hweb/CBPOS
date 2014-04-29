<?php

$this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'modalCancel',
    'header' => 'Cancel Transaction',
    'content' => '<h3>Are you sure you want to cancel the current transaction?</h3>',
    'footer' => array(
        TbHtml::button('OK', array('data-dismiss' => 'modal',
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
            'onclick' => 'cancelTransaction();')),
        TbHtml::button('Close', array('data-dismiss' => 'modal')),
    ),
));
?>
