<?php
include('session.php');

if(!isset($_SESSION['admin'])){
  header("Location: index.php");
}

?>
<?php include("header.php"); ?>

<script src="js/admin/category.js" ></script>

		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
				<div class="work-progres">
					<header class="widget-header"><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
                        <div class="pull-right" style="float:left;">
                           
					  </div>
					  <button type="button" class="btn btn-primary pull-right" id="add_categogy_btn">Add Category</button>
						<h4 class="widget-title">
						     <ul class="breadcrumb" style="margin-top:5px;" id="category_bradcumb"><li id="li0"><a href="javascript:void(0)"><span onclick="getCategory_bradcumb(0)"><i class="fa fa-home"></i> Home</span></a></li></ul>
                      
						    <b>All Category </b> 
							
						</h4>
                    </header>
				<hr class="widget-separator">
		        
			
			 <div class="table-responsive"><input type="hidden" id="last_cat" value="0">
            <table class="table table-hover"  id="tblname" >
               <thead>
                  <tr>
                     <th>Sno</th>
                     <th>Order</th>                     
                     <th>Image</th>             
                     
                     <th>Category</th>
                     <th>Status</th>
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
        <h4 class="modal-title">Add Category</h4>
      </div>
      <div class="modal-body"> 
		<form class="form" id="add_category_form">
			  <div id="new_cat_div"> </div>
			<div class="form-group"> 
				<label for="name">Name</label> 
				<input type="text" class="form-control" id="name" placeholder="Category Name" required> </input>
			</div>
			<div class="form-group">
				<label for="image">Image</label>
				<input type="file" name="cat_image" class="form-control" id="cat_image" required onchange="uploadFile1('cat_image')" accept="image/png, image/jpeg,image/jpg,image/gif">
    		</div>           
            <button type="submit" class="btn btn-success" value="Upload" href="javascript:void(0)" id="add_category_btn">Add</button> 
		</form> 
      </div>
      
    </div>

  </div>
</div>	
