var code_ajax = $("#code_ajax").val();
var pageno = 1;
var rowno = 0;

$(document).ready(function() {
    getBrand(pageno, rowno);
	
	$("#add_payment_btn").click(function (event) {
        event.preventDefault();

        var transection_id = $('#transection_id').val();
        var user_id = $('#user_id').val();
        var paymant_id = $('#paymant_id').val();
        var invoice_proof = $('#invoice_proof').val();

        if (!transection_id) {
            successmsg("Please Enter Transection Id");
        } else


            if (transection_id) {
                $.busyLoadFull("show");
                var file_data = $('#invoice_proof').prop('files')[0];
                var form_data = new FormData();
                form_data.append('invoice_proof', file_data);
                form_data.append('transection_id', transection_id);
                form_data.append('user_id', user_id);
                form_data.append('paymant_id', paymant_id);
                form_data.append('code', code_ajax);

                $.ajax({
                    method: 'POST',
                    url: 'add_wallet_payment_process.php',
                    data: form_data,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $.busyLoadFull("hide");
                        $("#myModal").modal('hide');
                        $('#transection_id').val('');
                        $('#invoice_proof').val('');
                        successmsg(response);
						//location.href = "wallet_withdrow_list.php";
                    }
                });
            }

    });

	
}); 


function getBrand(pagenov, rownov) {
	 showloader();
    var perpage = $('#perpage').val();
    // successmsg( "sdfs" );
    var count = 1;
    $.ajax({
        method: 'POST',
        url: 'get_wallet_withdrow_list.php',
        data: {
            code: code_ajax,
            page: pagenov,
            rowno: rownov,
            perpage: perpage
        },
        success: function(response) {
            hideloader();
            var parsedJSON = $.parseJSON(response);
            $("#cat_list").empty();           

            $("#totalrowvalue").html(parsedJSON["totalrowvalue"]);
            $(".page_div").html(parsedJSON["page_html"]);
			
			var data = parsedJSON.data;
            $(data).each(function() {
				var  btnactive ="";
                
				var html = '<tr id="tr' + this.id + '"> <td>' + count + '</td><td > ' + this.name + '</td><td > ' +this.amount + '</td><td > ' +this.add_date + '</td>';
				
				
				 if (this.payment_status == '') {
                        html += '<td class="Pending">Pending</td><td>' + this.transection_id + '</td><td style="width:50px;"><button type="submit"  class= "btn btn-danger waves-effect waves-light btn-sm pull-left open-modal" target="_blank" data-upi_id="'+ this.upi_id +'" data-pay_id="' + this.id + '" data-id="' + this.user_id + '" data-toggle="modal" data-target="#myModal">Pay</button></td></tr>';

                    } else if(this.payment_status == 'Paid') {

                        html += '<td class="Active">Paid</td><td>' + this.transection_id + '</td><td></td></tr> ';
                    }
					
				
                
                $("#cat_list").append(html);

                count = count + 1;
            });



        }
    });
}


function brand_product(pagenov) {
	 showloader();
    var perpage = $('#perpage').val();
    // successmsg( "sdfs" );
    var count = 1;
    $.ajax({
        method: 'POST',
        url: 'get_wallet_withdrow_list.php',
        data: {
            code: code_ajax,
            page: pagenov,
            rowno: 0,
            perpage: perpage
        },
        success: function(response) {
             hideloader();
            var parsedJSON = $.parseJSON(response);
            $("#cat_list").empty();           

            $("#totalrowvalue").html(parsedJSON["totalrowvalue"]);
            $(".page_div").html(parsedJSON["page_html"]);
			
			var data = parsedJSON.data;
            $(data).each(function() {
				
			 var html = '<tr id="tr' + this.id + '"> <td>' + count + '</td><td > ' + this.name + '</td><td > ' +this.amount + '</td><td > ' +this.add_date + '</td>';
				
				
				 if (this.payment_status == '') {
                        html += '<td class="Pending">Pending</td><td>' + this.transection_id + '</td><td style="width:50px;"><button type="submit"  class= "btn btn-danger waves-effect waves-light btn-sm pull-left open-modal" target="_blank" data-upi_id="'+ this.upi_id +'" data-pay_id="' + this.id + '" data-id="' + this.user_id + '" data-toggle="modal" data-target="#myModal">Pay</button></td></tr>';

                    } else if(this.payment_status == 'Paid') {

                        html += '<td class="Active">Paid</td><td>' + this.transection_id + '</td><td></td></tr> ';
                    }

				                
                $("#cat_list").append(html);

                count = count + 1;
            });



        }
    });
}




function perpage_filter() {
	showloader();
    var perpage = $('#perpage').val();
    // successmsg( "sdfs" );
    var count = 1;
    $.ajax({
        method: 'POST',
        url: 'get_wallet_withdrow_list.php',
        data: {
            code: code_ajax,
            page: 1,
            rowno: 0,
            perpage: perpage
        },
        success: function(response) {
            hideloader();
            var parsedJSON = $.parseJSON(response);
            $("#cat_list").empty();
            

            $("#totalrowvalue").html(parsedJSON["totalrowvalue"]);
            $(".page_div").html(parsedJSON["page_html"]);
			
			var data = parsedJSON.data;
            $(data).each(function() {
               var  btnactive ="";
			   var html = '<tr id="tr' + this.id + '"> <td>' + count + '</td><td > ' + this.name + '</td><td > ' +this.amount + '</td><td > ' +this.add_date + '</td>';
				
				
				 if (this.payment_status == '') {
                        html += '<td class="Pending">Pending</td><td>' + this.transection_id + '</td><td style="width:50px;"><button type="submit"  class= "btn btn-danger waves-effect waves-light btn-sm pull-left open-modal" target="_blank" data-upi_id="'+ this.upi_id +'" data-pay_id="' + this.id + '" data-id="' + this.user_id + '" data-toggle="modal" data-target="#myModal">Pay</button></td></tr>';

                    } else if(this.payment_status == 'Paid') {

                        html += '<td class="Active">Paid</td><td>' + this.transection_id + '</td><td></td></tr> ';
                    }
                $("#cat_list").append(html);
                count = count + 1;
            });
		}
    });
}

	
	
	
	