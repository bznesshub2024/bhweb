<?php

   include('session.php');




   if(!isset($_SESSION['admin'])){

     header("Location: index.php");

   }

    

   ?>

<?php include("header.php"); ?>





<!-- main content start-->

<div id="page-wrapper" class="content-page">

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

            <h4 class="widget-title"><b>All Products</b></h4>

         </header>

         <hr class="widget-separator">

         <div class="table-responsive">

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

<?php include("footernew.php"); ?>
<script src="js/admin/pending-manage-product.js"></script>