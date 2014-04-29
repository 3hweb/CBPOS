<?php
/*------------------------
 * Author: J.O. Pormento
 * Date Created: 04-22-2014
------------------------*/

$this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links' => array(
    'Sales Report',
    ),
    ));
?>

<h3>Sales Report</h3>

<?php Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker'); ?> 

<?php echo TbHtml::beginFormTb(TbHtml::FORM_LAYOUT_INLINE); ?>
    <?php echo TbHtml::label('Report Type: ', 'text'); ?>
    <?php echo TbHtml::dropDownList('report_type', '', array('Daily')); ?>
    
    <?php echo TbHtml::label('Date From: ', 'text'); ?>
    <?php 
        //date from
        $this->widget('CJuiDateTimePicker',array(
                        'model' => $model,
                        'attribute' => 'date_from',
                        //'name'=>'calDateFrom',
                        //'id'=>'calDateFrom',
                        //'value'=>date('Y-m-d'),
                        'value'=> $model->date_from,
                        'mode'=>'date', //use "time","date" or "datetime" (default)
                        'options'=>array(
                            'dateFormat'=>'yy-mm-dd',
                            'timeFormat'=> 'hh:mm',
                            'showAnim'=>'fold', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
                            'showOn'=>'button', // 'focus', 'button', 'both'
                            'buttonText'=>Yii::t('ui','Date'), 
                            'buttonImage'=>Yii::app()->request->baseUrl.'/images/calendar.png', 
                            'buttonImageOnly'=>true,
                        ),// jquery plugin options
                        'htmlOptions'=>array('readonly'=>'readonly', 'class'=>'input-medium'),
                        'language'=>'',
                    ));
    ?>
    <?php echo TbHtml::label('Date To: ', 'text'); ?>
    <?php 
        //date from
        $this->widget('CJuiDateTimePicker',array(
                        'model' => $model,
                        'attribute' => 'date_to',
                        //'name'=>'calDateFrom',
                        //'id'=>'calDateFrom',
                        //'value'=>date('Y-m-d'),
                        'value'=> $model->date_to,
                        'mode'=>'date', //use "time","date" or "datetime" (default)
                        'options'=>array(
                            'dateFormat'=>'yy-mm-dd',
                            'timeFormat'=> 'hh:mm',
                            'showAnim'=>'fold', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
                            'showOn'=>'button', // 'focus', 'button', 'both'
                            'buttonText'=>Yii::t('ui','Date'), 
                            'buttonImage'=>Yii::app()->request->baseUrl.'/images/calendar.png', 
                            'buttonImageOnly'=>true,
                        ),// jquery plugin options
                        'htmlOptions'=>array('readonly'=>'readonly', 'class'=>'input-medium'),
                        'language'=>'',
                    ));
    ?>
    <?php echo TbHtml::submitButton('Generate'); ?>
<?php echo TbHtml::endForm(); ?>

<?php
//display table
if (isset($dataProvider))
{
    $this->renderPartial('_daily', array(
                'dataProvider'=>$dataProvider,
        ));
}
else
{
    
}
?>