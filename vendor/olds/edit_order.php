<?php
include('session.php');
if(!isset($_SESSION['admin'])){
  header("Location: index.php");
}
 $ordersno = $_REQUEST['orderid'];
 $product_id = $_REQUEST['product_id'];
if(!$ordersno || !$product_id){
     header("Location: manage_orders.php");
}
include("header.php");


if(isset($_POST['orderstatus']) && $ordersno && $product_id){
	
	$orderstatus = $_POST['orderstatus'];
	$ordermessage = trim($_POST['ordermessage']);
	$sql_status = $conn->prepare("INSERT INTO `order_tracking_status`(`order_id`, `product_id`, `status`, `message`, `created_at`) VALUES (
					'".$ordersno."','".$product_id."','".$orderstatus."','".$ordermessage."','".$datetime."')");
	$sql_status->execute();
	$sql_status->store_result();
	$rows=$sql_status->affected_rows;
	
	
	$reverse_shipping = 0;
	if($orderstatus == 'Returned Completed')
	{
		$reverse_shipping = $Common_Function->get_system_settings($conn,'reverse_shipping');
	}
	
	$sql1 = $conn->prepare("UPDATE order_product SET status = '".$orderstatus."', status_date = '".$datetime."', update_date = '".$datetime."', reverse_shipping = '".$reverse_shipping."' WHERE order_id = '".$ordersno."' AND prod_id = '".$product_id."'");
	$sql1->execute();
	$sql1->store_result();
	
	if($rows>0){
		echo '<script>successmsg("Order Status updated successfully."); </script> ';
		//if($orderstatus =='Delivered'){
			$Common_Function->send_delivered_email_invoice_user($conn,$ordersno,$product_id,$_SESSION['admin'],$orderstatus);
		//}
	}
}

