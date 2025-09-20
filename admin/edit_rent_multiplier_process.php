<?php

include('session.php');



if(!$Common_Function->user_module_premission($_SESSION,$ProductAttributes)){

	echo "<script>location.href='no-premission.php'</script>";die();

}



$code = $_POST['code'];

$update_multiplier = $_POST['update_multiplier'];

$rent_id = $_POST['rent_id'];

$statuss = $_POST['statuss'];



$error=''; 

$code=   stripslashes($code);

$update_multiplier =   stripslashes($update_multiplier);



$rent_id =   stripslashes($rent_id);



if(!isset($_SESSION['admin'])){

  header("Location: index.php");

 // echo " dashboard redirect to index";

}else

if($code == $_SESSION['_token']  && !empty($update_multiplier) && !empty($rent_id) && !empty($statuss)  ) {

      
			$stmt11 = $conn->prepare("UPDATE rent_multipliers SET multiplier =? WHERE id ='".$rent_id."'");

			$stmt11->bind_param( "s",  $update_multiplier );

		
			$orderid =0;


			$stmt11->execute();

			$stmt11->store_result();

			echo "rent Multiplier  Updated Successfully. ";

		
    }else{

            echo "Invalid values.";

    }

    die;

?>

