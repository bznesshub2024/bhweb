<?php
include('session.php');

if(!isset($_SESSION['admin'])){
  header("Location: index.php");
  print_r($_SESSION);
 // echo " dashboard redirect to index";
}
 
 include("header.php"); ?>
	<script src="<?php echo BASEURL; ?>assets/amchart/core.js"></script>
	<script src="<?php echo BASEURL; ?>assets/amchart/charts.js"></script>
	<script src="<?php echo BASEURL; ?>assets/amchart/animated.js"></script>
	<script src="js/admin/report.js"></script>
	<script src="js/admin/Chart.min.js"></script>
	<script src ="js/admin/manage_all_order_data.js"></script>
	<!--<script src ="js/admin/manage_orders.js"></script>-->

		<!-- main content start-->
	<div id="page-wrapper">
		<div class="main-page">
		<div class="col_3">
			
		
		<div class="col_1">
			<div class="col-md-12">
				<div class="activity_box">					
					<header class="widget-header">
						<h2>Total Orders
							
							<div class="dropdown" style="float: right;margin-top:-8px;">
							<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" id="revenue_btn" value="current_month"><span id="btn_text">All Orders</span>
								<span class="caret"></span></button>
								<ul class="dropdown-menu" id="revenue_ul">									
									<li data-value="all"><a href="#">All Orders</a></li>
									<li data-value="last_week" class="dayLink" id="1"><a href="#" id="current">Last 7 Days</a></li>
									<li data-value="current_month" class="dayLink" id="2"><a href="#" id="current">Current Month</a></li>
									<li data-value="monthly" class="dayLink" id="3" ><a href="#">Year</a></li>	
									<li data-value="custom" class="dayLink" id="4"><a href="#">Custom</a></li>									
									<li class="divider"></li>									
									
								</ul>
							</div>
							<div class="custom_div" style="display:none;float: right;margin-top:-8px;">
								&nbsp;&nbsp;<div style="float: right;"><input class="btn btn-info custom_range" type="button" name="send" value="go"  /></div>&nbsp;&nbsp;<div style="float: right;margin-top:-9px;"><span>To</span><input class="form-control" type="date" name="end_date" id="end_date"></div><div style="float: right;margin-top:-9px;"><span>From</span><input class="form-control" type="date" name="start_date" id="start_date"></div>
							</div>
						</h2>						
					</header>					
					<!--<div>
						<div id="chartdiv" style="height:400px;"></div>
					</div>-->
					<div class="chart-container">
						<canvas id="mycanvas"></canvas>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"> </div>
		</br>
		
		
		<div  data-example-id="simple-form-inline">
    	    
          					     <form class="form-inline" style="float:left;">
							         
							        <div class="form-group" style="margin-right:20px;">
							            <input type="text" placeholder="Search.." class="form-control"   name="search" style="width:200px;"  id="search_name">
										<!--<select class="form-control" id="export" name="export"> 
										<option value="">Get Data</option>
										<option value="1">Export Data</option>
										</select>-->
										<input type="date" name="from_date" id="from_date">
										<input type="date" name="to_date" id="to_date">
                                          <button type="submit" href="javascript:void(0)" class="btn btn-default" id="searchName"><i class="fa fa-search"></i></button>
                                    </div> 
							      </form>
								  
								  <form action="export_excel.php" method="post">
											 <input type="hidden" name="search_name_exp" id="search_name_exp" >
											 <input type="hidden" name="from_date_exp" id="from_date_exp" >
											 <input type="hidden" name="to_date_exp" id="to_date_exp" >
											 <button class="btn  btn-success"  type="submit">Export</button>
										</form>
								  
							<br>
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
                                      <th>#</th>
                                      <th >Product Name</th>
                                      <th >ProductID</th>
                                      <th>Attributes</th>                     
                                      <th>Quantity</th>
                                      <th>MRP</th>
                                      <th>Price</th>
                                      <th>Shipping</th>
                                      <th >Discount</th> 
                                      <th >Order Status</th>                                      
                                      <th >Date</th>                                      
                                      <th>Action</th>
                                      
                                  </tr>
                              </thead>
                           	<tbody id="tbodyPostid"> 
            				 
                          </tbody>
                      </table>
                  </div>
             </div>
		
		<!--<div class="col_1">
			<div class="col-md-4 span_8">
				<div class="activity_box">
					<h2>Pending New Products</h2>
					<div class="scrollbar" id="style-2">
					
					</div>
				<button type="button" class="btn btn-primary pull-right" style="margin: 11px;" onclick="redirect_page('pending_products.php')">View All</button>
					
				</div>
			</div>
			<div class="col-md-4 span_8">
				<div class="activity_box activity_box1">
					<h3>Pending New Brand</h3>
					<div class="scrollbar" id="style-3">
					
					</div>
				<button type="button" class="btn btn-primary pull-right" style="margin: 11px;" onclick="redirect_page('pending_brand.php')">View All</button>
				
				</div>
			</div>
			<div class="col-md-4 span_8">
				<div class="activity_box activity_box2">
					<h3>Pending New Category</h3>
					<div class="scrollbar" id="style-1">
						
					</div>
				<button type="button" class="btn btn-primary pull-right" style="margin: 11px;" onclick="redirect_page('pending_category.php')">View All</button>
				
				
				</div>
				<div class="clearfix"> </div>
			</div>
			
		</div>-->

				
		</div>			
	
			</div>
		<div class="clearfix"> </div></br>
	<!--footer-->
        <?php include("footernew.php"); ?>
    <!--//footer-->

</div>