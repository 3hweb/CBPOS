<?php

/*
 * @author : owliber
 * @date : 2014-04-22
 */
?>
<?php $this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links' => array(
    'User Management' => '#',
    'Change Password',
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
    
    $("#removeKeypad").toggle(function() { 
        $(this).text("Re-attach"); 
        $("#UserModel_passcode").keypad("destroy"); 
        $("#UserModel_passcode_repeat").keypad("destroy");       
    }), 
    
    function() { 
        $(this).text("Remove"); 
        $("#UserModel_passcode").keypad(); 
        $("#UserModel_passcode_repeat").keypad(); 
    }
 ', CClientScript::POS_END);
?>

<div><h3>Change password for user <?php echo $user; ?></h3></div>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'enableClientValidation'=>true,
    'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    'htmlOptions'=>array('class'=>'well'),
)); ?>

<fieldset>

<legend>Password Information</legend>

<?php echo TbHtml::hiddenField('account_code', $account_code); ?>
<?php echo $form->textFieldControlGroup($model, 'passcode'); ?>
<?php echo $form->textFieldControlGroup($model, 'passcode_repeat'); ?>
</fieldset>

<?php echo TbHtml::formActions(array(
    TbHtml::submitButton('Update Password', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
    TbHtml::linkButton('Back',  array('url'=>Yii::app()->createUrl('user/index'))),
)); ?>

<?php $this->endWidget(); ?>

<?php $this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'message-modal',
    'show'=>$this->showDialog,
    'header' => 'User Management',
    'content' => $this->dialogMessage,
    'footer' => array(
    TbHtml::linkButton('Close', array(
        'url'=> array('user/index'),
      )),
    ),
)); ?>