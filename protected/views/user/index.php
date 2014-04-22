<?php

/*
 * @author : owliber
 * @date : 2014-04-21
 */

?>

<?php $this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links' => array(
    'User Management' => '#',
    'Users',
    ),
)); ?>

<?php echo TbHtml::linkButton('New User', array(
        'size'=>  TbHtml::BUTTON_SIZE_LARGE,
        'color' => TbHtml::BUTTON_COLOR_WARNING,
        'icon' => 'icon-plus',
        'url'=> Yii::app()->createUrl('user/add'),
        )
        
); ?>

<br /><br />
<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'type' => TbHtml::GRID_TYPE_BORDERED,
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'name' => 'account_id',
            'header' => '#',
            'htmlOptions' => array('style' => 'text-align:center'),
            'headerHtmlOptions' => array('style' => 'text-align:center'),
        ),
        array(
            'name' => 'account_code',
            'header' => 'Account Code',
            'htmlOptions' => array('style' => 'text-align:center'),
            'headerHtmlOptions' => array('style' => 'text-align:center'),
        ),
        array(
            'name' => 'first_name',
            'header' => 'First name',
        ),
        array(
            'name' => 'last_name',
            'header' => 'Last name',
        ),
        array(
            'name' => 'account_type',
            'header' => 'Account Type',
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
                        'url'=>'Yii::app()->createUrl("/user/update", array("id" =>$data["account_id"]))',
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
