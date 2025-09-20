<?php

include('session.php');





$code = $_POST['code'];

$transection_id = $_POST['transection_id'];

$paymant_id = $_POST['paymant_id'];
$user_id = $_POST['user_id'];

 



$error=''; 

$code=   stripslashes($code);

$transection_id =   stripslashes($transection_id);

$paymant_id =   stripslashes($paymant_id);





if(!isset($_SESSION['admin'])){

  header("Location: index.php");

 // echo " dashboard redirect to index";

}else

if($code == $_SESSION['_token'] && isset($transection_id)   && !empty($transection_id)  ) {



			$invoice_proof ='';

			if($_FILES['invoice_proof']['name']){

				$Common_Function->img_dimension_arr = $img_dimension_arr;

				$invoice_proof1 = $Common_Function->file_upload('invoice_proof',$media_path);

				$invoice_proof = json_encode($invoice_proof1);

			}
			
			$datetime = date('Y-m-d H:i:s');


			$orderid =0;

			$status = 'Paid';

			
			$stmt11 = $conn->prepare("UPDATE wallet_withdrow SET transection_id =?, invoice_proof =? , payment_status =? ,update_at=?  WHERE id ='".$paymant_id."'");

			$stmt11->bind_param( "ssss",  $transection_id,$invoice_proof,$status,$datetime );


			
			$stmt11->execute();

			$stmt11->store_result();


			$rows=$stmt11->affected_rows;

			if($rows>0){
				
				$get_pay_amount = $conn->prepare("SELECT amount FROM wallet_withdrow  WHERE id ='".$paymant_id."'");
				$get_pay_amount->execute();
				$get_pay_amount->store_result();
				$get_pay_amount->bind_result (  $pay_amount);
				
				while($get_pay_amount->fetch() ){
					$pay_amount = $pay_amount;
				}
				
				
				$get_amount = $conn->prepare("SELECT amount,wallet_id FROM wallet_summery  WHERE user_id ='".$user_id."'");
				$get_amount->execute();
				$get_amount->store_result();
				$get_amount->bind_result ($amount,$wallet_id);
							 
				while($get_amount->fetch() ){
					$wallet_id = $wallet_id;
					$totalamount = $amount;
				}
				
				$final_amount = $totalamount - $pay_amount;
				
				
				
				$stmt_wallet = $conn->prepare("UPDATE wallet_summery SET amount =? WHERE user_id ='".$user_id."'");

				$stmt_wallet->bind_param( "s",  $final_amount );
				
				$stmt_wallet->execute();
				$stmt_wallet->store_result();
				
				
				$payment_type = 3;
				$transaction_type = 'debit';
				$product_id = '';
				$order_id = '';
				$remark = 'Wallet Withdrowal Payment';
				
				
				$add_wallet_transaction_history = $conn->prepare("INSERT INTO wallet_transaction_history( wallet_id, payment_type,transaction_id,transaction_type,amount,balance,product_id,order_id,user_id,remark,created_at)  VALUES (?,?,?,?,?,?,?,?,?,?,?)");

				$add_wallet_transaction_history->bind_param( "sssssssssss", $wallet_id ,$payment_type,$transection_id,$transaction_type,$pay_amount,$final_amount,$product_id,$order_id,$user_id,$remark,$datetime);

				$add_wallet_transaction_history->execute(); 

				$add_wallet_transaction_history->store_result();
				
				//print_r($this->db->last_query());
				

				echo "Added New Payment Successfully. ";

				

			}else{

				echo "failed to add brand";

			}

			


    	 

    }else{

            echo "Invalid values.";

    }

    die;

?>

