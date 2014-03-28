<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->layout = '//layouts/login';
$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
    'Login',
);
?>

<?php
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl . '/js/jquery.plugin.js');
$cs->registerScriptFile($baseUrl . '/js/jquery.keypad.js');
$cs->registerCssFile($baseUrl . '/css/jquery.keypad.css');

Yii::app()->clientScript->registerScript('ui', '
           
    $("#LoginForm_passcode").keypad({
        layout: ["12345", "67890", 
        $.keypad.CLEAR + $.keypad.BACK + $.keypad.CLOSE]
    }); 
    
    $("#removeKeypad").toggle(function() { 
        $(this).text("Re-attach"); 
        $("#LoginForm_passcode").keypad("destroy"); 
    }), 
    
    function() { 
        $(this).text("Remove"); 
        $("#LoginForm_passcode").keypad(); 
        
    }
    
 ', CClientScript::POS_END);
?>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'login-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>

<fieldset>
    <legend>Login</legend>

    <?php echo $form->passwordFieldControlGroup($model, 'passcode', array()); ?>

</fieldset>
<?php
echo TbHtml::formActions(array(
    TbHtml::submitButton('Login', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
));
?>

<?php $this->endWidget(); ?>


