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
                <?php echo TbHtml::hiddenField("txtTotalAmt"); ?>
            </td>
        </tr>
        <tr>
            <td>Subtotal (12% VAT)</td>
            <td style='padding-left: 50px;'>
                <label id="lblSubTotal"></label>
                <?php echo TbHtml::hiddenField("txtSubTotal"); ?>
            </td>
        </tr>
        <tr>
            <td>VAT Amount</td>
            <td style='padding-left: 50px;'>
                <label id="lblVatAmount"></label>
                <?php echo TbHtml::hiddenField("txtVatAmt"); ?>
            </td>
        </tr>
    </table>
    <hr size="20%"/>
    <table>
        <tr>
            <td>Cash Tendered</td>
            <td>
                <label id="lblCashTendered"></label>
                <?php echo TbHtml::hiddenField("txtCashTendered"); ?>
            </td>
        </tr>
        <tr>
            <td>Cash Changed</td>
            <td>
                <label id="lblCashChanged"></label>
                <?php echo TbHtml::hiddenField("txtCashChanged"); ?>
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