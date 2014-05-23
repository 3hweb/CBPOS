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
    <?php echo TbHtml::label('Cashier Name: ', 'text'); ?>
    <?php echo TbHtml::dropDownList('account_id', '', SalesController::list_cashier_acounts()); ?>
    <?php //echo TbHtml::dropDownListControlGroup($model, array('1'=>'Admin', '2'=>'Cashier'), array('empty' => 'Select')); ?>
    
    <?php echo TbHtml::submitButton('Generate'); ?>
<?php echo TbHtml::endForm(); ?>

<?php
//display table
if (isset($dataProvider))
{
    $this->renderPartial('_daily', array(
                'dataProvider'=>$dataProvider,
                'total'=>$total,
        ));
}
else
{
    
}
?>