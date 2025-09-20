<?php
include('session.php');

if(!isset($_SESSION['admin'])){
  header("Location: index.php");
 // echo " dashboard redirect to index";
}
 
?>
<?php include("header.php"); ?>


		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
			<div class="col_3">
			<a onclick="redirect_page('reports.php')">
			   <div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                    <i class="pull-left fa fa-dollar icon-rounded"></i>
                    <div class="stats">
                      <h5><strong><?php 
            
                     $stmt = $conn->prepare("SELECT SUM(prod_price*qty) FROM `order_product` WHERE status ='Delivered' AND vendor_id= '".$_SESSION['admin']."'");
                       $stmt->execute();
                       $data = $stmt->bind_result( $col1);
					   $revenue=0;
                       while ($stmt->fetch()) { 
							$revenue = $col1;
						}
						echo $Common_Function->price_formate ($conn,$revenue);
                    
                      ?></strong></h5>
                      <span>Revenue</span>
                    </div>
                </div>
        	</div>
			</a>
			<a onclick="redirect_page('manage_orders.php')"> 
        	<div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                    <i class="pull-left fa fa-shopping-cart user2 icon-rounded"></i>
                    <div class="stats">
                      <h5><strong><?php 
            
                        $stmt = $conn->prepare("SELECT id FROM `order_product` where vendor_id= '".$_SESSION['admin']."'");
                       $stmt->execute();
                       $stmt->store_result();
                       echo number_format($stmt->num_rows);
                    
                      ?></strong></h5>
                      <span>Total Orders</span>
                    </div>
                </div>
        	</div>
			</a>
			<a onclick="redirect_page('manage_orders.php')">  
			<div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                    <i class="pull-left fa fa-shopping-cart user2 icon-rounded"></i>
                    <div class="stats">
                      <h5><strong><?php 
            
                       $stmt = $conn->prepare("SELECT id FROM `order_product` WHERE status ='Placed' AND vendor_id= '".$_SESSION['admin']."'");
                       $stmt->execute();
                       $stmt->store_result();
                       echo number_format($stmt->num_rows);
                    
                      ?></strong></h5>
                      <span>Pending Order</span>
                    </div>
                </div>
        	</div>
			</a>
			<a onclick="redirect_page('manage_orders.php')">  
        	<div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                    <i class="pull-left fa fa-shopping-cart user2 icon-rounded"></i>
                    <div class="stats">
                      <h5><strong><?php 
            
                      $stmt = $conn->prepare("SELECT id FROM `order_product` where status ='Cancelled' AND vendor_id= '".$_SESSION['admin']."'");
                       $stmt->execute();
                       $stmt->store_result();
                       echo number_format($stmt->num_rows);
                   
                      ?></strong></h5>
                      <span>Cancelled Order</span>
                    </div>
                </div>
        	</div>
			</a>
			<a onclick="redirect_page('manage_orders.php')">  
			<div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                   <i class="pull-left fa fa-shopping-cart user2 icon-rounded"></i>
                    <div class="stats">
                      <h5><strong><?php 
            
                       $stmt = $conn->prepare("SELECT id FROM `order_product` WHERE status ='Delivered' AND vendor_id= '".$_SESSION['admin']."'");
                       $stmt->execute();
                       $stmt->store_result();
                       echo number_format($stmt->num_rows);
                    
                      ?></strong></h5>
                      <span>Complete Order</span>
                    </div>
                </div>
        	</div>
			</a>
			<a onclick="redirect_page('manage_product.php')">
        	<div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                    <i class="pull-left fa fa-pie-chart user1 icon-rounded"></i>
                    <div class="stats">
                      <h5><strong><?php 
            
					   $query_total = $conn->prepare("SELECT pd.product_unique_id FROM product_details pd,brand , vendor_product vp WHERE vp.product_id =pd.product_unique_id AND vp.vendor_id = '".$_SESSION['admin']."'  AND brand.brand_id  = pd.brand_id AND vp.enable_status IN(1,3)");
                       $query_total->execute();
                       $query_total->store_result();
                       echo number_format($query_total->num_rows);
                    
                      ?></strong></h5>
                      <span>Total Product</span>
                    </div>
                </div>
        	</div>
			</a>
			<a onclick="redirect_page('reports.php')">
			 <div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                    <i class="pull-left fa fa-dollar icon-rounded"></i>
                    <div class="stats">
                      <h5><strong><?php 
            
						$stmt_today = $conn->prepare("SELECT SUM(prod_price*qty) FROM `order_product` WHERE DATE(create_date) ='".date('Y-m-d')."' AND vendor_id= '".$_SESSION['admin']."'");
                       $stmt_today->execute();
                       $data = $stmt_today->bind_result( $col1);
					   $today_sale=0;
                       while ($stmt_today->fetch()) { 
							$today_sale = $col1;
						}
						echo $Common_Function->price_formate ($conn,$today_sale);
                    
                      ?></strong></h5>
                      <span>Today's Sale</span>
                    </div>
                </div>
        	</div>
			</a>
			<a onclick="redirect_page('reports.php')">
			<div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                    <i class="pull-left fa fa-dollar icon-rounded"></i>
                    <div class="stats">
                      <h5><strong><?php 
            
						$stmt_month = $conn->prepare("SELECT SUM(prod_price*qty) FROM `order_product` WHERE Month(create_date) ='".date('m')."' AND YEAR(create_date) ='".date('Y')."' AND vendor_id= '".$_SESSION['admin']."'");
                       $stmt_month->execute();
                       $data = $stmt_month->bind_result( $col1);
					   $month_sale=0;
                       while ($stmt_month->fetch()) { 
							$month_sale = $col1;
						}
						echo $Common_Function->price_formate ($conn,$month_sale);
                    
                      ?></strong></h5>
                      <span>Monthly Sale</span>
                    </div>
                </div>
        	</div>
			</a>
         <div class="clearfix"> </div>
		</br>
		<div class="work-progres">
			<header class="widget-header">
				
				<button type="button" class="btn btn-primary pull-right" onclick="redirect_page('manage_orders.php')">View All</button>
				<h4 class="widget-title">Recent Orders</h4>
			</header>
			<hr class="widget-separator">
            <div class="table-responsive">
            <table class="table table-hover" id="tblname"> 
                  <thead>
					<tr>
						<th>Sno</th>
						<th>Order ID</th>
						<th>Product Name</th>
						<th>Amount</th>
						<th>Quantity</th>
						<th>Date</th>
						                   
						<th>Status</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody id="tbodyPostid">
					<?php
						 $get_neworder = $conn->query("SELECT op.prod_id,op.order_id,op.prod_name,op.prod_img,op.prod_attr,op.qty,op.prod_price,op.shipping,op.discount,op.status,op.order_id ,op.create_date
								FROM  `order_product` op WHERE op.vendor_id = '".$_SESSION['admin']."'  ORDER BY op.id DESC LIMIT 20 ");
       
						
						if($get_neworder->num_rows > 0){
							
						while ($rows_order = $get_neworder->fetch_assoc()) { 
							$i++;
					
					?>
				
					<tr>
						<th scope="row"><?php echo $i; ?></th>
						<td><?php echo $rows_order['order_id']; ?></td>
						<td><?php echo $rows_order['prod_name']; ?></td>
						<td><?php echo $rows_order['prod_price']; ?></td>
						<td><?php echo number_format($rows_order['qty']); ?></td>
						<td><?php echo $rows_order['create_date']; ?></td>
						
						<td><?php echo $rows_order['status']; ?></td> <td>	<button type="button" class="btn-warning" onclick="edit_orders('<?php echo $rows_order['order_id']; ?>', '<?php echo $rows_order['prod_id']; ?>')">Edit</button></td>
					</tr>
						<?php } }else{ ?>
							
							<tr>
						<td colspan="7">No Record Found</td>
					</tr>
							
					<?php	} ?>
				</tbody>
              </table>
			</div>
        </div>	
        	
        	<div class="clearfix"> </div>
</br>
		
			
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
