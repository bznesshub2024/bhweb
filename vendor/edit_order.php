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
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
?>

<?php
$stmt = $conn->prepare("SELECT o.* FROM orders o, order_product op WHERE op.order_id = o.order_id and op.order_id = ? and op.prod_id = ?");
$stmt->bind_param("ss", $ordersno, $product_id);
$stmt->execute();
$result = $stmt->get_result();
$order_data = $result->fetch_assoc();
$stmt->close();

$stmt = $conn->prepare("SELECT op.* FROM orders o, order_product op WHERE op.order_id = o.order_id and op.order_id = ? and op.prod_id = ?");
$stmt->bind_param("ss", $ordersno, $product_id);
$stmt->execute();
$result = $stmt->get_result();
$order_product_data = $result->fetch_assoc();
$stmt->close();


$stmt_state = $conn->prepare("SELECT name FROM  state WHERE stateid = '" . $_SESSION['seller_state_id'] . "' ");

$stmt_state->execute();
$data1 = $stmt_state->bind_result($state_name);
$state_name  = '';
while ($stmt_state->fetch()) {
	$state_name = $state_name;
}

$stmt_city = $conn->prepare("SELECT city_name FROM  city WHERE city_id = '" . $_SESSION['seller_city_id'] . "' ");

$stmt_city->execute();
$data2 = $stmt_city->bind_result($city_name);
$city_name  = '';
while ($stmt_city->fetch()) {
	$city_name = $city_name;
}

// echo "<pre>";
// print_r($order_product_data);
// exit;
?>

<?php if (isset($_POST['orderstatus']) && $ordersno && $product_id) {

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
		
		    $r_amount = round($order_product_data['prod_price'] * $order_product_data['qty'],2);
			$sql_rtn = $conn->prepare("INSERT INTO `refund_user`(`order_id`, `product_id`, `amount`, `order_date`, `refund_status`,`create_date`) VALUES (
					'" . $ordersno . "','" . $product_id . "','" . $r_amount . "','" . $order_product_data['create_date'] . "','0','" . $datetime . "')");
			$sql_rtn->execute();
			$sql_rtn->store_result();
		
	}
	/* notes to check if vendor cancel return order then in nimbus post return order shold be cancel as well. $orderstatus == 'Return Cancelled' && $order_product_data['tracking_id'] != '' */
	if($orderstatus == 'Cancelled' && $order_product_data['tracking_id'] != '')
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
						echo $token = $token_data->data;
						
						
						$curl = curl_init();

						curl_setopt_array($curl, array(
						  CURLOPT_URL => 'https://api.nimbuspost.com/v1/shipments/cancel',
						  CURLOPT_RETURNTRANSFER => true,
						  CURLOPT_ENCODING => '',
						  CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 0,
						  CURLOPT_FOLLOWLOCATION => true,
						  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => 'POST',
						  CURLOPT_POSTFIELDS =>'{
							"awb" : "'. $order_product_data['tracking_id'] .'"
						}',
						  CURLOPT_HTTPHEADER => array(
							'Content-Type: application/json',
								'charset: utf-8',
								'Authorization: Token ' . $token
						  ),
						));

						$response = curl_exec($curl);
						curl_close($curl);
	}
	

	$sql1 = $conn->prepare("UPDATE order_product SET status = '" . $orderstatus . "', status_date = '" . $datetime . "', update_date = '" . $datetime . "', reverse_shipping = '" . $reverse_shipping . "' WHERE order_id = '" . $ordersno . "' AND prod_id = '" . $product_id . "'");
	$sql1->execute();
	$sql1->store_result();
	
	if ($rows > 0) {
		if($order_data['mobile'] != '')
		{
			$Common_Function->send_delivered_email_invoice_user($conn, $ordersno, $product_id, $_SESSION['admin'], $orderstatus);
		}
		echo "<script>successmsg1('Order updated successfully.', 'edit_order.php?orderid={$ordersno}&product_id={$product_id}'); </script>";
		//if($orderstatus =='Delivered'){

		//}

	}
}

if (isset($_POST['curier_name']) && $_POST['curier_name'] == 'self') {
	$new_orderstatus = trim($_POST['new_orderstatus']);


	$curier_name = trim($_POST['curier_name']);

	/*$new_pickupdate = trim($_POST['pick_date']);
	$curtime = date('H:i:s');
	$pick_date = date("Y-m-d H:i:s", strtotime($new_pickupdate . $curtime));*/

	$sql_new = $conn->prepare("UPDATE order_product SET status = '" . $new_orderstatus . "',pickup_type = '" . $curier_name . "', update_date = '" . $datetime . "' WHERE order_id = '" . $ordersno . "' AND prod_id = '" . $product_id . "'");
	$sql_new->execute();
	$sql_new->store_result();
	echo "<script>successmsg1('Order updated successfully.', 'edit_order.php?orderid={$ordersno}&product_id={$product_id}'); </script>";
}

