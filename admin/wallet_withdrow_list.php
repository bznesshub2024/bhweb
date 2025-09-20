<?php
include('session.php');

if(!$Common_Function->user_module_premission($_SESSION,$Brand)){
	echo "<script>location.href='no-premission.php'</script>";die();
}

if(!isset($_SESSION['admin'])){
  header("Location: index.php");
}

?>
<?php include("header.php"); ?>

<style>
  .toggle-btn {
    background-color: #fff;
    border: none;
    color: #fff;
    cursor: pointer;
    font-size: 16px;
    padding: 10px;
    position: relative;
    transition: background-color 0.2s ease-in-out;
  }

  .toggle-btn:hover {
    background-color: #fff;
  }

  .fa-info {
    color: #ccc;
    font-size: 10px;
    border: 1px solid #ccc;
    border-radius: 50%;
    padding: 2px 5px;
  }

  .info-icon {
    background-color: rgba(255, 255, 255, 0.8);
    border-radius: 50%;
    color: #000000;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    height: 20px;
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    width: 20px;
    cursor: pointer;
    position: relative;
  }

  .hover-card {
    background-color: #000;
    border: 1px solid #000;
    border-radius: 5px;
    color: #fff;
    display: none;
    font-size: 12px;
    padding: 10px;
    position: absolute;
    bottom: calc(100% + 10px);
    left: 50%;
    transform: translateX(-50%);
    width: 200px;
    z-index: 1;
  }

  .arrow {
    position: absolute;
    bottom: -10px;
    left: calc(50% - 10px);
    width: 0;
    height: 0;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    border-top: 10px solid #000;
  }

  .info-icon:hover .hover-card {
    display: block;
  }
  .Pending {
    color: #FF6600;
  }
  .Active {
    color: #438F29;
  }
</style>

<!-- main content start-->
<div class="content-page">
  <!-- Start content -->
  <div class="content">
    <div class="container-fluid">
      <!-- start page title -->
      <div class="row">
        <div class="col-12">
          <div class="page-title-box">
            <h4 class="page-title">All Wallet Withdrawal List</h4>
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
                  <div class="col-md-6 mb-2">
				  
				  </div>
                  <div class="col-md-6 mb-2">
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
                  <table class="table table-hover table-centered" id="tblname">
                    <thead class="thead-light">
                      <tr>
                        <th>Sno</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Transaction ID</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody id="cat_list">
                    </tbody>
                  </table>
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

              <div class="col_1">


                <div class="clearfix"> </div>

              </div>
			  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
			<div class="modal-dialog  modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Add Payment</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form class="form" id="add_payment_form" enctype="multipart/form-data">
							<b>UPI ID - <span id="upi_text" class="text-blue"></span></b><br>
							<div class="form-group">
								<label for="name">Transaction ID</label>
								<input type="text" class="form-control" id="transection_id" placeholder="Transaction ID">
							</div>

							<div class="form-group">
								<label for="image">Invoice Image</label>
								<input type="file" name="invoice_proof" id="invoice_proof" class="form-control-file" onchange="uploadFile1('invoice_proof')" accept="image/png, image/jpeg,image/jpg,image/gif">
							</div>
							<input type="hidden" id="user_id">
							<input type="hidden" id="paymant_id">
							<button type="submit" class="btn btn-dark waves-effect waves-light" value="Upload" href="javascript:void(0)" id="add_payment_btn">Add</button>
						</form>
					</div>

				</div>

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
<script src="js/admin/wallet_withdrow_list.js"></script>
<script>
	$(document).on("click", ".open-modal", function() {
		var id = $(this).data('id');
		var pay_id = $(this).data('pay_id');
		var upi_id = $(this).data('upi_id');
		$('#upi_text').html(upi_id);
		$('#user_id').val(id);
		$('#paymant_id').val(pay_id);

	});
</script>
<!--//footer-->
