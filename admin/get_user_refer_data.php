<?php
 
include('session.php');

$refer_id = $_POST['refer_id'];

if(!isset($_SESSION['admin'])){
  header("Location: index.php");
}
    try{
    
        $Exist = false;
        $status =0;
        $information = array();
        $prodstatus = "active";
		
        
        $return = array();
        $i      = 0;
		
		$stmt = $conn->prepare("SELECT sl.user_unique_id, sl.fullname, sl.email, sl.phone FROM appuser_login sl
                WHERE   1=1 and sl.user_unique_id != 'admin_0001' and sl.referral_code = '".$refer_id."'  ORDER BY sl.create_by DESC");
            
    	   $stmt->execute();	 
     	   $data = $stmt->bind_result( $col1, $col3, $col4, $col5 );
           $return = array();
    	   $i =0;
       
          //echo " get col data ";
    	   while ($stmt->fetch()) {    
    	   	  	$Exist = true;
          
        	   	$information['fullname'] = $col3;
        	   	$information['email'] = $col4;
        	   	$information['phone'] = $col5;
        							  
    	    }
            
    
        
		echo json_encode($information);
	     
         
     }
    catch(PDOException $e)
        {
        echo "Error: " . $e->getMessage();
        }


?>