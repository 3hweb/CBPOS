<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'user-grid',
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'header' => '',
            'value' => '$row + ($this->grid->dataProvider->pagination->currentPage
            * $this->grid->dataProvider->pagination->pageSize + 1)',
            'htmlOptions' => array('style' => 'text-align:center'),
            'headerHtmlOptions' => array('style' => 'text-align:center'),
            ),
        array(
            'name' => 'menu_item_name',
            'header' => 'Menu Name',
            'htmlOptions' => array('style' => 'text-align:center'),
            'headerHtmlOptions' => array('style' => 'text-align:center'),
        ),
        array(
            'name' => 'quantity',
            'header' => 'Quantity',
            'htmlOptions' => array('style' => 'text-align:center'),
            'headerHtmlOptions' => array('style' => 'text-align:center'),
        ),
        array(
            'name' => 'amount',
            'header' => 'Price',
            'htmlOptions' => array('style' => 'text-align:right'),
            'headerHtmlOptions' => array('style' => 'text-align:center'),
            'footer'=>'<strong>Total</strong>',
            'footerHtmlOptions'=>array('style'=>'font-size:14px; text-align:center;'),
        ),
        array(
            'name' => 'subtotal',
            'header' => 'Subtotal',
            'htmlOptions' => array('style' => 'text-align:right'),
            'headerHtmlOptions' => array('style' => 'text-align:center'),
            'footer'=>'<strong>'.number_format($total, 2, '.', ',').'</strong>',
            'footerHtmlOptions'=>array('style'=>'text-align:right; font-size:14px'),
        ),
    ),
)); ?>
