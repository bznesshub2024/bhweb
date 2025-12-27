<?php

include('session.php');



if(!$Common_Function->user_module_premission($_SESSION,$ProductAttributes)){

	echo "<script>location.href='no-premission.php'</script>";die();

}

$code = $_POST['code'];

$name = $_POST['namevalue'];

$plan_value = $_POST['plan_value'];
$duration = $_POST['duration'];


$plan_id = $_POST['plan_id'];


$error='';  // Variable To Store Error Message

$code=   stripslashes($code);

$name =   stripslashes($name);

$plan_value =   stripslashes($plan_value);


$plan_id =   stripslashes($plan_id);
$duration =   stripslashes($duration);


if(!isset($_SESSION['admin'])){

  header("Location: index.php");

 // echo " dashboard redirect to index";

}else

if($code == $_SESSION['_token'] && isset($name) && isset($plan_value)   && !empty($name) && !empty($plan_id)  ) {

       //code for Check Brand Exist - START

	   $stmt12 = $conn->prepare("SELECT count(plan_id) FROM plans where plan_name ='".$name."' AND plan_id !='".$plan_id."' ");

     

        $stmt12->execute();

        $stmt12->store_result();

        $stmt12->bind_result (  $col55);

                	 

        while($stmt12->fetch() ){

            $totalrow = $col55;         

        }

		

		//code for Check Brand Exist - END

		if($totalrow == 0){
		

			$stmt11 = $conn->prepare("UPDATE plans SET plan_name =? ,duration =? , plan_value =?  WHERE plan_id ='".$plan_id."'");

			$stmt11->bind_param( "sss",  $name,$duration, $plan_value );

			

			

			//code for insert record - START

			

			

			$orderid =0;

			

		

			$stmt11->execute();

			$stmt11->store_result();

			// echo " insert done ";

			$rows=$stmt11->affected_rows;

		

			echo "Plan Updated Successfully. ";

				

			

			//code for insert record - END

		}else{

			echo "Plan already exist. ";

		}

    	 

    }else{

            echo "Invalid values.";

    }

    die;

?>

