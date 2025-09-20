<?php
 
include('session.php');

if(!$Common_Function->user_module_premission($_SESSION,$AppUser)){
	echo "<script>location.href='no-premission.php'</script>";die();
}
$code  = $_POST['code'];
$page  = $_POST['page'];
$rowno = $_POST['rowno'];
$perpage = $_POST['perpage'];

$search_string = $_POST['search_string'];
$error = ''; // Variable To Store Error Message

$code = stripslashes($code);
$page =  stripslashes($page);
$rowno =  stripslashes($rowno);
$perpage =  stripslashes($perpage);
$groupid =  stripslashes($groupid);
$search_string =  stripslashes($search_string);

if(!isset($_SESSION['admin'])){
  header("Location: index.php");
}
else if($code == $_SESSION['_token']){
    
    try{
    
        $Exist = false;
        $status =0;
        $information = array();
        $prodstatus = "active";
		if($_POST['perpage']){
			$limit = $_POST['perpage']; 
		}else{
			$limit = 10; 
		}
	   
        $start = ($page - 1) * $limit; 
        $totalrow =0;
		
        
        $return = array();
        $i      = 0;
		$search_string_qry = "";
		if($search_string){
			$search_string_qry = " AND (sl.user_unique_id like '%".$search_string."%' OR sl.fullname like '%".$search_string."%' OR  sl.phone like '%".$search_string."%' OR  sl.email like '%".$search_string."%' )  ";
		}
		
		$stmt = $conn->prepare("SELECT sl.user_unique_id, sl.fullname, sl.email, sl.phone, sl.create_by,  sl.status,sl.referral_code,sl.referral_link,sel.user_id FROM appuser_login sl left join sellerlogin sel on sel.user_id = sl.user_unique_id WHERE   1=1 and sl.user_unique_id != 'admin_0001' ".$search_string_qry." ORDER BY sl.create_by DESC LIMIT ?, ?");
               $stmt ->bind_param("ii", $start, $limit);
            
    	   $stmt->execute();	 
     	   $data = $stmt->bind_result( $col1, $col3, $col4, $col5,  $col7, $col8,$referral_code,$referral_link,$user_id );
           $return = array();
    	   $i =0;
       
          //echo " get col data ";
    	   while ($stmt->fetch()) {    
    	   	  	$Exist = true;
				
				$is_seller = '';
				if($user_id != '')
				{
					$is_seller = 'Virtual Partner';
				}
				
				
          
        	   	$return[$i] = 
        					array(	
        						'user_unique_id' => $col1,        						 
        						 'fullname' => $col3,
								 
        						 'email' => $col4,
        						 'phone' => $col5,								         						 
								 'referral_code' => $referral_code,
								 'referral_link' => $referral_link,
								 'is_seller' => $is_seller,
              		  			 'city' => '',
								 
              		  			 
              		  			 'createby' =>  date("d-m-Y", strtotime($col7)),
              		  	        
              		  			 'statuss' => $col8	  );        /// status  = 0 -pending  1 accepted , 2 reject, 
              		  			 
              		   $i = $i+1;  			  
                //echo " array created".json_encode($return);
    	    }
		
            $stmt12 = $conn->prepare("SELECT count(id) FROM appuser_login sl WHERE 1=1 and sl.user_unique_id != 'admin_0001'".$search_string_qry."");
            
         
        $stmt12->execute();
        $stmt12->store_result();
        $stmt12->bind_result (  $col21);
                	 
        while($stmt12->fetch() ){
            $totalrow = $col21;
        }
    
        if( $Exist){
                
			$page_html =  $Common_Function->pagination('appuser_page',$page,$limit,$totalrow); 
		
		echo json_encode(array("status"=>1,"page_html" =>$page_html,"details"=>$return,"totalrowvalue"=>$totalrow));
	                        
         }else{
             //echo "  page ".$page;
         
             echo json_encode(array("status"=>0,"page_html" =>'',"details"=>$return,"totalrowvalue"=>$totalrow));
         }
         
     }
    catch(PDOException $e)
        {
        echo "Error: " . $e->getMessage();
        }

}
?>