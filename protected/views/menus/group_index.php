<?php

/**
 * @author Noel Antonio
 * @date 04-21-2014
 */

$this->pageTitle = Yii::app()->name . ' - Group Menus';

$this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links' => array(
        'Menu Management' => '#',
        'Groups',
    ),
));
?>

<?php echo TbHtml::linkButton('New Group Menu', array(
        'size'=>  TbHtml::BUTTON_SIZE_LARGE,
        'color' => TbHtml::BUTTON_COLOR_WARNING,
        'icon' => 'icon-plus',
        'url'=> Yii::app()->createUrl('menus/addGroup'),
        )
        
); ?>

<br /><br />
<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'name' => 'menu_group_id',
            'header' => '#',
            'htmlOptions' => array('style' => 'text-align:center'),
            'headerHtmlOptions' => array('style' => 'text-align:center'),
        ),
        array(
            'name' => 'menu_group_name',
            'header' => 'Group Menu Name',
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
                        'url'=>'Yii::app()->createUrl("/menus/updateGroup", array("id" =>$data["menu_group_id"]))',
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