<?php

include('session.php');



if(!$Common_Function->user_module_premission($_SESSION,$ProductAttributes)){

	echo "<script>location.href='no-premission.php'</script>";die();

}



$code = $_POST['code'];

$name = $_POST['namevalue'];
$plan_value = $_POST['plan_value'];
$duration = $_POST['duration'];




$error='';  // Variable To Store Error Message

$code=   stripslashes($code);

$name =   stripslashes($name);
$plan_value =   stripslashes($plan_value);




if(!isset($_SESSION['admin'])){

  header("Location: index.php");

 // echo " dashboard redirect to index";

}else

if($code == $_SESSION['_token'] && isset($name)   && !empty($name) && !empty($plan_value)  ) {

       //code for Check Brand Exist - START

	   $stmt12 = $conn->prepare("SELECT count(plan_id) FROM plans where plan_name ='".$name."' and plan_value = '".$plan_value."'  ");

     

        $stmt12->execute();

        $stmt12->store_result();

        $stmt12->bind_result (  $col55);

                	 

        while($stmt12->fetch() ){

            $totalrow = $col55;         

        }

		

		//code for Check Brand Exist - END

		if($totalrow>0){

			 echo "Plan Already Exist. ";

		}else{

			

			

			

			//code for insert record - START

			

			

			$orderid =0;

			$stmt11 = $conn->prepare("INSERT INTO plans( plan_name,plan_value,duration)  VALUES (?,?,?)");

			$stmt11->bind_param( "sss",  $name,$plan_value,$duration );

		

			$stmt11->execute();

			$stmt11->store_result();

			// echo " insert done ";

			$rows=$stmt11->affected_rows;

			if($rows>0){

				echo "Plans Added Successfully. ";

				

			}else{

				echo "Failed to add Plans";

			}

			

			//code for insert record - END

		}

    	 

    }else{

            echo "Invalid values.";

    }

    die;

?>

