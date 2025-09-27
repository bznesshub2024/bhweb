<?php
include('../app/db_connection.php');
session_start(); // Starting Session
$error=''; // Variable To Store Error Message
include('common_function.php');
$Common_Function = new Common_Function();

if (isset($_POST['submit']) ) {

    if (empty($_POST['email']) || empty($_POST['password'])) {
        $error = "Email or Password is invalid";
    }
    else
    {
        // Define $username and $password
        $email=$_POST['email'];
        $password=$_POST['password'];
        $checkbox=$_POST['checkbox'];
  
        $email = stripslashes($email);
        $password = stripslashes($password);
        $notExist  = true; 
        
        include('encryptfun.php');
        global $publickey_server;
        $encruptfun = new encryptfun();
        $encryptedpassword = $encruptfun->encrypt($publickey_server, $password);
		
		$status ='99';
		$seller_unique_id ='';
      // echo "email is ".$notExist;
        $stmt = $conn->prepare("SELECT seller_unique_id,companyname,fullname,email,phone,status,pincode, address, state, city FROM sellerlogin WHERE email=? AND password=?");
        $stmt->bind_param("ss", $email, $encryptedpassword);
        $stmt->execute();

        $stmt->store_result();
        $stmt->bind_result($col1,$col2,$col3,$col4,$col5,$col6,$col7, $col8, $col9, $col10 );
         
        while ($stmt->fetch()) {
           $status = $col6;
           $seller_unique_id = $col1;
        }

       
		$stmt = $conn->prepare("
			SELECT * 
			FROM seller_plan_payment 
			WHERE seller_id = ? 
			ORDER BY id DESC 
			LIMIT 1
			");
		$stmt->bind_param("s", $seller_unique_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$current_date=strtotime(date('Y-m-d'));
		if ($row = $result->fetch_assoc()) {
			$plan_end_date=$row['plan_end_date'];
			if(!empty($plan_end_date)){
				if(strtotime($plan_end_date) < $current_date){
					//print_r(12345);die;
$update = $conn->prepare("UPDATE seller_plan_payment SET current_plan = ? WHERE id = ?");
$current_plan = 0; // integer
$id = $row['id'];  // integer from DB

$update->bind_param("ii", $current_plan, $id);
$update->execute();

$update1 = $conn->prepare("UPDATE sellerlogin SET status = ? WHERE seller_unique_id = ?");

$status = 3; // integer
// $seller_unique_id already defined

$update1->bind_param("is", $status, $seller_unique_id);
$update1->execute();
				$status = "payment_issue";
				}elseif($row['current_plan'] == 0){
				$status = "payment_issue";
				}

			}
		}




		if($status == 'payment_issue'){
			$error = "Your current plan has been deactivated. Please purchase a new plan to continue enjoying our services.";
		}else if($status ==0){
			$error = "Your account request is pending. Please wait untill admin approve.";
		}else if($status ==2){
			$error = "Your account is rejected. Please contact administrator.";
		}else if($status ==3){
			$error = "Your account is deactiveted. Please contact administrator.";
		}else if ($status == 1) {
			 $notExist = false;
            $_SESSION['admin'] = $col1; 
            $_SESSION['seller_name'] = $col3; 
            $_SESSION['seller_company'] = $col2; 
            $_SESSION['seller_email'] = $col4; 
            $_SESSION['seller_phone'] = $col5; 
            $_SESSION['seller_pincode'] = $col7; 
			$_SESSION['seller_address'] = $col8;
			$_SESSION['seller_state_id'] = $col9;
			$_SESSION['seller_city_id'] = $col10;
			$_SESSION['_token'] = md5(time());
			$_SESSION['type'] = 'seller';
			$session_id = session_id();
				
			$meta = array();
			
			
				
			$meta['user-agent'] = $_SERVER['HTTP_USER_AGENT'];
			$meta['id'] = $col1;
			$meta['ses_id'] = $session_id;
			
			
			//$query = $conn->query("INSERT INTO ci_session (meta,id) VALUES('".json_encode($meta)."','".$col1."')");
			if($checkbox == '1'){
				setcookie('seller_email', $email, time() + (86400 * 30), "/"); // 86400 = 1 day
				setcookie('seller_pass', $password, time() + (86400 * 30), "/"); // 86400 = 1 day
				setcookie('checkbox', 1, time() + (86400 * 30), "/"); // 86400 = 1 day
			}
			
			
			header("location: dashboard.php"); // Redirecting To Other Page
          
        } else {
          // $password = base64_decode ( $password );
            $error = "Email or Password is invalid";
          //  echo $error;
        }




      //  mysql_close($conn); // Closing Connection
    }
} 

if(isset($_POST['emailvalue'])){
	$email_id = trim($_POST['emailvalue']);
	
	$query = $conn->query("SELECT fullname,email,status FROM `sellerlogin` WHERE email ='".$email_id."'");
	if($query->num_rows > 0){
		$rows = $query->fetch_assoc();
		
		$adminname = $rows['fullname'];
		$admin_email = $rows['email'];
		$status = $rows['status'];
		
		if($status ==0){
			echo "pending";
			
		}else if($status ==2){
			echo "rejected";
		}else if($status ==3){
			echo "deactiveted";
			
		}else if ($status == 1) {
			$checksum = date('dym').$Common_Function->random_strings(10).date('his');
include('encryptfun.php');
global $publickey_server;
$new_passwords = $Common_Function->generateRandomCode();
$encruptfun = new encryptfun();
$passwords = $encruptfun->encrypt($publickey_server, $new_passwords);

$Common_Function->send_password_email($conn,$admin_email,$adminname,$new_passwords);
$query = $conn->query("UPDATE sellerlogin SET password ='".$passwords."' WHERE email ='".$email_id."'");


			// $query = $conn->query("UPDATE `sellerlogin` SET checksum ='".$checksum."' WHERE email ='".$email_id."'");
			
			// $Common_Function->send_email_forgot_password($conn,$admin_email,$adminname,$checksum,BASEURL,'Forgot Password');
			echo "done";
		}
	}else{
		echo "not_exist";
	}
	die();
}
?>
<!DOCTYPE HTML>
<html lang="en">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <title>Vendor Login</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" type="image/png" href="">
      <!-- Bootstrap Core CSS -->
      <link href="<?php echo BASEURL; ?>assets/css/bootstrap.css" rel='stylesheet' type='text/css' />
	  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
      <!-- font-awesome icons CSS-->
      <link href="<?php echo BASEURL; ?>assets/css/font-awesome.css" rel="stylesheet">
      <!-- //font-awesome icons CSS-->
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
      <link rel="stylesheet" type="text/css" href="<?php echo BASEURL; ?>assets/login/animate.css">
      <link rel="stylesheet" type="text/css" href="<?php echo BASEURL; ?>assets/login/main.css">
      <meta name="robots" content="noindex, follow">
   </head>
   <style>
    .login_body {
        width: 100%;
		height: 100%;
        border: 1px solid blue;
        background-image: linear-gradient(#d3c7ff, #2b2bf5);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .vendor_login {
        color: #ffffff !important;
        font-weight: 100;
		font-size: 20px;
    }

    .form_text {
        color: #ffffff !important;
        font-size: 16px !important;
        font-weight: 400 !important;
    }

    .remeber_checkbox {
        position: absolute;
        border-radius: 0px !important;
    }

    .vendor_login_btn {
        background-color: blue;
        color: #ffffff;
        border-radius: 0px;
    }
	
	.vendor_login_btn:hover {
        background-color: blue;
        color: #ffffff;
        border-radius: 0px;
    }
	
	.vendor-login-icons{
		margin-top: 15px;
	}

    .vendor_login_box {
        border: 0px;
		color: white !important;
		font-size: 14px;
        border-bottom: 1px solid white;
        background-color: transparent;
        border-radius: 0px !important;
		margin-left: 10px;
    }

	.vendor_login_box::placeholder{
		color: #ffffffcf !important;
	}
	
	.vendor_login_box:focus{
		border-bottom: 1px solid white !important;
	}

	.login100-form-title {
		font-family: 'Poppins-Regular' !important;
	}
	
	.error_msg{
		color: red;
		font-size: 18px;
	}
	
	.wrap-login100{
		background: transparent !important;
		border: 1px solid white !important;
		padding: 50px !important;
	}
	
	.container-login100{
		background-image: linear-gradient(#d3c7ff, #2b2bf5) !important;
	}
	
	.login100-form-btn {
		border-radius: 5px !important;
		background: transparent !important;
		border: 1px solid white !important;
		font-family: Montserrat !important;
	}
	
	.login100-form-btn:hover{
		background: #162b75 !important;
		border: 1px solid white !important;
	}
	
	.login100-form {
		width: 400px;
	}



    @media (max-width: 576px) and (min-width: 250px) {
        .form_text {
            color: #ffffff !important;
            font-size: 12px !important;
            font-weight: 200 !important;
        }
		
		.vendor_login_box{
			font-size: 12px !important;
		}
		
		.error_msg{
			font-size: 12px;
		}
		
		.vendor_login {
			font-size: 14px;
		}

        .login_sub_body {
            width: 80% !important;
        }
    }
	
	@media (min-width: 991px){
		.login_sub_body{
			width: 30%!important;
		}
	}
	
	@media (min-width: 576px) and (max-width: 767px){
		.login100-form{
			width: 100%!important;
		}
	}
	
</style>

   <body>
   
		<!--
		<section class="login_body text-center py-5">
			<div class="d-block login_sub_body w-50">
				<div class="">
					<img src="<?php // base_url ?>images/vendor-login.png" alt="">
				</div>
				<div class="form mt-3 w-100">
					<h3 class="vendor_login">Vendor Login</h3>
					<form class="mt-4" method="post" id="login_form">
						<div class="form-group my-1 d-flex validate-input" data-validate="Valid email is required: ex@abc.xyz">
							<i class="fa-solid fa-envelope fa-lg vendor-login-icons" style="color: #ffffff;"></i>
							<input type="email" id="user_name" name="email" class="my-1 vendor_login_box w-100">
						</div>
						<div class="form-group my-1 d-flex">
							<i class="fa-solid fa-lock fa-lg vendor-login-icons" style="color: #ffffff;"></i>
							<input type="password" name="password" id="password" class="my-1 vendor_login_box w-100">
						</div>
						<span class="error_msg"><?php echo $error; ?></span>
						<div class="d-flex justify-content-between align-items-center my-4">
							<div class="form-check pt-3">
								<input type="checkbox" class="form-check-input remeber_checkbox" <?php if($_COOKIE['checkbox'] ==1){ echo "checked";} ?> value="1">
								<label class="form-check-label form_text">Remember Me</label>
							</div>
							<a href="#" data-toggle="modal" data-target="#myModal" class="link form_text">Forget Password?</a>
						</div>
						<div class="button">
							<button class="btn vendor_login_btn w-100 form_text btn-lg" id="login_btn" name="submit">Login</button>
						</div>
					</form>
				</div>
			</div>
		</section>
		
		-->
   
   
   
		<div class="limiter" style="display:block">
         <div class="container-login100">
            <div class="wrap-login100">
               <div class="login100-pic js-tilt" data-tilt="" style="will-change: transform; transform: perspective(300px) rotateX(-1.61deg) rotateY(-4.28deg) scale3d(1.1, 1.1, 1.1);">
                  <img src="<?php echo BASEURL; ?>assets/login/img-01.png" alt="IMG">
               </div>
				<form class="login100-form validate-form" method="post" id="login_form">
                  <span class="login100-form-title vendor_login text-blue">
					Vendor Login
                  </span>
                  <span style="color:red;"><?php echo $error; ?></span>
                  <!-- <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                     <input class="input100 vendor_login_box" type="email" id="user_name" name="email" placeholder="Enter Your Email" required="">
                     <span class="focus-input100"></span>
                     <span class="symbol-input100">
                     <i class="fa fa-envelope" aria-hidden="true"></i>
                     </span>
                  </div> -->
					<div class="form-group my-1 mb-5 d-flex validate-input" data-validate="Valid email is required: ex@abc.xyz">
						<i class="fa-solid fa-envelope fa-2xl vendor-login-icons" style="color: #ffffff;"></i>
						<input type="email" id="user_name" name="email" class="my-1 vendor_login_box w-100" placeholder="Email ID">
					</div>
					<!--
                  <div class="wrap-input100 validate-input" data-validate="Password is required">
                     <input class="input100 vendor_login_box" type="password" name="password" id="password" placeholder="Password" required="">
                     <span class="focus-input100"></span>
                     <span class="symbol-input100">
                     <i class="fa fa-lock" aria-hidden="true"></i>
                     </span>
                  </div>
				  -->
					<div class="form-group my-1 mt-5 d-flex">
						<i class="fa-solid fa-lock fa-2xl vendor-login-icons" style="color: #ffffff;"></i>
						<input type="password" name="password" id="password" class="my-1 vendor_login_box w-100" placeholder="Password">
					</div>
					<!--
                  	<div class="forgot-grid">
								<label class="checkbox text-blue"><input type="checkbox" name="checkbox" <?php if($_COOKIE['checkbox'] ==1){ echo "checked";} ?> value="1" ><i></i>Remember me</label>
								<div class="forgot">
									<a class="text-orange" href="#"  data-toggle="modal" data-target="#myModal">forgot password?</a>
								</div>
								<div class="clearfix"> </div>
					</div>
					-->
					<div class="d-flex justify-content-between align-items-center my-4">
							<div class="form-check pt-3">
								<input type="checkbox" class="form-check-input remeber_checkbox" <?php if($_COOKIE['checkbox'] ==1){ echo "checked";} ?> value="1">
								<label class="form-check-label form_text">Remember Me</label>
							</div>
							<a href="#" data-toggle="modal" data-target="#myModal" class="link form_text">Forget Password?</a>
					</div>
                   <div class="wrap-input100" >
                    
                  </div>
                  <div class="container-login100-form-btn">
                     <button class="login100-form-btn" id="login_btn" name="submit">
                     Login
                     </button>
                  </div>
                
               </form>
            </div>
        </div>
    </div>
	  
	
		<!-- Modal -->
		<div id="myModal" class="modal" role="dialog">
			<div class="modal-dialog mx-auto" style="width:90%;">

				<!-- Modal content-->
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title text-blue">Forgot password</h4>
				  </div>
				  <div class="modal-body"> 
					<form class="form" id="add_brand_form"  enctype="multipart/form-data">
						
						<div class="form-group"> 
							<label for="name">User Email</label> 
							<input type="email" class="form-control" id="username" placeholder="User Email"> 
						</div>
							   
						<button type="submit" class="btn btn-success"style="background:#162b75;" value="" href="javascript:void(0)" id="update_password">Update</button> 
					</form> 
				  </div>
				  
				</div>

			</div>
		</div>
	
	
	<!-- js-->
	<script src="<?php echo BASEURL; ?>assets/js/jquery-1.11.1.min.js"></script>

	<script src="<?php echo BASEURL; ?>assets/login/popper.js"></script>
	<script src="<?php echo BASEURL; ?>assets/js/bootstrap.js"> </script>
	 
	<script src="<?php echo BASEURL; ?>assets/login/tilt.jquery.min.js"></script>
	<script>
		$('.js-tilt').tilt({
			scale: 1.1
		})
		
		// const inputElement = document.querySelector(".vendor_login_box");
		
		// inputElement.addEventListener("input", function () {
		  // this.style.borderBottom = "2px solid white";
		// });
	</script>

	
	<script>
			
	$(document).ready(function() {
	  
		
		$("#login_btn").click(function(event){
			//event.preventDefault();			
			var emailvalue = $('#user_name').val();
			  
			var passwords = $('#password').val();
			   
			if (emailvalue == '') {
				successmsg("Please enter user name");
			}else if (validate_email(emailvalue) == 'invalid') {
				successmsg("User name Email id is invalid");
			}else if(passwords =="" || passwords == null){
				successmsg("Password is empty"); 
			}else{
				$("#login_form").submit(); 
			}
		});	
		

		$("#update_password").click(function(event){
			event.preventDefault();			
			var emailvalue = $('#username').val();
			  
			var passwords = $('#password').val();
			   
			if (emailvalue == '') {
				successmsg("Please enter user email");
			}else if (validate_email(emailvalue) == 'invalid') {
				successmsg("User name Email id is invalid");
			}else{
				$.ajax({
					method: 'POST',
					url: 'index.php',
					data: {
					emailvalue: emailvalue
					},
					success: function(response){
						if(response == 'not_exist'){
							successmsg("This User Email not exist.");
						}else if(response == 'done'){
							successmsg("A new password has been sent to your email.");
						}else if(response == 'pending'){
							successmsg("Your account request is pending. Please wait untill admin approve.");
						}else if(response == 'rejected'){
							successmsg("Your account is rejected. Please contact administrator.");
						}else if(response == 'deactiveted'){
							successmsg("Your account is deactiveted. Please contact administrator.");
						}
						
					}
				});
			}
		});
	  
	});
	function validate_email(email) {
		var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
		if (!pattern.test(email)) {
			return 'invalid';
		} else {
			return 'valid';
		}
	}
	function successmsg(msg) {
		xdialog.confirm(msg, function() {
			// do work here if ok/yes selected...
				
		}, {
			style: 'width:420px;font-size:0.8rem;background:#162b75 !important',
			buttons: {
				 ok: 'OK'
			 },
			oncancel: function() {
				 // console.warn('Cancelled!');
			 }
	 });
	}


		
		</script>
		
		
	<link href="<?php echo BASEURL; ?>assets/css/xdialog.min.css" rel="stylesheet" />
	<script src="<?php echo BASEURL; ?>assets/js/xdialog.min.js"></script>


</body></html>