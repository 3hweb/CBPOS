<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'user-grid',
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'name' => 'order_detail_id',
            'header' => '#',
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
            'name' => 'amount',
            'header' => 'Amount',
        ),
    ),
)); ?>
