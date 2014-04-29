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
        
        $('.multiple-items').slick({
            autoplay: false, // Enables auto play of slides
            accessibility: true, // Enables tabbing and arrow key navigation
            cssEase: 'ease', // CSS3 easing
            easing: 'linear', // animate() fallback easing
            pauseOnHover: true, // Pauses autoplay on hover
            autoplaySpeed: 3000, // Auto play change interval
            dots: false, // Current slide indicator dots
            draggable: true, // Enables mouse drag
            arrows: true, // Next/Prev arrows
            fade: false, // Enables fade
            infinite: true, // Infinite looping
            onBeforeChange: null, // Before slide change callback
            onAfterChange: null, // After slide change callback
            responsive: null, // Breakpoint triggered settings
            slide: 'div', // Slide element query
            slidesToShow: 1, // # of slides to show at a time
            slidesTo: 3, // # of slides to scroll at a time
            speed: 300, // Transition speed
            swipe: true, // Enables touch swipe
            touchMove: true, // Enables slide moving with touch
            touchThreshold: 5 // Swipe distance threshold
        });	
});
</script>
<div id="LoadingImage" style="display: none;">
    <img src="css/loader.gif" alt="Please wait while processing" />
</div>

<div id="header">
    <div id="logo" style="float: left;">
        <img src="images/logo.png" alt="chicboy"/>
    </div>
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
<div id="sidebar" style="margin-top: 180px; float: left; position: absolute; margin-left: -50px;">
    <div style="overflow-y: scroll;height: 550px;width: 400px;">
        <p style="text-align: center;">
            <?php echo ReferenceInfoController::$NAME; ?>
            <br />
            <?php echo ReferenceInfoController::$ADDRESS; ?>
            <br />
            TIN: <?php echo ReferenceInfoController::$TIN; ?>
        </p>
        <p>
            DATE : <?php echo date('d F Y h:i A'); ?> <br />
            Terminal : <?php echo 'Terminal 1'; ?> <br /> 
            Cashier :  <?php echo 'Juan Dela Cruz'; ?> <br />
        </p>
        <table id="tblReceiptInfo" style="text-align: right;margin-left: 60px;word-break: normal;">
            
        </table>
        <hr size="20%"/>
        <table style="text-align: right;margin-left: 70px;word-break: normal;">
            <tr>
                <td>Total (VAT Inclusive)</td>
                <td style='padding-left: 50px;'>
                    <label id="lblTotalAmt"></label>
                    <?php echo TbHtml::hiddenField("txtTotalAmt");?>
                </td>
            </tr>
            <tr>
                <td>Subtotal (12% VAT)</td>
                <td style='padding-left: 50px;'>
                    <label id="lblSubTotal"></label>
                    <?php echo TbHtml::hiddenField("txtSubTotal");?>
                </td>
            </tr>
            <tr>
                <td>VAT Amount</td>
                <td style='padding-left: 50px;'>
                    <label id="lblVatAmount"></label>
                    <?php echo TbHtml::hiddenField("txtVatAmt");?>
                </td>
            </tr>
        </table>
        <hr size="20%"/>
        <table>
            <tr>
                <td>Cash Tendered</td>
                <td>
                    <label id="lblCashTendered"></label>
                    <?php echo TbHtml::hiddenField("txtCashTendered");?>
                </td>
            </tr>
            <tr>
                <td>Cash Changed</td>
                <td>
                    <label id="lblCashChanged"></label>
                    <?php echo TbHtml::hiddenField("txtCashChanged");?>
                </td>
            </tr>
        </table>
        <hr size="20%"/>
        <p>Receipt # : <label id="lblReceipt"></label> 
           <?php echo TbHtml::hiddenField("txtReceiptNo"); ?>
        </p>
        <br />
        <p>
            This serves as an official receipt
        </p>
    </div>
</div>

<div id="container"  class="span-16" style="margin: 80px 0 0 400px; float: left; position: absolute;">
    <div class="search-background">
        <label><img src="css/loader.gif" alt="" /></label>
    </div>
                
    <div id="content">
        &nbsp;
    </div>        
</div>
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
<div style="margin: 550px 0 0 400px; float: right; position: absolute;">
<!--    <div> Slide  1 </div>
    <div> Slide  2 </div>
    <div> Slide  3 </div>-->
    <?php 
        foreach($menuGroupResult as $val){
            $menuGrpId = $val['menu_group_id'];
            $menuGrpName = $val['menu_group_name'];
            
            echo '<input type="radio" id='.trim($menuGrpId).' name='.trim($menuGrpId).' value='.$menuGrpId.' /> '.$menuGrpName.'';
            echo '&nbsp&nbsp';
        }
    ?>
    
</div>   
<div style="margin-left: 400px; margin-top: 670px; position: absolute; float: left;">
    <?php 
        echo TbHtml::button('SAVE',array('color'=>  TbHtml::BUTTON_COLOR_PRIMARY, 
                                         'size'=>  TbHtml::BUTTON_SIZE_LARGE,
                                         'image'=>  TbHtml::IMAGE_TYPE_ROUNDED,
                                         'onclick'=>'displayPaymentData();',
                                         'data-toggle' => 'modal',
                                         'data-target' => '#modalSave',
                                        )
                           );
        echo '&nbsp&nbsp&nbsp';
        echo TbHtml::button('CANCEL',array('color'=>  TbHtml::BUTTON_COLOR_PRIMARY, 
                                         'size'=>  TbHtml::BUTTON_SIZE_LARGE,
                                         'image'=>  TbHtml::IMAGE_TYPE_ROUNDED,
                                         'onclick'=>'',
                                         'data-toggle'=>'modal',
                                         'data-target'=>'#modalCancel'
                                        )
                           );
        echo '&nbsp&nbsp&nbsp';
        echo TbHtml::button('HOLD',array('color'=>  TbHtml::BUTTON_COLOR_PRIMARY, 
                                         'size'=>  TbHtml::BUTTON_SIZE_LARGE,
                                         'image'=>  TbHtml::IMAGE_TYPE_ROUNDED,
                                         'onclick'=>'',
                                         'data-toggle'=>'modal',
                                         'data-target'=>'#modalHold'
                                        )
                           );
        echo '&nbsp&nbsp&nbsp';
        echo TbHtml::button('REPRINT',array('color'=>  TbHtml::BUTTON_COLOR_PRIMARY, 
                                         'size'=>  TbHtml::BUTTON_SIZE_LARGE,
                                         'image'=>  TbHtml::IMAGE_TYPE_ROUNDED,
                                         'onclick'=>'printReceipt(1);'
                                        )
                           );
        echo '&nbsp&nbsp&nbsp';
        echo TbHtml::button('SEARCH',array('color'=>  TbHtml::BUTTON_COLOR_PRIMARY, 
                                         'size'=>  TbHtml::BUTTON_SIZE_LARGE,
                                         'image'=>  TbHtml::IMAGE_TYPE_ROUNDED,
                                         'onclick'=>'displayPendingInvoice();',
                                         'data-toggle'=>'modal',
                                         'data-target'=>'#modalSearch'
                                        )
                           );
        echo '&nbsp&nbsp&nbsp';
    ?>
</div>   
