<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/css.css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
        
	<?php 
            Yii::app()->bootstrap->register(); 
            // Include the client scripts
            $baseUrl = Yii::app()->baseUrl; 

            $cs = Yii::app()->getClientScript();
           
            $cs->registerScriptFile($baseUrl.'/js/ajaxScript.js');
        ?>
        
</head>

<body>
    
<div class="container">
    <form method="post" id="frmModalDialog" action="#">
        <?php
             $this->widget('bootstrap.widgets.TbModal', array(
                'id' => 'myModal',
                'header' => 'Menu Item',
                'content' => '<table>
                                <tr>
                                    <td>Menu Item</td>
                                    <td>' . TbHtml::textField('txtMenuItem', 
                                            "", array('id' => 'txtMenuItem', 
                                                'readonly' => true)) . 
                                    '</td>
                                </tr>
                                <tr>
                                    <td>Price</td>
                                    <td>' . TbHtml::textField('txtPrice', "", 
                                            array('id' => 'txtPrice', 'readonly'=> true)) . 
                                    '</td>
                                </tr>
                                <tr>
                                    <td>Quantity</td>
                                    <td>' . TbHtml::textField('txtQuantity', "",array('id'=>'txtQuantity')) . '</td>
                                </tr>
                                <tr>
                                    <td>Type of Payment</td>
                                    <td><select id="cmbPayments" name="cmbPayments">
                                        <option value="0">Please Select</option>
                                        </select>
                                    </td>
                                </tr>
                                '.TbHtml::hiddenField('txtMenuId', "").'
                             </table>',
                'footer' => array(
                    TbHtml::button('Add Order', array('data-dismiss' => 'modal',
                        'color' => TbHtml::BUTTON_COLOR_PRIMARY,
                        'onclick' => 'addToList();')),
                    TbHtml::button('Close', array('data-dismiss' => 'modal')),
                ),
            ));
        ?>
	<?php echo $content; ?>
    </form>
	<div class="clear"></div>

</div><!-- page -->

</body>
</html>
