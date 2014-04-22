<?php

/**
 * @author Noel Antonio
 * @date 04-21-2014
 */

$this->pageTitle = Yii::app()->name . ' - Menu Management';
?>

<fieldset>
    <legend>Menu Management</legend>
    
    <div  class="hero-unit">
        <ul class="menu" style="text-align: center">
            <li class="menu-mgmt"><?php echo CHtml::link('Menu Groups', Yii::app()->createUrl('menus/groupIdx')); ?></li>
            <li class="menu-mgmt"><?php echo CHtml::link('Menu Items', Yii::app()->createUrl('menus/itemIdx')); ?></li>
            <li class="menu-mgmt"><?php echo CHtml::link('Go Back', Yii::app()->createUrl('site/index')); ?></li>
        </ul>
    </div>
</fieldset>