if (isset($_POST['delivery_date']) && $ordersno && $product_id) {
	$delivery_date = trim($_POST['delivery_date']);
	$tracking_id = trim($_POST['tracking_id']);
	$tracking_url = trim($_POST['tracking_url']);

	$sql1 = $conn->prepare("UPDATE order_product SET delivery_date = '" . $delivery_date . "', tracking_id = '" . $tracking_id . "', tracking_url = '" . $tracking_url . "', update_date = '" . $datetime . "' WHERE order_id = '" . $ordersno . "'
							AND prod_id = '" . $product_id . "'");
	$sql1->execute();
	$sql1->store_result();

	echo "<script>successmsg1('Order updated successfully.', 'edit_order.php?orderid={$ordersno}&product_id={$product_id}'); </script>";
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


<?php /* if (isset($_POST['orderstatus']) && $ordersno && $product_id) {
	$awb = $order_product_data['tracking_id'];
	$logistic_name = $order_product_data['courier_name'];
	$tracking_url = $order_product_data['tracking_url'];

	$orderstatus = $_POST['orderstatus'];
	$ordermessage = trim($_POST['ordermessage']);

	if ($orderstatus == 'Packed') {
		$curl = curl_init();

		$order_data = [
			"data" => [
				"shipments" => [
					[
						"waybill" => "",
						"order" => $ordersno,
						"sub_order" => "",
						"order_date" => date('d-m-Y'),
						"total_amount" => $order_product_data['prod_price'] - $order_product_data['discount'],
						"name" => $order_data['fullname'],
						"company_name" => "",
						"add" => $order_data['fulladdress'],
						"add2" => "",
						"add3" => "",
						"pin" => $order_data['pincode'],
						"city" => $order_data['city'],
						"state" => $order_data['state'],
						"country" => "India",
						"phone" => $order_data['mobile'],
						"alt_phone" => "",
						"email" => $order_data['email'],
						"is_billing_same_as_shipping" => "yes",
						"products" => [
							[
								"product_name" => $order_product_data['prod_name'],
								"product_sku" => $order_product_data['prod_sku'],
								"product_quantity" => $order_product_data['qty'],
								"product_price" => $order_product_data['prod_price'] - $order_product_data['discount'],
								"product_tax_rate" => "18",
								"product_hsn_code" => "",
								"product_discount" => "0"
							]
						],
						"shipment_length" => $order_product_data['p_length'],
						"shipment_width" => $order_product_data['p_width'],
						"shipment_height" => $order_product_data['p_height'],
						"weight" => $order_product_data['p_weight'],
						"shipping_charges" => "0",
						"giftwrap_charges" => "0",
						"transaction_charges" => "0",
						"total_discount" => "0",
						"first_attemp_discount" => "0",
						"cod_charges" => "0",
						"advance_amount" => "0",
						"cod_amount" => $order_data['payment_mode'] == 'COD' ? $order_product_data['prod_price'] - $order_product_data['discount'] : "0",
						"payment_mode" => $order_data['payment_mode'],
						"reseller_name" => "",
						"eway_bill_number" => "",
						"gst_number" => "",
						"return_address_id" => "55456"
					]
				],
				"pickup_address_id" => "55456",
				"access_token" => "9822895baf22790897c2167827dbf541",
				"secret_key" => "6d7b10675777ce233b7b705074cf87a9",
				"logistics" => "Delhivery",
				"s_type" => "",
				"order_type" => ""
			]
		];

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://my.ithinklogistics.com/api_v3/order/add.json',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode($order_data),
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		$order_reponse = json_decode($response, true);

		if ($order_reponse['status'] == 'success') {
			$awb =  $order_reponse['data'][1]['waybill'];
			$logistic_name =  $order_reponse['data'][1]['logistic_name'];
			$tracking_url =  $order_reponse['data'][1]['tracking_url'];
		} else {
			echo "<script>successmsg1('" . $order_reponse['html_message'] . "', 'edit_order.php?orderid={$ordersno}&product_id={$product_id}'); </script>";
			return;
		}
	}

	$sql_status = $conn->prepare("INSERT INTO `order_tracking_status`(`order_id`, `product_id`, `status`, `message`, `created_at`) VALUES (
					'" . $ordersno . "','" . $product_id . "','" . $orderstatus . "','" . $ordermessage . "','" . $datetime . "')");
	$sql_status->execute();
	$sql_status->store_result();
	$rows = $sql_status->affected_rows;

	$reverse_shipping = 0;

	$sql1 = $conn->prepare("UPDATE order_product SET status = '" . $orderstatus . "', tracking_id = '" . $awb . "', tracking_url = '" . $tracking_url . "', courier_name = '" . $logistic_name . "', update_date = '" . $datetime . "', reverse_shipping = '" . $reverse_shipping . "' WHERE order_id = '" . $ordersno . "' AND prod_id = '" . $product_id . "'");
	$sql1->execute();
	$sql1->store_result();

	if ($rows > 0) {
		$Common_Function->send_delivered_email_invoice_user($conn, $ordersno, $product_id, $_SESSION['admin'], $orderstatus);
		echo "<script>successmsg1('Order updated successfully.', 'edit_order.php?orderid={$ordersno}&product_id={$product_id}'); </script>";
	}
}*/
?>

<!-- main content start-->
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
									<a href="javascript: void(0);">Invoice : <?= $order_product_data['invoice_number']; ?></a>
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
									<input type="hidden" class="form-control1" id="site_url" value=<?= BASEURL; ?>></input>
									<input type="hidden" class="form-control1" id="sno_order" value=<?= $ordersno; ?>></input>
									<input type="hidden" class="form-control1" id="prod_id" value=<?= $product_id; ?>></input>
									<input type="hidden" class="form-control1" id="user_id" value=<?= $order_data['user_id']; ?>></input>
									<input type="hidden" class="form-control1" id="seller_id" value=<?= $_SESSION['admin']; ?>></input>
									<input type="hidden" class="form-control1" id="cust_phone" value=<?= $order_data['mobile']; ?>></input>
									<input type="hidden" class="form-control1" id="cust_email" value=<?= $order_data['email']; ?>></input>
									<input type="hidden" name="code_ajax" id="code_ajax" value="<?= $code_ajax; ?>" />

									<!-- title row -->
									<div class="row invoice-info">

										<div class="col-12 table-responsive">
											<table class="table table-hover">
												<thead class="thead-light">
													<tr>
														<th> OrderID</th>
														<th> Customer Details </th>
														<th> Shipping Address </th>
														<th> <b>Order Status </b></th>
														<th> <b>Order Date </b></th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>
															<?= $ordersno . '<br>'; ?>
														</td>
														<td>
															<?= $order_data['fullname'] ?>
															<?php /* '<br>'.$order_data['mobile'].'<br>'.$order_data['email'] */?>
														</td>
														<td>
															<?= $order_data['fullname'] . '<br>' .
																/*$order_data['mobile'] . ', ' . $order_data['email'] . ',<br>' .*/
																$order_data['fulladdress'] . ',<br>' . $order_data['city'] . ', ' . $order_data['state'] . ', India, ' . $order_data['pincode'];
															?>
														</td>
														<td><?= $order_product_data['status'] ?> </td>
														<td><?= date('d M Y h:i a', strtotime($order_data['create_date'])) ?> </td>
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
														<th>SKU</th>
														<!-- <th>Attribute</th> -->
														<th>Price</th>
														<th>Qty</th>
														<th class="dontprint">Action</th>
													</tr>
												</thead>

												<tbody id="tbodyPostid">
													<tr>
														<td><img src="<?= MEDIAURL.$order_product_data['prod_img'] ?>" style="width:50px;"> </td>
														<td><?= $order_product_data['prod_name']; ?> </td>
														<td><?= $order_product_data['prod_id']; ?> </td>
														<td><?= $order_product_data['prod_sku']; ?> </td>
														<?php
														$prod_attr1 = is_array(json_decode($order_product_data['prod_attr'])) ? rtrim(implode(', ', array_map(function ($prod_attr) {
															if (preg_match('/^#(?:[0-9a-fA-F]{3}){1,2}$/', $prod_attr->item)) {
																list($r, $g, $b) = sscanf($prod_attr->item, "#%02x%02x%02x");
																$darkerColor = "rgb(" . ($r * 0.8) . ", " . ($g * 0.8) . ", " . ($b * 0.8) . ")";
																$label =  '<label style="height: 20px; width: 20px; border-radius: 20px; background-color: ' . $prod_attr->item . '; border: 1px solid ' . $darkerColor . '">&nbsp;&nbsp;</label>';
																return $prod_attr->attr_name . ': ' . $label;
															} else {
																return $prod_attr->attr_name . ': ' . $prod_attr->item;
															}
														}, json_decode($order_product_data['prod_attr']))), ', ') : '';
														?>
														<!-- <td><?= $prod_attr1 ?></td> -->
														<td><?= $order_product_data['prod_price'] ?></td>
														<td><?= $order_product_data['qty']; ?> </td>
														<td class="dontprint"><button type="submit" onclick="back_page('view_product.php?id=<?= $product_id; ?>')" id="back_btn" class="btn btn-danger" style="margin-right:10px; margin-top:-4px;"> View Product</button> </td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<!-- /.col -->
									<span id="qty_save"></span> <br>
									<!-- /.row -->


									<div class="row">
										<!-- accepted payments column -->
										<div class="col-md-6">
											<strong>Shipping Type:</strong>
											<br>
											<a style="color:black;"><span id="deliverymode"><?= $order_product_data['pickup_type'] == "self" ? "Self Shipping" : "Ship By " . $Common_Function->get_system_settings($conn, "system_name") ?></span></a>
											<br><br>
											<strong>Payment Methods:</strong> <br>
											<a style="color:black;"><span id="deliverymode"><?= $order_data['payment_mode']; ?></span></a><br><br>
											<strong>Payment TXN ID: </strong><br>
											<a style="color:black;"><span id="paymentid"><?= $order_data['payment_id']; ?></span></a>
											<?php if($order_product_data['pickup_type'] == 'self' && $order_product_data['$tracking_id'] != '') { ?>
											<br>
											<br> <strong>Tracking ID: </strong>
											<br> <a style="color:black;"><span id="paymentid"><?= $order_product_data['$tracking_id']; ?></span></a>
											<?php } ?>
											<?php if ($order_product_data['tracking_url']) : ?>
												<br>
											<br> <strong>Tracking Url: </strong><br>
												<a href="<?= $order_product_data['tracking_url']; ?>" target="_blank" rel="noopener noreferrer"><?= $order_product_data['tracking_url']; ?></a>
											<?php endif ?>

											<?php if ($order_product_data['p_weight'] != '') { ?>
												<br><br>
												<div class="row p-2">
													<div class="col-md-6" style="padding:0 !important;">
														<strong>Product Weight(gm): </strong><br>
														<a style="color:black;"><span><?= $order_product_data['p_weight']; ?></span></a>
													</div>
													<div class="col-md-6">
														<strong>Product Length(cm): </strong><br>
														<a style="color:black;"><span><?= $order_product_data['p_length']; ?></span></a>
													</div>
													<div class="col-md-6" style="padding:0 !important;">
														<strong>Product Width(cm): </strong><br>
														<a style="color:black;"><span><?= $order_product_data['p_width']; ?></span></a>
													</div>
													<div class="col-md-6">
														<strong>Product Height(cm): </strong><br>
														<a style="color:black;"><span><?= $order_product_data['p_height']; ?></span></a>
													</div>
												</div>
											<?php } ?>

											<br><br>
											<?php
											$status_array = array();
											if ($order_product_data['pickup_type'] == 'self') {
												if ($order_product_data['status'] == 'Placed') {
													$status_array = array('Accepted' => 'Accepted', 'Rejected' => 'Rejected');
												} else if ($order_product_data['status'] == 'Accepted') {
													$status_array = array('Packed' => 'Packed', 'Cancelled' => 'Cancelled');
												} else if ($order_product_data['status'] == 'Packed') {
													$status_array = array('Shipped' => 'Shipped');
												} else if ($order_product_data['status'] == 'Shipped') {
													$status_array = array('Out for delivery' => 'Out for delivery');
												} else if ($order_product_data['status'] == 'Out for delivery') {
													$status_array = array('Delivered' => 'Delivered', 'RTO' => 'RTO');
												} else if ($order_product_data['status'] == 'Cancelled') {
													$status_array = array();
												} else if ($order_product_data['status'] == 'Return Requested') {
												$status_array = array('Return Accepted' => 'Return Accepted', 'Return Rejected' => 'Return Rejected');
											} else if ($order_product_data['status'] == 'Return Accepted') {
												$status_array = array('Return Cancelled' => 'Return Cancelled', 'Return Completed' => 'Return Completed');
												} else if ($order_product_data['status'] == 'Return Completed') {
													$status_array = array();
												} else if ($order_product_data['status'] == 'RTO') {
													$status_array = array();
												} else if ($order_product_data['status'] == 'Delivered') {
													$status_array = array('Return Requested' => 'Return Requested', 'Return Completed' => 'Return Completed');
												} else {
													$status_array = array();
												}
											} else {

												if ($order_product_data['status'] == 'Placed') {
													$status_array = array('Accepted' => 'Accepted', 'Rejected' => 'Rejected');
												} else if ($order_product_data['status'] == 'Accepted') {
													$status_array = array('Packed' => 'Packed', 'Cancelled' => 'Cancelled');
												} else if ($order_product_data['status'] == 'Packed') {
													$status_array = array('Shipped' => 'Shipped');
												} else if ($order_product_data['status'] == 'Shipped') {
													$status_array = array('Out for delivery' => 'Out for delivery');
												} else if ($order_product_data['status'] == 'Out for delivery') {
													$status_array = array('Delivered' => 'Delivered', 'RTO' => 'RTO');
												} else if ($order_product_data['status'] == 'Cancelled') {
													$status_array = array();
												} else if ($order_product_data['status'] == 'Return Requested') {
													$status_array = array('Return Accepted' => 'Return Accepted', 'Return Rejected' => 'Return Rejected');
												} else if ($order_product_data['status'] == 'Return Accepted') {
												$status_array = array('Return Cancelled' => 'Return Cancelled', 'Return Completed' => 'Return Completed');
												} else if ($order_product_data['status'] == 'Return Completed') {
													$status_array = array();
												} else if ($order_product_data['status'] == 'RTO') {
													$status_array = array();
												} else if ($order_product_data['status'] == 'Delivered') {
													$status_array = array('Return Requested' => 'Return Requested', 'Return Completed' => 'Return Completed');
												} else {
													$status_array = array();
												}
											}

											if ($order_product_data['status'] == 'Accepted' || $order_product_data['status'] == 'Packed' || $order_product_data['status'] == 'Shipped' || $order_product_data['status'] == 'Out for delivery' || $order_product_data['status'] == 'Return Requested' || $order_product_data['status'] == 'Return Accepted') : ?>
												<div class="form-three widget-shadow mt-2 dontprint">
													<strong>Update Status:</strong><br>
													<form class="form-horizontal" method="post" id="orderEditForm">

														<div class="form-group row align-items-center">
															<label for="orderstatus" class="col-4 control-label m-0"> Status*</label>
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
												</div>
											<?php endif; ?>
										</div>
										<!-- /.col -->
										<div class="col-md-6">
											<div class="table-responsive">
												<table class="table table-hover">
													<tbody>
														<tr>
															<th style="width:50%">Total:</th>
															<td><span id="subtotal"><?= $order_product_data['prod_price'] * $order_product_data['qty'] ?></span></td>
														</tr>
														<tr>
															<th style="width:50%">Discount:</th>
															<td><span id="subtotal"><?= $order_product_data['discount'] * $order_product_data['qty']; ?></span></td>
														</tr>
														<tr>
															<th style="width:50%">Shipping:</th>
															<td><span id="subtotal"><?= $order_product_data['shipping']; ?></span></td>
														</tr>
														<tr>
															<th style="width:50%">CGST(<?= round($order_product_data['gst_percentage'] / 2, 2) ?>%):</th>
															<td><span id="subtotal"><?= $order_product_data['cgst']; ?></span></td>
														</tr>
														<tr>
															<th style="width:50%">SGST(<?= round($order_product_data['gst_percentage'] / 2, 2) ?>%):</th>
															<td><span id="subtotal"><?= $order_product_data['sgst']; ?></span></td>
														</tr>
														<tr>
															<th style="width:50%">IGST(<?= round($order_product_data['gst_percentage'], 2) ?>%):</th>
															<td><span id="subtotal"><?= $order_product_data['igst']; ?></span></td>
														</tr>
														<tr>
															<th style="width:50%">Subtotal:</th>
															<td><span id="subtotal"><?= $Common_Function->price_formate($conn, ($order_product_data['prod_price']) * $order_product_data['qty'] + $order_product_data['shipping']) ?></span></td>
														</tr>


													</tbody>
												</table>
											</div>

											<?php if ($order_product_data['status'] !== 'Placed' && $order_product_data['pickup_type'] == 'self') { ?>
												<div class="form-three widget-shadow dontprint mb-3">
													<strong>Courier Details</strong> <br>
													<form class="form-horizontal" method="post" id="myform_tracking">
														<div class="form-group row align-items-center" style="display:none">
															<label for="focusedinput" class="col-4 control-label m-0">Delivery Date</label>
															<div class="col-8">
																<input type="text" class="form-control" id="delivery_date" name="delivery_date" placeholder="" value="<?= $order_product_data['delivery_date'] != '0000-00-00' ? $order_product_data['delivery_date'] : '' ?>">
															</div>
														</div>
														<div class="form-group row align-items-center">
															<label for="focusedinput" class="col-4 control-label m-0">Tracking Id</label>
															<div class="col-8">
																<input type="text" class="form-control" id="tracking_id" name="tracking_id" placeholder="" value="<?= $order_product_data['tracking_id'] ?>">
															</div>
														</div>

														<div class="form-group row align-items-center">
															<label for="focusedinput" class="col-4 control-label m-0">Tracking Url</label>
															<div class="col-8">
																<input type="text" class="form-control" id="tracking_url" name="tracking_url" placeholder="" value="<?= $order_product_data['tracking_url'] ?>">
															</div>
														</div>
														<div class="col-sm-offset-2">
															<button type="submit" class="btn btn-dark" href="javascript:void(0)" id="updatetracking">Update Tracking</button>
														</div>
													</form>
												</div> 
											<?php } ?>

											<?php
											

											if (isset($_POST['curier_company']) && $_POST['curier_company'] != '' && $_POST['curier_name'] != 'self' && $_POST['new_orderstatus'] == 'Accepted') {
												
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
												$url = 'https://api.nimbuspost.com/v1/shipments';

												$discount = str_replace('-','',$order_product_data['discount']);

												$data_ship = array(
													"order_number" => $order_product_data['invoice_number'],
													"shipping_charges" => 0,
													"discount" =>  $discount,
													"cod_charges" => 0,
													"payment_type" => strtolower($order_data['payment_mode']),
													"order_amount" => ($order_product_data['prod_price']) * $order_product_data['qty'],
													"package_weight" => $order_product_data['p_weight'],
													"package_length" =>  $order_product_data['p_length'],
													"package_breadth" => $order_product_data['p_width'],
													"package_height" => $order_product_data['p_height'],
													"consignee" => array(
														"name" => $order_data['fullname'],
														"address" => $order_data['fulladdress'],
														"address_2" => "",
														"city" => $order_data['city'],
														"state" => $order_data['state'],
														"pincode" => $order_data['pincode'],
														"phone" => $order_data['mobile']
													),
													"pickup" => array(
														"warehouse_name" => $_SESSION['seller_company'],
														"name" => $_SESSION['seller_name'],
														"address" => $_SESSION['seller_address'],
														"address_2" => "",
														"city" => $city_name,
														"state" => $state_name,
														"pincode" => $_SESSION['seller_pincode'],
														"phone" => $_SESSION['seller_phone']
														/*"phone" => $Common_Function->get_system_settings($conn, 'system_other_phone')*/
													),
													"order_items" => array(
														array(
															"name" => $order_product_data['prod_name'],
															"qty" => $order_product_data['qty'],
															"price" => ($order_product_data['prod_price']) * $order_product_data['qty'],
															"sku" => $order_product_data['prod_sku']
														)
													),
													"courier_id" => $_POST['curier_company'],
													"is_insurance" => "0",
													"tags" => "tag1, tag2"
												);
												

												$ch = curl_init($url); 

												$json_data = json_encode($data_ship);
												curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
												curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
												curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
												curl_setopt($ch, CURLOPT_HTTPHEADER, array(
													'Content-Type: application/json',
													'charset: utf-8',
													'Authorization: Token ' . $token,
													'Content-Length: ' . strlen($json_data)
												));

												$response_ship = curl_exec($ch);


												$response_shipment = json_decode($response_ship);
												
												
												//print_r($response_shipment);
												
												$tracking_id = $response_shipment->data->awb_number;
												$print_label = $response_shipment->data->label;
												$courier_name = $response_shipment->data->courier_name;
												if ($tracking_id != '') {
													$tracking_url = 'https://ship.nimbuspost.com/shipping/tracking/' . $tracking_id;
												} else {
													$tracking_url = '';
												}

												if($tracking_id)
												{

													$new_orderstatus = trim($_POST['new_orderstatus']);
													$new_pickupdate = trim($_POST['pick_date']);
													$curier_name = trim($_POST['curier_name']);

													$sql_ship = $conn->prepare("UPDATE order_product SET status = '" . $new_orderstatus . "', pickup_date = '" . $new_pickupdate . "',pickup_type = '" . $curier_name . "', tracking_id = '" . $tracking_id . "', tracking_url = '" . $tracking_url . "', print_label = '" . $print_label . "', courier_name = '" . $courier_name . "', courier_id = '" . $_POST['curier_company'] . "' WHERE order_id = '" . $ordersno . "' AND prod_id = '" . $product_id . "'");
													$sql_ship->execute();
													$sql_ship->store_result();
													echo "<script>successmsg1('Order updated successfully.', 'edit_order.php?orderid={$ordersno}&product_id={$product_id}'); </script>";
												}
												else
												{
													echo '<p style="color:red;">'.$response_shipment->message.'</p>';
												}
											}
											
											if($_POST['new_orderstatus'] == 'Rejected')
											{
												$sql_reject = $conn->prepare("UPDATE order_product SET status = '" . $_POST['new_orderstatus'] . "' WHERE order_id = '" . $ordersno . "' AND prod_id = '" . $product_id . "'");
												$sql_reject->execute();
												$sql_reject->store_result();
												
												echo "<script>successmsg1('Order updated successfully.', 'edit_order.php?orderid={$ordersno}&product_id={$product_id}'); </script>";
											}

											if ($order_product_data['status'] == 'Placed') {
											?>




												<div class="form-three widget-shadow dontprint">
													<strong>Order Accept Yes/No:</strong><br>

													<form class="form-horizontal" method="post" id="myform">

														<div class="form-group row align-items-center">
															<label class="col-4 control-label m-0"></label>
															<div class="col-8">
																<?php if ($type == 'Rent') { ?><span>Can You Delivered the product on / before <?php echo $rent_from_date; ?> ? <?php } ?></span>
																	<select class="form-control" id="new_orderstatus" name="new_orderstatus" required>
																		<option value="">Select</option>
																		<option value="Accepted">Yes</option>
																		<option value="Rejected">No</option>
																	</select>
															</div>
														</div>
														<div class="form-group row align-items-center" id="curier_name_div" style="display:none;">
															<label class="col-4 control-label m-0"> Courier By*</label>
															<div class="col-8">
																<select class="form-control" id="curier_name" name="curier_name">
																	<?php if ($order_product_data['pickup_type'] == 'self') { ?>
																		<option selected value="self">Self Ship</option>
																	<?php } else { ?>
																		<option selected value="self">Self Ship</option>
																		<option selected value="bznesshub">Ship By Bznesshub</option>
																	<?php } ?>
																</select>
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
															"destination" : ' . $order_data['pincode'] . ',
															"payment_type" : "' . strtolower($order_data['payment_mode']) . '",
															"order_amount" : ' . ($order_product_data['prod_price'] - $order_product_data['discount'] * $order_product_data['qty']) . ',
															"weight" : 300,	
															"length" : 10,
															"breadth" : 10,
															"height" : 10
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
														<div class="form-group row align-items-center" id="curier_company_div" style="display:none;">
															<label for="focusedinput" class="col-4 control-label m-0">Courier Name</label>
															<div class="col-8">
																<select class="form-control" id="curier_company" name="curier_company">
																	<option value="">select Courier</option>
																	<?php
																	foreach ($response_rate->data as $ship_data) {

																		if ($ship_data->id == $order_product_data['courier_id']) {
																			print_r($ship_data);
																	?>


																			<option <?php if ($order_product_data['courier_id'] == $ship_data->id) {
																						echo 'selected';
																					} ?> value="<?php echo $ship_data->id; ?>"><?php echo $ship_data->name; ?></option>
																		<?php } ?>

																	<?php /* if ($ship_data->id != '' && $ship_data->id == 179) { ?>
																			<option value="<?php echo $ship_data->id; ?>"><?php echo $ship_data->name . ' (Rs.' . $ship_data->freight_charges . ')'; ?></option>
																		<?php  } else if ($ship_data->id != '' && $ship_data->id == 67) { ?>
																			<option value="<?php echo $ship_data->id; ?>"><?php echo $ship_data->name . ' (Rs.' . $ship_data->freight_charges . ')'; ?></option>
																		<?php  } else if ($ship_data->id != '' && $ship_data->id == 17) { ?>
																			<option value="<?php echo $ship_data->id; ?>"><?php echo $ship_data->name . ' (Rs.' . $ship_data->freight_charges . ')'; ?></option>
																		<?php  } else if ($ship_data->id != '' && $ship_data->id == 3) { ?>
																			<option value="<?php echo $ship_data->id; ?>"><?php echo $ship_data->name . ' (Rs.' . $ship_data->freight_charges . ')'; ?></option>
																		<?php  } else if ($ship_data->id != '' && $ship_data->id == 79) { ?>
																			<option value="<?php echo $ship_data->id; ?>"><?php echo $ship_data->name . ' (Rs.' . $ship_data->freight_charges . ')'; ?></option>
																		<?php  } else if ($ship_data->id != '' && $ship_data->id == 10) { ?>
																			<option value="<?php echo $ship_data->id; ?>"><?php echo $ship_data->name . ' (Rs.' . $ship_data->freight_charges . ')'; ?></option>
																		<?php } else if ($ship_data->id != '' && $ship_data->id == 15) { ?>
																			<option value="<?php echo $ship_data->id; ?>"><?php echo $ship_data->name . ' (Rs.' . $ship_data->freight_charges . ')'; ?></option>
																		<?php  } else if ($ship_data->id != '' && $ship_data->id == 92) { ?>
																			<option value="<?php echo $ship_data->id; ?>"><?php echo $ship_data->name . ' (Rs.' . $ship_data->freight_charges . ')'; ?></option>
																		<?php  } else if ($ship_data->id != '' && $ship_data->id == 66) {  ?>
																			<option value="<?php echo $ship_data->id; ?>"><?php echo $ship_data->name . ' (Rs.' . $ship_data->freight_charges . ')'; ?></option>
																	<?php } */
																	}
																	?>
																</select>
															</div>
														</div>

														<!--<div class="form-group row align-items-center" id="new_pickupdate" style="display:none;">
															<label for="focusedinput" class="col-4 control-label m-0">Pickup Date</label>
															<div class="col-8">
																<input type="date" class="form-control" id="pick_date" name="pick_date" placeholder="">
															</div>
														</div>-->

														<div class="row col-sm-offset-2">
															<label class="col-4 control-label m-0"></label>
															<div class="col-8">
																<button type="submit" class="btn btn-dark" href="javascript:void(0)" id="updatestatus">Order Update</button>
															</div>
														</div>
													</form>
												</div>
											<?php } ?>



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
														$stmt_status_track = $conn->prepare("SELECT * FROM order_tracking_status WHERE order_id = ? AND product_id = ? ORDER BY id ASC");
														$stmt_status_track->bind_param("ss", $ordersno, $product_id);
														$stmt_status_track->execute();
														$status_track_result = $stmt_status_track->get_result();
														$status_track_data = $status_track_result->fetch_all(MYSQLI_ASSOC);
														$stmt_status_track->close();

														foreach ($status_track_data as $status_track_row) {
														?>
															<tr>
																<td><?= $status_track_row['status']; ?> </td>
																<td><?= date('d-m-Y H:i a', strtotime($status_track_row['created_at'])) ?> </td>
																<td>
																	<?= $status_track_row['message']; ?>
																	<div class="d-flex">
																		<?php if ($status_track_row['product_image_1']) : ?>
																			<a href="<?= UPLOAD_URL . $status_track_row['product_image_1'] ?>" target="_blank" rel="noopener noreferrer">
																				<img src="<?= UPLOAD_URL . $status_track_row['product_image_1'] ?>" alt="" height="75" width="auto">
																			</a>
																		<?php endif ?>
																		<?php if ($status_track_row['product_image_2']) : ?>
																			<a href="<?= UPLOAD_URL . $status_track_row['product_image_2'] ?>" target="_blank" rel="noopener noreferrer">
																				<img src="<?= UPLOAD_URL . $status_track_row['product_image_2'] ?>" alt="" height="75" width="auto" class="ml-2">
																			</a>
																		<?php endif ?>
																	</div>
																</td>
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

								<button type="submit" style="position: fixed;bottom: 62px;right: 5px;" href="javascript:void(0)" onclick="generate_invoice('<?= $product_id; ?>','<?= $ordersno; ?>'); " class="btn btn-danger pull-right" style="margin-right: 5px;margin-top: 11px;">
									<i class="fa fa-download"></i> Generate Invoice
								</button>

								<?php if ($order_product_data['print_label'] != '') { ?>
									<a class="btn btn-danger pull-right" style="position: fixed; bottom: 112px;right: 5px;" style="margin-right: 5px;margin-top: 11px;" href="<?= $order_product_data['print_label']; ?>"><i class="fa fa-download"></i> Download Label</a>
								<?php } ?>

								<?php /* if ($order_product_data['tracking_id']) : ?>
									<a href="<?= 'generate-label.php?order_id=' . $ordersno . '&awb_number=' . $order_product_data['tracking_id'] ?>" target="_blank" style="position: fixed; bottom: 112px;right: 5px;" href="javascript:void(0)" class="btn btn-danger pull-right" style="margin-right: 5px;margin-top: 11px;"><i class="fa fa-download"></i> Download Label</a>

									<a href="<?= 'generate-manifest.php?order_id=' . $ordersno . '&awb_number=' . $order_product_data['tracking_id'] ?>" target="_blank" style="position: fixed; bottom: 162px;right: 5px;" href="javascript:void(0)" class="btn btn-danger pull-right" style="margin-right: 5px;margin-top: 11px;"><i class="fa fa-download"></i> Download Manifest</a>
								<?php endif; */ ?>

								<script>
									function generate_invoice(prod_id, ordersno) {
										location.href = 'generate_invoice.php?orderid=' + ordersno + '&product_id=' + prod_id;
									}
								</script>
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

<script src="<?= BASEURL . 'vendor_php/js/admin/edit-order.js' ?>"></script>

<script>
	$(function() {

		$('#delivery_date1').flatpickr({
			weekStart: 0,
			time: false,
		});
	});
	
	function successmsg1(msg, locations) {
    xdialog.confirm(msg, function () {
        location.href = locations;

    }, {
        style: 'width:420px;font-size:0.8rem;',
        buttons: {
            ok: 'OK '
        },
        oncancel: function () {
            // console.warn('Cancelled!');
        }
    });
}

	$('#new_orderstatus').change(function() {
		if ($(this).val() == 'Accepted') {
			$('#new_pickupdate').show();
			$('#curier_name_div').show();
			if ($('#curier_name').val() == 'bznesshub') {
				$('#curier_company_div').show();
			}
		} else {
			$('#new_pickupdate').hide();
			$('#curier_name_div').hide();
			$('#curier_company_div').hide();
		}



	});

	$('#curier_name').change(function() {
		if ($(this).val() == 'self') {
			$('#curier_company_div').hide();
		} else {
			$('#curier_company_div').show();
		}



	});


	$(document).ready(function() {
		$("#updatetracking").click(function(event) {
			event.preventDefault();
			/*var delivery_date = $("#delivery_date").val();

			if (!delivery_date) {
				successmsg("Please select delivery date.");
			} else {*/
			$("#myform_tracking").submit();
			/*}*/
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


	$('#delivery_date').flatpickr({
		weekStart: 0,
		minDate: "today",
	});
</script>