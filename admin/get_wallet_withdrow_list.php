<?php

	include('session.php');

	

	
	$code = $_POST['code'];

	$page  = $_POST['page'];

	$rowno = $_POST['rowno'];

	

	$code =stripslashes($code);

	$page =  stripslashes($page);

	$rowno =  stripslashes($rowno);



$error='';  // Variable To Store Error Message



//echo "admin is ".$_SESSION['admin'];

if(!isset($_SESSION['admin'])){

  header("Location: index.php");

 // echo " dashboard redirect to index";

}else

if($code == $_SESSION['_token']){

    

    try{

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

        

        // echo "class id is  ".$class_id;     

        $inactive = "active";
		
		

           $stmt = $conn->prepare("SELECT ww.id,ww.amount, al.fullname,ww.created_at,ww.payment_status,ww.transection_id,ww.user_id,bd.upi_id FROM wallet_withdrow ww,appuser_login al,bank_details bd WHERE  al.user_unique_id = ww.user_id and bd.user_id = ww.user_id ORDER BY ww.id desc LIMIT  ".$start.", ".$limit."");

    	   //$stmt->bind_param( s,  $inactive );

    	   $stmt->execute();	 

     	   $data = $stmt->bind_result( $id, $amount, $name,$created_at,$payment_status,$transection_id,$user_id,$upi_id);

           $return = array();

    	   $i =0;

       	   while ($stmt->fetch()) { 

    	       	$return[$i] = 

        					array(	

        					    'id' => $id,

        						'amount' => $amount,
        						'name' => $name,
								
        						'add_date' => date('d-m-Y h:i a',strtotime($created_at)),

        						'payment_status' => $payment_status,
        						'user_id' => $user_id,
        						'upi_id' => $upi_id,
        						'transection_id' => $transection_id);

              		   $i = $i+1;  	

              	$status = 1;

                $msg = "Details here";

               // echo " array created".json_encode($return);

    	    }

    

    	 $information =array( 'status' => $status,

                              'msg' =>   $msg,

                              'data' => $return);

							  

							  

		$stmt12 = $conn->prepare("SELECT count(ww.id) FROM wallet_withdrow ww,appuser_login al WHERE  al.user_unique_id = ww.user_id ");

     

        $stmt12->execute();

        $stmt12->store_result();

        $stmt12->bind_result (  $col55);

                	 

        while($stmt12->fetch() ){

            $totalrow = $col55;         

        }

							  

		$page_html =  $Common_Function->pagination('brand_product',$page,$limit,$totalrow); 

		

		echo json_encode(array("status"=>1,"page_html" =>$page_html,"data"=>$return,"totalrowvalue"=>$totalrow));

    	  	

     }

    catch(PDOException $e)

        {

        echo "Error: " . $e->getMessage();

        }



}

?>