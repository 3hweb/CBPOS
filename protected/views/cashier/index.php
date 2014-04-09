<script type="text/javascript">
$(document).ready(function(){
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
    <div style="overflow-y: scroll;height: 450px;width: 400px;">
        <p style="text-align: center;">
            <?php echo ReferenceInfoController::$NAME; ?>
            <br />
            <?php echo ReferenceInfoController::$ADDRESS; ?>
            <br />
            TIN: <?php echo ReferenceInfoController::$TIN; ?>
        </p>
        <p>
            DATE : <?php echo date('d F Y h:i A'); ?> <br />
            Terminal : <?php echo ''; ?> <br /> 
            Cashier :  <?php echo ''; ?> <br />
        </p>
        <table id="tblReceiptInfo" style="text-align: center;">
            <thead>
                <tr>
                    <th style="padding: 20px;"></th>
                    <th style="padding: 20px;">Item</th>
                    <th style="padding: 20px;">Qty</th>
                    <th style="padding: 20px;">Price</th>
                    <th style="padding: 20px;">Amount</th>
                </tr>
            </thead>
        </table>
        <hr size="20%"/>
        <p>
            This serves as an official receipt
        </p>
    </div>
    <div style="margin-top: 50px; position: absolute;">
        <?php
        echo TbHtml::buttonGroup(array(
                        array('label' => 'DINE-IN'),
                        array('label' => 'TAKEOUT'),
                        array('label' => 'DELIVERY'),
                        array('label' => 'BULK ORDER'),
                    ), array('toggle' => TbHtml::BUTTON_TOGGLE_RADIO, 
                        'color' => TbHtml::BUTTON_COLOR_PRIMARY));
        ?>
        <?php 
//            echo "DINE-IN ".TbHtml::radioButton("optDineIn",array('toggle' => TbHtml::BUTTON_TOGGLE_RADIO, 
//                        'color' => TbHtml::BUTTON_COLOR_PRIMARY));
//            echo '&nbsp&nbsp';
//            echo "TAKEOUT ".TbHtml::radioButton("optTakeout",array());
//            echo '&nbsp&nbsp';
//            echo "DELIVERY ".TbHtml::radioButton("optDelivery",array());
//            echo '&nbsp&nbsp';
//            echo "BULK ORDER ".TbHtml::radioButton("optBulkOrder",array());
//            echo '&nbsp&nbsp';
        ?>
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
<div style="margin: 500px 0 0 400px; float: right; position: absolute;">
    <h3>Menu Groups</h3>
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
                                        )
                           );
        echo '&nbsp&nbsp&nbsp';
        echo TbHtml::button('CANCEL',array('color'=>  TbHtml::BUTTON_COLOR_PRIMARY, 
                                         'size'=>  TbHtml::BUTTON_SIZE_LARGE,
                                         'image'=>  TbHtml::IMAGE_TYPE_ROUNDED
                                        )
                           );
        echo '&nbsp&nbsp&nbsp';
        echo TbHtml::button('HOLD',array('color'=>  TbHtml::BUTTON_COLOR_PRIMARY, 
                                         'size'=>  TbHtml::BUTTON_SIZE_LARGE,
                                         'image'=>  TbHtml::IMAGE_TYPE_ROUNDED
                                        )
                           );
        echo '&nbsp&nbsp&nbsp';
        echo TbHtml::button('REPRINT',array('color'=>  TbHtml::BUTTON_COLOR_PRIMARY, 
                                         'size'=>  TbHtml::BUTTON_SIZE_LARGE,
                                         'image'=>  TbHtml::IMAGE_TYPE_ROUNDED
                                        )
                           );
        echo '&nbsp&nbsp&nbsp';
        echo TbHtml::button('SEARCH',array('color'=>  TbHtml::BUTTON_COLOR_PRIMARY, 
                                         'size'=>  TbHtml::BUTTON_SIZE_LARGE,
                                         'image'=>  TbHtml::IMAGE_TYPE_ROUNDED
                                        )
                           );
        echo '&nbsp&nbsp&nbsp';
    ?>
</div>   
