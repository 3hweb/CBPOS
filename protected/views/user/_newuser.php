<?php

/*
 * @author : owliber
 * @date : 2014-04-21
 */
?>

<?php $this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links' => array(
    'User Management' => array('user/index'),
    'New User',
    ),
)); ?>

<?php
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl . '/js/jquery.plugin.js');
$cs->registerScriptFile($baseUrl . '/js/jquery.keypad.js');
$cs->registerCssFile($baseUrl . '/css/jquery.keypad.css');

Yii::app()->clientScript->registerScript('ui', '
           
    $("#UserModel_passcode").keypad(); 
    $("#UserModel_passcode_repeat").keypad();
    $("#UserModel_mobile_no").keypad();
   
    var qwertyLayout = [ 
        $.keypad.qwertyAlphabetic[0] + $.keypad.CLOSE, 
        $.keypad.HALF_SPACE + $.keypad.qwertyAlphabetic[1] + 
        $.keypad.HALF_SPACE + $.keypad.CLEAR, 
        $.keypad.SPACE + $.keypad.qwertyAlphabetic[2] + 
        $.keypad.SHIFT + $.keypad.BACK]; 
        
   var qwertyLayout2 = [ 
        $.keypad.qwertyAlphabetic[0] + $.keypad.CLOSE, 
        $.keypad.HALF_SPACE + $.keypad.qwertyAlphabetic[1] + 
        $.keypad.HALF_SPACE + $.keypad.CLEAR, 
        $.keypad.SPACE + $.keypad.qwertyAlphabetic[2] + 
        "@." + $.keypad.SHIFT + $.keypad.BACK];
    
    $("#UserModel_first_name").keypad({keypadOnly: false, layout: qwertyLayout});
    $("#UserModel_last_name").keypad({keypadOnly: false, layout: qwertyLayout});
    $("#UserModel_address").keypad({keypadOnly: false, layout: qwertyLayout});
    $("#UserModel_email").keypad({keypadOnly: false, layout: qwertyLayout2});
    
    $("#removeKeypad").toggle(function() { 
        $(this).text("Re-attach"); 
        $("#UserModel_passcode").keypad("destroy"); 
        $("#UserModel_passcode_repeat").keypad("destroy"); 
        $("#UserModel_mobile_no").keypad("destroy"); 
        
    }), 
    
    function() { 
        $(this).text("Remove"); 
        $("#UserModel_passcode").keypad(); 
        $("#UserModel_passcode_repeat").keypad(); 
        $("#UserModel_mobile_no").keypad();
    }
    
 ', CClientScript::POS_END);
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'enableClientValidation'=>true,
    'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    'htmlOptions'=>array('class'=>'well'),
)); ?>

<fieldset>

<legend>Login Information</legend>
 
<?php echo $form->uneditableFieldControlGroup($model, 'account_code'); ?>
<?php echo $form->dropDownListControlGroup($model, 'account_type', array('1'=>'Admin', '2'=>'Cashier'), array('empty' => 'Select')); ?>
<?php echo $form->passwordFieldControlGroup($model, 'passcode'); ?>
<?php echo $form->passwordFieldControlGroup($model, 'passcode_repeat'); ?>
<legend>Account Information</legend>
<?php echo $form->textFieldControlGroup($model, 'first_name'); ?>
<?php echo $form->textFieldControlGroup($model, 'last_name'); ?>
<?php echo $form->textFieldControlGroup($model, 'mobile_no'); ?>
<?php echo $form->textFieldControlGroup($model, 'email', array('prepend' => '@')); ?>
<?php echo $form->textAreaControlGroup($model, 'address', array('span' =>4, 'rows' => 5)); ?>

</fieldset>

<?php echo TbHtml::formActions(array(
    TbHtml::submitButton('Submit', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
    TbHtml::resetButton('Reset'),
    TbHtml::linkButton('Back',  array('url'=>Yii::app()->createUrl('user/index'))),
)); ?>

<?php $this->endWidget(); ?>

<?php $this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'message-modal',
    'show'=>$this->showDialog,
    'header' => 'User Management',
    'content' => $this->dialogMessage,
    'footer' => array(
    //TbHtml::button('Save Changes', array('data-dismiss' => 'modal', 'color' => TbHtml::BUTTON_COLOR_PRIMARY)),
    TbHtml::linkButton('Close', array(
        'url'=> array('user/add'),
      )),
    ),
)); ?>