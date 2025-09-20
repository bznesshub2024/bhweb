<?php
   include('session.php');
   
   if(!isset($_SESSION['admin'])){
     header("Location: index.php");
   }
    
   ?>
<?php include("header.php"); ?>
<style>
    
    .switch {
	position: relative;
	display: block;
	vertical-align: top;
	width: 86px;
	height: 30px;
	padding: 3px;
	margin: 0 10px 10px 0;
	background: linear-gradient(to bottom, #eeeeee, #FFFFFF 25px);
	background-image: -webkit-linear-gradient(top, #eeeeee, #FFFFFF 25px);
	border-radius: 18px;
	box-shadow: inset 0 -1px white, inset 0 1px 1px rgba(0, 0, 0, 0.05);
	cursor: pointer;
	box-sizing:content-box;
}
.switch-input {
	position: absolute;
	top: 0;
	left: 0;
	opacity: 0;
	box-sizing:content-box;
}
.switch-label {
	position: relative;
	display: block;
	height: inherit;
	font-size: 10px;
	text-transform: uppercase;
	background: #eceeef;
	border-radius: inherit;
	box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.12), inset 0 0 2px rgba(0, 0, 0, 0.15);
	box-sizing:content-box;
}
.switch-label:before, .switch-label:after {
	position: absolute;
	top: 50%;
	margin-top: -.5em;
	line-height: 1;
	-webkit-transition: inherit;
	-moz-transition: inherit;
	-o-transition: inherit;
	transition: inherit;
	box-sizing:content-box;
}
.switch-label:before {
	content: attr(data-off);
	right: 11px;
	color: #aaaaaa;
	text-shadow: 0 1px rgba(255, 255, 255, 0.5);
}
.switch-label:after {
	content: attr(data-on);
	left: 11px;
	color: #FFFFFF;
	text-shadow: 0 1px rgba(0, 0, 0, 0.2);
	opacity: 0;
}
.switch-input:checked ~ .switch-label {
	background: #E1B42B;
	box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.15), inset 0 0 3px rgba(0, 0, 0, 0.2);
}
.switch-input:checked ~ .switch-label:before {
	opacity: 0;
}
.switch-input:checked ~ .switch-label:after {
	opacity: 1;
}
.switch-handle {
	position: absolute;
	top: 4px;
	left: 4px;
	width: 28px;
	height: 28px;
	background: linear-gradient(to bottom, #FFFFFF 40%, #f0f0f0);
	background-image: -webkit-linear-gradient(top, #FFFFFF 40%, #f0f0f0);
	border-radius: 100%;
	box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.2);
}
.switch-handle:before {
	content: "";
	position: absolute;
	top: 50%;
	left: 50%;
	margin: -6px 0 0 -6px;
	width: 12px;
	height: 12px;
	background: linear-gradient(to bottom, #eeeeee, #FFFFFF);
	background-image: -webkit-linear-gradient(top, #eeeeee, #FFFFFF);
	border-radius: 6px;
	box-shadow: inset 0 1px rgba(0, 0, 0, 0.02);
}
.switch-input:checked ~ .switch-handle {
	left: 33px;
	box-shadow: -1px 1px 5px rgba(0, 0, 0, 0.2);
}
 
/* Transition
========================== */
.switch-label, .switch-handle {
	transition: All 0.3s ease;
	-webkit-transition: All 0.3s ease;
	-moz-transition: All 0.3s ease;
	-o-transition: All 0.3s ease;
}
</style>
 <input type="hidden" value="<?php if($_SESSION['page_no']){ echo $_SESSION['page_no'];} else{ echo '1';} ?>" id="product_sel_page">
<script src="js/admin/manage-product.js"></script>
<script>
    function catfilter(){
          var cat = document.getElementById("selectcategory");
           var catvalue = cat.options[cat.selectedIndex].value;
       // alert("cat name is "+catvalue);
       var pageno = $("#product_sel_page").val();
        var rowno = 0;
        getProducts(pageno, rowno);
    }
    
    
</script> 
<!-- main content start-->
<div id="page-wrapper">
   <div class="main-page">
      <div  data-example-id="simple-form-inline">
         <div class="pull-right page_div" style="float:left;">  </div>
         <form class="form-inline" style="float:left;">
            <div class="form-group">
               <input type="text" placeholder="Name.." name="search" class="form-control"  id="search_name">
               <button type="submit" href="javascript:void(0)" class="btn btn-default" id="searchName" ><i class="fa fa-search"></i></button>
            </div>
         </form>
		 
		 <div class="perpage">
			<div class="pull-right col-sm-2"> 
				<select class="form-control" id="perpage" name="perpage" onchange="perpage_filter()" style="float:left;">
					<option value="10" <?php if($_SESSION['prod_per_page'] == 10){ echo 'selected';} ?>>10</option>
					<option value="25" <?php if($_SESSION['prod_per_page'] == 25){ echo 'selected';} ?>>25</option>
					<option value="50" <?php if($_SESSION['prod_per_page'] == 50){ echo 'selected';} ?>>50</option>
				</select> 
			</div><span class="pull-right per-pag">Per Page:</span>
			
		</div>
         <div style=" display: inline-block;  vertical-align: middle">
         </div>
      </div>
      </br>	<br>
	  <div class="col-sm-2">
								               <select class="form-control1" id="selectcategory" name="selectcategory" onchange="catfilter()" >
                                                    <?php
                                                         echo '<option value="blank">Select Category </option>';
                                                                                                               
                                                        function categoryTree($parent_id = 0, $sub_mark = ''){
                                                            global $conn;
                                                            $query = $conn->query("SELECT * FROM category WHERE parent_id = $parent_id ORDER BY cat_name ASC");
                                                           
                                                            if($query->num_rows > 0){
                                                                while($row = $query->fetch_assoc()){
                                                                    echo '<option value="'.$row['cat_id'].'">'.$sub_mark.$row['cat_name'].'</option>';
                                                                    categoryTree($row['cat_id'], $sub_mark.'---');
                                                                }
                                                            }
                                                        }
                                                        categoryTree();
                                               
                                                                        
                                                    ?>
                                                </select> 
                                          </div>
										  </br></br>	
      <div class="work-progres">
         <header class="widget-header">
            <div class="pull-right" style="float:left;">
               Total Row :	<a id="totalrowvalue" class="totalrowvalue"></a>
            </div>
            <h4 class="widget-title"><b>All Products</b></h4>
         </header>
         <hr class="widget-separator">
         <div class="table">
            <table class="table table-hover"  id="tblname" >
               <thead>
                  <tr>
                     <th>Sno</th>
                     <th>Image</th>
                     <th>ProductID</th>
                     <th>Name</th>
                     <th>SKU</th>
                     <th>Brand</th>
                     <th>Category</th>
                     <th>Status</th>
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
   <div class="clearfix"></div>
</div>
<div class="col_1">
   <div class="clearfix"> </div>
</div>
</div>
</div>
</div>
<!--footer-->
 <?php    include('footernew.php'); ?>
<!--//footer-->
