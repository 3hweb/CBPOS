<?php

$this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'modalApplyDiscount',
    'header' => 'Apply Discount',
    'content' => '<div id="applyDiscount" class="btn-group" data-toggle="buttons-radio"></div>'.TbHtml::buttonGroup(array(),
                         array('toggle' => TbHtml::BUTTON_TOGGLE_RADIO,
                               'color' => TbHtml::BUTTON_COLOR_PRIMARY)).
                        TbHtml::hiddenField("txtDiscount").'',
    'footer' => array(
        TbHtml::button('APPLY', array('data-dismiss' => 'modal',
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
            'onclick' => 'applyDiscount();')),
        TbHtml::button('Close', array('data-dismiss' => 'modal')),
    ),
));
?>