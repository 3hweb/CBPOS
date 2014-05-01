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
    echo TbHtml::button('APPLY DISCOUNT',array('color'=>  TbHtml::BUTTON_COLOR_PRIMARY, 
                                     'size'=>  TbHtml::BUTTON_SIZE_LARGE,
                                     'image'=>  TbHtml::IMAGE_TYPE_ROUNDED,
                                     'onclick'=>'',
                                     'data-toggle'=>'modal',
                                     'data-target'=>'#modalApplyDiscount'
                                    )
                       );
    echo '&nbsp&nbsp&nbsp';
?>
