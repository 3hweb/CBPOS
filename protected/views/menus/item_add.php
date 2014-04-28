<?php

/**
 * @author Noel Antonio
 * @date 04-21-2014
 */

$this->pageTitle = Yii::app()->name . ' - Add Menu Items';
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
            'enableClientValidation'=> true,
            'clientOptions'=>array('validateOnSubmit'=>true),
            'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

<fieldset>
    <legend>Add Menu Item</legend>
    
    <?php echo $form->dropDownListControlGroup($model, 'group_id', TbHtml::listData(MenuGroupModel::getActiveMenuGrps(), 'menu_group_id', 'menu_group_name'), array('empty' => '- Please Select -')); ?>
    <?php echo $form->textFieldControlGroup($model, 'item_name'); ?>
    <?php echo $form->textFieldControlGroup($model, 'item_price', array('append' => '.00')); ?>
    <?php echo $form->fileFieldControlGroup($model, 'item_image_path'); ?>
    
    <?php echo TbHtml::formActions(array(
            TbHtml::submitButton('Submit', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
            TbHtml::button('Cancel', array('onclick'=>'location.href="' . Yii::app()->createUrl('menus/itemIdx') . '"')),
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
        'url'=> array('menus/itemIdx'),
      )),
    ),
)); ?>
<!-- message modal -->