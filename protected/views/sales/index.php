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

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'enableClientValidation'=>true,
    'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    'htmlOptions'=>array('class'=>'well'),
)); ?>

<?php echo $form->dropDownListControlGroup($model, 'report_type', array('1'=>'Daily', '2'=>'Monthly', '3'=>'Yearly'), array('empty' => 'Select')); ?>

<?php $this->endWidget(); ?>