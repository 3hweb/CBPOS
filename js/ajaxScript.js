/* 
 * Contains the javascript used for cashier module
 */

displayMenu = function(itemName, price, id){
      $('#txtMenuItem').val(itemName);
      $('#txtPrice').val(parseFloat(price));
      $('#txtMenuId').val(id);
      $('#txtQuantity').val("");
};

addToList = function(){
    $("#LoadingImage").show();
    jQuery.ajax({
        url: 'index.php?r=cashier/addOrderToList',
        type: "POST",
        data: $('#frmModalDialog').serialize(),  
        dataType:'json',
        error: function(xhr,tStatus,e){
            $("#LoadingImage").hide();
            if(!xhr){
                alert(tStatus+"   "+e.message);
            }else{
                alert("else: "+e.message); // the great unknown
            }
        },
        success : function(data){
            var tblRow = "<thead>"
                            +"<tr>"
                            +"<th style='padding: 10px;width:30px;'>Item</th>"
                            +"<th style='padding: 10px;'>Qty</th>"
                            +"<th style='padding: 10px;'>Price</th>"
                            +"<th style='padding: 10px;'>Amount</th>"
                            +"</tr>"
                            +"</thead>";

            $.each(data, function(i,user){      
                
                tblRow +=
                "<tbody>"
                +"<tr>"
                +"<td style='padding: 10px;'>"+this.MenuItemName+"</td>"
                +"<td style='padding: 10px;'>"+this.Quantity+"</td>"
                +"<td style='padding: 10px;'>"+this.MenuItemPrice+"</td>"
                +"<td style='padding: 10px;'>"+this.Amount+"</td>"
                +"</tr>"
                +"<tr><th colspan=4><label style='font-style: italic;width: 120px;font-size: 10px;'>"+this.ItemNote+"</label></th></tr>"
                +"</tbody>";
                
                $('#tblReceiptInfo').html(tblRow);
                
                $('#lblTotalAmt').text(this.TotalAmount);
                $('#txtTotalAmt').val(this.TotalAmount);
                
                $('#lblSubTotal').text(this.SubTotalAmount);
                $('#txtSubTotal').val(this.SubTotalAmount);
                
                $('#lblVatAmount').text(this.VatAmount);
                $('#txtVatAmt').val(this.VatAmount);
                
                $('#lblReceipt').text(this.InvoiceNo);
                $('#txtReceiptNo').val(this.InvoiceNo); 
                
                $("#lblLessVat").text(this.VatExemptAmount);
                $("#txtLessVat").val(this.VatExemptAmount);
                
                $("#lblDiscType").text(this.DiscountName);
                
                $("#lblDiscAmt").text("("+this.DiscountAmount+")");
                $("#txtDiscAmt").val(this.DiscountAmount);
            });
            $("#LoadingImage").hide();
        }
    });
};

saveRecord = function(){
    jQuery.ajax({
        url: 'index.php?r=cashier/saveRecord',
        type: "POST",
        data: {
            txtReceiptNo: function(){ return $('#txtReceiptNo').val();},
            txtTotalAmt: function(){return $('#txtTotalAmt').val();},
            txtSubTotal: function(){return $('#txtSubTotal').val();},
            txtVatAmt: function(){return $('#txtVatAmt').val();},
            txtCashTendered: function(){return $('#txtCashTendered').val()},
            txtCashChange: function(){return $("#txtCashChange").val()},
            paymentType: function(){return $('#txtTransPayment').val()},
            dineType: function(){return $('#txtTransType').val()},
            txtDiscAmt: function(){ return $('#txtDiscAmt').val()},
            txtTableNum: function(){return $('#txtTableNum').val()}
        },  
        dataType:'json',
        error: function(xhr,tStatus,e){
            $("#LoadingImage").hide();
            if(!xhr){
                alert(tStatus+"   "+e.message);
            }else{
                alert("else: "+e.message); // the great unknown
            }
        },
        success : function(data){
            //Call the print receipt function three times
            printReceipt(0);
           // printReceipt(0); 
           // printReceipt(0); 
            alert(data.message);
            clearTrans();
        }
    });
};

displayPaymentData = function(){
    $("#txtCashTendered").val("");
    $("#txtCashChange").val("");
    
    //Dine-In Type is selected default when saving the transaction
    $('#dineinType').addClass('active');
    $('#takeoutType').removeClass('active');
    $('#deliverType').removeClass('active');
    $('#bulkType').removeClass('active');
    $("#txtTransType").val("DINE-IN");
    
    //Cash Type is selected default when saving the transaction
    $('#cashType').addClass('active');
    $('#cardType').removeClass('active');
    $('#txtTransPayment').val("CASH");
    
    if($('#txtReceiptNo').val() != ""){
        jQuery.ajax({
            url: 'index.php?r=cashier/getPaymentTypes',
            type: "POST",
            data: {},  
            dataType:'json',
            error: function(xhr,tStatus,e){
                $("#LoadingImage").hide();
                if(!xhr){
                    alert(tStatus+"   "+e.message);
                }else{
                    alert("else: "+e.message); // the great unknown
                }
            },
            success : function(data){
                $("#cmbPayments").empty();
                var payment = $("#cmbPayments");
                payment.append($("<option />").val(0).text("Please Select"));
                $.each(data, function(i,user){      
                    payment.append($("<option />").val(this.PaymentTypeId).text(this.PaymentTypeName));
                });
                $("#LoadingImage").hide();
            }
        });  
    } else {
        alert("No active transaction.");
        window.location.reload();
    }
};

