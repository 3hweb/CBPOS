/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


ajaxCall = function(a){
    jQuery.ajax({
        // The url must be appropriate for your configuration;
        // this works with the default config of 1.1.11
        url: 'index.php?r=cashier/ajaxProcessor',
        type: "POST",
        data: {
            ajaxData: a
        },  
        error: function(xhr,tStatus,e){
            if(!xhr){
                alert(tStatus+"   "+e.message);
            }else{
                alert("else: "+e.message); // the great unknown
            }
        },
        success: function(response){
            $.each(response, function(a, b){
               alert(b); 
            });
        }
    });
};

displayMenu = function(itemName, price, id){
      $('#txtMenuItem').val(itemName);
      $('#txtPrice').val(parseFloat(price));
      $('#txtMenuId').val(id);
      $('#txtQuantity').val("");
};

addToList = function(){
    var a = 'et';
    $("#LoadingImage").show();
    jQuery.ajax({
        // The url must be appropriate for your configuration;
        // this works with the default config of 1.1.11
        url: 'index.php?r=cashier/addOrderToList',
        type: "POST",
        data: $('#frmModalDialog').serialize()
            //quantity: function(){ return $('#txtQuantity').val();}
            
        ,  
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
                
                
            });
             
            $("#LoadingImage").hide();
        }
    });
};

saveRecord = function(){
    jQuery.ajax({
        // The url must be appropriate for your configuration;
        // this works with the default config of 1.1.11
        url: 'index.php?r=cashier/saveRecord',
        type: "POST",
        data: {
            txtReceiptNo: function(){ return $('#txtReceiptNo').val();},
            txtTotalAmt: function(){return $('#txtTotalAmt').val();},
            txtSubTotal: function(){return $('#txtSubTotal').val();},
            txtVatAmt: function(){return $('#txtVatAmt').val();}
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
            $('#tblReceiptInfo').html("");
            $('#lblReceipt').text("");
            $('#txtReceiptNo').val("");
            $('#lblTotalAmt').text("");
            $('#txtTotalAmt').val("");
                
            $('#lblSubTotal').text("");
            $('#txtSubTotal').val("");
                
            $('#lblVatAmount').text("");
            $('#txtVatAmount').val("");
            $("#LoadingImage").hide();
        }
    });
};

displayPaymentData = function(){
    if($('#txtReceiptNo').val() != ""){
        jQuery.ajax({
            // The url must be appropriate for your configuration;
            // this works with the default config of 1.1.11
            url: 'index.php?r=cashier/getPaymentTypes',
            type: "POST",
            data: {
                ajaxData: "test"
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

$('#txtCashTendered').live('keyup',function(){
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