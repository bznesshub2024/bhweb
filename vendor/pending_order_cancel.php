<?php
include('session.php');


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
						<h4 class="page-title">All Returned Order</h4>
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
									<div class="col-md-12">

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
									<table class="table table-hover" id="tblname">
										<thead class="thead-light">
											<tr>
												<th>Sno</th>
												<th>OrderId</th>
												<th>seller Reson</th>
												<th>Status</th>
												<th>Add</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody id="cat_list">
										</tbody>
									</table>
								</div>
								<div class="clearfix"> </div>

							</div>

							<div class="col_1">


								<div class="clearfix"> </div>

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
	</div>
</div>
<!--footer-->
<?php include("footernew.php"); ?>
<!--//footer-->
<!-- Modal -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog  modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form" id="add_form" enctype="multipart/form-data">

               <div class="form-group">
                  <label for="name">Status </label>
                  <select class="form-control" id="seller_status" name="seller_status" >
					<option value="">Select</option>
					<option value="1">Accept</option>
					<option value="2">Reject</option>
				  </select>
               </div>
				  <div class="form-group">
					<label for="name">Reason</label>
					<textarea class="form-control" id="seller_reason" name="seller_reason" required> </textarea>
				</div> 
				<input type="hidden" id="order_id_update">
				 <button type="submit" class="btn btn-danger waves-effect waves-light" value="Upload" href="javascript:void(0)" id="update_order_btn">Add</button>
			</form>
				
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="js/admin/manage_cancel_order.js"></script>
<script>
$(document).ready(function () {

    getReview(pageno, rowno);

	$("#update_order_btn").click(function (event) {
		event.preventDefault();
		var order_id_update = $("#order_id_update").val();
		var seller_status = $('#seller_status').val();
		var seller_reason = $('textarea#seller_reason').val();
		if (!seller_status) {
			successmsg("Please select status");
		} else if (seller_reason == ' ') {
			successmsg("Please Add Reason");
		} else {
			$.busyLoadFull("show");
			var form_data = new FormData();
			form_data.append('seller_status', seller_status);
			form_data.append('seller_reason', seller_reason);
			form_data.append('order_id_update', order_id_update);
			form_data.append('code', code_ajax);

			$.ajax({
				method: 'POST',
				url: 'add_cancell_order_reson.php',
				data: form_data,
				contentType: false,
				processData: false,
				success: function (response) {
					$.busyLoadFull("hide");
					successmsg(response);
					$("#myModal").modal('hide');
					var parentvalue = $("#last_cat").val();
					$('#seller_status').val('');
					$('#seller_reason').val('');
					setTimeout( function(){ 
						location.reload();
					}  , 1500 );
				}
			});
		}

	});

});

</script>