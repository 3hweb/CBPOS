<script type="text/javascript">
$(document).ready(function(){
        $(':text').val("");
	function showLoader(){
		$('.search-background').fadeIn(200);
	}
	function hideLoader(){
	
		$('.search-background').fadeOut(200);
	};
	
	$("#paging_button li").click(function(){
		
		showLoader();
		
		$("#paging_button li").css({'background-color' : ''});
		$(this).css({'background-color' : '#006699'});

		$("#content").load("index.php?r=cashier/itemMenuResults&page=" +this.id, hideLoader);
		
		return false;
	});
	
	$("#1").css({'background-color' : '#006699'});
	showLoader();
	$("#content").load("index.php?r=cashier/itemMenuResults&page=1", hideLoader);
        $('#slider1').tinycarousel();
});
</script>

<?php 
    $this->renderPartial('widgetMenuDisplay');
             
    $this->renderPartial('widgetTransSave');

    $this->renderPartial('widgetTransCancel');

    $this->renderPartial('widgetTransHold');

    $this->renderPartial('widgetTransSearch');
    
    $this->renderPartial('widgetDiscount');
?>

<div id="LoadingImage" style="display: none;">
    <img src="css/loader.gif" alt="Please wait while processing" />
</div>

<div id="header">
    <div id="logo" style="float: left; visibility: hidden;">
        <img src="images/logo.png" alt="chicboy"/>
    </div>
    <!--SEARCH BUTTON-->
    <div style="float: left;margin: 30px 0 0 170px; position: relative;">
        <?php
            echo TbHtml::textField("txtSearch");
            echo '&nbsp;';
            echo TbHtml::button("SEARCH", array('color'=>  TbHtml::BUTTON_COLOR_PRIMARY, 
                                         'size'=>  TbHtml::BUTTON_SIZE_DEFAULT,
                                         'image'=>  TbHtml::IMAGE_TYPE_ROUNDED
                                        ));
        ?>
    </div>
</div>
<br />

<!--RECEIPT INFORMATION-->
<div id="sidebar" style="margin-top: 180px; float: left; position: absolute; margin-left: -50px;">
    <?php $this->renderPartial('widgetReceiptInfo',array('cashierName'=>$accountName)); ?>
</div>

<!--PAGING CONTENT-->
<div id="container"  class="span-16" style="margin: 80px 0 0 400px; float: left; position: absolute;">
    <div class="search-background">
        <label><img src="css/loader.gif" alt="" /></label>
    </div>
    <div id="content">
        &nbsp;
    </div>        
</div>

<!--PAGING BUTTON-->
<div id="paging_button" style="margin: 452px 0 0 440px; float: right; position: absolute;">
    <ul>
        <?php
        //Show page links
        for ($i = 1; $i <= $pages; $i++) {
            echo '<li id="' . $i . '">' . $i . '</li>';
        }
        ?>
    </ul>
</div>
<div class="clear"></div>

<!--MENU GROUPS DIV -->
<div style="margin: 515px 0 0 390px; ">
<!--    <div id="slider1">
        <a class="buttons prev" href="#">&#60;</a>
        <div class="viewport">
            <ul class="overview">
                <?php
//                  foreach($menuGroupResult as $val){
//                  $menuGrpId = $val['menu_group_id'];
//                  $menuGrpName = $val['menu_group_name'];
//
//                  echo '<li>';
//                  echo TbHtml::label($menuGrpName, "", array(
//                        'style' => 'height:100px; width:210px; cursor: pointer;
//                        font-size: 25px;text-wrap: normal;background-color: blue;
//                        background-color: #FFD324;padding-top: 10px;',
//                    ));
//                  echo '</li>';
////                  echo '<li><input type="radio" id='.trim($menuGrpId).' name='.trim($menuGrpId).' value='.$menuGrpId.' /> '.$menuGrpName.'</li>';
////                  echo '&nbsp&nbsp';
//                  }
                 
                ?>
            </ul>
        </div>
        <a class="buttons next" href="#">&#62;</a>
    </div>-->
</div>   

<!--MAIN BUTTONS-->
<div style="margin-left: -50px; margin-top: 150px; position: absolute; float: left;">
    <?php $this->renderPartial("widgetMainButtons"); ?>
</div>   
