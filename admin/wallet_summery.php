<?php
include('session.php');

if (!isset($_SESSION['admin'])) {
   header("Location: index.php");
}
$stmt = $conn->prepare("SELECT fullname FROM appuser_login WHERE user_unique_id = '".$_REQUEST['id']."'");
$stmt->execute();	 
$data_pay = $stmt->bind_result($fullname);
	
while ($stmt->fetch()) {    
	$user_name = $fullname;
} 
	
?>
<?php include("header.php"); ?>
<style>
	span.Active
	{
		color : green;
	}
	span.Deactive
	{
		color : red;
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
                  <h4 class="page-title">Wallet Summary (<?php echo $user_name?>)</h4>
               </div>
            </div>
         </div>
		<input type="hidden" name="user_id" id="user_id" value="<?php echo $_REQUEST['id']; ?>"
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

                     <div class="work-progres">
                        <div class="table-responsive">
                           <table class="table table-hover" id="tblname">
                              <thead>
                                 <tr>
                                    <th>Sno</th>
                                    <th>TransactionId</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>From</th>
                                    <th>Remark</th>
                                    <th>Date</th>

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
<script src="js/admin/wallet_summery.js"></script>