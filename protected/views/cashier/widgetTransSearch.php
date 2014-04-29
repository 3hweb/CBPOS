<?php

$this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'modalSearch',
    'header' => 'Search Pending Transaction',
    'content' => '<div>
                     <table id="tblPendingTrans">
                     
                     </table>
                  </div>',
    'footer' => array(TbHtml::button('Close', array('data-dismiss' => 'modal',
                                     'id'=>'btnSearchClose')),
    ),
));
?>