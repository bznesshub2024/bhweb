<?php
include('session.php');

if(!isset($_SESSION['admin'])){
  header("Location: index.php");
}else if(!isset($_REQUEST['attribute_id'])){
	header("Location: manage_conf_attributes.php");
}
	$stmt1 = $conn->prepare("SELECT attribute FROM product_attributes_set WHERE id ='".$_REQUEST['attribute_id']."'");
    $stmt1->execute();	 
    $data = $stmt1->bind_result( $col11);
	while ($stmt1->fetch()) { 
		   $main_attr = $col11;
	}
	
	if($stmt1->num_rows == 0){
		header("Location: manage_conf_attributes.php");
	}

?>
<?php include("header.php"); ?>

<script src ="js/admin/manage_attributes_val.js"></script>
<input type="hidden" class="form-control" id="main_attribute_id"value="<?php echo $_REQUEST['attribute_id']; ?>" > 
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
            <h4 class="widget-title">
                <button type="button" class="btn btn-default" onclick="back_page();"><i class="fa fa-arrow-left"></i> Back</button>
                <b>All Attributes Value</b>  <button type="button" class="btn btn-primary" id="" data-toggle="modal" data-target="#myModal">Add Attribute Value</button>
		
		</h4>
			
         </header>      
		<hr class="widget-separator">		
		
		<div class="table-responsive">
            <table class="table table-hover"  id="tblname" >
               <thead>
                  <tr>
                     <th>Sno</th> 
                     <th>Main Attributes</th>
                     <th>Attributes</th>
                     
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
        <h4 class="modal-title">Add Attributes</h4>
      </div>
      <div class="modal-body"> 
		<form class="form" id="add_attributes_form"  enctype="multipart/form-data">
			
			<div class="form-group"> 
				<label for="name">Attributes</label> 
				<input type="text" class="form-control" id="attributes" placeholder="Attributes"> 
			</div>
			
			          
            <button type="submit" class="btn btn-success" value="Upload" href="javascript:void(0)" id="add_attributes_btn">Add</button> 
		</form> 
      </div>
      
    </div>

  </div>
</div>		
