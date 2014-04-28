<?php

/**
 * @author Noel Antonio
 * @date 04-21-2014
 */

$this->pageTitle = Yii::app()->name . ' - Item Menus';

$this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links' => array(
        'Menu Management' => Yii::app()->createUrl('menus/index'),
        'Items',
    ),
));
?>

<?php echo TbHtml::linkButton('New Item Menu', array(
        'size'=>  TbHtml::BUTTON_SIZE_LARGE,
        'color' => TbHtml::BUTTON_COLOR_WARNING,
        'icon' => 'icon-plus',
        'url'=> Yii::app()->createUrl('menus/addItem'),
        )
        
); ?>

<br /><br />
<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'name' => 'menu_item_id',
            'header' => '#',
            'htmlOptions' => array('style' => 'text-align:center'),
            'headerHtmlOptions' => array('style' => 'text-align:center'),
        ),
        array(
            'name' => 'menu_group_name',
            'header' => 'Group Name',
            'htmlOptions' => array('style' => 'text-align:center'),
            'headerHtmlOptions' => array('style' => 'text-align:center'),
        ),
        array(
            'name' => 'menu_item_name',
            'header' => 'Item Name',
            'htmlOptions' => array('style' => 'text-align:center'),
            'headerHtmlOptions' => array('style' => 'text-align:center'),
        ),
        array(
            'name' => 'menu_item_price',
            'header' => 'Item Price',
            'htmlOptions' => array('style' => 'text-align:center'),
            'headerHtmlOptions' => array('style' => 'text-align:center'),
        ),
        array(
            'name' => 'menu_item_image_path',
            'header' => 'Item Image',
            'value'=>'TbHtml::image(Yii::app()->request->baseUrl."/".$data["menu_item_image_path"], "", array("style"=>"width:70px;height:70px;"))',
            'type'=>'raw',
            'htmlOptions' => array('style' => 'text-align:center'),
            'headerHtmlOptions' => array('style' => 'text-align:center'),
        ),
        array(
            'name' => 'status',
            'header' => 'Status',
            'htmlOptions' => array('style' => 'text-align:center'),
            'headerHtmlOptions' => array('style' => 'text-align:center'),
        ),
        array('class'=>'bootstrap.widgets.TbButtonColumn',
                'template'=>'{update}',
                'buttons'=>array
                (
                    'update'=>array
                    (
                        'label'=>'Update',
                        'icon'=>'icon-edit',
                        'url'=>'Yii::app()->createUrl("/menus/updateItem", array("id" =>$data["menu_item_id"]))',
                        'options' => array(
                            'class'=>"btn btn-small",
                        ),
                        array('id' => 'send-link-'.uniqid())
                    ),
                ),
                'header'=>'Action',
                'htmlOptions'=>array('style'=>'width:80px;text-align:center'),
                'headerHtmlOptions' => array('style' => 'text-align:center'),
            ),
    ),
)); ?>