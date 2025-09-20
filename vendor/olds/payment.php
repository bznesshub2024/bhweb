<?php

include('session.php');


if(!isset($_SESSION['admin'])){

  header("Location: index.php");

}

 

?>

<?php include("header.php"); ?>



<script src ="js/admin/payment.js"></script>

<input type="hidden"  name="seller_id" id="seller_id0" value="<?php echo $_REQUEST['id']; ?>">



		<!-- main content start-->

		<div id="page-wrapper">

			<div class="main-page">

			

    	 <div  data-example-id="simple-form-inline">
			<br><br>
    	    <div class="pull-right page_div" style="float:left;">  </div>

    	        <div class="perpage">

					<div class="pull-right col-sm-2"> 

						<select class="form-control " id="perpage" name="perpage" onchange="perpage_filter()" style="float:left;">

							<option value="10">10</option>

							<option value="25">25</option>

							<option value="50">50</option>

						</select> 

					</div><span class="pull-right per-pag">Per Page:</span>

				</div>

          					     <form class="form-inline" style="float:left;">

							         

							        
									   <select class="form-control" id="orderstatus" name="orderstatus"  style="width:150px;" required>

											  <option value="">All Status</option>


											<option value="pending">Pending</option>
											
											<option value="completed">Completed</option>
									

										</select>

								  
							            <input type="date"  class="form-control"   name="from_date" style="width:130px;"  id="from_date">
										<input type="date"  class="form-control"   name="to_date" style="width:130px;"  id="to_date">

										  

								  <button type="submit" href="javascript:void(0)" class="btn btn-default" id="searchName"><i class="fa fa-search"></i></button>&nbsp;

								

							      </form>

							       

                               <a>&nbsp;&nbsp;</a>

                               

							   

				</div>			     

					</br>	

		           <div class="work-progres">

                                        <header class="widget-header"><meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 

                                         <div class="pull-right" style="float:left;">

                                        	        Total Row :	<a id="totalrowvalue" class="totalrowvalue"></a>

                                            </div>

                                            <h4 class="widget-title"><b>All Orders</b></h4>

                                        </header>

							<hr class="widget-separator">

                            <div class="table-responsive">

                        	<table class="table"  id="tblname" style="overflow-x: auto;"> 

            			          <thead>

                                    <tr>

                                      <th>S.N.</th>
									  <th>Seller</th>
                                      <th>Amount</th>
                                      <th>Dates</th>
                                      <th>Status</th>
                                      <th>Transection ID</th>
                                      <th>Action</th>
                                      

                                  </tr>

                              </thead>

                           	<tbody id="tbodyPostid"> 

            				 

                          </tbody>

                      </table>

                  </div>

             </div>

      



				

			<div class="clearfix"> </div>

		</div>

		<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:50%;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Payment</h4>
      </div>
      <div class="modal-body"> 
		<form class="form" id="add_payment_form"  enctype="multipart/form-data">
			
			<div class="form-group"> 
				<label for="name">Transection ID</label> 
				<input type="text" class="form-control" id="transection_id" placeholder="Transection ID"> 
			</div>
			
			<div class="form-group">
				<label for="image">Invoice Image</label>
				<input type="file" name="invoice_proof" id="invoice_proof" class="form-control" onchange="uploadFile1('invoice_proof')"  accept="image/png, image/jpeg,image/jpg,image/gif">
    		</div>    
			<input type="hidden" id="seller_id">
			<input type="hidden" id="paymant_id">
            <button type="submit" class="btn btn-success" value="Upload" href="javascript:void(0)" id="add_payment_btn">Add</button> 
		</form> 
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

		</div>


	<!--footer-->

        <?php include("footernew.php"); ?>

    <!--//footer-->
	<script>
    $(document).on("click", ".open-modal", function () {
         var id = $(this).data('id');
         var pay_id = $(this).data('pay_id');
		$('#seller_id').val(id);
		$('#paymant_id').val(pay_id);

    });
    </script>