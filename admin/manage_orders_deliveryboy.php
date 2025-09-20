<?php
include('session.php');


if (!$Common_Function->user_module_premission($_SESSION, $Orders)) {
	echo "<script>location.href='no-premission.php'</script>";
	die();
}


if (!isset($_SESSION['admin'])) {
	header("Location: index.php");
}

?>
<?php include("header.php"); ?>

<!-- main content start-->
<div class="content-page">
	<!-- Start content -->
	<div class="content">
		<div class="container-fluid"> 
			<div class="row">
				<div class="col-12">
					<div class="page-title-box">
						<h4 class="page-title">All Orders</h4>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div data-example-id="simple-form-inline">
								<div class="row align-items-center">
									<div class="col-md-6 mb-2">
										<div class="text-right">
											<form>
												<div class="form-group mb-0 d-flex">
													<input type="text" placeholder="Name.." name="search" class="form-control" id="search_name" style="width: 220px;">
													<select class="form-control ml-1" style="width:180px;" id="orderstatus" name="orderstatus" required>
														<option value="">Status</option>
														<option value="completed">Completed</option>
														<option value="pending">Pending</option>
														<option value="cancelled">Cancelled</option>
													</select>
													<button type="submit" href="javascript:void(0)" class="btn btn-danger waves-effect waves-light ml-1" id="searchName"><i class="fa fa-search"></i></button>
												</div>
											</form>
										</div>
									</div>
									<div class="col-md-6 mb-2">
										<div class="d-flex align-items-center">
											<div class="ml-md-auto">
												<div class="d-flex align-items-center">
													<span>Show</span>
													<select class="form-control " id="perpage" name="perpage" onchange="perpage_filter()" style="float:left;">
														<option value="10">10</option>
														<option value="25">25</option>
														<option value="50">50</option>
													</select>
													<span class="pull-right per-pag">entries</span>
												</div>
											</div>
										</div>
									</div>
								</div>

							</div>
							</br>
							<div class="work-progres">
								<div class="table-responsive">
									<table class="table" id="tblname" style="overflow-x: auto;">
										<thead>
											<tr>
												<th>OrderID</th>
												<th>User Type</th>
												<th>Delivery Boy</th>
												<th>Amount</th>
												<th>Quantity</th>
												<th>Payment Mode</th>
												<th>Order Date</th>
												<th>Payment Status</th>
												<th>Order Status</th>
												<th>Action</th>

											</tr>
										</thead>
										<tbody id="tbodyPostid">

										</tbody>
									</table>
								</div>
								<div class="row align-items-center">
									<div class="col-md-6">
										<div class="pull-right" style="float:left;">
											Total Row : <a id="totalrowvalue" class="totalrowvalue"></a>
										</div>
									</div>
									<div class="col-md-6">
										<div class="pull-right page_div ml-auto" style="float:right;"> </div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>


			<div class="clearfix"> </div>
		</div>


		<div class="clearfix"></div>
	</div>
	<!-- //calendar -->


	<div class="col_1">


		<div class="clearfix"> </div>

	</div>

</div>
<!--footer-->
<?php include("footernew.php"); ?>
<!--//footer-->
<script src="js/admin/manage_orders_deliveryboy.js"></script>