$('#txtCashTendered').live('keypress',function(){
    var cashTendered = $(this).val();
    var totalAmount = $('.txtTotalAmtSave').val();
    
    cashTendered = cashTendered.replace(/,/g,"");
    totalAmount = totalAmount.replace(/,/g,"");
    
    var changeAmount = cashTendered - totalAmount;
    
    if(eval(changeAmount) >= 0){
        changeAmount = commaFormat(changeAmount);
    } else {
        changeAmount = 'N/A';
    }
     
    $('#txtCashChange').val(changeAmount);  
});


commaFormat = function(num)
{
    num = num.toString().replace(/\$|\,/g,'');
    if(isNaN(num))
        num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num*100+0.50000000001);
    cents = num%100;
    num = Math.floor(num/100).toString();
    if(cents<10)
        cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
        num = num.substring(0,num.length-(4*i+3))+','+ num.substring(num.length-(4*i+3));
    return (((sign)?'':'-') + num + '.' + cents);
};

identifyTransType = function(transType){
    $("#txtTransType").val(transType);
};

identifyTransPayment = function(transPayment){
    $("#txtTransPayment").val(transPayment);
};

cancelTransaction = function(){
    jQuery.ajax({
        url: 'index.php?r=cashier/modifyTransaction',
        type: "POST",
        data: {
            txtReceiptNo: function(){ return $('#txtReceiptNo').val();},
            isTransactionCancel: function(){ return 1;}
        },  
        dataType:'json',
        error: function(xhr,tStatus,e){
            $("#LoadingImage").hide();
            if(!xhr){
                alert(tStatus+"   "+e.message);
            }else{
                alert("else: "+e.message); // the great unknown
            }
        },
        success : function(data){
            alert(data.message);
            clearTrans();
        }
    });
};

holdTransaction = function(){
    jQuery.ajax({
        url: 'index.php?r=cashier/modifyTransaction',
        type: "POST",
        data: {
            txtReceiptNo: function(){ return $('#txtReceiptNo').val();},
            isTransactionCancel: function(){ return 0;}
        },  
        dataType:'json',
        error: function(xhr,tStatus,e){
            $("#LoadingImage").hide();
            if(!xhr){
                alert(tStatus+"   "+e.message);
            }else{
                alert("else: "+e.message); // the great unknown
            }
        },
        success : function(data){
            alert(data.message);
            clearTrans();
        }
    });
};

clearTrans = function(){
    $('#tblReceiptInfo').html("");
    $('#tblPendingTrans').html("");
    $('#lblReceipt').text("");
    $('#txtReceiptNo').val("");
    $('#lblTotalAmt').text("");
    $('#txtTotalAmt').val("");
                
    $('#lblSubTotal').text("");
    $('#txtSubTotal').val("");
                
    $('#lblVatAmount').text("");
    $('#txtVatAmount').val("");
    
    $('#lblLessVat').text("");
    $('#txtLessVat').val("");
    
    $('#lblDiscType').text("");
    
    $('#lblDiscAmt').text("");
    $('#txtDiscAmt').val("");
    
    $("#LoadingImage").hide();
};

displayPendingInvoice = function(){
    $('#tblPendingTrans').html("");
    jQuery.ajax({
        url: 'index.php?r=cashier/getPendingInvoice',
        type: "POST",
        data: {},  
        dataType:'json',
        error: function(xhr,tStatus,e){
            $("#LoadingImage").hide();
            if(!xhr){
                alert(tStatus+"   "+e.message);
            }else{
                alert("else: "+e.message); // the great unknown
            }
        },
        success : function(data){
            var tblRow = "<thead>"
                            +"<tr>"
                            +"<th>Invoice No.</th>"
                            +"</tr>"
                            +"</thead>";

            $.each(data, function(i,user){      
                tblRow +=
                "<tbody>"
                +"<tr>"
                +"<td><a onclick='reloadTransaction("+this.InvoiceNo+");' \n\
                         style='cursor:pointer;'>"+this.InvoiceNo+"</a></td>"
                +"</tr>"
                +"</tbody>";
                
                $('#tblPendingTrans').html(tblRow);
            });
            $("#LoadingImage").hide();
        }
    });
};

