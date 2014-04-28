<?php

/**
 * @author Noel Antonio
 * @date 04-21-2014
 */

$this->pageTitle = Yii::app()->name . ' - Update Group Menu';
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
            'enableClientValidation'=> true,
            'clientOptions'=>array('validateOnSubmit'=>true),
            
)); ?>

<fieldset>
    <legend>Update Group Menu</legend>
    
    <?php echo $form->textFieldControlGroup($model, 'group_name', array('value'=>$data["menu_group_name"])); ?>
    
    <?php echo TbHtml::formActions(array(
            TbHtml::submitButton('Submit', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
            TbHtml::button('Cancel', array('onclick'=>'location.href="' . Yii::app()->createUrl('menus/groupIdx') . '"')),
    )); ?>
    
</fieldset>

<?php $this->endWidget(); ?>

<!-- message modal -->
<?php $this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'message-modal',
    'show'=>$this->autoOpen,
    'header' => $this->title,
    'content' => $this->message,
    'footer' => array(
    TbHtml::linkButton('Close', array(
        'url'=> array('menus/groupIdx'),
      )),
    ),
)); ?>
<!-- message modal -->