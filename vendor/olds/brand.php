<?php
include('session.php');

if(!isset($_SESSION['admin'])){
  header("Location: index.php");
}

?>
<?php include("header.php"); ?>

<script src ="js/admin/brand.js"></script>
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
		</div>
         <div style=" display: inline-block;  vertical-align: middle">
         </div>
      </div>
	   </br>	
		 <div class="work-progres">
             <header class="widget-header">
            <div class="pull-right" style="float:left;">
			
               Total Row :	<a id="totalrowvalue" class="totalrowvalue"></a>
            </div>
            <h4 class="widget-title"><b>All Brand </b> <button type="button" class="btn btn-primary" id="" data-toggle="modal" data-target="#myModal">Add Brand</button>
		</h4>
			
         </header>      
				<hr class="widget-separator">
		
		<div class="table-responsive">
            <table class="table table-hover"  id="tblname" >
               <thead>
                  <tr>
                     <th>Sno</th>                    
                     <th>Image</th>          
                     <th>Brand</th>
                     <th>Status</th>
                     
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
        <h4 class="modal-title">Add Brand</h4>
      </div>
      <div class="modal-body"> 
		<form class="form" id="add_brand_form"  enctype="multipart/form-data">
			
			<div class="form-group"> 
				<label for="name">Brand Name</label> 
				<input type="text" class="form-control" id="name" placeholder="Brand Name"> 
			</div>
			<div class="form-group">
				<label for="image">Image</label>
				<input type="file" name="brand_image" id="brand_image" class="form-control" onchange="uploadFile1('brand_image')"  required accept="image/png, image/jpeg,image/jpg,image/gif">
    		</div>           
            <button type="submit" class="btn btn-success" value="Upload" href="javascript:void(0)" id="add_brand_btn">Add</button> 
		</form> 
      </div>
      
    </div>

  </div>
</div>		
