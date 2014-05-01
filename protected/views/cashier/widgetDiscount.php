<?php

$this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'modalApplyDiscount',
    'header' => 'Apply Discount',
    'content' => '',
    'footer' => array(
        TbHtml::button('APPLY', array('data-dismiss' => 'modal',
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
            'onclick' => '')),
        TbHtml::button('Close', array('data-dismiss' => 'modal')),
    ),
));
?>