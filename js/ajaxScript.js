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
                            +"<th>Item</th>"
                            +"<th>Qty</th>"
                            +"<th>Price</th>"
                            +"<th>Amount</th>"
                            +"</tr>"
                            +"</thead>";

            $.each(data, function(i,user){      
                
                tblRow +=
                "<tbody>"
                +"<tr>"
                +"<td align='left'>test item</td>"
                +"<td align='left'>test qty</td>"
                +"<td align='left'>test price</td>"
                +"<td align='left'>test address</td>"
                +"</tr>"
                +"</tbody>";
                
                $('#tblReceiptInfo').html(tblRow);
            });
            $("#LoadingImage").hide();
        }
    });
};