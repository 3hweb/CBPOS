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
    'id'=>'user-grid',
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
                'template'=>'{update}{activate}{deactivate}{changepwd}',
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
                    'activate'=>array
                    (
                        'label'=>'Activate',
                        'icon'=>'icon-check',
                        'url'=>'Yii::app()->createUrl("/user/activate", array("id" =>$data["account_id"]))',
                        'visible'=>'$data["status"]=="Deactivated"',
                        'options' => array(
                            'class'=>"btn btn-small",
                            'ajax' => array(
                                'type' => 'GET',
                                'dataType'=>'json',
                                'url' => 'js:$(this).attr("href")',
                                'success' => 'function(data){
                                    if(data["result_code"] = 0)
                                    {
                                        alert(data["result_msg"]);
                                        $.fn.yiiGridView.update("user-grid");
                                    }
                                    else
                                    {
                                        alert(data["result_msg"]);
                                        $.fn.yiiGridView.update("user-grid");
                                    }
                                 }',
                            ),
                        ),
                        array('id' => 'send-link-'.uniqid())
                    ),
                    'deactivate'=>array
                    (
                        'label'=>'Deactivate',
                        'icon'=>'icon-minus-sign',
                        'url'=>'Yii::app()->createUrl("/user/deactivate", array("id" =>$data["account_id"]))',
                        'visible'=>'$data["status"]=="Active"',
                        'options' => array(
                            'class'=>"btn btn-small",
                            'ajax' => array(
                                'type' => 'GET',
                                'dataType'=>'json',
                                'url' => 'js:$(this).attr("href")',
                                'success' => 'function(data){
                                    $.each(data, function(name,val){
                                       $("#product_id").val(val.product_id);
                                       $("#product_code").val(val.product_code);
                                       $("#product_name").val(val.product_name);
                                       $("#amount").val(val.amount);
                                       $("#ibo_discount").val(val.ibo_discount);
                                       $("#ipd_discount").val(val.ipd_discount);
                                       $("#status").val(val.status);
                                    });
                                    $("#product-update-dialog").modal("show");
                                 }',
                            ),
                        ),
                        array('id' => 'send-link-'.uniqid())
                    ),
                    'changepwd'=>array
                    (
                        'label'=>'Change Password',
                        'icon'=>'icon-lock',
                        'url'=>'Yii::app()->createUrl("/user/changepass", array("id" =>$data["account_id"]))',
                        'options' => array(
                            'class'=>"btn btn-small",
                        ),
                        array('id' => 'send-link-'.uniqid())
                    ),
                ),
                'header'=>'Action',
                'htmlOptions'=>array('style'=>'width:120px;text-align:center'),
                'headerHtmlOptions' => array('style' => 'text-align:center'),
            ),
    ),
)); ?>
