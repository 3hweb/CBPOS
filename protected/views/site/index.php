<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
    
?>

<div  class="hero-unit">
    <ul class="menu">
        <?php
        foreach ($menus as $menu) {
            ?>
            <li class="<?php echo $menu['css_class']; ?>"><fkey><?php echo $menu['menu_fkey']; ?></fkey> 
            <?php echo CHtml::link($menu['menu_name'], array($menu['menu_link'])); ?></li>
            <?php }
        ?>
    <li class="logout"><fkey>F12</fkey> <a href="index.php?r=site/logout">Logout</a></li>    
    </ul>
</div>


