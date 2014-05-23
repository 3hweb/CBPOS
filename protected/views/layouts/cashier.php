<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/css.css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/tinycarousel.css" type="text/css" media="screen"/>

	<?php 
            Yii::app()->bootstrap->register(); 
            // Include the client scripts
            $baseUrl = Yii::app()->baseUrl; 

            $cs = Yii::app()->getClientScript();
            $cs->registerScriptFile($baseUrl.'/js/ajaxScript.js');
            //$cs->registerScriptFile($baseUrl.'/js/jquery.min.js');
            $cs->registerScriptFile($baseUrl.'/js/jquery.tinycarousel.js')
        ?>
        
        <applet id="qz" name="QZ Print Plugin" code="qz.PrintApplet.class" archive="<?php echo Yii::app()->request->baseUrl; ?>/js/qz-print.jar" width="1" height="1">
              <param name="printer" value="zebra">
        </applet>
</head>

<body>
    
<div class="container">
    <form method="post" id="frmModalDialog" action="#">
        <?php echo $content; ?>
    </form>
	<div class="clear"></div>
</div><!-- page -->

</body>
</html>
