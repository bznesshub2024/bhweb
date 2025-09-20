<?php
include('session.php');
if (!isset($_SESSION['admin'])) {
	header("Location: index.php");
}
$ordersno = $_REQUEST['orderid']; 
$product_id = $_REQUEST['product_id'];
$datetime = date('Y-m-d H:i:s');
if (!$ordersno || !$product_id) {
	header("Location: manage_orders.php");
}
include("header.php");


if (isset($_POST['orderstatus']) && $ordersno && $product_id) {

	$orderstatus = $_POST['orderstatus'];
	$ordermessage = trim($_POST['ordermessage']);
	$sql_status = $conn->prepare("INSERT INTO `order_tracking_status`(`order_id`, `product_id`, `status`, `message`, `created_at`) VALUES (
					'" . $ordersno . "','" . $product_id . "','" . $orderstatus . "','" . $ordermessage . "','" . $datetime . "')");
	$sql_status->execute();
	$sql_status->store_result();
	$rows = $sql_status->affected_rows;


	$reverse_shipping = 0; 
	if ($orderstatus == 'Returned Completed') {
		$reverse_shipping = $Common_Function->get_system_settings($conn, 'reverse_shipping');
	}

	$sql1 = $conn->prepare("UPDATE order_product SET status = '" . $orderstatus . "', status_date = '" . $datetime . "', update_date = '" . $datetime . "', reverse_shipping = '" . $reverse_shipping . "' WHERE order_id = '" . $ordersno . "' AND prod_id = '" . $product_id . "'");
	$sql1->execute();
	$sql1->store_result();

	if ($rows > 0) {
		echo '<script>successmsg("Order Status updated successfully."); </script> ';
		//if($orderstatus =='Delivered'){
		$Common_Function->send_delivered_email_invoice_user($conn, $ordersno, $product_id, $_SESSION['admin'], $orderstatus);
		//}
	}
}
 
