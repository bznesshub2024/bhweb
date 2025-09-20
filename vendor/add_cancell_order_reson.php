<?php
include('session.php');

if(!isset($_SESSION['admin'])){
  header("Location: index.php");
}else{
   
    $seller_status = $_POST['seller_status'];
    $seller_reason = $_POST['seller_reason'];
    $order_id_update = $_POST['order_id_update'];
    $code = $_POST['code'];
    
    $seller_status =   stripslashes($seller_status);
    $seller_reason =   stripslashes($seller_reason);
    $order_id_update =   stripslashes($order_id_update);
    $code =  stripslashes($code);
   // echo " delete array ".$deletearray ;
    
   if(isset($seller_status) &&!empty( $seller_reason) && isset($seller_status) &&!empty( $seller_status)  &&!empty( $code)   ) {
           
				
         	     $stmt2 = $conn->prepare("UPDATE cancel_order_track SET seller_reason=?,seller_status=? WHERE id =?");
        		 $stmt2->bind_param( 'sss',   $seller_reason,$seller_status, $order_id_update );
        		 $stmt2->execute();
        		
        		 $rows=$stmt2->affected_rows;
        			

        		if($rows>0){
        			 $information = 'Status Update Successful.';
					 
					 if($seller_status == 1)
					 {
						
						$stmt = $conn->query("SELECT co.order_id,o.email,o.fullname FROM cancel_order_track co INNER JOIN orders o on o.order_id = co.order_id  WHERE co.id='".$order_id_update."'");
						while ($row = $stmt->fetch_assoc()) {
							$order_id = $row['order_id'];
							$user_email = $row['email'];
							$name = $$row['fullname'];
						}
						
						 $stmt3 = $conn->query("UPDATE order_product SET status='Returned Completed' WHERE order_id = '".$order_id."'");
						
						$Common_Function->send_cancel_emails($conn,$user_email,$name);
					 } 
        			   
        		}else{
        			    
        			     $information = 'Failed to Update.';
        		}
        		
               echo  $information;	 
        
        die;
    }
}    
?>
