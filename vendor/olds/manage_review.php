<?php
include('session.php');


if(!isset($_SESSION['admin'])){
  header("Location: index.php");
}

?>
<?php include("header.php"); ?>

<script src ="js/admin/manage_review.js"></script>
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
			
				<div  data-example-id="simple-form-inline">
         <div class="pull-right page_div" style="float:left;">  </div>
        
		 
		 <div class="perpage">
			<div class="pull-right col-sm-2"> 
				<select class="form-control" id="perpage" name="perpage" onchange="perpage_filter()" style="float:left;">
					<option value="10">10</option>
					<option value="25">25</option>
					<option value="50">50</option>
				</select> 
			</div><span class="pull-right per-pag">Per Page:</span>
		</div>		<div class="form-group" style="margin-right:20px;float:left;">	 		</div> 
         <div style=" display: inline-block;  vertical-align: middle">
         </div>
      </div>
	   </br>	
		 <div class="work-progres">
             <header class="widget-header">
            <div class="pull-right" style="float:left;">
			
               Total Row :	<a id="totalrowvalue" class="totalrowvalue"></a>
            </div>
            <h4 class="widget-title"><b>All Reviews </b> 
		</h4>
			
         </header>      
				<hr class="widget-separator">
		
		<div class="table-responsive">
            <table class="table table-hover"  id="tblname" >
               <thead>
                  <tr>
                     <th>Sno</th>                    
                     <th>User Name</th>          
                     <th>Producte</th>          
                     <th>Title</th>
                     <th>Rating</th>
                     
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
				
			</div>
		</div>
		</div>
	<!--footer-->
        <?php include("footernew.php"); ?>
    <!--//footer-->
	<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:50%;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Review</h4>
      </div>
      <div class="modal-body"> 
			<div class="form-group"> 
				<label for="name">User</label> 
				<input type="text" class="form-control" readonly id="user_name"> 
			</div>
			<div class="form-group"> 
				<label for="name">Product</label> 
				<input type="text" class="form-control" readonly id="product_name"> 
			</div>
			<div class="form-group"> 
				<label for="name">Review Title</label> 
				<input type="text" class="form-control" readonly id="review_title" > 
			</div>
			<div class="form-group"> 
				<label for="name">Review Rating</label> 
				<input type="text" class="form-control" readonly id="review_rating" > 
			</div>
			<div class="form-group"> 
				<label for="name">Review Comment</label> 
				<textarea  class="form-control" id="review_comment" readonly> </textarea>
			</div>
			 
			
      </div>
      
    </div>

  </div>
</div>	