reloadTransaction = function(invoiceNo){
    $("#LoadingImage").show();
    $('#tblReceiptInfo').html("");
    jQuery.ajax({
        url: 'index.php?r=cashier/getPendingTransaction',
        type: "POST",
        data: {txtReceiptNo: function(){ return invoiceNo;}},  
        dataType:'json',
        error: function(xhr,tStatus,e){
            $("#LoadingImage").hide();
            if(!xhr){
                alert(tStatus+"   "+e.message);
            }else{
                alert("else: "+e.message); // the great unknown
            }
        },
        success : function(data){
            var tblRow = "<thead>"
                            +"<tr>"
                            +"<th style='padding: 10px;width:30px;'>Item</th>"
                            +"<th style='padding: 10px;'>Qty</th>"
                            +"<th style='padding: 10px;'>Price</th>"
                            +"<th style='padding: 10px;'>Amount</th>"
                            +"</tr>"
                            +"</thead>";

            $.each(data, function(i,user){      
                
                tblRow +=
                "<tbody>"
                +"<tr>"
                +"<td style='padding: 10px;'>"+this.MenuItemName+"</td>"
                +"<td style='padding: 10px;'>"+this.Quantity+"</td>"
                +"<td style='padding: 10px;'>"+this.MenuItemPrice+"</td>"
                +"<td style='padding: 10px;'>"+this.Amount+"</td>"
                +"</tr>"
                +"</tbody>";
                
                $('#tblReceiptInfo').html(tblRow);
                
                $('#lblTotalAmt').text(this.TotalAmount);
                $('#txtTotalAmt').val(this.TotalAmount);
                
                $('#lblSubTotal').text(this.SubTotalAmount);
                $('#txtSubTotal').val(this.SubTotalAmount);
                
                $('#lblVatAmount').text(this.VatAmount);
                $('#txtVatAmt').val(this.VatAmount);
                
                $('#lblReceipt').text(this.InvoiceNo);
                $('#txtReceiptNo').val(this.InvoiceNo); 
                
                $("#lblLessVat").text(this.VatExemptAmount);
                $("#txtLessVat").val(this.VatExemptAmount);
                
                $("#lblDiscType").text(this.DiscountName);
                
                $("#lblDiscAmt").text(this.DiscountAmount);
                $("#txtDiscAmt").val(this.DiscountAmount);
            });
            
            $("#LoadingImage").hide();
            $("#btnSearchClose").trigger('click');
        }
    });
};

printReceipt = function(isReprint){
    $.ajax({
        url : 'index.php?r=cashier/printReceipt',
        type : 'post',
        data : {isReprint : function(){return isReprint;},
                invoiceNo : function() {return $('#txtReceiptNo').val();}
        },
        dataType : 'html',
        error: function(xhr,tStatus,e){
            $("#LoadingImage").hide();
            if(!xhr){
                alert(tStatus+"   "+e.message);
            }else{
                alert("else: "+e.message); // the great unknown
            }
        },
        success : function(data){
            var qz = document.getElementById('qz');
            qz.appendHtml(fixHtml(""+data+""));
            qz.printHtml();
        }
    });
};
              
fixHtml = function(html) {
    return html.replace(/ /g, "&nbsp;").replace(/�/g, "'").replace(/&dash;/g, "-");
};

displayAvailableDiscounts = function(){
    var invoiceNo = $('#txtReceiptNo').val();
    
    if(invoiceNo == 0){
        alert("Get Discounts: No active transaction.");
        window.location.reload();
    } else {
        $.ajax({
            url : 'index.php?r=cashier/getDiscounts',
            type : 'post',
            data : {
                invoiceNo : function(){
                    return invoiceNo;
                }
            },
            dataType : 'json',
            error: function(xhr,tStatus,e){
                $("#LoadingImage").hide();
                if(!xhr){
                    alert(tStatus+"   "+e.message);
                }else{
                    alert("else: "+e.message); // the great unknown
                }
            },
            success : function(data){
                var discountOptions;
                $("#applyDiscount").empty();
                $.each(data, function(x, y){
                    discountOptions = "<a class='btn btn-primary' href='#' onclick='identifyDiscountId("+this.discount_id+")'>"+this.discount_name+"</a>";
                    $("#applyDiscount").append(discountOptions);
                });
                $("#applyDiscount").append("</div>");
            }
        });   
    }
};

identifyDiscountId = function(discountId){
    $("#txtDiscount").val(discountId);
}

applyDiscount = function(){
    var invoiceNo = $('#txtReceiptNo').val();
    $.ajax({
        url : 'index.php?r=cashier/applyDiscount',
        type : 'post',
        data : {
            invoiceNo : function(){ return invoiceNo;},
            discountId : function(){return $("#txtDiscount").val(); }
        },
        dataType : 'json',
        error: function(xhr,tStatus,e){
            $("#LoadingImage").hide();
            if(!xhr){
                alert(tStatus+"   "+e.message);
            }else{
                alert("else: "+e.message); // the great unknown
            }
        },
        success : function(data){
            alert(data);
            reloadTransaction(invoiceNo);
        }
    });
};