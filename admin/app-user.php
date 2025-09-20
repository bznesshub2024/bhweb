<?php
include('session.php');

if (!$Common_Function->user_module_premission($_SESSION, $AppUser)) {
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
			<!-- start page title -->
			<div class="row">
				<div class="col-12">
					<div class="page-title-box">
						<h4 class="page-title">All Users</h4>
					</div>
				</div>
			</div>
			<!-- end page title -->

			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div data-example-id="simple-form-inline">

								<div class="row align-items-center">
									<div class="col-md-9 mb-2">

										<div class="d-flex flex-wrap">

											<input type="text" placeholder="Search.." class="form-control mr-1" name="search" style="width:180px;" id="search_string">

											<button type="submit" href="javascript:void(0)" class="btn btn-danger waves-effect waves-light" id="searchName"><i class="fa fa-search"></i></button>

										</div>
									</div>
									<div class="col-md-3 mb-2">
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

							<div class="work-progres">
								<div class="table-responsive">
									<table class="table table-hover" id="tblname" style="overflow-x: auto;">
										<thead class="thead-light">
											<tr>
												<th>SNO</th>
												<th>ID</th>
												<th>Parent Referral Code</th>
												<th>Seller Type</th>
												<th>Name</th>
												<th>Refer Code</th>
												<th>Phone</th>
												<th>Since</th>
												<th>Status</th>
												<!--<th>Action</th>-->

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



							<div class="clearfix"> </div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
			<div class="modal-dialog  modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">User Details</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<span id="user_name"></span><br>
						<span id="user_mobile"></span>
					</div>

				</div>

			</div>
		</div>

			<div class="clearfix"></div>
		</div>
		<!-- //calendar -->



		<div class="col_1">


			<div class="clearfix"> </div>

		</div>

	</div>
</div>

<!--footer-->
<?php include("footernew.php"); ?>
<!--//footer-->

<script src="js/admin/manage_appuser.js"></script>
<script>
var code_ajax = $("#code_ajax").val();
	$(document).on("click", ".open-modal", function() {
		var refer_id = $(this).data('id');
		$('#user_name').text();
		$('#user_mobile').text();
		 $.ajax({
                    method: 'POST',
                    url: 'get_user_refer_data.php',
                    data: {
						code: code_ajax,
						refer_id: refer_id
					},
                     cache: false,
                    success: function (response) {
						 var data = $.parseJSON(response);
						 $('#user_name').text('Name : '+data.fullname);
						 $('#user_mobile').text('Mobile No : '+data.phone);
                    }
                });
		
	});
</script>