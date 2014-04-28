<?php

/**
 * @author Noel Antonio
 * @date 04-21-2014
 */

$this->pageTitle = Yii::app()->name . ' - Update Menu Items';
?>

<script type="text/javascript">
$(document).ready(function(){
    $('#image_id li img').click(function(){
        $('#image-modal').modal("show");
    });
});

function uploadPhoto()
{
    var formData = new FormData($("#frmUpload")[0]);
    $.ajax({
        url: '<?php echo Yii::app()->createUrl("menus/uploadPhoto"); ?>',
        type: 'POST',
        data: formData,
        datatype:'json',
        // async: false,
        beforeSend: function() {
            // do some loading options
        },
        success: function (data) {
            // on success do some validation or refresh the content div to display the uploaded images
            location.href = "<?php echo Yii::app()->createUrl('menus/itemIdx'); ?>";
        },
 
        complete: function() {
            // success alerts
        },
 
        error: function (data) {
            alert("There may a error on uploading. Try again later");
        },
        cache: false,
        contentType: false,
        processData: false
    });
}
</script>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
            'enableClientValidation'=> true,
            'clientOptions'=>array('validateOnSubmit'=>true),
            'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

<fieldset>
    <legend>Update Menu Item</legend>
    
    <?php
        echo TbHtml::thumbnails(array(
            array('image' => Yii::app()->request->baseUrl."/".$data["menu_item_image_path"], 'url' => '#', 'span' => 3, 'caption'=>'Click the image to change'),
        ), array('id'=>'image_id', 'style'=>'margin-left: 5%;'));
    ?>
    <?php echo $form->dropDownListControlGroup($model, 'group_id', TbHtml::listData(MenuGroupModel::getActiveMenuGrps(), 'menu_group_id', 'menu_group_name'), array('empty' => '- Please Select -', 'options' => array($data['menu_group_id']=>array('selected'=>true)))); ?>
    <?php echo $form->textFieldControlGroup($model, 'item_name', array('value'=>$data['menu_item_name'])); ?>
    <?php echo $form->textFieldControlGroup($model, 'item_price', array('append' => '.00', 'value'=>$data['menu_item_price'])); ?>
    
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

<!-- image modal -->
<?php 
$content = '
    <form id="frmUpload" name="frmUpload" enctype="multipart/form-data">
        <div>
            <input type="hidden" id="filename" name="filename" value="'.$data['menu_item_name'].'" />
            <input type="file" name="MenuItemsModel[item_image_path]" id="MenuItemsModel_item_image_path" />
        </div>
    </form>';

$this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'image-modal',
    'show'=>false,
    'header' => 'Change Item Image',
    'content' =>$content,
    'footer' => array(
        TbHtml::button('Upload', array('onclick'=>'uploadPhoto()')),
        TbHtml::button('Close', array('data-dismiss' => 'modal')),
    ),
)); ?>
<!-- image modal -->