if(isset($_POST['delivery_date']) && $ordersno && $product_id){
	$delivery_date = trim($_POST['delivery_date']);
	$tracking_id = trim($_POST['tracking_id']);
	$tracking_url = trim($_POST['tracking_url']);
	
	$sql1 = $conn->prepare("UPDATE order_product SET delivery_date = '".$delivery_date."', tracking_id = '".$tracking_id."', tracking_url = '".$tracking_url."', update_date = '".$datetime."' WHERE order_id = '".$ordersno."'
							AND prod_id = '".$product_id."'");
	$sql1->execute();
	$sql1->store_result();
	
	echo '<script>successmsg("Order updated successfully."); </script> ';
	
}

if(isset($_POST['pickup_date']) && isset($_POST['pickup_status']) && $ordersno && $product_id){
	$pickup_date = trim($_POST['pickup_date']);
	$pickup_status = trim($_POST['pickup_status']);
	
	$sql1 = $conn->prepare("UPDATE order_product SET pickup_date = '".$pickup_date."', pickup_status = '".$pickup_status."', update_date = '".$datetime."' WHERE order_id = '".$ordersno."'
							AND prod_id = '".$product_id."'");
	$sql1->execute();
	$sql1->store_result();
	
	
	$sql_status = $conn->prepare("INSERT INTO `order_tracking_status`(`order_id`, `product_id`, `status`, `message`, `created_at`) VALUES (
					'".$ordersno."','".$product_id."','".$pickup_status."','','".$datetime."')");
	$sql_status->execute();
	$sql_status->store_result();
	$rows=$sql_status->affected_rows;
	
	echo '<script>successmsg("Order pickup status updated successfully."); </script> ';
	
}
 ?>
 


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>

$( function() {
    $( "#delivery_date1" ).datepicker({dateFormat:"yy-mm-dd"});
	
	
  } );
   
   
    $(document).ready(function(){       
		$("#updatetracking").click(function(event){
			event.preventDefault();
			var delivery_date1 = $("#delivery_date1").val();
			
			if(!delivery_date1){
				successmsg("Please select delivery date."); 
			}else{
				$("#myform_tracking").submit();
			}
		});
		
		
		$("#updatepickup").click(function(event){
			event.preventDefault();
			var delivery_date1 = $("#delivery_date1").val();
			var pickup_status = $("#pickup_status").val();
			
			if(!delivery_date1){
				successmsg("Please select pickup date."); 
			}else if(!pickup_status){
				successmsg("Please select pickup status."); 
			}else{
				$("#myform_tracking").submit();
			}
		});
    });
    
      function refreshdata(){   
	        var order_id = $('#sno_order').val();
                                                           
          //  alert("--"+order_id); 
             $.ajax({
              method: 'POST',
              url: 'edit_order_data.php',
              data: {
                code: "123",
                orderid: order_id
              },
              success: function(response){
                          //  alert(response); // display response from the PHP script, if any
                          //$('#msgdiv').val("subsdfa");
                         var data = $.parseJSON(response);
                        
                        if(data["status"]=="1"){
                              // alert("status "+data["deliveryid"]);
                               $('#orderidvalue').html(data["orderId"]);
                               $('#orderdate').html(data["orderdate"]);
                               $('#custname').html(data["username"]);
                                $('#custphonevalue').html(data["phone"]);
                                $('#custemailvalue').html(data["email"]);
                               $('#shipping').html(data["address"]);
                               $('#orderstatus').html(data["orderstatus"]);
                               $('#deliverymode').html(data["deliverymode"]);
                               $('#paymentid').html(data["paymentid"]);
                               $('#subtotal').html(data["subtotal"]);
                               $('#ship').html(data["ship"]);
                               $('#grandtotal').html(data["grandtotal"]);
                               $('#deliveryid').html(data["deliveryid"]);
                               $('#couriername').val(data["courier"]);
                               $('#trackingid').val(data["trackid"]);
                                 $('#coupancode').html(data["coupancode"]);
                             
                               
                               // add prod details
                               $("#tbodyPostid").empty();
                            var count =1;    	 
                               $(data["proddetails"]).each(function() {
                            		var btnstatus= '<button type = "button" class = "btn-alert">View</button>';
                                
                            	//	alert( "btn "+this.prodid);
                            		$("#tbodyPostid").append('<tr> <th style="display:none;"><input type="text" class="nrprodid" style="width:30px;" value="'+this.prodid+'"></input></th><th scope="row">'+count+'</th><td style="display:none;"><img   src='+this.img+' style="width: 121px; height: 72px;"></td><td class="dontprint">'+this.sellername+'</td><td>'+this.prodname+'</td> <td> '+this.otherart+'</td><td >'+this.price+'</td><td class="nrqtyorg">'+this.orgqty+'</td><td>'+this.cgst+'</td><td>'+this.sgst+'</td><td style="display:none;">'+this.ship+'</td><td>'+this.total+'</td><td style="color:red">'+this.prodstatus+'</td><td class="dontprint">'+btnstatus+'</td></tr> ');
                               	//	alert(this.orgqty);
                            			
                               	count = count+1
                            });
                            
                             $(".btn-alert").click(function() {
                                  var $row = $(this).closest("tr");    // Find the row
                                 var $text = $row.find(".nrprodid").val(); // Find the text
                                    viewProduct($text, "20");
                               // alert("prod ID "+$text); 
                               
                          
                            });
                         
                            
                        }else{
                            
                            
                        }
                        
         
                    }
            });
        }
        
</script>

		<!-- main content start-->
<?php
		$invoice_number = '';
		
		$query = $conn->query("SELECT invoice_number,status FROM `order_product` WHERE order_id = '".$ordersno."' AND prod_id = '".$product_id."' ");
		if($query->num_rows > 0){
			
			$rows = $query->fetch_assoc();			
			
		 	$invoice_number = $rows['invoice_number'];
			$order_status =  $rows['status'];
			
		}
	
		$col1= $col2= $col3= $col4= $col5= $col6= $col7= $col8= $col9= $col10= $col11= $col12= $col13= $col14= $col15= $col16= $col17= $col18= $col19= $col20  ='';						
        $stmt = $conn->prepare("SELECT o.order_id,o.user_id,o.status, o.total_price, o.payment_orderid,o.payment_id,o.payment_mode,o.qoute_id,o.create_date,
							o.discount,o.total_qty, o.fullname, o.mobile,o.locality, o.fulladdress,o.city,st.name,o.pincode,o.addresstype,o.email FROM orders o,state st WHERE st.stateid = o.state and o.order_id = '".$ordersno."' ");
       
            
    	   $stmt->execute();	 
     	   $data = $stmt->bind_result( $col1, $col2, $col3, $col4, $col5, $col6, $col7, $col8, $col9, $col10, $col11, $col12, $col13, $col14, $col15, $col16, $col17, $col18, $col19, $col20      );
          
    	   while ($stmt->fetch()) {    
    	   	  	
        		$orderid =  $col1;        						
        		$user_id =  $col2;
        		
        		$total_price =  $col4;
        		$payment_orderid =  $col5;
              	$payment_id =  $col6;
              	$payment_mode =  $col7;
              	$qoute_id =  $col8;
              	$create_date =   date('d-m-Y',strtotime($col9));
				$total_discount =  $col10;
              	$payment_status =   'Paid';	
              	$total_qty =  $col11;	
              	$fullname =  $col12;
              	$mobile =  $col13;
              	$locality =  $col14;
              	$fulladdress =  $col15;
              	$city =  $col16;
              	$state =  $col17;
              	$pincode =  $col18;
              	$addresstype =  $col19;
              	$email =  $col20;

    	    }
			
			
			$html ='';
			if($col2){
				$user_type = 'App User';
			
				$stmt1 = $conn->prepare("SELECT fullname,phone,email FROM  appuser_login WHERE user_unique_id = '".$col2."' ");
            
				$stmt1->execute();	 
				$data1 = $stmt1->bind_result( $fullname, $phone ,$email  );
				$user_name = $user_phone = $user_email = '';
				while ($stmt1->fetch()) { 
					$user_name = $fullname;
					$user_phone = $phone;
					$user_email = $email; 
					$html = '<br>'.$user_phone.',<br>'.$user_email;
				}
				
			}else{
				$user_type = 'Guest';
			}
      
               ?>
		<div id="page-wrapper">
			<div class="main-page">
			  <div class="tables">
	
 		 
        	    <div class="bs-example widget-shadow" data-example-id="hoverable-table"> 
        <div id="printableArea">	         
        		<input type="hidden" class="form-control1" id="sno_order" value=<?php echo $ordersno; ?> ></input>
        
        			<input type="hidden" class="form-control1" id="cust_phone" value=<?php echo $cust_phone; ?> ></input>
        			<input type="hidden" class="form-control1" id="cust_email" value=<?php echo $cust_email; ?> ></input>
        		
         <!-- title row -->
		 
		 
		 
		 
		 
		 
      <div class="row">

      <div class="col-xs-12">
           <div style="text-align:center;">
            <h3 >Order Details </h3> 
			<span style="float:right;"> Invoice : <?php echo $invoice_number; ?></span>
          </div>
          <h4 class="page-header">
                <div class="pull-right"> 
                     <span id="orderidvalue" class="orderidvalue" ></span><br>
                    <small class="pull-right" style="margin-top:10px;"> <span id="orderdate"></span></small>
            
                </div> 
            
            
            
          </h4>
        </div>
        <!-- /.col -->
           
           <div class="row invoice-info">
         
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                <thead>
                <tr>
                    
                  <th>   OrderID               </th>
                  <th>   Customer Details                </th>
                  <th>   Shipping Address             </th>
                  <th >  <b>Order Status </b>               
                  <th >  <b>Order Date </b>               
                  </th>
                </tr>
                </thead>
                    <tr>
                       <td ><?php echo $ordersno; ?>    </td>
                       <td ><?php echo $user_name. '('.$user_type.')'; echo $html; ?>    </td>
                       <td ><?php echo $fullname.'<br>'. $mobile.', '.$email;
													echo '<br>Landmark - '.$locality.',<br>'.$fulladdress.',<br>'.$city.', '.$state.', '.$pincode.'('.$addresstype.')';
					   ?>    </td>
                     <td ><?php echo $order_status; ?>    </td>
                     <td ><?php echo $create_date; ?>    </td>
                </tr>
                      
              </table>
            </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
        
 
      
       <!-- Table row -->
      <div class="row">
           <div class="row invoice-info">
     
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped" style="border: 1px solid black;">
            <thead>
            <tr >
              <th >#</th>
              <th>Product Name</th>
			  <th>ProductID</th>
              <!--<th>Vendor</th>-->
              <th>SKU</th>
              <th>Attribute</th>
               
              <th>Price</th>
              <th>Qty</th>
              <!--<th>Ship</th>-->
            
               <th class="dontprint">Action</th>
              
            </tr>
            </thead>
            
            <tbody id="tbodyPostid">
            <?php
				$stmtp = $conn->prepare("SELECT op.prod_id,op.prod_sku,op.prod_name,op.prod_img,op.prod_attr,op.qty,op.prod_price,op.shipping,op.discount,op.status, sl.companyname, op.invoice_number FROM `order_product` op
						,sellerlogin sl WHERE op.order_id = '".$ordersno."' AND op.prod_id = '".$product_id."' AND sl.seller_unique_id = op.vendor_id ");
            
				$stmtp->execute();	 
				$datap = $stmtp->bind_result( $prod_id, $prod_sku ,$prod_name,$prod_img,$prod_attr,$qty,$prod_price,$shipping,$discount,$status ,$seller,$invoice_number );
				$prod_id1= $prod_sku1=$prod_name1=$prod_img1=$prod_attr1=$qty1=$prod_price1=$shipping1=$discount=$status1 = $seller  = $invoice_number1 = '';
				while ($stmtp->fetch()) { 
					$prod_attr1= '';
					if($prod_attr){
						$attr = json_decode($prod_attr);
						$attribute = '';
						foreach($attr as $prod_attr){
							$attribute .= $prod_attr->attr_name.': '.$prod_attr->item.', ';
						}
						
						$prod_attr1 = rtrim($attribute,', ');
					}	

				?>
					<tr>
					<td><img src="<?php echo   MEDIAURL.$prod_img; ?>" style="width:50px;">  </td>
					
					
					<td><?php echo   $prod_name; ?>  </td>
					<td><?php echo   $prod_id; ?>  </td>
					<!--<td><?php // echo   $seller; ?>  </td>-->
					<td><?php echo   $prod_sku; ?>  </td>
					<td><?php echo   $prod_attr1; ?>  </td>
					<td><?php echo   $prod_price; ?>  </td>
					<td><?php echo   $qty; ?>  </td>
					<!--<td><?php // echo   $shipping; ?>  </td>-->
					<td class="dontprint"><button type="submit" onclick="back_page('view_product.php?id=<?php echo   $prod_id; ?>')" id="back_btn" class="btn  btn-info" style="margin-right:10px; margin-top:-4px;"> View Product</button>  </td>
					</tr>
			<?php	}
			
			?>
            <tr>
                 
         	
            </tr>
                                   
            </tbody>
          </table>
        </div>
        </div>
        <!-- /.col -->
        <span id="qty_save"></span> <br>
        
     
      </div>
      <!-- /.row -->
	  <?php 
 if(isset($_POST['pickup_curier_date']) || isset($_POST['curier_name']))
{		
	
	$curl1 = curl_init();
		  curl_setopt_array($curl1, array(
		  CURLOPT_URL => 'https://api.nimbuspost.com/v1/users/login',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>'{
			  "email" : "marurangecommerce@gmail.com",
			  "password" : "Borawar@739"				}',
			  CURLOPT_HTTPHEADER => array(
			  'content-type: application/json'
			  ),
			  ));
			  $response1 = curl_exec($curl1);
			  curl_close($curl1);
			  $token_data = json_decode($response1);
			  $token = $token_data->data;
			  $curl = curl_init();
			  curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://api.nimbuspost.com/v1/shipments',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
					"order_number": "#001",
					"shipping_charges": 0,
					"discount": '.$total_discount.',
					"cod_charges": 0,
					"payment_type": '.$payment_mode.',
					"order_amount": '.$total_price.',
					"package_weight": 300,
					"package_length": 10,
					"package_breadth": 10,
					"package_height": 10,
					"consignee": {
						"name": '.$fullname.',
						"address": '.$fulladdress.',
						"address_2": "",
						"city": '.$city.',
						"state": '.$state.',
						"pincode": '.$pincode.',
						"phone": '.$mobile.'
					},
					"pickup": {
						"warehouse_name": '.$seller.',
						"name" : "Vikalp Sharma",
						"address": "140, MG Road",
						"address_2": "Near metro station",
						"city": "Gurgaon",
						"state": "Haryana",
						"pincode": "122001",
						"phone": "9999999999"
					},
					"order_items": [
						{
							"name": "product 1",
							"qty": "18",
							"price": "100",
							"sku": "sku001"
						}
					]
				}',
				  CURLOPT_HTTPHEADER => array(
				  'Content-Type: application/json',
				  'Authorization: token '.$token.''	
				  ),
				  ));	
				  $response_shipment = curl_exec($curl);
				  curl_close($curl);
				  $response_shipment = json_decode($response_shipment);	

}
?>
	  
	  
	  
	  
		<?php
			$status_track1 = $conn->prepare("SELECT bo.delivery_boy,bl.fullname,bl.phone,bl.email FROM delivery_boy_orders bo INNER JOIN deliveryboy_login bl ON bl.deliveryboy_unique_id = bo.delivery_boy WHERE  bo.order_id = '".$ordersno."'
				AND bo.product_id = '".$prod_id."' ");
			
				$status_track1->execute();	 
				$delivery_boy_rows=$status_track1->affected_rows;
				$datap = $status_track1->bind_result( $col,$co2,$co3,$co4 );
				$delivery_boy ='';
				while ($status_track1->fetch()) {
					$delivery_uniq_id = $col;
					$delivery_boy_name = $co2;
					$delivery_boy_phone = $co3; 
					$delivery_boy_email = $co4;
				}
				
				
			?>
      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
			<!--<strong>Delivery Boy Name:</strong>
			<br> 
			<a style="color:black;"><span id="deliveryboyname"><?php // echo $delivery_boy_name; ?></span></a>
			<br>
			<br>
			<strong>Delivery Boy Mobile:</strong>
			<br> 
			<a style="color:black;"><span id="deliveryboyname"><?php // echo $delivery_boy_phone; ?></span></a>
			<br>
			<br>
			<strong>Delivery Boy Email:</strong>
			<br> 
			<a style="color:black;"><span id="deliveryboyname"><?php // echo $delivery_boy_email; ?></span></a>
			<br>-->
			<br>
          <strong>Payment Methods:</strong> <br>
          <a style="color:black;"><span id="deliverymode"><?php echo $payment_mode; ?></span></a><br><br>
          <strong>Payment TXN ID: </strong><br>
          <a style="color:black;"><span id="paymentid"><?php echo $payment_id; ?></span></a>
		   <br> <br>
		  ` <div class="form-three widget-shadow dontprint">
		    <strong>Update Status:</strong> <br>
        	<form class="form-horizontal" method="post" id="myform">
        	    	   
        		<div class="form-group">
			    		<label class="col-sm-2 control-label"> Status*</label>
			       	<div class="col-sm-8">
			           <select class="form-control1" id="orderstatus" name="orderstatus" required>
                          <option value="">Select</option>
                          <option value="Packed">Packed</option>
                          <option value="Shipped">Shipped</option>
                          <option value="Cancelled">Cancelled</option>
                          <option value="Return Request">Return Request</option>
                          <option value="Returned Completed">Return Completed</option>
                          <option value="RTO">RTO</option>
						  <option value="Delivered">Delivered</option>   
					  </select> 
                  </div>
                </div>
            
        		<div class="form-group">
        			<label for="focusedinput" class="col-sm-2 control-label">Message</label>
        			<div class="col-sm-8">
        				<input type="text" class="form-control1" id="ordermessage" name="ordermessage" placeholder="" >
        			</div>
        		</div>
				<div class="col-sm-offset-2">
					<button type="submit" class="btn btn-success" href="javascript:void(0)" id="updatestatus">Update</button>
            	</div>
            </form>
        	</div>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">

          <div class="table-responsive">
            <table class="table">
              <tbody>
			   <tr>
                <th style="width:50%">Total:</th>
                <td><span id="subtotal"><?php echo ($prod_price*$qty)+($discount*$qty); ?></span></td>
              </tr>
             <tr>
                <th style="width:50%">Discount:</th>
                <td><span id="subtotal"><?php echo ($discount*$qty); ?></span></td>
              </tr>
			  <tr>
                <th style="width:50%">Shipping:</th>
                <td><span id="subtotal"><?php echo ($shipping); ?></span></td>
              </tr>
			   <tr>
                <th style="width:50%">Subtotal:</th>
                <td><span id="subtotal">Rs. <?php echo ($prod_price*$qty)+$shipping; ?></span></td>
              </tr>
             
            
            </tbody></table>
          </div>
		  
		  
		  
		  
		  <div class="form-three widget-shadow dontprint" >
		  <strong>Pickup Details</strong> <br>
		  <form class="form-horizontal" method="post" id="pickup_form"> 
		  <div class="form-group">
		  <label class="col-sm-2 control-label"> Pickup Date*</label>
		  <div class="col-sm-8">
		  <input type="text" class="form-control1" id="pickup_curier_date" name="pickup_curier_date" readonly required placeholder="" > 
		  </div>
		  </div>
		  <?php				
		  $curl1 = curl_init();
		  curl_setopt_array($curl1, array(
		  CURLOPT_URL => 'https://api.nimbuspost.com/v1/users/login',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>'{
			  "email" : "marurangecommerce@gmail.com",
			  "password" : "Borawar@739"				}',
			  CURLOPT_HTTPHEADER => array(
			  'content-type: application/json'
			  ),
			  ));
			  $response1 = curl_exec($curl1);
			  curl_close($curl1);
			  $token_data = json_decode($response1);
			  $token = $token_data->data;
			  $curl = curl_init();
			  curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://api.nimbuspost.com/v1/courier/serviceability',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
				  "origin" : '.$_SESSION['seller_pincode'].',
				  "destination" : '.$pincode.',
				  "payment_type" : "cod",
				  "order_amount" : "999",
				  "weight" : "500",	
				  "length" : "10",
				  "breadth" : "10",
				  "height" : "10"
				  }',
				  CURLOPT_HTTPHEADER => array(
				  'Content-Type: application/json',
				  'Authorization: token '.$token.''	
				  ),
				  ));	
				  $response_rate = curl_exec($curl);
				  curl_close($curl);
				  $response_rate = json_decode($response_rate);	
				  ?>   
				  <div class="form-group">
				  <label for="focusedinput" class="col-sm-2 control-label">Courier  Name</label>
				  <div class="col-sm-8"> 
				  <select class="form-control1" id="curier_name" name="curier_name">
				  <option>select Courier</option>
				  <?php 
				  foreach($response_rate->data as $ship_data)
				  {	
				  if($ship_data->id != '' && $ship_data->id == 5)
					  { ?>	
				  <option value="<?php echo $ship_data->id; ?>"><?php echo $ship_data->name; ?></option>
				  <?php } else if($ship_data->id != '' && $ship_data->id == 3) /* Xpressbees Air */
				  { ?>	
				  <option value="<?php echo $ship_data->id; ?>"><?php echo $ship_data->name; ?></option>
				  <?php }
				  else if($ship_data->id != '' && $ship_data->id == 6) /* Delhivery Surface */	
				  { ?>	
				  <option value="<?php echo $ship_data->id; ?>"><?php echo $ship_data->name; ?></option>
				  <?php }
				  else if($ship_data->id != '' && $ship_data->id == 15) /* Ekart */				  
				  { ?>	
				  <option value="<?php echo $ship_data->id; ?>"><?php echo $ship_data->name; ?></option>
				  <?php }
				  else if($ship_data->id != '' && $ship_data->id == 66) /* Amazon Shipping */
				  { ?>
				  <option value="<?php echo $ship_data->id; ?>"><?php echo $ship_data->name; ?></option>
				  <?php }
				  }		
				  ?>
				  </select> 
				  </div> 
				  </div>
				  <div class="col-sm-offset-2">
				  <button type="submit" class="btn btn-success" href="javascript:void(0)" id="pickup_form">Update</button> 
				  </div>
				  </form>
				  </div>
		  <?php if($status=='Placed'){ ?> 
          <div class="form-three widget-shadow dontprint" >
		    <strong>Courier Details</strong> <br>
			<form class="form-horizontal" method="post" id="myform_tracking">
        	    	   
        		<div class="form-group">
			    		<label class="col-sm-2 control-label"> Delivery Date*</label>
			       	<div class="col-sm-8">
			           <input type="text" class="form-control1" id="delivery_date1" name="delivery_date" readonly required placeholder="" >
                  </div>
                </div>
            
        		<div class="form-group">
        			<label for="focusedinput" class="col-sm-2 control-label">Tracking Id</label>
        			<div class="col-sm-8">
        				<input type="text" class="form-control1" id="tracking_id" name="tracking_id" placeholder="" >
        			</div>
        		</div>
				
				<div class="form-group">
        			<label for="focusedinput" class="col-sm-2 control-label">Tracking Url</label>
        			<div class="col-sm-8">
        				<input type="text" class="form-control1" id="tracking_url" name="tracking_url" placeholder="" >
        			</div>
        		</div>
				<div class="col-sm-offset-2">
					<button type="submit" class="btn btn-success" href="javascript:void(0)" id="updatetracking">Update</button>
            	</div>
            </form>
			</div>
		  <?php }else if($status=='Returned'){ ?> 
            <div class="form-three widget-shadow dontprint">
		    <strong>Return Details</strong> <br>
			<form class="form-horizontal" method="post" id="myform_tracking">
        	    	   
        		<div class="form-group">
			    		<label class="col-sm-2 control-label"> Return Date*</label>
			       	<div class="col-sm-8">
			           <input type="text" class="form-control1" id="delivery_date1" name="pickup_date" readonly required placeholder="" >
                  </div>
                </div>
            
        		<div class="form-group">
        			<label for="focusedinput" class="col-sm-2 control-label">Return Status </label>
					<div class="col-sm-8">
						<select class="form-control1" id="pickup_status" name="pickup_status" required>
							<option value="">Select</option>
							<option value="Return Scheduled">Return Scheduled</option>
							<option value="Return Cancelled">Return Cancelled</option>
							<option value="Return Reschedule">Return Reschedule</option>
							<option value="Return Completed">Return Completed</option>
							
						</select> 
					</div>
        		</div>
				
				
				<div class="col-sm-offset-2">
					<button type="submit" class="btn btn-success" href="javascript:void(0)" id="updatepickup">Update</button>
            	</div>
            </form>
			</div>
		  <?php } ?>
			
        </div>
		
		
		 <div class="col-xs-12 dontprint" >

         
		   
           <div class="form-three widget-shadow">
		    <strong>Track Status</strong> <br>
			<table class="table table-striped" style="border: 1px solid black;">
            <thead>
				<tr>
                <th >Status</th>
                <th >Date</th>
                <th >Message</th>
                
              </tr>
			  </thead>
			<tbody>
			 <?php
				$status_track = $conn->prepare("SELECT `status`, `message`, `created_at` FROM `order_tracking_status` WHERE order_id = '".$ordersno."' AND product_id = '".$product_id."' ORDER BY id asc ");
            
				$status_track->execute();	 
				$datap = $status_track->bind_result( $trackst, $trackmag ,$tracktime);
				
				while ($status_track->fetch()) { 
				
				?>
				<tr>
					<td><?php echo   $trackst; ?> </td>
					<td><?php echo   $tracktime; ?> </td>
					<td><?php echo   $trackmag; ?> </td>
				</tr>
             
				<?php } ?>
            </tbody>
			</table>
			</div>
			
			
        </div>
        <!-- /.col -->
      </div>
      <!--- /.row -->
   </div> 	<!-- print area close-->  

	<?php 
		  
		  
		/*  $curl_handle=curl_init();
		  curl_setopt($curl_handle,CURLOPT_URL,'https://api.postalpincode.in/pincode/'.$_SESSION['seller_pincode']);
		  curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
		  curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
		  $buffer = curl_exec($curl_handle);
		  curl_close($curl_handle);
			$satte_data = json_decode($buffer);	
			$seller_state_name = $satte_data[0]->PostOffice[0]->State;
			
			$curl_handle0=curl_init();
		  curl_setopt($curl_handle0,CURLOPT_URL,'https://api.postalpincode.in/pincode/'.$pincode);
		  curl_setopt($curl_handle0,CURLOPT_CONNECTTIMEOUT,2);
		  curl_setopt($curl_handle0,CURLOPT_RETURNTRANSFER,1);
		  $buffer1 = curl_exec($curl_handle0);
		  curl_close($curl_handle0);
			$satte1_data = json_decode($buffer1);	
			$user_state_name = $satte1_data[0]->PostOffice[0]->State;*/
			
		  ?>
   
   <button  type="submit" style="position: fixed;bottom: 62px;right: 5px;"  href="javascript:void(0)" onclick="generate_invoice('<?php echo $prod_id; ?>','<?php echo $ordersno; ?>'); "  class="btn btn-primary pull-right" style="margin-right: 5px;margin-top: 11px;" >
		<i class="fa fa-download"></i> Generate Invoice
    </button>  
			

<script>
        function generate_invoice(prod_id,ordersno) {
			location.href = 'generate_invoice.php?orderid='+ordersno+'&product_id='+prod_id;
        }
        
</script>
            <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-8">
			
          
          
          
          
        </div>


		<div class="col-xs-4">
      
           
          
          
        </div>
      </div></br></br>
      	         <center> <p id="test1" style="color:green;"></p></center>
        					
        		     
             <div class="clearfix"> </div>
		</div>  
		 
      
			<div class="clearfix"> </div>
			
		</div>
			    
		
		<div class="col_1">
			
			
			<div class="clearfix"> </div>
			
		</div>
				
			</div>
		</div>
		<!--footer-->
              <?php    include('footernew.php'); ?>
        <!--//footer-->
	