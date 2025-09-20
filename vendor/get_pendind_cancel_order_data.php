<?php

	include('session.php');

	

	$code = $_POST['code'];	


	

	$code =stripslashes($code);

	



$error='';  // Variable To Store Error Message



//echo "admin is ".$_SESSION['admin'];

if(!isset($_SESSION['admin'])){

  header("Location: index.php");

 // echo " dashboard redirect to index";

}else {


    

    try{

		$page  = $_POST['page'];

		$rowno = $_POST['rowno'];

		

		$page =  stripslashes($page);

		$rowno =  stripslashes($rowno);

	

		if($_POST['perpage']){

			$limit = $_POST['perpage']; 

		}else{

			$limit = 10; 

		}

	   

        $start = ($page - 1) * $limit; 

        $totalrow =0;

    

        $status = 0;

        $msg = "Unable to Get Data";

        $return = array();

        

            
           $stmt = $conn->prepare("SELECT id,order_id,seller_reason,seller_status,create_at FROM  cancel_order_track where seller_id = '".$_SESSION['admin']."'  ORDER BY create_at DESC LIMIT  ".$start.", ".$limit."");

    	   

    	   $stmt->execute();	 

     	   $data = $stmt->bind_result( $id,$order_id, $seller_reason,$seller_status,$created_at);

           $return = array();

    	   $i =0;

       	   while ($stmt->fetch()) { 

    	     if($seller_status ==0)
			 {
				$seller_status = ''; 
			 }
			 else if($seller_status == 1)
			 {
				$seller_status = 'Accept'; 
			 }
			 else if($seller_status == 2)
			 {
				$seller_status = 'Reject'; 
			 }
			 
			 
        	   	$return[$i] = 

        					array(	

        					    'id' => $id,
								
        					    'order_id' => $order_id,

        						'seller_reason' => $seller_reason,
								
        						'seller_status' => $seller_status,
								
        						'created_at' => date('d-m-Y',strtotime($created_at)));

              		   $i = $i+1;  	

              	$status = 1;

                $msg = "Details here";

               // echo " array created".json_encode($return);

    	    }

    

    	 $information =array( 'status' => $status,

                              'msg' =>   $msg,

                              'data' => $return);

							  

							  

		$stmt12 = $conn->prepare("SELECT count(id) FROM cancel_order_track WHERE seller_id = '".$_SESSION['admin']."'");

     

        $stmt12->execute();

        $stmt12->store_result();

        $stmt12->bind_result (  $col55);

                	 

        while($stmt12->fetch() ){

            $totalrow = $col55;         

        }

							  

		$page_html =  $Common_Function->pagination('product_review',$page,$limit,$totalrow); 

		

		echo json_encode(array("status"=>1,"page_html" =>$page_html,"data"=>$return,"totalrowvalue"=>$totalrow));

    	  	

     }

    catch(PDOException $e)

        {

        echo "Error: " . $e->getMessage();

        }



}

?>