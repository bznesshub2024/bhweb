<?php
include('../app/db_connection.php'); 
session_start(); // Starting Session
$error=''; // Variable To Store Error Message
include('common_function.php');
$Common_Function = new Common_Function();
if (isset($_POST['submit']) ) {

    if (empty($_POST['email']) || empty($_POST['password'])) {
        $error = "email or Password is invalid";
    }
    else
    {
        // Define $username and $password
        $email=$_POST['email'];
        $password=$_POST['password'];
  
        $email = stripslashes($email);
        $password = stripslashes($password);
        $notExist  = 1; 
        
        include('encryptfun.php');
        global $publickey_server;
        $encruptfun = new encryptfun();
        $encryptedpassword = $encruptfun->encrypt($publickey_server, $password);
      
      // echo "email is ".$notExist;
        $stmt = $conn->prepare("SELECT seller_id,fullname,email,status,role_id FROM admin_login WHERE email=? AND password=?");
        $stmt->bind_param("ss", $email, $encryptedpassword);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($col1,$col2,$col3,$col4,$col5 );
        
        while ($stmt->fetch()) {
            
			if($col4 ==1){

				$notExist = 0;
				if($col5 > 0){
					$stmt1 = $conn->prepare("SELECT id,title,premission FROM user_roles WHERE id=? ");
					$stmt1->bind_param("i", $col5);
					$stmt1->execute();
					$stmt1->store_result();
					$stmt1->bind_result($ids,$title,$premission);
					
					while ($stmt1->fetch()) {
						$_SESSION['title_role'] = $title; 
						$_SESSION['premission_role'] = $premission; 
					}
				}else if($col5 == 0){
					$_SESSION['title_role'] = 'admin'; 
					$_SESSION['premission_role'] = 'admin';
				}
				
				$_SESSION['admin'] = $col1; 
				$_SESSION['admin_name'] = $col2; 
				$_SESSION['admin_email'] = $col3; 
				$_SESSION['_token'] = md5(time());
				$_SESSION['type'] = 'admin';
			}else{
				$notExist = 2;
			}
           
        }
       // echo " not wxsist is ".$notExist;
        if ($notExist == 0) {
            header("location: dashboard.php"); // Redirecting To Other Page
          //  $error = " sucess valid";
          // echo " go to dashborad";
        }else if ($notExist == 2) {
			$error = "Your account is deactiveted. Please contact administrator.";
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
	
	$query = $conn->query("SELECT fullname,email FROM `admin_login` WHERE email ='".$email_id."'");
	if($query->num_rows > 0){
		$rows = $query->fetch_assoc();
		
		$adminname = $rows['fullname'];
		$admin_email = $rows['email'];
		
		$checksum = date('dym').$Common_Function->random_strings(10).date('his');
		
		$query = $conn->query("UPDATE `admin_login` SET checksum ='".$checksum."' WHERE email ='".$email_id."'");
		
		$Common_Function->send_email_forgot_password($conn,$admin_email,$adminname,$checksum,BASEURL,'Forgot Password');
		echo "done";
	}else{
		echo "not_exist";
	}
	die();
}
?>
<!DOCTYPE html>
<!-- saved from url=(0014)about:internet -->
<html lang="en">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <title>Admin Login</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" type="image/png" href="">
      <!-- Bootstrap Core CSS -->
      <link href="<?php echo BASEURL; ?>assets/css/bootstrap.css" rel='stylesheet' type='text/css' />
	  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

      <!-- font-awesome icons CSS-->
      <link href="<?php echo BASEURL; ?>assets/css/font-awesome.css" rel="stylesheet">
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
      <!-- //font-awesome icons CSS-->
      <link rel="stylesheet" type="text/css" href="<?php echo BASEURL; ?>assets/login/animate.css">
      <link rel="stylesheet" type="text/css" href="<?php echo BASEURL; ?>assets/login/main.css">
      <meta name="robots" content="noindex, follow">
   </head>
   
    <style>
    .login_body {
        width: 100%;
		height: 100%;
        border: 1px solid blue;
        background-color: #ff6600;
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
		background-color: #ff6600 !important;
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
      <div class="limiter">
         <div class="container-login100">
            <div class="wrap-login100">
               <div class="login100-pic js-tilt" data-tilt="" style="will-change: transform; transform: perspective(300px) rotateX(-1.61deg) rotateY(-4.28deg) scale3d(1.1, 1.1, 1.1);">
                  <img src="<?php echo BASEURL; ?>assets/login/img-01.png" alt="IMG">
               </div>
               <!--
			   <form class="login100-form validate-form" method="post" id="login_form">
                  <span class="login100-form-title text-blue">
                  Admin Login
                  </span>
                  <span style="color:red;"><?php echo $error; ?></span>
                  <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                     <input class="input100" type="email" id="user_name" name="email" placeholder="Enter Your Email" required="">
                     <span class="focus-input100"></span>
                     <span class="symbol-input100">
                     <i class="fa fa-envelope" aria-hidden="true"></i>
                     </span>
                  </div>
                  <div class="wrap-input100 validate-input" data-validate="Password is required">
                     <input class="input100" type="password" name="password" id="password" placeholder="Password" required="">
                     <span class="focus-input100"></span>
                     <span class="symbol-input100">
                     <i class="fa fa-lock" aria-hidden="true"></i>
                     </span>
                  </div>
                   <div class="wrap-input200" >
                    
                  </div>
                  <div class="container-login100-form-btn">
                     <button class="login100-form-btn" id="login_btn" name="submit">
                     Login
                     </button>
                  </div>
					<br><a class="text-orange" href="forget_password.php">Forgot Password</a>
               </form>
			   -->
			   
			   
			   
			   <form class="login100-form validate-form" method="post" id="login_form">
			   
			   <span class="login100-form-title vendor_login text-blue">
					Admin Login
                  </span>
                  <span style="color:red;"><?php echo $error; ?></span>
                  
					<div class="form-group my-1 mb-5 d-flex validate-input" data-validate="Valid email is required: ex@abc.xyz">
						<i class="fa-solid fa-envelope fa-2xl vendor-login-icons" style="color: #ffffff;"></i>
						<input type="email" id="user_name" name="email" class="my-1 vendor_login_box w-100" placeholder="Email ID">
					</div>
					
					<div class="form-group my-1 mt-5 d-flex">
						<i class="fa-solid fa-lock fa-2xl vendor-login-icons" style="color: #ffffff;"></i>
						<input type="password" name="password" id="password" class="my-1 vendor_login_box w-100" placeholder="Password">
					</div>
					
					<div class="d-flex justify-content-between align-items-center my-4">
							<div class="form-check pt-3">
								<input type="checkbox" class="form-check-input remeber_checkbox" <?php if($_COOKIE['checkbox'] ==1){ echo "checked";} ?> value="1">
								<label class="form-check-label form_text">Remember Me</label>
							</div>
							<a href="forget_password.php" class="link form_text">Forget Password?</a>
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

 <!-- js-->
<script src="<?php echo BASEURL; ?>assets/js/jquery-1.11.1.min.js"></script>

<script src="<?php echo BASEURL; ?>assets/login/popper.js"></script>
 <script src="<?php echo BASEURL; ?>assets/js/bootstrap.js"> </script>
 
 <script src="<?php echo BASEURL; ?>assets/login/tilt.jquery.min.js"></script>
<script>
		$('.js-tilt').tilt({
			scale: 1.1
		})
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
        style: 'width:420px;font-size:0.8rem;',
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