if(isset($_POST['new_orderstatus']))
{
	$new_orderstatus = trim($_POST['new_orderstatus']);
	$pickup_type = trim($_POST['pickup_type']);
	$new_pickupdate = trim($_POST['pick_date']);
	$p_weight = trim($_POST['p_weight']);
	$p_length = trim($_POST['p_length']);
	$p_width = trim($_POST['p_width']);
	$p_height = trim($_POST['p_height']);
	
	$p_length =ltrim($p_length, '0');
	$p_width =ltrim($p_width, '0');
	$p_height =ltrim($p_height, '0');
	
	/*if($pickup_type == 1)
	{
		$new_orderstatus = 'Ready to ship';
	}*/
	
	$curtime = date('H:i:s');
	$pick_date = date("Y-m-d H:i:s",strtotime($new_pickupdate.$curtime)) ;
	
	$sql_new = $conn->prepare("UPDATE order_product SET status = '" . $new_orderstatus . "', pickup_date = '" . $pick_date . "' ,p_weight = '" . $p_weight . "' ,p_length = '" . $p_length . "' ,p_width = '" . $p_width . "' ,p_height = '" . $p_height . "' , update_date = '" . $datetime . "', pickup_type = '" . $pickup_type . "' WHERE order_id = '" . $ordersno . "'
							AND prod_id = '" . $product_id . "'");
	$sql_new->execute();
	$sql_new->store_result();
	$Common_Function->send_delivered_email_invoice_user($conn, $ordersno, $product_id, $_SESSION['admin'], $new_orderstatus);
	?>
	<script>successmsg("Order updated successfully."); </script>
	<?php
}

if (isset($_POST['delivery_date']) && $ordersno && $product_id) {
	$delivery_date = trim($_POST['delivery_date']);
	$tracking_id = trim($_POST['tracking_id']);
	$tracking_url = trim($_POST['tracking_url']);

	$sql1 = $conn->prepare("UPDATE order_product SET delivery_date = '" . $delivery_date . "', tracking_id = '" . $tracking_id . "', tracking_url = '" . $tracking_url . "', update_date = '" . $datetime . "' WHERE order_id = '" . $ordersno . "'
							AND prod_id = '" . $product_id . "'");
	$sql1->execute();
	$sql1->store_result();

	echo '<script>successmsg("Order updated successfully."); </script> ';
}

if (isset($_POST['pickup_date']) && isset($_POST['pickup_status']) && $ordersno && $product_id) {
	$pickup_date = trim($_POST['pickup_date']);
	$pickup_status = trim($_POST['pickup_status']);

	$sql1 = $conn->prepare("UPDATE order_product SET pickup_date = '" . $pickup_date . "', pickup_status = '" . $pickup_status . "', update_date = '" . $datetime . "' WHERE order_id = '" . $ordersno . "'
							AND prod_id = '" . $product_id . "'");
	$sql1->execute();
	$sql1->store_result();


	$sql_status = $conn->prepare("INSERT INTO `order_tracking_status`(`order_id`, `product_id`, `status`, `message`, `created_at`) VALUES (
					'" . $ordersno . "','" . $product_id . "','" . $pickup_status . "','','" . $datetime . "')");
	$sql_status->execute();
	$sql_status->store_result();
	$rows = $sql_status->affected_rows;

	echo '<script>successmsg("Order pickup status updated successfully."); </script> ';
}
?>



<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->



<!-- main content start-->
<?php
$invoice_number = '';

$query = $conn->query("SELECT invoice_number,status FROM `order_product` WHERE order_id = '" . $ordersno . "' AND prod_id = '" . $product_id . "' ");
if ($query->num_rows > 0) {

	$rows = $query->fetch_assoc();

	$invoice_number = $rows['invoice_number'];
	$order_status =  $rows['status'];
}

$col1 = $col2 = $col3 = $col4 = $col5 = $col6 = $col7 = $col8 = $col9 = $col10 = $col11 = $col12 = $col13 = $col14 = $col15 = $col16 = $col17 = $col18 = $col19 = $col20  = '';
$stmt = $conn->prepare("SELECT o.order_id,o.user_id,o.status, o.total_price, o.payment_orderid,o.payment_id,o.payment_mode,o.qoute_id,o.create_date, o.discount,o.total_qty, o.fullname, o.mobile,o.locality, o.fulladdress,o.city,st.name,o.pincode,o.addresstype,o.email FROM orders o,state st WHERE st.stateid = o.state and o.order_id = '" . $ordersno . "' ");


$stmt->execute();
$data = $stmt->bind_result($col1, $col2, $col3, $col4, $col5, $col6, $col7, $col8, $col9, $col10, $col11, $col12, $col13, $col14, $col15, $col16, $col17, $col18, $col19, $col20);

while ($stmt->fetch()) {

	$orderid =  $col1;
	$user_id =  $col2;

	$total_price =  $col4;
	$payment_orderid =  $col5;
	$payment_id =  $col6;
	$payment_mode =  $col7;
	$qoute_id =  $col8;
	$create_date =   date('d-m-Y', strtotime($col9));
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


$html = '';
if ($col2) {
	$user_type = 'App User';

	$stmt1 = $conn->prepare("SELECT fullname,phone,email FROM  appuser_login WHERE user_unique_id = '" . $col2 . "' ");

	$stmt1->execute();
	$data1 = $stmt1->bind_result($fullname, $phone, $email);
	$user_name = $user_phone = $user_email = '';
	while ($stmt1->fetch()) {
		$user_name = $fullname;
		$user_phone = $phone;
		$user_email = $email;
		$html = '<br>' . $user_phone . ',<br>' . $user_email;
	}
} else {
	$user_type = 'Guest';
}

if ($_REQUEST['meg_form'] != '') {
	$msg_title = $_REQUEST['msg_title'];
	$msg_data = $_REQUEST['msg_data'];
	$datetime = date('Y-m-d H:i:s');
	$sql_status = $conn->prepare("INSERT INTO `order_chat`(`title`, `message`, `order_id`, `datetime`) VALUES ('" . $msg_title . "','" . $msg_data . "','" . $ordersno . "','" . $datetime . "')");
	$sql_status->execute();
	$sql_status->store_result();
	$chat_rows = $sql_status->affected_rows;
	$to = $c_email;
	$subject = $msg_title;
	$user_result['status'] = '1';
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$message = '<html><body>';
	$message .= '<h1 style="color:#f40;">' . $msg_title . '</h1>';
	$message .= '<p>Message : ' . $msg_data . '</p>';
	$message .= '</body></html>';
	if (mail($to, $subject, $message, $headers)) {
		$msg = 'Your mail has been sent successfully.';
	} else {
		$msg = 'Unable to send email. Please try again.';
	}
	
}

?>

<div class="content-page">
	<!-- Start content -->
	<div class="content">
		<div class="container-fluid">


			<!-- start page title -->
			<div class="row">
				<div class="col-12">
					<div class="page-title-box">
						<div class="page-title-right">
							<ol class="breadcrumb m-0" id="category_bradcumb">
								<li class="breadcrumb-item">
									<a href="javascript: void(0);">Invoice : <?= $invoice_number; ?></a>
								</li>
							</ol>
						</div>
						<h4 class="page-title">Order Details</h4>
					</div>
				</div>
			</div>
			<!-- end page title -->

			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div class="bs-example widget-shadow" data-example-id="hoverable-table">
								<div id="printableArea">
									<input type="hidden" class="form-control1" id="sno_order" value=<?php echo $ordersno; ?>></input>

									<input type="hidden" class="form-control1" id="cust_phone" value=<?php echo $cust_phone; ?>></input>
									<input type="hidden" class="form-control1" id="cust_email" value=<?php echo $cust_email; ?>></input>

									<!-- title row -->
									<div class="row invoice-info">

										<div class="col-12 table-responsive">
											<table class="table table-hover">
												<thead class="thead-light">
													<tr>
														<th> OrderID </th>
														<th> Customer Details </th>
														<th> Shipping Address </th>
														<th> <b>Order Status </b>
														<th> <b>Order Date </b>
														</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td><?php echo $ordersno; ?> </td>
														<td><?php echo $user_name . '(' . $user_type . ')';
															echo $html; ?> </td>
														<td><?php echo $fullname . '<br>' . $mobile . ', ' . $email;
															echo '<br>Landmark - ' . $locality . ',<br>' . $fulladdress . ',<br>' . $city . ', ' . $state . ', ' . $pincode . '(' . $addresstype . ')';
															?> </td>
														<td><?php echo $order_status; ?> </td>
														<td><?php echo $create_date; ?> </td>
													</tr>
												</tbody>

											</table>
										</div>
									</div>

									<div class="row invoice-info">

										<div class="col-12 table-responsive">
											<table class="table table-hover" style="border: 0.5px solid #ccc;">
												<thead class="thead-light">
													<tr>
														<th>#</th>
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
													$stmtp = $conn->prepare("SELECT op.prod_id,op.prod_sku,op.prod_name,op.prod_img,op.prod_attr,op.qty,op.prod_price,op.shipping,op.discount,op.status, sl.companyname, op.invoice_number,op.pickup_type,op.pickup_date,op.p_weight,op.p_length,op.p_width,op.p_height,op.coupon_value,op.tracking_id,op.cgst,op.sgst,op.igst,op.default_discount FROM `order_product` op, sellerlogin sl WHERE op.order_id = '" . $ordersno . "' AND op.prod_id = '" . $product_id . "' AND sl.seller_unique_id = op.vendor_id ");

													$stmtp->execute();
													$datap = $stmtp->bind_result($prod_id, $prod_sku, $prod_name, $prod_img, $prod_attr, $qty, $prod_price, $shipping, $discount, $status, $seller, $invoice_number,$pickup_type,$pickup_date,$p_weight,$p_length,$p_width,$p_height,$coupon_value,$tracking_id,$cgst, $sgst, $igst,$default_discount);
													$prod_id1 = $prod_sku1 = $prod_name1 = $prod_img1 = $prod_attr1 = $qty1 = $prod_price1 = $shipping1 = $discount = $status1 = $seller  = $invoice_number1 = $pickup_type = $pickup_date = $p_weight = $p_length = $p_width = $p_height = $coupon_value = $tracking_id = $default_discount = '';
													$cgst = $sgst = $igst = 0;
													while ($stmtp->fetch()) {
														$prod_attr1 = '';
														if ($prod_attr) {
															$attr = json_decode($prod_attr);
															$attribute = '';
															foreach ($attr as $prod_attr) {
																$attribute .= $prod_attr->attr_name . ': ' . $prod_attr->item . ', ';
															}

															$prod_attr1 = rtrim($attribute, ', ');
														}

													?>
														<tr>
															<td><img src="<?php echo   MEDIAURL.str_replace('-430-590','',$prod_img); ?>" style="width:50px;"> </td>


															<td><?php echo   $prod_name; ?> </td>
															<td><?php echo   $prod_id; ?> </td>
															<!--<td><?php // echo   $seller; 
																	?>  </td>-->
															<td><?php echo   $prod_sku; ?> </td>
															<td><?php echo   $prod_attr1; ?> </td>
															<td><?php echo   $prod_price; ?> </td>
															<td><?php echo   $qty; ?> </td>
															<!--<td><?php // echo   $shipping; 
																	?>  </td>-->
															<td class="dontprint"><button type="submit" onclick="back_page('view_product.php?id=<?php echo   $prod_id; ?>')" id="back_btn" class="btn btn-danger" style="margin-right:10px; margin-top:-4px;"> View Product</button> </td>
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

									<!-- /.row -->
									<?php
									if (isset($_POST['pickup_curier_date']) || isset($_POST['curier_name'])) {

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
											CURLOPT_POSTFIELDS => '{
												"email" : "udvala.eswar@gmail.com",
												"password" : "Bittu@2024"				
											}',
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
											CURLOPT_POSTFIELDS => '{
												"order_number": "#001",
												"shipping_charges": 0,
												"discount": ' . $total_discount . ',
												"cod_charges": 0,
												"payment_type": ' . $payment_mode . ',
												"order_amount": ' . $total_price . ',
												"package_weight": 300,
												"package_length": 10,
												"package_breadth": 10,
												"package_height": 10,
												"consignee": {
													"name": ' . $fullname . ',
													"address": ' . $fulladdress . ',
													"address_2": "",
													"city": ' . $city . ',
													"state": ' . $state . ',
													"pincode": ' . $pincode . ',
													"phone": ' . $mobile . '
												},
												"pickup": {
													"warehouse_name": ' . $seller . ',
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
												'Authorization: token ' . $token . ''
											),
										));
										$response_shipment = curl_exec($curl);
										curl_close($curl);
										$response_shipment = json_decode($response_shipment);
									}
									?>




									<?php
									$status_track1 = $conn->prepare("SELECT bo.delivery_boy,bl.fullname,bl.phone,bl.email FROM delivery_boy_orders bo INNER JOIN deliveryboy_login bl ON bl.deliveryboy_unique_id = bo.delivery_boy WHERE  bo.order_id = '" . $ordersno . "'AND bo.product_id = '" . $prod_id . "' ");

									$status_track1->execute();
									$delivery_boy_rows = $status_track1->affected_rows;
									$datap = $status_track1->bind_result($col, $co2, $co3, $co4);
									$delivery_boy = '';
									while ($status_track1->fetch()) {
										$delivery_uniq_id = $col;
										$delivery_boy_name = $co2;
										$delivery_boy_phone = $co3;
										$delivery_boy_email = $co4;
									}

									?>
									<div class="row">
										<!-- accepted payments column -->
										<div class="col-md-6">
											<!--<strong>Delivery Boy Name:</strong>
											<br> 
											<a style="color:black;"><span id="deliveryboyname"><?php  echo $delivery_boy_name; 
																								?></span></a>
											<br>
											<br>
											<strong>Delivery Boy Mobile:</strong>
											<br> 
											<a style="color:black;"><span id="deliveryboyname"><?php  echo $delivery_boy_phone; 
																								?></span></a>
											<br>
											<br>
											<strong>Delivery Boy Email:</strong>
											<br> 
											<a style="color:black;"><span id="deliveryboyname"><?php echo $delivery_boy_email; 
																								?></span></a>
											<br>-->
											<strong>Payment Methods:</strong> <br>
											<a style="color:black;"><span id="deliverymode"><?php echo $payment_mode; ?></span></a><br><br>
											<strong>Payment TXN ID: </strong><br> 
											<a style="color:black;"><span id="paymentid"><?php echo $payment_id; ?></span></a>
											<?php if($pickup_type != '') { ?>
											<br><br>
											<strong>Shipping Type: </strong><br> 
											<a style="color:black;"><span id="paymentid"><?php if($pickup_type == 1){ echo 'Self Ship'; } else if($pickup_type == 2){ echo 'Ship By Bussinesshub'; }; ?></span></a>
											<?php if($pickup_type != '') { ?>
											<br><br>
											<strong>Pickup Date: </strong><br> 
											<a style="color:black;"><span id="paymentid"><?php echo date('d-m-Y',strtotime($pickup_date)); ?></span></a>
											<?php } } ?>
											<?php if($p_weight != ''){ ?>
											<br><br>
											<div class="row">
											<div class="col-md-6">
												<strong>Product Weight(gm): </strong><br> 
												<a style="color:black;"><span><?php echo $p_weight; ?></span></a>
											</div>
											<div class="col-md-6">
												<strong>Product Length(cm): </strong><br> 
												<a style="color:black;"><span><?php echo $p_length; ?></span></a>
											</div>
											<div class="col-md-6">
												<strong>Product Width(cm): </strong><br> 
												<a style="color:black;"><span><?php echo $p_width; ?></span></a>
											</div>
											<div class="col-md-6">
												<strong>Product Height(cm): </strong><br> 
												<a style="color:black;"><span><?php echo $p_height; ?></span></a>
											</div>
											</div>
											<?php } ?>
											<br> <br>
											
											<?php 
											$stmt_check = $conn->prepare("SELECT print_label,status,tracking_id,tracking_url,delivery_date as track_url FROM order_product WHERE order_id = '" . $ordersno . "' AND prod_id = '" . $prod_id . "'");
            
         
											$stmt_check->execute();
											$stmt_check->store_result();
											$stmt_check->bind_result (  $print_label,$ord_status,$tracking_id,$track_url,$delivery_date);
														 
											while($stmt_check->fetch() ){
												$print_label_data = $print_label;
												$ord_status_data = $ord_status;
												$tracking_id_data = $tracking_id;
												$tracking_url_data = $track_url;
												$delivery_date_data = $delivery_date;
											}
											if($tracking_id_data != '' && $pickup_type == 2)
											{
											?>
												<strong>Tracking ID: </strong><br>
												<a style="color:black;"><span><?php echo $tracking_id_data; ?></span></a>
											<?php
											}
											if($tracking_id != '' && $pickup_type == 2) { ?>
												<br><strong>Tracking Url: </strong><br> 
												<a style="color:green;" target="_blank" href="<?php echo 'https://ship.nimbuspost.com/shipping/tracking/'.$tracking_id; ?>"><span><?php echo 'https://ship.nimbuspost.com/shipping/tracking/'.$tracking_id; ?></span></a>
											<?php } 
											if($ord_status_data == 'Placed') {
											?>
											
											<div class="form-three widget-shadow dontprint">
												<strong>Order Status:</strong><br>
												<form class="form-horizontal" method="post" id="myform" novalidate>

													<div class="form-group row align-items-center">
														<label class="col-4 control-label m-0"> Status*</label>
														<div class="col-8">
															<select class="form-control" id="new_orderstatus" name="new_orderstatus" required>
																<option value="">Select</option>
																<option value="Accepted">Accept</option>
																<option value="Rejected">Reject</option> 
															</select>
														</div>
													</div>
													
													<div class="form-group row align-items-center" id="new_pickup_type" style="display:none;">
														<label class="col-4 control-label m-0"> Pickup Type*</label>
														<div class="col-8">
															<select class="form-control" id="pickup_type" name="pickup_type" required>
																<option value="">Select</option>
																<option selected value="1">Self Ship</option>
																<option value="2">Ship By Bussinesshub</option>
															</select>
														</div>
													</div>

													<div class="form-group row align-items-center" id="new_pickupdate" style="display:none;">
														<label for="focusedinput" class="col-4 control-label m-0">Pickup Date</label>
														<div class="col-8">
															<input type="date" class="form-control" id="pick_date" name="pick_date" placeholder="">
														</div>
													</div>
													
													<div class="form-group row align-items-center" id="new_parcel_data" style="display:none;">
														<label for="focusedinput" class="col-4 control-label m-0">Pickup Details</label>
														<div class="col-8">
															<input type="number" class="form-control" id="p_weight" name="p_weight" placeholder="Weight(gm)">
															<input type="number" class="form-control" id="p_length" name="p_length" placeholder="Length(cm)">
															<input type="number" class="form-control" id="p_width" name="p_width" placeholder="Width(cm)">
															<input type="number" class="form-control" id="p_height" name="p_height" placeholder="Height(cm)">
														</div>
													</div>
													
													<div class="col-sm-offset-2">
														<button type="submit" class="btn btn-dark" href="javascript:void(0)" id="updatestatus">Order Update</button>
													</div>
												</form>
											</div>
											<?php } else if($print_label_data != '') { ?>
													<br><br><a class="btn btn-success" href="<?php echo $print_label_data; ?>"><i class="fa fa-download"></i> Label</a>
											<?php } ?>
											<br>
											<div class="form-three widget-shadow dontprint" >
												<?php
												if ($status == 'Placed') {
													$status_array = array('Accepted' => 'Accept', 'Rejected' => 'Reject');
												} else if ($status == 'Accepted') {
													$status_array = array('Packed' => 'Packed', 'Cancelled' => 'Cancelled');
												} else if ($status == 'Packed') {
													$status_array = array('Shipped' => 'Shipped');
												} else if ($status == 'Shipped') {
													$status_array = array('Out for delivery' => 'Out for delivery');
												} else if ($status == 'Out for delivery') {
													$status_array = array('Delivered' => 'Delivered', 'RTO' => 'RTO');
												} else if ($status == 'Cancelled') {
													$status_array = array();
												} else if ($status == 'Return Requested') {
													$status_array = array('Return Accepted' => 'Accept', 'Return Rejected' => 'Reject');
													//$status_array = array('Return Accepted' => 'Return Accepted');
												} else if ($status == 'Return Accepted') {
													$status_array = array('Return Completed' => 'Return Completed');
												} else if ($status == 'Return Completed') {
													$status_array = array();
												} else if ($status == 'RTO') {
													$status_array = array();
												} else if ($status == 'Delivered') {
													$status_array = array('Return Requested' => 'Return Requested', 'Return Completed' => 'Return Completed');
												} else {
													$status_array = array();
												}
												
												if ($status == 'Accepted' || $status == 'Packed' || $status == 'Shipped' || $status == 'Out for delivery' || $status == 'Return Requested' || $status == 'Return Accepted') : ?>
												<strong>Update Status:</strong><br>
												<form class="form-horizontal" method="post" id="myform">

													<div class="form-group row align-items-center">
														<label class="col-4 control-label m-0"> Status*</label>
														<div class="col-8">
															<select class="form-control" id="orderstatus" name="orderstatus" required>
																<option value="">Select</option>
																<?php foreach ($status_array as $status_key => $status_val) { ?>
																		<option value="<?php echo $status_key; ?>"><?php echo $status_val; ?></option>
																	<?php } ?>
															</select>
														</div>
													</div>

													<div class="form-group row align-items-center">
														<label for="focusedinput" class="col-4 control-label m-0">Message</label>
														<div class="col-8">
															<input type="text" class="form-control" id="ordermessage" name="ordermessage" placeholder="">
														</div>
													</div>
													<div class="col-sm-offset-2">
														<button type="submit" class="btn btn-dark" href="javascript:void(0)" id="updatestatus">Update</button>
													</div>
													
												</form>
												<?php endif; ?>
											</div>
										</div>
										<!-- /.col -->
										<div class="col-md-6">

											<div class="table-responsive">
												<table class="table table-hover">
													<tbody>
														<tr>
															<th style="width:50%">Total:</th>
															<td><span id="subtotal"><?php echo ($prod_price * $qty) + ($discount * $qty); ?></span></td>
														</tr>
														<tr>
															<th style="width:50%">Discount:</th>
															<td><span id="subtotal"><?php echo ($discount * $qty); ?></span></td>
														</tr>
														<!--<tr>
															<th style="width:50%">Coupon Discount:</th>
															<td><span id="subtotal"><?php echo number_format($coupon_value); ?></span></td>
														</tr>-->
														<tr>
															<th style="width:50%">Shipping:</th>
															<td><span id="subtotal"><?php echo ($shipping); ?></span></td> 
														</tr>
														<tr>
															<th style="width:50%">BH Customer Discount:</th>
															<td><span id="subtotal"><?= $default_discount; ?></span></td>
														</tr>
														<tr>
															<th style="width:50%">CGST:</th>
															<td><span id="subtotal"><?= $cgst; ?></span></td>
														</tr>
														<tr>
															<th style="width:50%">SGST:</th>
															<td><span id="subtotal"><?= $sgst; ?></span></td>
														</tr>
														<tr>
															<th style="width:50%">IGST:</th>
															<td><span id="subtotal"><?= $igst; ?></span></td>
														</tr>
														<tr>
															<th style="width:50%">Subtotal (Included GST):</th>
															<td><span id="subtotal">Rs. <?php echo ($prod_price * $qty) + $shipping - $default_discount; ?></span></td>
														</tr>


													</tbody>
												</table>
											</div>
											
											


											<?php /*<div class="form-three widget-shadow dontprint mb-3"> 
												<strong>Pickup Details</strong> <br>
												<form class="form-horizontal" method="post" id="pickup_form">
													<div class="form-group row align-items-center">
														<label class="col-4 control-label m-0"> Pickup Date*</label>
														<div class="col-8">
															<input type="text" class="form-control" id="pickup_curier_date" name="pickup_curier_date" readonly required placeholder="">
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
														CURLOPT_POSTFIELDS => '{
															"email" : "marurangecommerce@gmail.com",
															"password" : "Borawar@739"				
														}',
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
														CURLOPT_POSTFIELDS => '{
															"origin" : ' . $_SESSION['seller_pincode'] . ',
															"destination" : ' . $pincode . ',
															"payment_type" : "cod",
															"order_amount" : "999",
															"weight" : "500",	
															"length" : "10",
															"breadth" : "10",
															"height" : "10"
														}',
														CURLOPT_HTTPHEADER => array(
															'Content-Type: application/json',
															'Authorization: token ' . $token . ''
														),
													));
													$response_rate = curl_exec($curl);
													curl_close($curl);
													$response_rate = json_decode($response_rate);
													?>
													<div class="form-group row align-items-center">
														<label for="focusedinput" class="col-4 control-label">Courier Name</label>
														<div class="col-8">
															<select class="form-control" id="curier_name" name="curier_name">
																<option>select Courier</option>
																<?php
																foreach ($response_rate->data as $ship_data) {
																	if ($ship_data->id != '' && $ship_data->id == 5) { ?>
																		<option value="<?php echo $ship_data->id; ?>"><?php echo $ship_data->name; ?></option>
																	<?php } else if ($ship_data->id != '' && $ship_data->id == 3) // Xpressbees Air  { ?>
																		<option value="<?php echo $ship_data->id; ?>"><?php echo $ship_data->name; ?></option>
																	<?php } else if ($ship_data->id != '' && $ship_data->id == 6) // Delhivery Surface  { ?>
																		<option value="<?php echo $ship_data->id; ?>"><?php echo $ship_data->name; ?></option>
																	<?php } else if ($ship_data->id != '' && $ship_data->id == 15) // Ekart  { ?>
																		<option value="<?php echo $ship_data->id; ?>"><?php echo $ship_data->name; ?></option>
																	<?php } else if ($ship_data->id != '' && $ship_data->id == 66) // Amazon Shipping  { ?>
																		<option value="<?php echo $ship_data->id; ?>"><?php echo $ship_data->name; ?></option>
																<?php }
																}
																?>
															</select>
														</div> 
													</div>
													<div class="col-sm-offset-2">
														<button type="submit" class="btn btn-dark" href="javascript:void(0)" id="pickup_form">Update</button>
													</div>
												</form>
											</div> */ ?>
											<?php if ($pickup_type == '1') { ?>
												<div class="form-three widget-shadow dontprint mb-3" >
													<strong>Courier Details</strong> <br>
													<form class="form-horizontal" method="post" id="myform_tracking">

														<div class="form-group row align-items-center">
															<label class="col-4 control-label m-0"> Delivery Date*</label>
															<div class="col-8">
																<input type="text" class="form-control" id="delivery_date1" name="delivery_date" value="<?php if($delivery_date_data != '0000-00-00') { echo $delivery_date_data; } ?>" readonly required placeholder="">
															</div>
														</div>

														<div class="form-group row align-items-center">
															<label for="focusedinput" class="col-4 control-label m-0">Tracking Id</label>
															<div class="col-8">
																<input type="text" class="form-control" id="tracking_id" name="tracking_id" value="<?php echo $tracking_id_data; ?>" placeholder="">
															</div>
														</div>

														<div class="form-group row align-items-center">
															<label for="focusedinput" class="col-4 control-label m-0">Tracking Url</label>
															<div class="col-8">
																<input type="text" class="form-control" id="tracking_url" name="tracking_url" value="<?php echo $tracking_url_data; ?>" placeholder="">
															</div>
														</div>
														<div class="col-sm-offset-2">
															<button type="submit" class="btn btn-dark" href="javascript:void(0)" id="updatetracking">Update</button>
														</div>
													</form>
												</div>
											<?php } else if ($status == 'Returned') { ?>
												<div class="form-three widget-shadow dontprint mb-3">
													<strong>Return Details</strong> <br>
													<form class="form-horizontal" method="post" id="myform_tracking">

														<div class="form-group row aligm-items-center">
															<label class="col-4 control-label m-0"> Return Date*</label>
															<div class="col-8">
																<input type="text" class="form-control" id="delivery_date1" name="pickup_date" readonly required placeholder="">
															</div>
														</div>

														<div class="form-group row aligm-items-center">
															<label for="focusedinput" class="col-sm-2 control-label">Return Status </label>
															<div class="col-sm-8">
																<select class="form-control" id="pickup_status" name="pickup_status" required>
																	<option value="">Select</option>
																	<option value="Return Scheduled">Return Scheduled</option>
																	<option value="Return Cancelled">Return Cancelled</option>
																	<option value="Return Reschedule">Return Reschedule</option>
																	<option value="Return Completed">Return Completed</option>

																</select>
															</div>
														</div>


														<div class="col-sm-offset-2">
															<button type="submit" class="btn btn-dark" href="javascript:void(0)" id="updatepickup">Update</button>
														</div>
													</form>
												</div>
											<?php } ?>

										</div>
										<br><br>
										<div class="col-12 dontprint mt-2">
											<div class="form-three widget-shadow dontprint">
												<h5 class="text-center"><strong>Chat With User</strong></h5> <br>
												<form class="form-horizontal text-center" method="post" id="myform_tracking">
													<div class="form-group row align-items-center">
														<label class="col-2 control-label"> Title*</label>
														<div class="col-8"> <input type="text" class="form-control" id="msg_title" name="msg_title" required placeholder=""> </div>
													</div>
													<div class="form-group row align-items-center">
														<label for="focusedinput" class="col-2 control-label">Message</label>
														<div class="col-8">
															<textarea class="form-control" id="msg_data" col="3" name="msg_data" placeholder=""></textarea>
														</div>
													</div>
													<div class="col-sm-offset-2"> <button type="submit" name="meg_form" value="meg_data" class="btn btn-dark waves-effect waves-light" href="javascript:void(0)" id="sendmessaga">Send</button> </div>
												</form>
											</div>
										</div>

										<div class="col-12 dontprint mt-2">
											<div class="form-three widget-shadow">
												<strong>Track Status</strong> <br>
												<table class="table table-hover" style="border: 0.5px solid #ccc;">
													<thead class="thead-light">
														<tr>
															<th>Status</th>
															<th>Date</th>
															<th>Message</th>

														</tr>
													</thead>
													<tbody>
														<?php
														$status_track = $conn->prepare("SELECT `status`, `message`, `created_at` FROM `order_tracking_status` WHERE order_id = '" . $ordersno . "' AND product_id = '" . $product_id . "' ORDER BY id asc ");

														$status_track->execute();
														$datap = $status_track->bind_result($trackst, $trackmag, $tracktime);

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
								</div> <!-- print area close-->

								<?php

									/* $curl_handle=curl_init();
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
									$user_state_name = $satte1_data[0]->PostOffice[0]->State; */

								?>

								<button type="submit" style="position: fixed;bottom: 62px;right: 5px;" href="javascript:void(0)" onclick="generate_invoice('<?php echo $prod_id; ?>','<?php echo $ordersno; ?>'); " class="btn btn-danger pull-right" style="margin-right: 5px;margin-top: 11px;">
									<i class="fa fa-download"></i> Generate Invoice
								</button>


								<script>
									function generate_invoice(prod_id, ordersno) {
										location.href = 'generate_invoice.php?orderid=' + ordersno + '&product_id=' + prod_id;
									}
								</script>
								<!-- this row will not appear when printing -->
								<div class="row no-print">
									<div class="col-xs-8">





									</div>


									<div class="col-xs-4">




									</div>
								</div></br></br>
								<center>
									<p id="test1" style="color:green;"></p>
								</center>


								<div class="clearfix"> </div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="clearfix"> </div>

			<div class="col_1">

				<div class="clearfix"> </div>

			</div>

		</div>
	</div>
</div>
<!--footer-->
<?php include('footernew.php'); ?>
<!--//footer-->

<script>
	$(function() {
		/* $("#delivery_date1").datepicker({
			dateFormat: "yy-mm-dd"
		}); */

		$('#delivery_date1').flatpickr({
			weekStart: 0,
			time: false,
		});
	});
	
	
	$('#new_orderstatus').change(function () { 
    if ($(this).val() == 'Accepted'){
      $('#new_pickupdate').show();
      $('#new_pickup_type').hide();
    }
    else
	{
		$('#new_pickupdate').hide();
		$('#new_pickup_type').hide();
	}
	
	
	
});

$('#pickup_type').change(function () {
	if ($(this).val() == '2'){
		$('#new_parcel_data').show();
	}
	else
	{
		$('#new_parcel_data').hide();
	}
});



	$(document).ready(function() {
		$("#updatetracking").click(function(event) {
			event.preventDefault();
			var delivery_date1 = $("#delivery_date1").val();

			if (!delivery_date1) {
				successmsg("Please select delivery date.");
			} else {
				$("#myform_tracking").submit();
			}
		});


		$("#updatepickup").click(function(event) {
			event.preventDefault();
			var delivery_date1 = $("#delivery_date1").val();
			var pickup_status = $("#pickup_status").val();

			if (!delivery_date1) {
				successmsg("Please select pickup date.");
			} else if (!pickup_status) {
				successmsg("Please select pickup status.");
			} else {
				$("#myform_tracking").submit();
			}
		});
	});

	function refreshdata() {
		var order_id = $('#sno_order').val();

		//  alert("--"+order_id); 
		$.ajax({
			method: 'POST',
			url: 'edit_order_data.php',
			data: {
				code: "123",
				orderid: order_id
			},
			success: function(response) {
				//  alert(response); // display response from the PHP script, if any
				//$('#msgdiv').val("subsdfa");
				var data = $.parseJSON(response);

				if (data["status"] == "1") {
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
					var count = 1;
					$(data["proddetails"]).each(function() {
						var btnstatus = '<button type = "button" class = "btn-alert">View</button>';

						//	alert( "btn "+this.prodid);
						$("#tbodyPostid").append('<tr> <th style="display:none;"><input type="text" class="nrprodid" style="width:30px;" value="' + this.prodid + '"></input></th><th scope="row">' + count + '</th><td style="display:none;"><img   src=' + this.img + ' style="width: 121px; height: 72px;"></td><td class="dontprint">' + this.sellername + '</td><td>' + this.prodname + '</td> <td> ' + this.otherart + '</td><td >' + this.price + '</td><td class="nrqtyorg">' + this.orgqty + '</td><td>' + this.cgst + '</td><td>' + this.sgst + '</td><td style="display:none;">' + this.ship + '</td><td>' + this.total + '</td><td style="color:red">' + this.prodstatus + '</td><td class="dontprint">' + btnstatus + '</td></tr> ');
						//	alert(this.orgqty);

						count = count + 1
					});

					$(".btn-alert").click(function() {
						var $row = $(this).closest("tr"); // Find the row
						var $text = $row.find(".nrprodid").val(); // Find the text
						viewProduct($text, "20");
						// alert("prod ID "+$text); 


					});


				} else {


				}


			}
		});
	}
</script>